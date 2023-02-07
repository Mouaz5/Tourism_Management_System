<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SaveHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
use App\Models\Hotel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;

class HotelController extends Controller
{
    protected function uploadHotelImage($request) {
        $hotelImage = $request->file('image');
        $imageName = time().$hotelImage->getClientOriginalName();
        $directory = 'tourism/hotel-images/';
        $imageUrl = $directory.$imageName;
        Image::make($hotelImage)->save($imageUrl);
        return $imageUrl;
    }

    public function index(){
        $hotels = Hotel::all();
        return response()->json([
            'hotels' => $hotels
        ], 200);
    }

    public function store(SaveHotelRequest $request) {
        
        $imageUrl = '';
        if ($request->hasFile('image')) {
            $imageUrl = this->uploadHotelImage($request);
        }
        $hotel = new Hotel();
        $hotel->h_name = $request->h_name;
        $hotel->added_by = Auth::user()->name;
        $hotel->image = $imageUrl;
        $hotel->city = $request->city;
        $hotel->country_id = $request->country_id;
        $hotel->description = $request->description;
        $hotel->save();
        return response()->json([
            'data' => $hotel,
            'message' => 'hotel added successfully',
        ], 200);
    }

    public function show($id){
        $hotel = DB::table('hotels')
        ->join('countries', 'countries.id', '=', 'hotels.country_id')
        ->where('hotels.id', $id)
        ->increment('views')
        ->first();
        return response()->json([
            'hotel' => $hotel
        ], 200);
    }

    public function update(UpdateHotelRequest $request, $id) {
        
        $hotel = Hotel::findOrFail($id);
        $imageUrl = '';
        if ($request->hasFile('image')) {
            $imageUrl = this->uploadHotelImage($request);
        }
        $hotel->h_name = $request->h_name;
        $hotel->added_by = Auth::user()->name;
        $hotel->image = $imageUrl;
        $hotel->rate = $request->rate;
        $hotel->city = $request->city;
        $hotel->country_id = $request->country_id;
        $hotel->description = $request->description;
        $hotel->save();
        return response()->json([
            'data' => $hotel,
            'message' => 'hotel info updated successfully',
        ], 200);
    }

    public function destroy($id){
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();
        return response([
            'message' => 'hotel removed successfully'
        ], 200);
    }

}
