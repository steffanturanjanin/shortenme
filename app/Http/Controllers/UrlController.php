<?php

namespace App\Http\Controllers;

use DB;
use App\Url;
use App\Visit;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Mail\UrlGenerated;
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
        $url = Url::where('details_url', $details_url)->first();
        dd($url->visits);
        if ($url) {
            return view('details', compact('url'));
        }
        else
            return Redirect::to('/');
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

        $url = new Url;
        $url->large_url = $request->url;
        $url->overall_visits = 0;
        $url->unique_visits = 0;

        while (true)
        {
            $shorten_url = Url::generateRandomString(4);
            $details_url = $shorten_url . Url::generateRandomString(16);

            if (!Url::where('shorten_url', $shorten_url)->first()) {
                $url->shorten_url = $shorten_url;
                $url->details_url = $details_url;
                $url->save();
                if ($request->email)
                    Mail::to($request->email)->send(new UrlGenerated($url));

                return redirect()->route('details', $url->details_url);
            }
        }
    }

    /**
     * @param integer $shorten_url
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirection($shorten_url)
    {
        $url = Url::where('shorten_url', $shorten_url)->first();
        if ($url)
        {
            $url->overall_visits++;
            if (!Cookie::get('shortenme'))
            {
                $url->unique_visits++;
                $generated = false;
                while (!$generated)
                {
                    $cookie = Str::random(32);
                    if (!Visit::where('cookie', $cookie)->first())
                    {
                        $visit = new Visit;
                        $visit->url_id = $url->id;
                        $visit->cookie = $cookie;
                        $visit->save();

                        $generated = true;
                        Cookie::queue('shortenme', $cookie, 60 * 24 * 30 * 12);
                    }
                }
            }
            else
            {
                if (!Visit::where('url_id', $url->id)->where('cookie', Cookie::get('shortenme'))->first())
                {
                    $url->unique_visits++;

                    $visit = new Visit;
                    $visit->url_id = $url->id;
                    $visit->cookie = Cookie::get('shortenme');
                    $visit->save();
                }
            }
            $url->save();
            return Redirect::to($url->large_url);
        }
        else
        {
            return redirect()->route('home');
        }
    }
}
