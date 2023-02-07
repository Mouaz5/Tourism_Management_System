<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Package;
use App\Models\Paypal;
use App\Models\Booking;
use App\Models\Hotel;
use Illuminate\Support\Facades\Auth;
class PaymentController extends Controller
{
    public function payPackage($id) {
        $package = Package::findorFail($id);
        $user = User::findOrFail(Auth::id());
        $paypal = Paypal::where('user_id', $user['id'])->first();
        $paypal->amount = ($paypal->amount - $package->price);
        if ($paypal->amount < 0) {
        	return response()->json([
        		'message' => 'you dont have enough money'
        	]);
        }
        $paypal->save();
        $package->approved_status = "YES";
        $package->save();
        return response([
            'message' => 'payment is completed and your amount is',
            'data' =>$paypal->amount
        ]);
    }

    public function payHotel($id) {
        $hotel = Hotel::findOrFail($id);
        $user = User::findOrFail(Auth::id());
        $paypal = Paypal::where('user_id', $user['id'])->first();
        $paypal->amount = ($paypal->amount - $hotel->price);
        $paypal->save();
        return response ([
            'message' => 'payment is completed and your amount is',
            'data' => $paypal->amount
        ]);
    }

    public function payTransport($id) {

    }
}
