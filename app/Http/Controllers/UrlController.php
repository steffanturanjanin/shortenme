<?php

namespace App\Http\Controllers;

use App\Url;
use App\Visit;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  integer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index($details_url)
    {
        $url = Url::where('details_url', $details_url)->firstOrFail();

        return view('details', compact('url'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           'url' => 'required|url',
           'email' => 'nullable|email'
        ]);

       $url =  Url::buildDefaultFromRequest($request);

        do {
            $generated = Url::generateUrls($url, $request);
        } while(!$generated);

        return redirect()->route('urls.index', $url->details_url);
    }

    /**
     * @param integer $shorten_url
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirection($shorten_url)
    {
        $url = Url::where('shorten_url', $shorten_url)->firstOrFail();
        $url->overall_visits++;

        $cookie = Cookie::get('shortenme');

        if (!$cookie)
        {
            do {
                $cookie = Str::random(32);
            } while(!Visit::where('cookie', $cookie)->first());

            Cookie::queue('shortenme', $cookie, 60 * 24 * 30 * 12);
        }

        if (!Visit::where('url_id', $url->id)->where('cookie', $cookie)->first())
        {
            $url->unique_visits++;

            $visit = new Visit;
            $visit->url_id = $url->id;
            $visit->cookie = $cookie;
            $visit->save();
        }

        $url->save();
        return Redirect::to($url->large_url);
    }
}
