<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Smalot\PdfParser\Parser; // ✅ Add this line
use Maatwebsite\Excel\Facades\Excel; // ✅ Required for Excel

class ContactImportController extends Controller
{
    public function import(Request $request)
    {
        \Log::info('Import endpoint hit');


        $file = $request->file('file');

        if (!$request->hasFile('file')) {
            \Log::error('No file received');
            return response()->json(['message' => 'No file uploaded'], 400);
        }

        $file = $request->file('file');

        \Log::info('Received file', [
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'extension' => $file->getClientOriginalExtension(),
        ]);

        $ext = $file->getClientOriginalExtension();
        if ($ext === 'pdf') {
            return $this->importFromPdf($file);
        }

        return $this->importFromExcel($file);
    }

    protected function importFromPdf($file)
    {
        \Log::info('Parsing PDF...');

        $parser = new Parser();
        $pdf = $parser->parseFile($file->getRealPath());
        $text = $pdf->getText();

        $lines = explode("\n", $text);

        foreach ($lines as $line) {
            $parts = array_map('trim', explode(',', $line));
            if (count($parts) < 3) continue;

            Contact::create([
                'firstname' => $parts[0],
                'lastname' => $parts[1],
                'phone_number' => $parts[2],
                'city' => $parts[3] ?? null,
                'country' => $parts[4] ?? null,
            ]);
        }

        return response()->json(['message' => 'PDF contacts imported']);
    }

    protected function importFromExcel($file)
    {
        \Log::info('Parsing Excel...');

        $data = Excel::toArray([], $file);

        if (empty($data) || !is_array($data[0])) {
            return response()->json(['message' => 'Invalid Excel format'], 422);
        }

        foreach ($data[0] as $row) {
            if (empty($row[0]) || empty($row[1]) || empty($row[2])) continue;

            Contact::create([
                'firstname' => $row[0],
                'lastname' => $row[1],
                'phone_number' => $row[2],
                'city' => $row[3] ?? null,
                'country' => $row[4] ?? null,
            ]);
        }

        return response()->json(['message' => 'Excel contacts imported']);
    }
}
