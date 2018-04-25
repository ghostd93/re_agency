<?php

namespace App\Http\Controllers;

use App\User;
use App\PersonalData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $data = $request->all();

        $validator = Validator::make($data, [
            "name" => 'required',
            "surname" => 'required',
            "phone_number" => 'required',
            "country" => 'required',
            "city" => 'required',
            "street" => 'required',
            "street_number" => 'required',
            "postal_code" => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 409);
        } else {

            $personalData = new PersonalData([
                    "name" => $data['name'],
                    "surname" => $data['surname'],
                    "phone_number" => $data['phone_number'],
                    "country" => $data['country'],
                    "city" => $data['city'],
                    "street" => $data['street'],
                    "street_number" => $data['street_number'],
                    "postal_code" => $data['postal_code']]
            );

            $personalData->save();

            $user->personalData()->save($personalData);
            $personalData->user()->associate($user)->save();

            return response()->json([
                'message' => 'Personal data has been successfully attached to the user'
            ], 201);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $userId)
    {
        $personalData = PersonalData::ofUser($userId);
        $personalData->update([
            "name" => $request->get('name'),
            "surname" => $request->get('surname'),
            "phone_number" => $request->get('phone_number'),
            "country" => $request->get('country'),
            "city" => $request->get('city'),
            "street" => $request->get('street'),
            "street_number" => $request->get('street_number'),
            "postal_code" => $request->get('postal_code')]);

        return response()->json([
            'message' => 'Personal data has been successfully updated'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId)
    {
        $personalData = PersonalData::ofUser($userId);
        $personalData->destroy();
    }
}
