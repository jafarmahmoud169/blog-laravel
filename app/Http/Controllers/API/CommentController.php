<?php

namespace App\Http\Controllers\API;

use App\Models\Comment;
use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\API\BaseController as BaseController;


class CommentController extends BaseController
{
    public function replies($id)
    {
        $comment=Comment::where('parent_id',$id)->get();
        if (is_null($comment)) {
            return $this->sendError('comment not found');
        }
        return $this->sendResponse($comment,'all replyes',);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'post_id'=>'required'
        ]);
        $comment=$request->all();
        $comment['user_id']=Auth::id();
        Comment::create($comment);
        return $this->sendResponse($comment,'comment added succesfully',);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $comment=Comment::find($id);
        if (is_null($comment)) {
            return $this->sendError('user not found');
        }
        if ($comment->user_id != Auth::id()) {
            return $this->sendError('you dont have permission to update this comment');
        }
        $request->validate([
            'content' => 'required',
        ]);
        $comment->content=$request->content;
        $comment->save();
        return $this->sendResponse($comment,'comment updated succesfully',);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $comment=Comment::find($id);
        if (is_null($comment)) {
            return $this->sendError('comment not found');
        }
        $comment->delete();
        return $this->sendResponse($comment,'comment deleted succesfully',);
    }
}
