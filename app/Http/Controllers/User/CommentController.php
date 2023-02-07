<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with(['packages']);
        return response()->json($comments);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'value' => 'required',
        ]);
        $comment = new Comment();
        $comment->value = $request->value;
        $comment->added_By = Auth::user()->name;
        $comment->package_id = $request->package_id;
        $comment->hotel_id = $request->hotel_id;
        $comment->place_id = $request->place_id;
        $comment->resturant_id = $request->resturant_id;
        $comment->company_id = $request->company_id;
        $comment->save();

        return response()->json(['message' => 'comment added succefully']);
    }

    public function show(Comment $comment)
    {
        return response()->json([
            'comment' => $comment->value
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'value' => 'required'
        ]);
        $comment = Comment::findOrFail($id);
        $comment->value = $request->value;
        $comment->save();
        return response()->json([
            'message' => 'message updated succefully'
        ]);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFill($id);
        $comment->delete();
        return response()->json([
            'message' => 'comment deleted succefully'
        ]);
    }
}
