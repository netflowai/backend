<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect(){
        return Socialite::driver('google')->redirect();
    }

    public function callback(){
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->getEmail())->first();
            if($user){
                Auth::login($user);
                return response()->json([
                    'status' => true,
                    'message' => 'login',
                    'token' => $user->createToken("app")->accessToken
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'register',
                    'data' => ['name' => $googleUser->getName(), 'email' => $googleUser->getEmail()],
                ], 200);
            }
        } catch (\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);        }
    }

}
