<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use App\Http\Requests\SavePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use App\Models\ListPlaces;

class PackageController extends Controller
{
    protected function uploadPackageImage($request){
        $packageImage = $request->file('package_image');
        $imageName = time().$packageImage->getClientOriginalName();
        $directory = 'tourism/package-images/';
        $imageUrl = $directory.$imageName;
        Image::make($packageImage)->save($imageUrl);
        return $imageUrl;
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

        $places = $request->list_places;
        $i1 = 0;$i2 = 0;
        $input2 = [];
        foreach($places as $place) {
            $image = $place['image'];
            $image_name = time().$image->getClientOriginalName();
            $image->move(public_path('products'),$image_name);
            //$path = $image->storeAs($destination_path,$image_name);
            $path2 = "public/products/$image_name";
            $input2[$i1] = $path2;
            $i1++;
        }
        $package = new Package();
        $package->added_By = Auth::user()->name;
        $package->name = $request->name;
        $package->price = $request->price;
        $package->start_date = $request->start_date;
        $package->end_date = $request->end_date;
        $package->hotel_name = $request->hotel_name;
        $package->company_name = $request->company_name;
        $package->transport_type = $request->transport_type;
        $package->description = $request->description;
        $package->package_image = $imageUrl;
        $package->duration = $request->duration;
        $package->no_people = $request->no_people;
        $package->country_id = $request->country_id;
        $places = $request->list_places;
        $package->save();

        foreach($places as $place){
            $package->places()->create([
                'name' => $place['name'],
                'image' => $input2[$i2],
            ]);
            $i2++;
        }
        $package->save();
        return response([
            'package' => $package,
            'message' => 'package added successfuly',
        ], 200);
    }

    public function show(Package $package)
    {
        $details = Package::with(['country', 'comments'])
            ->where('id', $package->id)
            ->get();

        return response()->json([
        	'package' => $details
        ], 200);
    }

    public function update(UpdatePackageRequest $request, Package $package)
    {
    	$imageUrl = '';
        if($request->hasFile('package_image')) {
        	$imageUrl = $this->uploadPackageImage($request);
        	$package->package_image = $imageUrl;
        }

        $destination_path = 'public/images/products';
        $places = $request->list_places;
        $i1 = 0;$i2 = 0;
        $input2 = [];
        foreach($places as $place) {
            $image = $place['image'];
            $randomString = Str::random(50);
            $image_name = $randomString . $image->getClientOriginalName();
            $path = $image->storeAs($destination_path,$image_name);
            $input2[$i1] = $image_name;
            $i1++;
        }
        $package->added_By = Auth::user()->name;
        $package->name = $request->name;
        $package->price = $request->price;
        $package->start_date = $request->start_date;
        $package->end_date = $request->end_date;
        $package->hotel_name = $request->hotel_name;
        $package->transport_type = $request->transport_type;
        $package->description = $request->description;
        $package->package_image = $imageUrl;
        $package->duration = $request->duration;
        $package->no_people = $request->no_people;
        $package->country_id = $request->country_id;
        $places = $request->list_places;
        $package->save();
        foreach($places as $place){
            $package->places()->create([
                'name' => $place['name'],
                'image' => $input2[$i2],
            ]);
            $i2++;
        }
        $placess = new ListPlaces();
        return response([
            'package' => $package,
            'places' => $placess->packages()->get(),
            'message' => 'package updated successfuly',
        ], 200);
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return response()->json([
            'message' => 'package removed successfully!'
        ], 200);
    }
}
