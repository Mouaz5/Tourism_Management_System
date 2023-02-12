<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SaveGuiderRequest;
use App\Http\Requests\UpdateGuiderRequest;
use App\Models\Guide;
use Illuminate\Support\Facades\DB;
use Image;

class GuideController extends Controller
{
	protected function uploadGuiderImage($request) {
		$guiderImage = $request->file('image');
		$imageName = time().$guiderImage->getClientOriginalName();
		$guiderImage->move(public_path('tourism/guider-images'), $guiderImage);
		$imageUrl = "public/tourism/guider-images/$imageName";
		return $imageUrl;
	}

    public function index()
    {
        $guides = Guide::all();
        return response()->json([
            'guides' => $guides,
        ], 200);
    }

    public function store(SaveGuiderRequest $request)
    {
        $imageUrl = '';
        if ($request->hasFile('image')) {
            $imageUrl = $this->uploadGuiderImage($request);
        }

        $guide = new Guide();
        $guide->name = $request->name;
        $guide->email = $request->email;
        $guide->gender = $request->gender;
        $guide->price = $request->price;
        $guide->country = $request->country;
        $guide->contact = $request->contact;
        $guide->address = $request->address;
        $guide->package_id = $request->package_id;
        $guide->country_id = $request->country_id;
        $guide->save();
        return response()->json([
            'message' => 'guider is added succefully'
        ]);
    }

    public function show($id)
    {
    	$guider = DB::table('guides')
    	->join('packages', 'packages.id', '=', 'guiders.package_id')
    	->join('countries', 'countries.id', '=', 'guiders.country_id')
    	->where('guiders.id', $id)
    	->first();

    	return response()->json([
    		'guider' => $guider
    	], 200);
    }

    public function update(UpdateGuiderRequest $request, $id)
    {
    	$imageUrl = '';
        $guidr = Guider::findOrFail($id);
        if ($request->file('image')) {
        	$imageUrl = $this->uploadGuiderImage($request);
        }
        $guide->name = $request->name;
        $guide->email = $request->email;
        $guide->gender = $request->gender;
        $guide->price = $request->price;
        $guide->country = $request->country;
        $guide->contact = $request->contact;
        $guide->address = $request->address;
        $guide->package_id = $request->package_id;
        $guide->country_id = $request->country_id;
        $guide->save();
        return response()->json([
            'message' => 'guider is updated succefully'
        ], 200);
    }

    public function destroy($id)
    {
        $guider = Guider::findOrFail($id);
        $guider->delete();
        return response()->json([
        	'message' => 'guider is deleted succfully'
        ], 200);
    }
}
