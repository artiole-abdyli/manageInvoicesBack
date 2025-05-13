<?php

namespace App\Services;

use App\Models\User;
use App\Models\Company;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactService
{
    protected $contact;
    protected $user;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }
    public function showContact($id)
    {
        $contact = Contact::where('id', $id)->first();
        return response()->json([
            'message' => 'contact retrieved succesfully',
            'data' => $contact
        ]);
    }

    public function createContact(Request $request)
    {
        $contact = new Contact();
        $contact->firstname = $request->input("firstname");
        $contact->lastname = $request->input("lastname");
        $contact->city = $request->input("city");
        $contact->country = $request->input("country");
        $contact->phone_number = $request->input("phone_number");
        $contact->save();
        return response()->json('Contact is created successfully');
    }
    public function updateContact(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->firstname = $request->input("firstname");
        $contact->lastname = $request->input("lastname");
        $contact->city = $request->input("city");
        $contact->country = $request->input("country");
        $contact->phone_number = $request->input("phone_number");
        $contact->save();
        return response()->json('Contact is updated successfully');
    }
    public function listOfContacts()
    {
        $contacts = Contact::all();
        return response()->json([
            'data' => $contacts,

        ]);
    }
    public function deleteContact($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return response()->json('Contact is deleted successfully');
    }

    public function contactsOptions()
    {
        try {
            $contacts = Contact::select('id', 'firstname', 'lastname')->get()->map(function ($contact) {
                return [
                    'label' => $contact->firstname . '' . $contact->lastname,
                    'value' => $contact->id
                ];
            });
            return response()->json([
                'message' => 'success',
                'code' => 200,
                'data' => $contacts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 400
            ]);
        }
    }
}
