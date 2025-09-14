<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Services\NotesService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    protected $noteService;
    public function __construct(NotesService $noteService)
    {
        $this->noteService = $noteService;
    }
    public function notes()
    {
        $start = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $end   = Carbon::now()->endOfWeek(Carbon::SUNDAY);

        $notes = Note::whereBetween('date', [$start->toDateString(), $end->toDateString()])->orderBy('date', 'asc')->get();
        return $notes;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = $request->only(['title', 'description', 'date']);

        $note = Note::create($data);

        return response()->json([
            'message' => 'note created',
            'data' => $note,
            'code' => 200
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $oid = new \MongoDB\BSON\ObjectId($id);
            $note = Note::where('_id', $oid)->firstOrFail();
            $note->title = $request->input('title');
            $note->description = $request->input('description');
            $note->date = $request->input('date');
            $note->save();

            return response()->json(['message' => 'note updated', 'data' => $note]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'update failed', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $oid = new \MongoDB\BSON\ObjectId($id);
            $note = Note::where('_id', $oid)->firstOrFail();
            $note->delete();
            return response()->json(['message' => 'note deleted']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'delete failed', 'error' => $e->getMessage()], 400);
        }
    }
}
