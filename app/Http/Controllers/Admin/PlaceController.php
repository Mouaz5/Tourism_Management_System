<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\City;
use App\Models\Placetype;
use Illuminate\Http\Request;
use App\Http\Requests\SavePlaceRequest;
use App\Http\Requests\UpdatePlaceRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;
class PlaceController extends Controller
{
    protected function uploadPlaceImage($request){
        $placeImage = $request->file('image');
        $imageName = time().$image->getClientOriginalName();
        $directory = 'tourism/place-images/';
        $imageUrl = $directory.$imageName;
        Image::make($placeImage)->save($imageUrl);
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
            $imageUrl = this->uploadPlaceImage($request);
        }
        $place = new Place();
        $place->added_By = Auth::user()->name;
        $place->name = $request->name;
        $place->country_id = $request->country_id;
        $place->city = $request->city;
        $place->rating = $request->rating;
        $place->description = $request->description;
        $place->image = $imageUrl;
        $place->save();

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
    public function show($id)
    {
        $place = DB::table('places')
        ->join('countries', 'countries.id', '=', 'places.id')
        ->where('places.id', $id)
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
    public function update(UpdatePlaceRequest $request, $id)
    {
        $place = Place::findOrFail($id);
        $imageUrl = '';
        if ($request->hasFile('image')) {
            $imageUrl = this->uploadPlaceImage($request);
            $place->image = $imageUrl;
        }
        
        $place->added_By = Auth::user()->name;
        $place->name = $request->name;
        $place->country_id = $request->country_id;
        $place->city = $request->city;
        $place->rating = $request->rating;
        $place->description = $request->description;
        $place->save();

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
    public function destroy($id)
    {
        $place = Place::findOrFail($id);
        $place->delete();
        return response()->json([
            'message' => 'place has been delete it'
        ], 200);

    }
}
