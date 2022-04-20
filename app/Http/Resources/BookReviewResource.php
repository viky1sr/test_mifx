<?php

namespace App\Http\Resources;

use App\BookReview;
use Illuminate\Http\Resources\Json\JsonResource;

class BookReviewResource extends JsonResource
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
            'avg' => round($this->book->avgRating,1),
            'count' => $this->book->reviews_count($this->book_id)
        ];
    }
}
