<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use Symfony\Component\Console\Input\Input;

class BuyerController extends Controller
{
    public function getSeller()
    {
        try {
            $seller = DB::table('user_padang_tb')->get();

            return response()->json([
                'success' => true,
                'message' => 'Successfully get seller',
                'seller' => $seller
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'failed getting seller',
                'error' => $e
            ]);
        }
    }

    public function getMenu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $email = $request->input('email');

        try {
            $productItems = DB::table('product_tb')
                ->join('user_padang_tb', 'product_tb.email_id', '=', 'user_padang_tb.email')
                ->where('email_id', $email)
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Successfully get item menu',
                'product' => $productItems
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'failed getting item menu',
                'error' => $e
            ]);
        }
    }

    public function setBuyerLatandLong(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $getUser = DB::table('pembeli_location_tb')->where('email', $request->Input('email'))->get()->count();

            if ($getUser > 0) {
                DB::table('pembeli_location_tb')->where('email', $request->input('email'))->update([
                    'latitude' => $request->input('latitude'),
                    'longitude' => $request->input('longitude'),
                ]);

                return response()->json([
                    'success' => true,
                    'data' => 'success update user lat and long',
                    'tes' => $getUser
                ]);
            } else {
                DB::table('pembeli_location_tb')->insert([
                    'email' => $request->input('email'),
                    'latitude' => $request->input('latitude'),
                    'longitude' => $request->input('longitude'),
                ]);

                return response()->json([
                    'success' => true,
                    'data' => $getUser
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e,
            ]);
        }
    }

    public function getBuyerLatandLong()
    {
        try {
            $getUser = DB::table('pembeli_location_tb')->get();

            return response()->json([
                'success' => true,
                'data' => $getUser
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e,
            ]);
        }
    }

    public function insertBuyerTokens(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'notfication_token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            DB::table('users_tb')->where('email', $request->input('email'))->update([
                'notfication_token' => $request->input('notfication_token')
            ]);

            return response()->json([
                'success' => true,
                'error' => 'No error',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e,
            ]);
        }
    }

    public function getBuyerProfile(Request $request)
    {
        try{
            $data = DB::table('pembeli_profile_tb')->where('email', $request->input('email'))->get();

            return response()->json([
                'success' => true,
                'message' => 'Success',
                'data' => $data
            ]);

        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed getting user profile',
                'data' => 'No data found'
            ]);
        }
    }

    public function setBuyerProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'email' => 'required',
            'profile_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userProfile = DB::table('pembeli_profile_tb')->where('email', $request->input('email'))->get()->count();

        if ($userProfile > 0) {
            if ($request->hasFile('profile_img')) {
                try {
                    $image = $request->file('profile_img');
                    $name = time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('pembeli/profile');
                    $image->move($destinationPath, $name);

                    DB::table('pembeli_profile_tb')
                    ->where('email', $request->input('email'))
                    ->update([
                        'nama' => $request->input('nama'),
                        'no_hp' => $request->input('no_hp'),
                        'alamat' => $request->input('alamat'),
                        'email' => $request->input('email'),
                        'profile_img' => $name,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Successfully add profile'
                    ]);
                } catch (Exception $e) {
                    return response()->json([
                        'success' => false,
                        'message' => $e
                        //'message' => 'Something went wrong, please try again later'
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'You must upload photos or image for item product'
                ]);
            }
        } else {
            if ($request->hasFile('profile_img')) {
                try {
                    $image = $request->file('profile_img');
                    $name = time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('pembeli/profile');
                    $image->move($destinationPath, $name);

                    DB::table('pembeli_profile_tb')->insert([
                        'nama' => $request->input('nama'),
                        'no_hp' => $request->input('no_hp'),
                        'alamat' => $request->input('alamat'),
                        'email' => $request->input('email'),
                        'profile_img' => $name,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Successfully add profile'
                    ]);
                } catch (Exception $e) {
                    return response()->json([
                        'success' => false,
                        'message' => $e
                        //'message' => 'Something went wrong, please try again later'
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'You must upload photos or image for item product'
                ]);
            }
        }
    }

    
}
