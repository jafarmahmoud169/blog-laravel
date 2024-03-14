@extends('layouts.app')

@section('content')
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">Edit Post</h1>
    </div>
</div>
<div class="container" style="padding: 3%">
    <form class="row g-3" action="{{route('post.update',['id'=>$post->id])}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="col-md-6">
            <label for="inputtitle" class="form-label">Title</label>
            <input type="text" name='title'class="form-control" id="inputtitle" value="{{$post->title}}">
        </div>
        <div class="col-12">
            @foreach ($tags as $item)
                <input type="checkbox" name='tags[]' id="inputags" value="{{$item->id}}"
                @foreach ($post->tags as $item2)
                    @if ($item->id == $item2->id)
                        checked
                    @endif
                @endforeach
                >
                <label for="inputtags" class="form-label">{{$item->name}}</label>
            @endforeach
        </div>
        <div>
            <label for="inputcontent" class="form-label">Content</label>
            <textarea id="inputcontent" class="form-control" name='content' rows="5">{{$post->content}}</textarea>
        </div>
        <div class="col-md-6">
            <label for="inputphoto" class="form-label">Photo</label>
            <img width="100px" height="100px" src="/images/{{$post->photo}}" class="img-fluid rounded" alt="{{$post->photo}}" />
            <input type="file" name='photo'class="form-control" id="inputphoto">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
    <br>
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $item )
                <li>{{$item}}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
