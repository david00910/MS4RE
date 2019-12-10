<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    protected function contactUs(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'topic' => 'required|string',
            'message' => 'required',
        ]);

        try {


            Mail::to(config('mail.app_email'))->send(new SendMail($validated));

        } catch (Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'msg' => $e->getMessage()
            ], 400);
        }

        return response()->json([
            'status' => 'Thank you for contacting us! We will get back to you soon.'
        ], 200);

    }
}
