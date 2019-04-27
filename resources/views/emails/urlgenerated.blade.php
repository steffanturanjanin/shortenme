@extends('layouts.app')

@section('content')

    <h1 class="font-weight">Thank You For Using shorten.me</h1>
    <h2 class="font-weight-normal">Your new url is shown below:</h2>
    <a class="lead" href="{{ route('redirection', $url->shorten_url) }}" style="color: #1b1e21; font-size: 40px;" target="_blank">{{ route('redirection', $url->shorten_url) }}</a>
    <p class="font-weight-bold mt-5" style="font-size: 40px;">To view url details click <a href="{{ route('details', $url->details_url) }}"> here </a></p>
@endsection

