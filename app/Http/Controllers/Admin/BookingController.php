<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
class BookingController extends Controller
{
    public function pendingBookingList() {
        $pendingLists = Booking::where('approved_states', 'no')->get();
        return response()->json(['data', $pendingLists]);
    }

    public function runningPackage(){
        $runningLists = Booking::where('approved_states', 'yes')->where('is_completed', 'no')->get();
        return response()->json(['data', $runningLists], 200);
    }

    public function runningPackageComplete($id){
        $req = Booking::find($id);
        $req->is_completed = "yes";
        $req->save();
        return response(['success' => 'Tour Completed Successfully']);
    }

    public function bookingApprove($id){
        $req = Booking::find($id);
        $req->approved_status = "yes";
        $req->save();
        //$req->tourist->notify(new PackageApproveConfirmation($req));
        return response(['message' => 'Booking Request Approved Successfully']);
    }

    public function bookingRemoveByAdmin($id) {
        $req = Booking::findOrFail($id);
        $req->delete();
    }
}
