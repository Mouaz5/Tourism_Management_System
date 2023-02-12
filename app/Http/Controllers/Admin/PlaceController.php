<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;
use App\Http\Requests\SavePlaceRequest;
use App\Http\Requests\UpdatePlaceRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class PlaceController extends Controller
{
    private function uploadPlaceImage($request){
        $placeImage = $request->file('image');
        $imageName = time().$placeImage->getClientOriginalName();
        $placeImage->move(public_path('tourism/place-images'), $placeImage);
        $imageUrl = "public/tourism/place-images/$imageName";
        return $imageUrl;
    }

    public function index()
    {
        $places = Place::all();
        $placecount = Place::all()->count();
        return response()->json([
           'places' => $places,
           'placecount' => $placecount,
        ], 200);
    }

    public function store(SavePlaceRequest $request)
    {
        $imageUrl = '';
        if ($request->hasFile('image')) {
            $imageUrl = $this->uploadPlaceImage($request);
        }

        $place = Place::query()->create($request->validated() +
            ['image' => $imageUrl] +
            ['added_By' => Auth::user()->name]);

        return response()->json([
           'data' => $place,
           'message' => 'place added Successfuly',
        ], 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Place $place)
    {
        $place = DB::table('places')
        ->join('countries', 'countries.id', '=', 'places.id')
        ->where('places.id', $place->id)
        ->increment('views')
        ->first();
        return response()->json([
            'place' => $place
        ], 200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlaceRequest $request, Place $place)
    {
        $imageUrl = '';
        if ($request->hasFile('image')) {
            $imageUrl = $this->uploadPlaceImage($request);
            $place->image = $imageUrl;
        }
        $place = Place::query()->update($request->validated() +
            ['added_By' => Auth::user()->name]);

        return response()->json([
            'data' => $place,
            'message' => 'Place info Update it Successfuly',
        ], 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        $place->delete();
        return response()->json([
            'message' => 'place has been delete it'
        ], 200);
    }
}
