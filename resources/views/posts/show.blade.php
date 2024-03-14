@extends('layouts.app')

@section('content')

    <div class="container ">
        <div class="row justify-content-center">
            <div class="card"style="width: 30rem;">
                <img src="/images/{{ $post->photo }}" class="card-img" alt="{{ $post->photo }}">
                <div class="card-body">
                    <h4 class="card-title">{{ $post->title }}</h4>
                    <p class="card-text">{{ $post->content }}</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Created at :{{ $post->created_at }}</li>
                    <li class="list-group-item">Updated at :{{ $post->updated_at }}</li>
                    <li class="list-group-item">
                        @foreach ($tags as $item)
                            @foreach ($post->tags as $item2)
                                @if ($item->id == $item2->id)
                                    {{ $item->name }}&nbsp; &nbsp; &nbsp;&nbsp;
                                @endif
                            @endforeach
                        @endforeach
                    </li>
                </ul>
                <div class="card-body">
                    <h4 class="card-title">Comments</h4>
                    <div class="card-text">
                        @include('posts.comments',['comments'=>$post->comments,'post_id'=>$post->id])
                        <hr>
                        <form class="row g-3" action="{{ route('comments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $item->user_id }}">
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <textarea class="form-control" name='content' rows="1"></textarea>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Comment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
        </div>
    </div>
@endsection
