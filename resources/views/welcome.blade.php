@extends('layouts.app')

@section('content')

    <h1 class="font-weight-light">Shorten Your URL</h1>
    <p class="lead">Fill in the form to shorten your url and share it everywhere across the web</p>
    <form method="POST" action="{{ route('urls.store') }}">
        @csrf
        <div class="container col-md-10">
            @if(!empty($errors->get('url')))
                <div class="alert alert-danger">
                        @foreach($errors->get('url') as $error)
                           <p class="error"> {{ $error }} </p>
                        @endforeach
                        @foreach($errors->get('email') as $error)
                            <p class="error"> {{ $error }} </p>
                        @endforeach
                </div>
            @endif
            <input type="text" name="url" class="form-control mb-2" placeholder="Place your URL here">
            <input type="email" name="email" class="form-control mb-2" placeholder="Fill your e-mail address here">
            <button type="submit" class="btn btn-primary">Shorten me!</button>
        </div>
    </form>
@endsection
