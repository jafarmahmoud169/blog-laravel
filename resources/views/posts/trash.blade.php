@extends('layouts.app')

@section('content')
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">Trashed Posts</h1>
        <a class="btn btn-success" href="{{route('posts.index')}}">All Posts</a>
    </div>
</div>
    <div class="container" style="padding: 3%">
        <br>
        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
            <br>
        @endif
        @if ($posts->count()>0)
            <table class="table table-success table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">User</th>
                        <th scope="col">Title</th>
                        <th scope="col">Photo</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=0;
                    @endphp
                    @foreach ($posts as $item)
                    <tr>
                        <th scope="row">{{$i++}}</th>
                        <td>{{$item->user->name}}</td>
                        <td>{{$item->title}}</td>
                        <td><img width="100px" height="100px" src="/images/{{$item->photo}}" class="img-fluid rounded" alt="{{$item->photo}}" /></td>
                        <td><a class="text-warning" href="{{route('post.restore',['id'=>$item->id])}}"><i class="fas fa-2x fa-undo" aria-hidden="true"></i></a> &nbsp;
                            <a class="text-danger" href="{{route('post.destroy',['id'=>$item->id])}}"><i class="fa fa-2x fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-danger" role="alert">
                Empty Trash !
            </div>
        @endif
        <br>
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="d-flex justify-content-center">{!! $posts->links('pagination::bootstrap-5') !!}</div>
    </div>
@endsection
