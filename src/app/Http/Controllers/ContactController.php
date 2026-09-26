<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactSystemMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function send(ContactRequest $request)
    {
        $validated = $request->validated();

        $adminEmails = User::where('role', 'admin')->pluck('email')->toArray();

        if (empty($adminEmails)) {
            $adminEmails = [config('mail.from.address')]; // デフォルトの送信元アドレスなどに逃がす
        }

        // 管理者全員（または最初の1人）宛にメール送信
        Mail::to($adminEmails)->send(new ContactSystemMail($validated));

        return redirect()->route('contact.thanks');
    }



    public function thanks()
    {
        return view('contact.thanks');
    }

}
