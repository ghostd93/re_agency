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
        $advertisements = Advertisement::with('property', 'photos', 'user')
            ->where('status',3)
            ->paginate(10);
        return $advertisements;
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
                'status' => 0,
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
        $advertisement = Advertisement::where(['id' => $id, 'status' => 3])
            ->get()
            ->load('property', 'photos', 'user')
            ->first();

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

        $advertisement->update($request->except('status'));

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

    /**
     * @param Request $request
     * @return array
     */
    public function search(Request $request)
    {
        $search_query = $request->get('query');
        $paginate = Advertisement::search($search_query)->paginate(10);
        $advertisements = $paginate->where('status', 3);
        $advertisements->load('property');
        $return = [
            'current_page' => $paginate->currentPage(),
            'data' => $advertisements,
            'first_page_url' => $paginate->url(1),
            'from' => $paginate->firstItem(),
            'last_page' => $paginate->lastPage(),
            'last_page_url' => $paginate->url($paginate->lastPage()),
            'next_page_url' => $paginate->nextPageUrl(),
            'per_page' => $paginate->perPage(),
            'prev_page_url' => $paginate->previousPageUrl(),
            'to' => $paginate->lastItem(),
            'total' => $paginate->total()
        ];
        return $return;
    }

    public function verification(Request $request)
    {
        $request->user()->authorizeRoles('administrator');

        return response()->json([
            'data' => Advertisement::where('status',1)->get()
        ], 200);
    }

    public function changeStatus(Request $request, $advertisementId)
    {
        $request->user()->authorizeRoles('administrator');

        $advertisement = Advertisement::findOrFail($advertisementId);

        $validator = Validator::make($request->all(), [
            'status' => 'required|integer|between:2,3'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 200);
        }

        if($advertisement->update($request->all())){
            return response()->json([
                'message' => 'Status has been successfully updated'
            ], 200);
        }

        return response()->json([
            'message' => 'Something went wrong'
        ], 409);
    }
}
