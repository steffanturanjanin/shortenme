<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
   /* public $id;
    public $large_url;
    public $shorten_url;
    public $count;*/

    //protected $fillable = ['large_url', 'shorten_url'];

    public function visits()
    {
        return $this->hasMany('App\Visit');
    }


    /**
     * @param integer
     * @return string
     */
    public static function encode($number) {
        return strtr(rtrim(base64_encode(pack('i', $number)), '='), '+/', '-_');
    }

    /**
     * @param string
     * @return integer
     */
    public static function decode($base64) {
        $number = unpack('i', base64_decode(str_pad(strtr($base64, '-_', '+/'), strlen($base64) % 4, '=')));
        return $number[1];
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
