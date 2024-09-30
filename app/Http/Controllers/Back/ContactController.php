<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();

        return view('back.contact.index',compact('contacts'));
    }
    public function deleteContact($id)
    {

    }
}
