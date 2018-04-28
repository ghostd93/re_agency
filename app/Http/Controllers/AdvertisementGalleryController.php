<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdvertisementGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $advertisementId
     * @return \Illuminate\Http\Response
     */
    public function index($advertisementId)
    {
        $photo = Photo::where('advertisement_id', $advertisementId)->get();

        if($photo->count() == 0){
            return response()->json([
                'message' => 'No images'
            ], 404);
        }

        return response()->json([
            'data' => $photo
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $advertisementId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $advertisementId)
    {
        $advertisement = Advertisement::findOrFail($advertisementId);

        if(!$request->user()->isOwner($advertisement)){
            abort('401', 'This action is unauthorized');
        }

        $data = $request->all();
        $validator = Validator::make($data, [
            'image' => '
                dimensions:min_width=300,min_height=300,max_width:1280,max_height=1280|
                image:jpeg,png,bmp,gif
            '
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 409);
        }

        $file_content = file_get_contents($request->file('image'));
        $file_name = str_random(16) . '.' . $request->file('image')->extension();;
        $path = $advertisementId . '/' . $file_name;

        $photo = new Photo([
            'name' => $file_name,
            'url' => Storage::disk('public_uploads')->url($path),
            'thumb_url' => null
        ]);

        $photo->advertisement()->associate($advertisement);
        $photo->save();

        if(!Storage::disk('public_uploads')->put($path, $file_content)) {
            return response()->json([
                'message' => 'Something went wrong'
            ], 409);
        }

        return response()->json([
            'message' => 'Image has been successfully saved',
            'image_url' => Storage::disk('public_uploads')->url($path)
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($advertisementId, $id)
    {
        $photo = Photo::find($id);

        if($photo == null){
            return response()->json([
                'message' => 'No image'
            ], 404);
        }

        return response()->json([
            'data' => $photo
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
     * @param Request $request
     * @param $advertisementId
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, $advertisementId, $id)
    {
        $advertisement = Advertisement::find($advertisementId);
        if($advertisement != null) {
            if(!$request->user()->isOwner($advertisement)){
                abort('401', 'This action is unauthorized');
            }
        }
        $photo = Photo::findOrFail($id);
        if($photo != null) {
            Storage::disk('public_uploads')->delete($advertisementId . '/' . $photo->name);
            $photo->delete();
            return response()->json([
                'message' => 'Photo has been successfully deleted'
            ], 201);
        }
        return response()->json([
            'message' => 'Nothing to delete'
        ], 409);
    }
}
