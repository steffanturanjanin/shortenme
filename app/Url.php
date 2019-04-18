<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
   /* public $id;
    public $large_url;
    public $shorten_url;
    public $count;*/

    //protected $fillable = ['large_url', 'shorten_url'];

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
}
