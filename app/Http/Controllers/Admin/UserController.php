<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role_id', 2)->get();
        return response()->json([
            'users' => $users
        ], 200);
    }

    public function adminList() {
        $admins = User::where('role_id', 1)->get();
        return response()->json([
            'admins' => $admins
        ], 200);
    }
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $user = DB::table('users')
        ->join('bookings', 'bookings.user_id', '=', 'users.id')
        ->where('users.id', '=', $id)
        ->first();
        if ($user == null)
            return response()->json([
                'message' => 'this user has not book anything',
                'user' => User::findOrFail($id)
            ]);

        $data = collect($user)->except(
            'role_id', 'package_id', 'user_id', 'remember_token', 'created_at', 'updated_at'
        );
        return response()->json([
            'user' => $data
        ], 200);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function block($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            'message' => 'blocked successfully'
        ]);
    }
}
