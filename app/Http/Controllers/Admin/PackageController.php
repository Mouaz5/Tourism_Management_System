<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SavePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
//    private function uploadPackageImage($request){
//        $packageImage = $request->file('package_image');
//        $imageName = time().$packageImage->getClientOriginalName();
//        $packageImage->move(public_path('tourism/package-images'), $packageImage);
//        $imageUrl = "public/tourism/package-images/$imageName";
//        return $imageUrl;
//    }

    private function uploadPackageImage($request) {
      $packageImage = $request->file('package_image');
      if (isset($packageImage)) {
          // Make Unique Name for Image
          $currentDate = Carbon::now()->toDateString();
          $imageName =$currentDate.'-'.uniqid().'.'.$packageImage->getClientOriginalExtension();

          // Check Category Dir is exists
          if (!Storage::disk('public')->exists('package-image')) {
              Storage::disk('public')->makeDirectory('package-image');
          }
          Storage::disk('public')->put('packageImage/'.$imageName,$packageImage);
      }
    }

    public function index()
    {
        $packages = Package::all();
        return response()->json([
        	'packages' => $packages
        ], 200);
    }

    public function store(SavePackageRequest $request)
    {
    	$imageUrl = '';
        if ($request->hasFile('package_image')) {
            $imageUrl = $this->uploadPackageImage($request);
        }

        $package = Package::query()->create($request->validated() +
            ['package_image' => $imageUrl] +
            ['added_By' => Auth::user()->name]);

        $package->places()->attach($request->places);
        return response([
            'package' => $package,
            'message' => 'package added successfuly',
        ], 200);
    }

    public function show(Package $package)
    {
        return response()->json($package);
    }

    public function update(UpdatePackageRequest $request, Package $package)
    {
    	$imageUrl = '';
        if($request->hasFile('package_image')) {
        	$imageUrl = $this->uploadPackageImage($request);
        	$package->package_image = $imageUrl;
        }

        $package = Package::query()->update($request->validated() +
            ['added_By' => Auth::user()->name]);

        $package->places()->sync($request->places);

        return response()->json([
            'package' => $package,
            'status' => 'success',
            'message' => 'Package Updated Successfully'
        ]);
    }

    public function destroy(Package $package)
    {
        if(Storage::disk('public')->exists('package-image/'.$package->package_image))
        {
            Storage::disk('public')->delete('package-image/'.$package->package_image);
        }

        $package->places()->detach();
        $package->delete();
        return response()->json([
            'message' => 'package removed successfully!'
        ], 200);
    }
}
