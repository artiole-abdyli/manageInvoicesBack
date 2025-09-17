<?php

namespace App\Http\Controllers;

use App\Models\Mailings;
use Illuminate\Http\Request;

class MailingsController extends Controller
{

    public function index()
    {
        $mailings = Mailings::all();
        return response()->json([
            'data' => $mailings,
            'code' => 200,
            'message' => 'mailings returned succesfully'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $mailing = Mailings::findOrFail($id);
            $mailing->delete();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
