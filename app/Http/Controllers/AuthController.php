<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = DB::table('users_tb')->where('email', $request->input('email'));
        $login = $user->value('email');
        $role = $user->value('role');
        $varified_status = $user->value('varified_status');
        
        if ($login) {
            if (Hash::check($request->input('password'), $user->value('password'))) {
                if ($varified_status == 1) {

                    return response()->json([
                        'success' => true,
                        'message' => 'Login success',
                        'user' => $login,
                        'role' => $role
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Your account wasn\'t verified. Please verified status first'
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Password wrong'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Email wrong'
            ]);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'email' => 'required|string|email|max:100|unique:users_tb,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        DB::table('users_tb')->insert([
            'nama' => $request->input('nama'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
            'notfication_token' => '',
            'verification_code' => $request->input('verification_code'),
            'varified_status' => $request->input('varified_status')
        ]);

        if ($request->input('role') == 'pedagang') {
            $data = DB::table('user_padang_tb')->where('email', $request->input('email'))->get()->count();

            if($data < 1){
                try{
                    DB::table('user_padang_tb')->insert([
                        'email' => $request->input('email'),
                        'nama' => $request->input('nama'),
                        'alamat' => '',
                        'no_hp' => '',
                        'nama_toko' => '',
                        'desc_toko' => '',
                        'image' => ''
                    ]);
                    return response()->json([
                        'success' => true,
                        'message' => 'Register Successfully'
                    ], 201);

                }catch(Exception $e){
                    return response()->json([
                        'success' => false,
                        'message' => 'Register error',
                        'tes' => $e
                    ], 201);
                } 
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Account allready register'
                ], 201);
            }

        } elseif ($request->input('role') == 'pembeli') {
            $data = DB::table('pembeli_profile_tb')->where('email', $request->input('email'))->get()->count();

            if($data < 1){
                try{
                    DB::table('pembeli_profile_tb')->insert([
                        'nama' => $request->input('nama'),
                        'no_hp' => '',
                        'alamat' => '',
                        'email' => $request->input('email'),
                        'profile_img' => ''
                    ]);
                    return response()->json([
                        'success' => true,
                        'message' => 'Register Successfully'
                    ], 201);
                    
                }catch(Exception $e){
                    return response()->json([
                        'success' => false,
                        'message' => 'Register error',
                        'tes' => $e
                    ], 201);
                }
                
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Account allready register'
                ], 201);
            }
        }

        
    }

    public function resetPassword(Request $request)
    {
        $email = $request->input('email');
        $password = bcrypt($request->input('password'));

        $updatePassword = DB::table('users_tb')->where('email', $email)->update(['password' => $password]);

        if ($updatePassword) {
            return response()->json([
                'success' => true,
                'message' => 'Update password success'
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Update password failed'
            ]);
        }
    }

    public function updateVerificationCode(Request $request)
    {
        $email = $request->input('email');
        $verification_code = $request->input('verification_code');

        $updateCerificationCode = DB::table('users_tb')->where('email', $email)->update(['verification_code' => $verification_code]);

        if ($updateCerificationCode) {
            return response()->json([
                'success' => true,
                'message' => 'Update verification Code success'
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Verification failed, please correct your email'
            ]);
        }
    }

    public function updateVerificationStatus(Request $request)
    {
        $email = $request->input('email');
        $verification_status = $request->input('verification_status');

        $updateCerificationStatus = DB::table('users_tb')->where('email', $email)->update(['varified_status' => $verification_status]);

        if ($updateCerificationStatus) {
            return response()->json([
                'success' => true,
                'message' => 'Update verification Status success'
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Update verification Status failed'
            ]);
        }
    }

    public function userProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user =  DB::table('users_tb')->where('email', $request->input('email'))->get();

        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'User found',
                'user' => $user
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 201);
        }
    }
}
