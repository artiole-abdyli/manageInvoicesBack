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
        return $this->noteService = $noteService;
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
            $note = Note::where('id', $id)->first();
            $note->title = $request->input('title');
            $note->description = $request->input('description');
            $note->date = $request->input('date');
            $note->save();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $note = Note::findOrFail($id);
            $note->delete();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
