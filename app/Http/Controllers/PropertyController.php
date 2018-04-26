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
     * @param $advertisementId
     * @return \Illuminate\Http\Response
     */
    public function index($advertisementId)
    {
        return response()->json([
            'data' => Advertisement::find($advertisementId)->property
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $advertisementId
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store($advertisementId, Request $request)
    {
        $advertisement = Advertisement::find($advertisementId);
        if(!$request->user()->isOwner($advertisement)){
            abort('401', 'This action is unauthorized');
        }
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
        $validator = Validator::make($request->all(),[
            "property_type" => 'required',
            "description" => 'required',
            "date_of_registration" => 'required',
            "country" => 'required',
            "city" => 'required',
            "street"=> 'required',
            "street_number"=> 'required',
            "postal_code" => 'required']
        );
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 409);
        } else {
            $property->save();

            $property->advertisement()->save($advertisement);
            $advertisement->property()->associate($property)->save();

            return response()->json([
                'message' => 'Property has been successfully attached to the advertisement'
            ], 201);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $advertisementId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $advertisementId)
    {
        $advertisement = Advertisement::find($advertisementId);
        if(!$request->user()->isOwner($advertisement)){
            abort('401', 'This action is unauthorized');
        }
        $property = Advertisement::find($advertisementId)->property;
        $property->update([
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

        return response()->json([
            'message' => 'Property data has been successfully updated'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $advertisementId
     * @return void
     */
    public function destroy(Request $request, $advertisementId)
    {
        $advertisement = Advertisement::find($advertisementId);
        if(!$request->user()->isOwner($advertisement)){
            abort('401', 'This action is unauthorized');
        }
        $property = Advertisement::findOrFail($advertisementId)->property;
        $property->delete();
    }
}
