@foreach ($comments as $item)
    <div @if ($item->parent_id != null)
        style="margin-left:60px;"
    @endif>
        <strong>{{ $item->user->name }}</strong>
        <p>{{ $item->content }}</p>
        <form class="row g-3" action="{{ route('comments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="post_id" value="{{ $item->post_id }}">
            <input type="hidden" name="parent_id" value="{{ $item->id }}">
            <textarea class="form-control" name='content' rows="1"></textarea>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Reply</button>
            </div>
            <hr>
        </form>
        @include('posts.comments',['comments'=>$item->replies])
    </div>
@endforeach
