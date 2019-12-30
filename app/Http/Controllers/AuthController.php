<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password'  => 'required|min:3|confirmed',
        ]);
        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json(['status' => 'success'], 200);
    }

    public function login(Request $request)
    {
        // $credentials = $request->only('email', 'password');
        // if ($token = $this->guard()->attempt($credentials)) {
        //     return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
        // }
        // return response()->json(['error' => 'login_error'], 401);
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $status = false;
        $message = "";
        $data = null;

        $credentials = $request->only('email', 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            $user = User::find(Auth::user()->id);
            $data = $user;
            $message = "Success";
            $status = true;
            $data['token'] = $token;
            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data,
            ], 200);
        }
        return response()->json(['error' => 'login_error'], 401);
    }

    public function logout()
    {
        $this->guard('users')->logout();
        return response()->json([
            'status' => true,
            'message' => 'Logged out Successfully.'
        ], 200);
    }

    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }
    /**
     * Return auth guard
     */
    private function guard()
    {
        return Auth::guard();
    }

    // private function guard($user)
    // {
    //     return Auth::guard($user);
    // }
}
