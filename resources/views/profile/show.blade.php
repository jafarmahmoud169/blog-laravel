@extends('layouts.app')

@section('content')
    <div class="container" style="padding: 3%">
        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
            <br>
        @endif
        <div class="row row-cols-3 ">
            <div class="col  bg-info ">
                <label for="Name" class="form-label">Name</label>
                <p id="Name">{{ $user->name }}</p>
            </div>
            <div class="col  bg-secondary">
                <label for="Email" class="form-label">Email</label>
                <p id="Email">{{ $user->email }}</p>
            </div>
            <div class="col  bg-info">
                <label for="Gender" class="form-label">Gender</label>
                <p id="Gender">{{ $user->profile->gender }}</p>
            </div>
            <div class="col  bg-secondary">
                <label for="Country" class="form-label">Country</label>
                <p id="Country">{{ $user->profile->country }}</p>
            </div>
            <div class="col  bg-info">
                <label for="Age" class="form-label">Age</label>
                <p id="Age">{{ $user->profile->age }}</p>
            </div>
            <div class="col  bg-secondary">
                <label for="Bio" class="form-label">Bio</label>
                <p id="Bio">{{ $user->profile->bio }}</p>
            </div>
        </div>
        <br>
        <a class="btn btn-primary"href="{{ route('profile.edit') }}">Edit</a>
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
@endsection