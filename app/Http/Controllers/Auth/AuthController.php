<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\support\facades\Auth;
use Carbon\Carbon;
class AuthController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required',
        ]);

        $mytime = Carbon::now();
        $mytime->toDateTimeString();
        $input = $request->all();
        $user = new User();
        $user->role_id = 2;
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->Mobile = $input['Mobile'];
        $user->password = Hash::make($input['password']);
        $user->card_number = $input['card_number'];
        $user->email_verified_at = $mytime;
        $user->save();

        $token = $user->createToken('Personal Access Token')->plainTextToken;
        $user['token_type'] = 'Bearer';
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
    }
    
    public function login(Request $request) {
        $fileds = $request->validate([
            'email' => 'required|string',
            'password' => 'required',
        ]);
        //Check email
        $user = User::where('email', $fileds['email'])->first();
        //Check Password
        if (!$user || !Hash::check($fileds['password'], $user->password)) {
            return response([
                'message' => 'Bad Login'
            ],401);
        }
        //Create New Token
        $token = $user->createToken('Personal Access Token')->plainTextToken;
        $user['token_type'] = 'Bearer';
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function logout() {
        Auth::user()->tokens->each(function($token, $key) {
            $token->delete();
        });
        return response([
            'Successfully logged out'
        ], 200);
    }
}
