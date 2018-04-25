<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles('administrator');
        return response()->json([
            'data' => User::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
            'password' => bcrypt($data['password'])
        ]);
        $user->save();
        $role = \App\Role::where('role_name', 'user')->first();
        $user->roles()->attach($role);
        return response()->json([
           'message' => 'User successfully created'
        ], 201);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'data' => User::where('id', $id)->get()
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(User::findOrFail($id)){
            User::destroy($id);
            return response()->json([
                'message' => 'User successfully deleted'
            ], 200);
        }
        return response()->json([
            'message' => 'User deletion failed'
        ],409);

    }
}
