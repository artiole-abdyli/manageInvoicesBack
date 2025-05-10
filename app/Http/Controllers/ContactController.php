<?php

namespace App\Http\Controllers;

use App\Services\ContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $contactService;
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index()
    {
        return $this->contactService->listOfContacts();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->contactService->createContact($request);
    }


    public function show(string $id)
    {
        return $this->contactService->showContact($id);
    }


    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        return $this->contactService->updateContact($request, $id);
    }

    public function destroy(string $id)
    {
        return $this->contactService->deleteContact($id);
    }
}
