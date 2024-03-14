@extends('layouts.app')
@section('content')
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">Create Tag</h1>
    </div>
</div>
<div class="container" style="padding: 3%">
    <form class="row g-3" action="{{route('tag.store')}}" method="POST">
        @csrf
        <div class="col-md-6">
            <label for="inputname" class="form-label">Name</label>
            <input type="text" name='name'class="form-control" id="inputname">
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
