<?php

namespace App\Interfaces;

use App\Models\Contact;
use Illuminate\Http\Request;

interface ContactInterface 
{
    public function getAllContacts();
    public function saveContact(Request $request);
    public function showContact(int $id);
    public function updateContact(Request $request, Contact $contact);
    public function deleteContact(Contact $contact);
}