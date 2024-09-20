<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Jobs\SendEmailJob;

class EmailController extends Controller
{
    public function sendBulkEmails()
    {
        $users = User::all(); // Fetch all users from the database

        $message = "Hello, welcome to our my website page";
        $subject = "hey sir how are you";

        foreach ($users as $user) {
            SendEmailJob::dispatch($user->email, $message, $subject);
        }

        return response()->json(['message' => 'Emails have been dispatched successfully!']);
    }
}
