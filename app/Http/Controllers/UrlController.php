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
        $id = Url::decode($shorten_url);
        $url = Url::find($id);
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
           'url' => 'required',
           'email' => 'nullable'
        ]);

        $existingUrl = Url::where('large_url', $request->url)->first();

        if ($existingUrl) {
            if($request->email)
                Mail::to($request->email)->send(new UrlGenerated($existingUrl));
            $existingUrl->count = 0;
            $existingUrl->save();
            return redirect('details/' . $existingUrl->shorten_url);
        }
        else
        {
            $shorten_url = Url::encode(DB::table('urls')->max('id') + 1);
            $url = new Url;
            $url->large_url = $request->url;
            $url->shorten_url = $shorten_url;
            $url->count = 0;
            $url->save();

            if($request->email)
                Mail::to($request->email)->send(new UrlGenerated($url));

            return redirect('details/'.$shorten_url);
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
    public function redirection($shorten_url)
    {
        $id = Url::decode($shorten_url);
        $url = Url::find($id);
        if ($url) {
            $url->count++;
            $url->save();
            return Redirect::to($url->large_url);
        }
        else
            return Redirect::to('/');
    }
}
