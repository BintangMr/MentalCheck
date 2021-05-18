<?php

namespace App\Http\Controllers;

use App\Mail\Feedback;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    public function feedback(Request $request){
        $admin = User::where('admin',true)->get();

        $nama = $request->nama;
        $email = $request->email;
        $pesan = $request->pesan;

        foreach ($admin as $recipient) {
            Mail::to($recipient->email)->send(new Feedback($nama, $email, $pesan));
        }

        return response()->json('success');
    }
}
