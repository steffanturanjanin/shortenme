<?php

namespace App\Http\Controllers;

use App\Http\Resources\UrlResource;
use Illuminate\Http\Request;
use App\Url;

class UrlApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return UrlResource
     */
    public function store(Request $request)
    {
        $url =  Url::buildDefaultFromRequest($request);
        while (true)
        {
            if (Url::generateUrls($url, $request))
            {
                return new UrlResource($url);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  String  $details_url
     * @return UrlResource
     */
    public function show($details_url)
    {
        $url = Url::where('details_url', $details_url)->first();
        if ($url)
        {
            return new UrlResource($url);
        }
        else
        {
            return response()->json("Resource not found", 404);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
