<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UrlResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'large_url' => $this->large_url,
            'shorten_url' => $this->shorten_url,
            'details_url' => $this->details_url,
            'overall_visits' => $this->overall_visits,
            'unique_visits' => $this->unique_visits
        ];
    }
}
