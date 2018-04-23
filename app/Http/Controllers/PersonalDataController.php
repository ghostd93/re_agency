<?php

namespace App\Http\Controllers;

use App\User;
use App\PersonalData;
use Illuminate\Http\Request;

class PersonalDataController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param int $userId
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        //return PersonalData::ofUser($userId)->get();
        return response()->json([
            'data' => PersonalData::ofUser($userId)->get()
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param $userId
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store($userId, Request $request)
    {
        $user = User::find($userId);
        $personalData = new PersonalData([
            'user_id' => $user->id,
            "name" => $request->get('name'),
            "surname" => $request->get('surname'),
            "phone_number" => $request->get('phone_number'),
            "country" => $request->get('country'),
            "city" => $request->get('city'),
            "street" => $request->get('street'),
            "street_number" => $request->get('street_number'),
            "postal_code" => $request->get('postal_code')]);
        $user->personalData()->save($personalData);
        $user->personal_data_id = $personalData->id;
        $user->save();

        return response()->json([
            'message' => 'Personal data has been successfully attached to the user'
        ], 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
