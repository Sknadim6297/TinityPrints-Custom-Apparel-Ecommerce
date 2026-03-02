<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
// use Illuminate\Http\Request;

class ContactController extends Controller
{
  

public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'phone' => 'required',
        'email' => 'required|email',
        'message' => 'required'
    ]);

    Contact::create($request->all());

    return back()->with('success', 'Message sent successfully!');
} 
}
