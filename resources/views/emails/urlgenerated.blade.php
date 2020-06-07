@extends('layouts.app')

@section('content')
    <h1 class="font-weight">Thank You For Using shorten.me</h1>
    <h2 class="font-weight-normal">Your new url is shown below:</h2>
    <a class="lead link" href="{{ route('urls.redirection', $url->shorten_url) }}" target="_blank">{{ route('urls.redirection', $url->shorten_url) }}</a>
    <p class="font-weight-bold mt-5 visit">To view url details click <a href="{{ route('urls.index', $url->details_url) }}"> here </a></p>
@endsection

