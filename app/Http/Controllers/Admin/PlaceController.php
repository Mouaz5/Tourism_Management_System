<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Requests\SavePlaceRequest;
use App\Http\Requests\UpdatePlaceRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PlaceController extends Controller
{
//    private function uploadPlaceImage($request){
//        $placeImage = $request->file('image');
//        $imageName = time().$placeImage->getClientOriginalName();
//        $placeImage->move(public_path('tourism/place-images'), $placeImage);
//        $imageUrl = "public/tourism/place-images/$imageName";
//        return $imageUrl;
//    }
    private function uploadPlaceImage($request) {
        $placeImage = $request->file('image');
        if (isset($placeImage)) {
            // Make Unique Name for Image
            $currentDate = Carbon::now()->toDateString();
            $imageName =$currentDate.'-'.uniqid().'.'.$placeImage->getClientOriginalExtension();

            // Check Category Dir is exists
            if (!Storage::disk('public')->exists('place-image')) {
                Storage::disk('public')->makeDirectory('place-image');
            }
            Storage::disk('public')->put('packageImage/'.$imageName,$placeImage);
        }
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

    public function show(Place $place)
    {
        return response()->json($place);
    }

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
            'place' => $place,
            'status' => 'success',
            'message' => 'Place info Update it Successfuly',
        ], 200);
    }

    public function destroy(Place $place)
    {
        $place->delete();
        return response()->json([
            'message' => 'place has been delete it'
        ], 200);
    }
}
