<?php

namespace App\Services;

use App\Models\Notes;

class NotesService

{
    public function getNotes()
    {
        $notes = Notes::all();
        return $notes;
    }
}
