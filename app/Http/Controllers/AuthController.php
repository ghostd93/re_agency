<?php

namespace App\Http\Controllers;

use App\Mail\ActivateAccount;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $validator = Validator::make(\request()->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 200);
        }

        $credentials = request(['email', 'password']);

        $user = User::where('email', $credentials['email'])->first();

        if($user != null) {
            if (!$user->active) {
                $token = JWTAuth::fromUser($user);
                Mail::to($user)->send(new ActivateAccount($token));
                return response()
                    ->json([
                        'error' => 'Your account is not active. The activation link was sent again'
                    ], 401);
            }
        }

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 409);
        }
        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'active' => false
        ]);

        $user->save();
        $role = \App\Role::where('role_name', 'user')->first();
        $user->roles()->attach($role);

        $token = JWTAuth::fromUser($user);
//        return new ActivateAccount($token);
        Mail::to($user)->send(new ActivateAccount($token));
        return response()->json([
            'message' => 'User successfully created'
        ], 201);
    }

    public function activate()
    {
        $user = Auth::user();
        $user->update(['active' => 1]);
        return response()->json([
            'message' => 'User successfully activated'
        ], 201);
    }
}
