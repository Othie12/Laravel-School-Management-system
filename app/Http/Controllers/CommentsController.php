<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;
use Illuminate\Support\Facades\Auth;


class CommentsController extends Controller
{

    public function resolve()
    {
        $comments = Comments::where('class_id', Auth::user()->class->id)->get();

        if(count($comments) === 0){
            return $this->create();
        }else{
            return $this->edit($class_id = Auth::user()->class->id);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('comments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $from = 0;
        $to = 10;
        foreach ($request->comms as $comm) {
            Comments::create([
                'class_id' => Auth::user()->class->id,
                'agg_from' => $from,
                'agg_to' => $to,
                'ct_comm' => $comm,
            ]);
            $from += 10;
            $to += 10;
        }
        return redirect(route('comments'))->with('status', 'successfuly created');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $class_id)
    {
        return view('comments.edit', ['comments' => Comments::where('class_id', $class_id)->get()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        $ids = $request->ids;
        $htcomms = $request->htcomms;
        $ctcomms = $request->ctcomms;
        for($i = 0; $i < count($ids); $i++) {
            $comment = Comments::find($ids[$i]);
            if (Auth::user()->role === 'head_teacher') {
                $comment->ht_comm = $htcomms[$i];
                $comment->ct_comm = $ctcomms[$i];
            }else{
                $comment->ct_comm = $ctcomms[$i];
            }
            $comment->save();
        }
        return redirect()->back()->with('status', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
