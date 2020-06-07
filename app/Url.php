<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\UrlGenerated;

/**
 * App\Url
 *
 * @property int $id
 * @property string $large_url
 * @property string $shorten_url
 * @property string $details_url
 * @property int $overall_visits
 * @property int $unique_visits
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Visit[] $visits
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Url newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Url newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Url query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Url whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Url whereDetailsUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Url whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Url whereLargeUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Url whereOverallVisits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Url whereShortenUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Url whereUniqueVisits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Url whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Url extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visits()
    {
        return $this->hasMany('App\Visit');
    }

    /**
     * @param Request $request
     * @return Url
     */
    public static function buildDefaultFromRequest(Request $request)
    {
        $url = new Url;
        $url->large_url = $request->url;
        $url->overall_visits = 0;
        $url->unique_visits = 0;

        return $url;
    }

    /**
     * @param Url $url
     * @param Request $request
     * @return bool
     */
    public static function generateUrls(Url &$url, Request $request)
    {
        $shorten_url = Self::generateRandomString(4);
        $details_url = $shorten_url . Self::generateRandomString(16);

        if (!Url::where('shorten_url', $shorten_url)->first()) {
            $url->shorten_url = $shorten_url;
            $url->details_url = $details_url;
            $url->save();

            if ($request->email) {
                Mail::to($request->email)->send(new UrlGenerated($url));
            }

            return true;
        }

        return false;
    }

    /**
     * @param $length
     * @return string
     */
    public static function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
