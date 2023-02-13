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
    private function uploadHotelImage($request) {
        $hotelImage = $request->file('image');
        $imageName = time().$hotelImage->getClientOriginalName();
        $hotelImage->move(public_path('tourism/hotel-images'), $hotelImage);
        $imageUrl = "public/tourism/hotel-images/$imageName";
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
            $imageUrl = $this->uploadHotelImage($request);
        }

        $hotel = Hotel::query()->create($request->validated() +
            ['imageUrl' => $imageUrl] +
            ['added_By' => Auth::user()->name]);

        return response()->json([
            'data' => $hotel,
            'message' => 'hotel added successfully',
        ], 200);
    }

    public function show(Hotel $hotel) {
        return response()->json($hotel);
    }

    public function update(UpdateHotelRequest $request, Hotel $hotel) {

        $imageUrl = '';
        if ($request->hasFile('image')) {
            $imageUrl = $this->uploadHotelImage($request);
            $hotel->image = $imageUrl;
        }

        $hotel->update($request->validated() +
            ['added_By' => Auth::user()->name]);

        return response()->json([
            'data' => $hotel,
            'message' => 'hotel info updated successfully',
        ], 200);
    }

    public function destroy(Hotel $hotel){
        $hotel->delete();
        return response([
            'message' => 'hotel removed successfully'
        ], 200);
    }

}
