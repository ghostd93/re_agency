<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($advertisementId)
    {
        return response()->json([
            'data' => Property::ofAdvertisement($advertisementId)->get()
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($advertisement_id, Request $request)
    {

        $property = new Property([
            "property_type" => $request->get('property_type'),
            "description" => $request->get('description'),
            "date_of_registration" => $request->get('date_of_registration'),
            "property_area" => $request->get('property_area'),
            "date_of_construction" => $request->get('date_of_construction'),
            "number_of_floors" => $request->get('number_of_floors'),
            "number_of_rooms" => $request->get('number_of_rooms'),
            "floor" => $request->get('floor'),
            "balcony" => $request->get('balcony'),
            "garage" => $request->get('garage'),
            "land_area" => $request->get('land_area'),
            "country" => $request->get('country'),
            "city" => $request->get('city'),
            "street" => $request->get('street'),
            "street_number" => $request->get('street_number'),
            "postal_code" => $request->get('postal_code')]);

        $validator = Validator::make($property,[
            "property_type" => 'required',
            "description" => 'required',
            "date_of_registration" => 'required',
            "property_area" => 'required',
            "date_of_construction" => 'required',
            "country" => $request->get('country'),
            "city" => $request->get('city'),
            "street" => $request->get('street'),
            "street_number" => $request->get('street_number'),
            "postal_code" => $request->get('postal_code')]
        );

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 409);
        } else {

            $property->save();

            return response()->json([
                'message' => 'Property has been successfully attached to the advertisement'
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $advertisementId)
    {
        $property = Property::ofAdvertisement($advertisementId);
        $property->update([
            "property_type" => $request->get('property_type'),
            "description" => $request->get('description'),
            "date_of_registration" => $request->get('date_of_registration'),
            "property_area" => $request->get('property_area'),
            "date_of_construction" => $request->get('date_of_construction'),
            "estete_status" => $request->get('estete_status'),
            "number_of_floors" => $request->get('number_of_floors'),
            "number_of_rooms" => $request->get('number_of_rooms'),
            "floor" => $request->get('floor'),
            "balcony" => $request->get('balcony'),
            "garage" => $request->get('garage'),
            "destiny" => $request->get('destiny'),
            "land_area" => $request->get('land_area'),
            "management" => $request->get('management'),
            "country" => $request->get('country'),
            "city" => $request->get('city'),
            "street" => $request->get('street'),
            "street_number" => $request->get('street_number'),
            "postal_code" => $request->get('postal_code')]);

        return response()->json([
            'message' => 'Property data has been successfully updated'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($advertisementId)
    {
        $property = Property::ofAdvertisement($advertisementId);
        $property->destroy();
    }
}
