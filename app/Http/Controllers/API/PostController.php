<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\File;
use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use App\Http\Controllers\API\BaseController as BaseController;

use App\Http\Resources\Post as PostResources;
use Validator;

class PostController extends BaseController
{

    public function index()
    {
        $posts = Post::latest()->paginate(5);
        return $this->sendResponse(PostResources::collection($posts),'five posts');
    }

    public function userPosts()
    {
        $posts = Post::where('user_id',Auth::id())->latest()->paginate(5);
        return $this->sendResponse(PostResources::collection($posts),'five posts');
    }
    public function trash()
    {
        $posts = Post::onlyTrashed()->where('user_id',Auth::id())->latest()->paginate(5);
        return $this->sendResponse(PostResources::collection($posts),'your trashed posts');
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'photo' => 'image',
            // 'tags'=>'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('invalide requist',$validator->errors());
        }
        if ($request->has('photo')){
            $photo = $request->photo;
            $nphoto = time() . "." . $photo->getClientOriginalExtension();
            $photo->move('images/', $nphoto);
        }else{$nphoto='noimage.jfif';}

        $post=Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'photo' => $nphoto,
            'user_id' => Auth::id(),
            'slug' => Str::slug($request->title, '-')
        ]);
        if ($request->has('tags')){
        $post->tags()->attach($request->tags);
        }
        return $this->sendResponse(new PostResources($post),'post added succesfully',);
    }
    public function show($id)
    {
        $post = Post::where('id', $id)->first();
        if (is_null($post)) {
            return $this->sendError('post not found');
        }
        return $this->sendResponse(new PostResources($post),'post found succesfully');
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $validator=Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'photo' => 'image',
            // 'tags'=>'required'
        ]);
        if (is_null($post)) {
            return $this->sendError('post not found');
        }
        if ($post->user_id != Auth::id()) {
            return $this->sendError('you dont have permission to update this post');
        }
        if ($validator->fails()) {
            return $this->sendError('invalide requist',$validator->errors());
        }
        if ($request->has('photo')) {
            $photo = $request->photo;
            $nphoto = time() . "." . $photo->getClientOriginalExtension();
            $photo->move('images/', $nphoto);
            $post->photo =$nphoto;
        }
        $post->title=$request->title;
        $post->slug = Str::slug($request->title, '-');
        $post->content=$request->content;
        $post->save();
        if ($request->has('tags')) {
        $post->tags()->sync($request->tags);
        }
        return $this->sendResponse(new PostResources($post),'post updated succesfully',);
    }

    public function destroy($id)
    {
        $post = Post::onlyTrashed()->find($id);
        if (is_null($post)) {
            return $this->sendError('post not found');
        }
        if ($post->photo != 'noimage.jfif') {
            File::delete('images/'.$post->photo);
        }
        $post->forceDelete();
        return $this->sendResponse($post->id,'post deleted succesfully',);
    }
    public function sdelete($id)
    {
        $post = Post::find($id);
        if (is_null($post)) {
            return $this->sendError('post not found');
        }
        if ($post->user_id != Auth::id()) {
            return $this->sendError('you dont have permission to delete this post');
        }
        $post->delete();
        return $this->sendResponse(new PostResources($post),'post moved to trash succesfully',);
    }
    public function restore($id)
    {
        $post = Post::onlyTrashed()->where('id', $id)->first();
        $post->restore();
        return $this->sendResponse(new PostResources($post),'post restored succesfully',);

    }
}
