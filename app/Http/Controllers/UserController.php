<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function getProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $email = $request->input('email');

        try {
            $product = DB::table('product_tb')
                ->where('email_id', $email)
                ->join('user_padang_tb', 'product_tb.email_id', '=', 'user_padang_tb.email')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Successfully get item product',
                'product' => $product
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'failed getting item product',
                'error' => $e
            ]);
        }
    }

    public function uploadItem(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'subTitle' => 'required',
            'price' => 'required',
            'image_item' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('image_item')) {

            try {
                $image = $request->file('image_item');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('pedagang/product_items');
                $image->move($destinationPath, $name);

                DB::table('product_tb')->insert([
                    'title' => $request->input('title'),
                    'sub_title' => $request->input('subTitle'),
                    'price' => $request->input('price'),
                    'product_image_name' => $name,
                    'email_id' => $request->input('email_id'),
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Successfully add item product'
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

    public function updateItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'title' => 'required',
            'subTitle' => 'required',
            'price' => 'required',
            'image_item' => 'required',
            'email_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('image_item')) {

            $productData = DB::table('product_tb')->where('email_id', $request->input('email'));
            $oldFileName = $productData->value('product_image_name');

            try {
                $image = $request->file('image_item');
                $name = time() . '.' . $image->getClientOriginalExtension();
                unlink(public_path('pedagang/product_items/' . $oldFileName));
                $destinationPath = public_path('pedagang/product_items');
                $image->move($destinationPath, $name);

                DB::table('product_tb')->where('email_id', $request->input('email'))->update([
                    'title' => $request->input('title'),
                    'sub_title' => $request->input('subTitle'),
                    'price' => $request->input('price'),
                    'product_image_name' => $name,
                    'email_id' => $request->input('email_id'),
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Successfully update item product'
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e,
                    'message2' => $oldFileName
                ]);
            }
        } else {
            try {
                DB::table('product_tb')->where('email_id', $request->input('email'))->update([
                    'title' => $request->input('title'),
                    'sub_title' => $request->input('subTitle'),
                    'price' => $request->input('price'),
                    'product_image_name' => $request->input('image_item'),
                    'email_id' => $request->input('email_id'),
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Successfully update item product'
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e
                    //'message' => 'Something went wrong, please try again later'
                ]);
            }
        }
    }

    public function setUserLatandLong(Request $request)
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
            $getUser = DB::table('pedagang_location_tb')->where('email', $request->Input('email'))->count();

            if ($getUser > 0) {
                DB::table('pedagang_location_tb')->where('email', $request->input('email'))->update([
                    'latitude' => $request->input('latitude'),
                    'longitude' => $request->input('longitude'),
                ]);

                return response()->json([
                    'success' => true,
                    'data' => 'success update user lat and long',
                ]);
            } else {
                DB::table('pedagang_location_tb')->insert([
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

    public function getUserLatandLong()
    {
        try {
            $getUser = DB::table('pedagang_location_tb')
                ->join('user_padang_tb', 'pedagang_location_tb.email', '=', 'user_padang_tb.email')
                ->get();

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

    public function getBuyerTokens()
    {
        try {
            $tokens = DB::table('users_tb')->select('notfication_token')->get();
            $tokenArray = [];

            foreach($tokens as $item){
                if($item->notfication_token != ""){
                    $tokenArray[] = [
                        'notfication_token' => $item->notfication_token
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Successfully get buyer tokens',
                'tokens' => $tokenArray
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'failed getting buyer tokens',
                'error' => $e
            ]);
        }
    }

    public function getUserProfile(Request $request)
    {
        try {
            $data = DB::table('user_padang_tb')->where('email', $request->input('email'))->get();

            return response()->json([
                'success' => true,
                'message' => 'Success',
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed getting user profile',
                'data' => 'No data found'
            ]);
        }
    }

    public function setUserProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'nama_toko' => 'required',
            'desc_toko' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userProfile = DB::table('user_padang_tb')->where('email', $request->input('email'))->get()->count();

        if ($userProfile > 0) {
            if ($request->hasFile('image')) {
                try {
                    $image = $request->file('image');
                    $name = time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('pedagang/profiles');
                    $image->move($destinationPath, $name);

                    DB::table('user_padang_tb')
                        ->where('email', $request->input('email'))
                        ->update([
                            'email' => $request->input('email'),
                            'nama' => $request->input('nama'),
                            'alamat' => $request->input('alamat'),
                            'no_hp' => $request->input('no_hp'),
                            'nama_toko' => $request->input('nama_toko'),
                            'desc_toko' => $request->input('desc_toko'),
                            'image' => $name,
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
            if ($request->hasFile('image')) {
                try {
                    $image = $request->file('image');
                    $name = time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('pembeli/profile');
                    $image->move($destinationPath, $name);

                    DB::table('user_padang_tb')->insert([
                            'email' => $request->input('email'),
                            'nama' => $request->input('nama'),
                            'alamat' => $request->input('alamat'),
                            'no_hp' => $request->input('no_hp'),
                            'nama_toko' => $request->input( 'nama_toko'),
                            'desc_toko' => $request->input('desc_toko'),
                            'image' => $name,
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
