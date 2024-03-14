@extends('layouts.app')
@section('content')
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">Create Post</h1>
    </div>
</div>
<div class="container" style="padding: 3%">
    <form class="row g-3" action="{{route('post.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-md-6">
            <label for="inputtitle" class="form-label">Title</label>
            <input type="text" name='title'class="form-control" id="inputtitle">
        </div>
        <div class="col-12">
            @foreach ($tags as $item)
                <input type="checkbox" name='tags[]' id="inputags" value="{{$item->id}}">
                <label for="inputtags" class="form-label">{{$item->name}}</label>
            @endforeach
        </div>
        <div>
            <label for="inputcontent" class="form-label">Content</label>
            <textarea id="inputcontent" class="form-control" name='content' rows="5"></textarea>
        </div>
        <div class="col-md-6">
            <label for="inputphoto" class="form-label">Photo</label>
            <input type="file" name='photo'class="form-control" id="inputphoto">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Create</button>
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
