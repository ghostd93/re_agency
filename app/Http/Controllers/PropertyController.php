<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\Photo;
use App\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Psy\Exception\FatalErrorException;
use Symfony\Component\Debug\Exception\FatalThrowableError;

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
        $property = Advertisement::findOrFail($advertisementId)->property;
        if($property == null){
            return response()->json([
                'message' => 'No property'
            ], 404);
        }

        return response()->json([
            'data' => $property
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

        if($advertisement->property != null){
            return response()->json([
                'message' => 'Personal data for this user already exists',
                'data' => $advertisement->property
            ], 409);
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

            if (Photo::where("advertisement_id", $advertisement->id)->get()->first()!= null) $advertisement->update([
                "status" => 1]);
            else $advertisement->update([
                "status" => 0]);

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
        $property->update($request->all());

        if (Photo::where("advertisement_id", $advertisement->id)->get()->first()!= null) $advertisement->update([
            "status" => 1]);
        else $advertisement->update([
            "status" => 0]);

        return response()->json([
            'message' => 'Property data has been successfully updated'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $advertisementId
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $advertisementId)
    {
        $advertisement = Advertisement::find($advertisementId);
        if($advertisement != null) {
            if(!$request->user()->isOwner($advertisement)){
                abort('401', 'This action is unauthorized');
            }
        }
        $property = Advertisement::findOrFail($advertisementId)->property;
        if($property != null) {
            $property->delete();
            return response()->json([
                'message' => 'Property data has been successfully deleted'
            ], 201);
        }
        return response()->json([
            'message' => 'Nothing to delete'
        ], 409);
    }
}
