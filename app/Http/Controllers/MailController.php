<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

use App\Mail\TestMail;

class MailController extends Controller
{
    public function send()
    {
        $name = 'テスト　ユーザー';
        $email = 'test@test.com';

        Mail::send(new TestMail($name, $email));

        return Inertia::render('Dashboard');
    }
}
