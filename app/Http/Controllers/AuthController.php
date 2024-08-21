<?php

namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;

class AuthController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'name' => ['required','string'],
            'email' => ['required','email','unique:users'],
            'password' => ['required','string','min:6'],
            ]);
            $user = User::create($data);
            $token = 'aaa'; //$user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'message' => 'User created successfully',
                'user' => $user,
                'token' => $token,

                ]);
            }

    public function login(Request $request){
        $data = $request->validate([
            'email' => ['required','email','exists:users'],
            'password' => ['required','min:6']  
        ]);

        $user = User::where('email',$data['email'])->first();
        if (!$user || !Hash::check($data['password'],$user->password)) {
            return response([
                'message' => 'Login failed',
            ], 401);
        }

        $token = 'aaa'; //$user->createToken('auth_token')->plainTextToken;
        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function userprofile(){
        $userData = auth()->user();
        return response()->json([
            'message' => 'User Profile',
            'data' => $userData,
            'status' => true,
            'id' => auth()->user()->id
            ],200);
    }

    public function logout(){
        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => true,  
            'message' => 'User Logged out',
            'data' => [] ],
             200);
        }

        public function userResource(){
            $userData = new UserResource(User::findOrFail(auth()->user()->id));
            return response()->json([
                'message' => 'User Login Profile using API Resource',
                'data' => $userData,
                'status' => true,
                'id' => auth()->user()->id
                ],200);
        }

        public function userResourceCollection(){
            $userData = UserResource::collection(User::all());
            return response()->json([
                'message' => 'User Login Profile using API Resource Collection',
                'data' => $userData,
                'status' => true,
                'id' => ''
                ],200);
        }

        public function userCollection(){
            $userData = new UserCollection(User::all());
            return response()->json([
                'message' => 'User Login Profile using API Resource',
                'data' => $userData,
                'status' => true,
                'id' => auth()->user()->id
                ],200);
        }
}
