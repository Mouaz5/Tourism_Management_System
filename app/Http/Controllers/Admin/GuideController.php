<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SaveGuiderRequest;
use App\Http\Requests\UpdateGuiderRequest;
use App\Models\Guide;

class GuideController extends Controller
{
	private function uploadGuiderImage($request) {
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

        $guider = Guide::query()->create($request->validated() + ['image' => $imageUrl]);
        return response()->json([
            'message' => 'guider is added succefully'
        ]);
    }

    public function show(Guide $guide)
    {
    	return response()->json($guide);
    }

    public function update(SaveGuiderRequest $request, Guide $guider)
    {
    	$imageUrl = '';
        if ($request->file('image')) {
        	$imageUrl = $this->uploadGuiderImage($request);
        	$guider->image = $imageUrl;
        }

        $guider = Guide::query()->update($request->validated());

        return response()->json([
            'guider' => $guider,
            'message' => 'guider is updated succefully'
        ], 200);
    }

    public function destroy(Guide $guider)
    {
        $guider->delete();
        return response()->json([
        	'message' => 'guider is deleted succfully'
        ], 200);
    }
}
