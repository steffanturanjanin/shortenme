<?php

namespace App\Http\Controllers;

use App\Http\Resources\UrlResource;
use Illuminate\Http\Request;
use App\Url;
use Illuminate\Support\Facades\Validator;

class UrlApiController extends Controller
{
    /**
     * @param Request $request
     * @return UrlResource|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url',
            'email' => 'nullable|email'
        ]);

        if ($validator->fails())
        {
            return response()->json($validator->errors(), 409);
        }

        $url =  Url::buildDefaultFromRequest($request);

        do {
            $generated = Url::generateUrls($url, $request);
        } while(!$generated);

        return new UrlResource($url);

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

        if (!$url) {
            return response()->json("Resource not found", 404);
        }

        return new UrlResource($url);
    }
}
