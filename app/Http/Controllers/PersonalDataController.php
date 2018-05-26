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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index($userId, Request $request)
    {

        $personalData = PersonalData::ofUser($userId)->get()->first();

        if($personalData == null){
            return response()->json([
                'message' => 'No personal data'
            ], 404);
        }

        if(!$request->user()->isOwner($personalData)){
            abort('401', 'This action is unauthorized');
        }

        return response()->json([
            'data' => $personalData
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

        if(!$request->user()->isOwner($user)){
            abort('401', 'This action is unauthorized');
        }

        if(PersonalData::ofUser($userId)->get()->first() != null){
            return response()->json([
                'message' => 'Personal data for this user already exists',
                'data' => PersonalData::ofUser($userId)->get()->first()
            ], 409);
        }

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
     * @param  \Illuminate\Http\Request $request
     * @param $userId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $userId)
    {
        $personalData = PersonalData::ofUser($userId)->get()->first();

        if($personalData != null) {

            if (!$request->user()->isOwner($personalData)) {
                abort('401', 'This action is unauthorized');
            }

            $personalData->update($request->all());

            return response()->json([
                'message' => 'Personal data has been successfully updated'
            ], 201);

        } else {

            $personalData->save($request->all());

            $request->user()->personalData()->save($personalData);
            $personalData->user()->associate($request->user())->save();

            return response()->json([
                'message' => 'Personal data has been successfully updated'
            ], 201);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $userId
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId, Request $request)
    {
        $personalData = PersonalData::ofUser($userId)->first();

        if($personalData == null){
            return response()->json([
                'message' => 'Nothing to delete'
            ], 409);
        }

        if(!$request->user()->isOwner($personalData)){
            abort('401', 'This action is unauthorized');
        }

        $personalData->delete();

        return response()->json([
            'message' => 'Personal data has been successfully deleted'
        ], 200);
    }
}
