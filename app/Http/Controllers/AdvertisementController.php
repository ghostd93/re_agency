<?php

namespace App\Http\Controllers;

use App\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return Advertisement::all();
        return response()->json([
            'data' => Advertisement::all()
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
            'user_id' => 'required',
            'property_id' => 'required',
            'status' => 'required',
            'type' => 'required',
            'date_of_announcement' => 'required',
            'description' => 'required',
            'price' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 200);
        } else {

            $advertisement = new Advertisement([
                'user_id' => $data['user_id'],
                'property_id' => $data['property_id'],
                'status' => $data['status'],
                'type' => $data['type'],
                'date_of_announcement' => $data['date_of_announcement'],
                'description' => $data['description'],
                'price' => $data['price']]);
            $advertisement->save();

            return response()->json([
                'message' => 'Advertisement successfully created'
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
        return response()->json([
            'data' => Advertisement::where('id', $id)->get()
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
        if(Advertisement::findOrFail($id)){
            Advertisement::destroy($id);
            return response()->json([
                'message' => 'Advertisement successfully deleted'
            ], 200);
        }
        return response()->json([
            'message' => 'Advertisement deletion failed'
        ],409);
    }
}
