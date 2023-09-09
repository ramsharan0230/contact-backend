<?php

namespace App\Repositories;

use App\Interfaces\ContactInterface;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactRepository implements ContactInterface
{
    public function getAllContacts(){
        return Contact::all();
    }

    public function saveContact(Request $request){
        Validator::make($request->all(), [
            "first_name"=> "required|min:2|max:20",
            "last_name"=> "required|min:2|max:20",
            "email"=> "required|min:2|max:20",
            "phone_number"=> "required|min:2|max:20",
        ]);
        
        try {
            $created = Contact::create([
                "first_name"=> $request->first_name,
                "last_name"=> $request->last_name,
                "email"=> $request->email,
                "phone_number"=> $request->phone_number,
            ]);
            return $created;
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function showContact(int $id){
        try {
            return Contact::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            return $ex->getMessage();
        }
        catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function updateContact(Request $request, $contact){
        Validator::make($request->all(), [
            "first_name"=> "sometimes|min:2|max:20",
            "last_name"=> "sometimes|min:2|max:20",
            "email"=> "sometimes|email|min:2|max:20",
            "phone_number"=> "sometimes|min:2|max:20",
        ]);
        
        try {
            $created = Contact::where('id', $contact->id)->update($request->all());
            return $created;
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }


    public function deleteContact(Contact $contact)
    {
        try {
            return $contact->delete($contact->id);
        } 
        catch (\Symfony\Component\Routing\Exception\ResourceNotFoundException $ex) {
            return $ex->getMessage();
        }
        catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
}