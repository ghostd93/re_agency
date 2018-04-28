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
        $data['user_id'] = $request->user()->id;

        $validator = Validator::make($data, [
            'user_id' => 'required',
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
                'type' => $data['type'],
                'date_of_announcement' => $data['date_of_announcement'],
                'description' => $data['description'],
                'price' => $data['price']]);
            if(!$request->user()->isOwner($advertisement)){
                abort('401', 'This action is unauthorized');
            }
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
        $advertisement = Advertisement::where('id', $id)->get()->first();

        if($advertisement == null){
            return response()->json([
                'message' => 'Advertisement does not exist'
            ], 404);
        }

        return response()->json([
            'data' => $advertisement
        ], 200);
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
        $advertisement->update([
            "type" => $request->get('type'),
            "description" => $request->get('description'),
            "price" => $request->get('price')]);

        return response()->json([
            'message' => 'Advertisement data has been successfully updated'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$advertisementId)
    {
        $advertisement = Advertisement::findOrFail($advertisementId);
        if(!$request->user()->isOwner($advertisement)){
            abort('401', 'This action is unauthorized');
        }
        Advertisement::destroy($advertisementId);
        Storage::disk('public_uploads')->delete($advertisementId);
            return response()->json([
                'message' => 'Advertisement successfully deleted'
            ], 200);
    }
}
