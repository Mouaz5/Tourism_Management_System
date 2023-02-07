<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Package;
use App\Models\Paypal;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class UserBookingController extends Controller
{
    public function bookPackage($id) {
        $user = Auth::id();
        $package = Package::findOrFail($id);
        $paypal = Paypal::where('user_id', $user)->first();
        $paypal->amount = ($paypal->amount - $package->price);
        $booking = new Booking();
        $booking->package_id = $package['id'];
        $booking->package_name = $package['name'];
        $booking->user_id = $user;
        $booking->approved_states = "YES";
        $booking->is_completed = "YES";
        $paypal->save();
        $booking->save();
        return response()->json([
            'message' => 'the package is booked succefully'
        ]);
    }

    public function tourHistory(){
        $historyList = Booking::where('approved_states', 'YES')
                    ->where('user_id', Auth::id())
                    ->get();
        $currentDate = Carbon::now()->format('F d, Y');
        return response()->json([
            'historyList' => $historyList,
            'currentData' => $currentDate
        ]);
    }

    public function pendingBookingList(){
        $pendinglists = Booking::where('approved_states', 'no')
                    ->where('user_id', Auth::id())
                    ->get();
        return response()->json(['data', $pendinglists]);
    }

    public function cancelBookingRequest($id){
        $req = Booking::find($id);
        $req->approved_states = "NO";
        $req->save();
        return response()->json(['success' => 'Booking Request Canceled Successfully']);
    }
}
