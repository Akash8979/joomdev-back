<?php

namespace App\Http\Controllers;

use App\Mail\JoomMail;
use App\Models\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    public function sendEmail(Request $req)
    {

        Mail::to($req->mail)->send(new JoomMail($req->body));

        return 'true';
    }

    public function login(Request $req)
    {
        return $req;
    }
}
