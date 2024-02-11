<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;
use Illuminate\Support\Facades\Auth;


class CommentsController extends Controller
{

    public function index(string $classId){
        $comments = Comments::where('class_id', $classId)->get();
        return response()->json($comments, 200);
    }

    public function store(Request $request, string $classId)
    {
        $stored = Comments::create([
            'class_id' => $classId,
            'agg_from' => $request->agg_from,
            'agg_to' => $request->agg_to,
            'ct_comm' => $request->ct_comm,
            'ht_comm' => $request->ht_comm
        ]);
        return response()->json($stored, 200);
    }

    public function update(Request $request, string $id)
    {
        $comment = Comments::find($id);

        $comment->agg_from = $request->agg_from;
        $comment->agg_to = $request->agg_to;
        $comment->ct_comm = $request->ct_comm;
        $comment->ht_comm = $request->ht_comm;
        $comment->save();

        return response()->json($comment, 200);
    }

    public function destroy(string $id)
    {
        Comments::destroy($id);
        return response()->json(['message' => 'deleted succesfuly'], 200);
    }
}
