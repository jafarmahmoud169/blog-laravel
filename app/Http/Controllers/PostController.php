<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Auth;
class PostController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    public function index()
    {
        // $favPosts= Post::
        // join('post_tag', 'post_tag.post_id', '=', 'posts.id')
        // ->join('profile_tag', 'profile_tag.tag_id', '=', 'post_tag.tag_id')
        // ->where('profile_tag.profile_id','=',Auth::user()->profile->id)->paginate(7);

        // $otherPosts =  Post::
        // join('post_tag', 'post_tag.post_id', '=', 'posts.id')
        // ->join('profile_tag', 'profile_tag.tag_id', '=', 'post_tag.tag_id')
        // ->where('profile_tag.profile_id','!=',Auth::user()->profile->id)->paginate(7);;

        $allPosts = Post::latest()->paginate(5);
        $posts=$allPosts;
        return view("posts.index",compact('posts'));
    }
    public function trash()
    {
        $posts = Post::onlyTrashed()->where('user_id',Auth::id())->latest()->paginate(5);
        return view('posts.trash', compact('posts'));
    }
    public function userPosts()
    {
        $posts = Post::where('user_id',Auth::id())->latest()->paginate(5);
        return view("posts.index", compact('posts'));
    }
    public function create()
    {
        $tags=Tag::all();
        if (count($tags)==0) {
            return redirect()->route('tag.create');
        }
        return view("posts.create")->with('tags',$tags);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'photo' => 'image',
            // 'photo' => 'required|image',
            // 'tags'=>'required'
        ]);

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
        $post->tags()->attach($request->tags);
        return redirect()->route('posts.index')->with('success', 'post added succesfully');
    }
    public function show($id)
    {
        $tags=Tag::all();
        $post = Post::where('id', $id)->first();
        return view('posts.show')->with('post',$post)->with('tags',$tags);
    }
    public function edit($id)
    {
        $tags=Tag::all();
        $post = Post::where('id',$id)->where('user_id',Auth::id())->first();
        if ($post===null) {
            return redirect()->route('posts.index')->with('faild', 'you dont have permission to edit this post');
        }
        return view('posts.edit')->with('post',$post)->with('tags',$tags);
    }
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'photo' => 'image',
            // 'tags'=>'required'
        ]);
        if ($request->has('photo')) {
            $photo = $request->photo;
            $nphoto = time() . "." . $photo->getClientOriginalExtension();
            $photo->move('images/', $nphoto);
            $post->photo =$nphoto;
        }
        $post->title=$request->title;
        $post->content=$request->content;
        $post->save();
        $post->tags()->sync($request->tags);
        return redirect()->route('posts.index')->with('success', 'post updated succesfully');
    }

    public function destroy($id)
    {
        $post = Post::onlyTrashed()->find($id);
        if ($post->photo != 'noimage.jfif') {
            File::delete('images/'.$post->photo);
        }
        $post->forceDelete();
        return redirect()->route('posts.trash')->with('success', 'post deleted succesfully');
    }
    public function sdelete($id)
    {
        // $post = Post::find($id);
        $post = Post::where('id',$id)->where('user_id',Auth::id())->first();
        if ($post===null) {
            return redirect()->route('posts.index')->with('faild', 'you dont have permission to delete this post');
        }
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'post deleted succesfully');
    }
    public function restore($id)
    {
        $post = Post::onlyTrashed()->where('id', $id)->first();
        $post->restore();
        return redirect()->route('posts.trash')->with('success', 'post restored succesfully');
    }
}
