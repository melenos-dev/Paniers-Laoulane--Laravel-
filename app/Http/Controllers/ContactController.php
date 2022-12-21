<?php

namespace App\Http\Controllers;

use Mail;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function __construct()
    {

    }

    public function getForm()
    {
    	return view ('contact');
    }

    public function postForm(ContactRequest $request)
    {
    	Mail::send('emails/email_contact', $request->validated(), function($message)
    	{
    		$message->to(config('app.adminMail'))->subject(__('Message from contact page'));
    	});
        return redirect(route('welcome'))->withOk(__('Email sent succesfully, thank you for your interest ! See you soon'));
    }
}