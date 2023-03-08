<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function index(){
        $user = User::all();
        return response()->json([
            "result" => $user,
        ], Response::HTTP_OK);
    }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('authToken')->plainTextToken;
            $user->token = $token;
            return response()->json([
                'success'=> true,
                'status' => 200,
                'message' => 'User created successfully',
                'data' => $user,
            ]);
        } else {
            return response()->json([
                'success'=> false,
                'status' => 401,
                'message' => 'Invalid login credentials',
                'data' => null,
            ]);
        }
    }

    public function register(Request $request){
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'utype' => 'USR',
            'active' => true,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'data' => $user,
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }
}
