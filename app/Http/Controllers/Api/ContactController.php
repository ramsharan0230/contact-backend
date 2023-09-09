<?php

namespace App\Http\Controllers\Api;

use App\Helpers\CSVFileRead;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Interfaces\ContactInterface;
use App\Models\Contact;
use App\Models\ContactRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    private $contactRepository;
    public function __construct(ContactInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function index()
    {
        $contacts = $this->contactRepository->getAllContacts();
        
        return response()->json(['data'=> ContactResource::collection($contacts), 'message'=>'Contact fetched successfully'], 200);
    }

    public function store(Request $request)
    {
        $contact = $this->contactRepository->saveContact($request);
        $formattedContact = new ContactResource($contact);

        return response()->json(['data'=> $formattedContact, 'message'=>'Contact saved successfully'], 201);
    }

    public function show(int $id)
    {
        $contact = $this->contactRepository->showContact($id);
        $contactResource = new ContactResource($contact);

        return response()->json(['data'=> $contactResource, 'message'=>'Contact fetched successfully'], 200);
    }


    public function update(Request $request, Contact $contact)
    {
        $this->contactRepository->updateContact($request, $contact);
        $contactResource = new ContactResource($contact);
        
        return response()->json(['data'=> $contactResource, 'message'=>'Contact updated successfully'], 200);
    }

    public function destroy(Contact $contact)
    {
        $this->contactRepository->deleteContact($contact);
        return response()->json(['message'=> "Resource has been deleted Successfully"], 204);
    }

    public function handleCSV(Request $request){
        dd($request->all());
                
        $contactSeeded = CSVFileRead::readCSV($request);
        return response()->json(['message'=> $contactSeeded], 200);
    }
}
