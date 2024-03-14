<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::latest()->paginate(10);
        return view("tags.index", compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("tags.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        Tag::create([
            'name' => $request->name,
        ]);
        return redirect()->route('tags.index')->with('success', 'tag added succesfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tag = Tag::find($id);
        return view('tags.edit')->with('tag',$tag);    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $tag = Tag::find($id);
        $this->validate($request, [
            'name' => 'required',
        ]);
        $tag->name=$request->name;
        $tag->save();
        return redirect()->route('tags.index')->with('success', 'tag updated succesfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);
        $tag->forceDelete();
        return redirect()->route('tags.index')->with('success', 'tag deleted succesfully');    }
}
