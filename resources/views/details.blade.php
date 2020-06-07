@extends('layouts.app')

@section('content')

    @php
        /**@var \App\Url $url */
    @endphp

    <h1 class="font-weight">Thank You For Using shorten.me</h1>
    <h2 class="font-weight-normal">Your new url is shown below:</h2>
    <a class="link" href="{{ route('urls.redirection', $url->shorten_url) }}" target="_blank">{{ route('urls.redirection', $url->shorten_url) }}</a>
    <p class="font-weight-bold mt-5 visit">Overall visits: {{ $url->overall_visits }}</p>
    <p class="font-weight-bold mt-5 visit">Unique visits: {{ $url->unique_visits }}</p>
@endsection

