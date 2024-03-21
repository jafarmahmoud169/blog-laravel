<?php

namespace App\Http\Controllers\API;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Tag as TagResources;
use Validator;

class TagController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::latest()->paginate(10);
        return $this->sendResponse(TagResources::collection($tags),'ten tags');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('invalide requist',$validator->errors());
        }
        $tag=Tag::create([
            'name' => $request->name,
        ]);
        return $this->sendResponse(new TagResources($tag),'tag created succsfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $tag = Tag::find($id);
        $validator=Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('invalide requist',$validator->errors());
        }
        if (is_null($tag)) {
            return $this->sendError('post not found');
        }
        $tag->name=$request->name;
        $tag->save();
        return $this->sendResponse(new TagResources($tag),'tag updated succsfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);
        if (is_null($tag)) {
            return $this->sendError('post not found');
        }
        $tag->forceDelete();
        return $this->sendResponse(new TagResources($tag),'tag deleted succsfully');
}
}
