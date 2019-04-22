<?php

namespace App\Http\Controllers;

use DB;
use App\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Mail\UrlGenerated;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  integer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index($shorten_url)
    {
        dd(md5("UDMx"));
        $url = Url::where('shorten_url', $shorten_url)->first();
        if ($url)
            return view('details', compact('url'));
        else
            return Redirect::to('/');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

            if (!Url::where('shorten_url', $shorten_url)->first()) {
                $url->shorten_url = $shorten_url;
                $url->details_url = md5($shorten_url);
                $url->save();
                if($request->email)
                    Mail::to($request->email)->send(new UrlGenerated($url));

                return redirect('details/'.$url->details_url);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function show(Url $url)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function edit(Url $url)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Url $url)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function destroy(Url $url)
    {
        //
    }

    /**
     * @param integer $shorten_url
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirection($details_url)
    {
        $url = Url::where('details_url', $details_url)->first();
        if ($url) {
            $url->overall_visits++;
            $url->save();
            return Redirect::to($url->large_url);
        }
        else
            return Redirect::to('/');
    }
}
