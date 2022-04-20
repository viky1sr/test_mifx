<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'Id' => $this->id,
            'Isbn' => $this->isbn,
            'Title' => $this->title,
            'Description' => $this->description,
            'PublishedYear' => $this->published_year,
            'Authors' => AuthorResource::collection($this->authors),
            'Reviews' =>
            !empty(BookReviewResource::collection($this->reviews)) && count(BookReviewResource::collection($this->reviews)) != 0 ? BookReviewResource::collection($this->reviews)[0] : ""
            ,
        ];
    }
}
