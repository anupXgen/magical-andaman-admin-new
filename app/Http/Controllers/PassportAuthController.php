<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Webuser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
// Client ID: 1
// Client secret: IYgTjrcryDwpAgibNJQps27G0MgHKfdweB2ZaB64

class PassportAuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        //echo "<pre>".$request->name;print_r($request->all());die;
        $Webuser = Webuser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $Webuser->createToken('LaravelAuthApp')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    // public function login(Request $request)
    // {
    //     $data = [
    //         'email' => $request->email,
    //         'password' => $request->password
    //     ];

    //     if (auth()->guard('api')->attempt($data)) {
    //         $token = auth()->guard('api')->user()->createToken('LaravelAuthApp')->accessToken;
    //         return response()->json(['token' => $token], 200);
    //     } else {
    //         return response()->json(['error' => 'Unauthorised'], 401);
    //     }
    // }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            //'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $user = Webuser::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token, 'user' => $user];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" => 'User does not exist'];
            return response($response, 422);
        }
    }
    public function logout(Request $request)
    {
        //echo "<pre>";print_r($request->all());die;
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
    public function Hello(Request $request)
    {
        // //echo "<pre>";print_r($request->all());die;
        // $token = $request->user()->token();
        // $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
