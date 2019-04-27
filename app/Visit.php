<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Visit
 *
 * @property int $id
 * @property int $url_id
 * @property string $cookie
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Url[] $urls
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visit query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visit whereCookie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visit whereUrlId($value)
 * @mixin \Eloquent
 */
class Visit extends Model
{
    public function urls()
    {
        return $this->belongsToMany('App\Url');
    }
}
