<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\VerificationMail;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class EmailVerificationController extends Controller
{
    public function sendEmail(Request $request) {
        $validator = Validator::make($request->all(), [
            'email_address' => 'required|email',
            'verification_code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
 
        try{
            $to_email = $request->input('email_address');
            $verification_code = $request->input('verification_code');
            Mail::to($to_email)->send(new VerificationMail($verification_code));

            return response()->json([
                'success' => true,
                'message' => 'Please check your Gmail inbox to get Verification Code'
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed send email verification, please try again leter. Error: '.$e
            ]);
        }
    }
}
