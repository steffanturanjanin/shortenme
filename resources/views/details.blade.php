@extends('layouts.app')

@section('content')

    @php
        /**@var \App\Url $url */
    @endphp

    <h1 class="font-weight">Thank You For Using shorten.me</h1>
    <h2 class="font-weight-normal">Your new url is shown below:</h2>
    <a class="lead" href="{{ route('redirection', $url->shorten_url) }}" style="color: #1b1e21; font-size: 40px;" target="_blank">{{ route('redirection', $url->shorten_url) }}</a>
    <p class="font-weight-bold mt-5" style="font-size: 40px;">Overall visits: {{$url->overall_visits}}</p>
    <p class="font-weight-bold mt-5" style="font-size: 40px;">Unique visits: {{$url->unique_visits}}</p>
@endsection

