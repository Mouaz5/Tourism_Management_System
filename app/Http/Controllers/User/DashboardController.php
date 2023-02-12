<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Country;
use App\Models\Place;
use App\Models\User;
use App\Models\Booking;
use App\Models\Hotel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function index() {
        $packages = Package::with('country')->get();
        return $packages;
    }

    public function getPlaces(){
        $places = Place::latest()->get();
        $placeCount = Place::all()->count();
        return response()->json([
            'places' => $places,
            'placeCount' => $placeCount,
        ]);
    }

    public function getPlaceByCountry(Country $country) {
        $places = $country->places()->get();
        return response()->json(['data' => $places]);
    }

    public function getPlaceDetails(Place $place){
        $place->increment('views');
        $data = Place::with('country')
            ->where('id', $place->id)
            ->get();
        return response()->json(['data' => $data]);
    }

    public function getPackage() {
        $packages = Package::latest()->get();
        return response()->json(['data' => $packages]);
    }

    public function getPackageDetails($id) {
        $package = DB::table('packages')
        ->join('countries','countries.id', '=', 'packages.country_id')
        ->join('list_places', 'list_places.package_id', '=', 'packages.id')
        ->select('packages.*', 'countries.name as country_name')
        ->where('packages.id', '=', $id)
        ->first();

        return response()->json([
            'package' => $package
        ], 200);

    }

    public function getPackageByCountry(Country $country) {
        $package = $country->packages()->get();
        //$package = Package::where('country_id', $country['id'])->get();
        return response()->json(['data' => $package]);
    }

    public function showProfile() {
        $user = User::findOrFail(Auth::id());
        return response()->json(['user' => $user]);
    }

    public function updateProfile(Request $request) {
        $profile = Auth::id();
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        $profile = User::findOrFail($profile);
        $profile->name = $request->name;
        $profile->email = $request->email;
        $profile->password = $request->password;
        $profile->save();

        return response()->json([
            'message' => 'Profile Updated Successfully'
        ]);
    }

    public function getHotels(){
        $hotels = Hotel::latest()->get();
        return response()->json([
            'hotels' => $hotels,
        ]);
    }

    public function getHotelDetails($id){
        $hotel = Hotel::findOrFail($id);
        return response()->json(['data' => $hotel]);
    }

    public function getHotelByCountry($id) {
        $country = Country::findOrFail($id);
        //$hotels = Hotel::where('country_id', $country['id'])->first();
        $hotels = $country->hotels()->get();
        return response()->json(['data' => $hotels]);
    }
}
