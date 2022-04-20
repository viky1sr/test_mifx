<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'isbn',
        'title',
        'description',
        'published_year'
    ];

    protected $appends= ['author', 'review'];

    public function getAuthorAttribute()
    {
        $data = $this->belongsToMany(Author::class, 'book_author')
            ->select('id','name','surname')->first();
        unset($data->pivot);
        return $data;
    }

    public function getReviewAttribute(){
        $data = [
            'avg' => round(BookReview::where('book_id',$this->id)->avg('review'),1),
            'count' => $this->reviews_count($this->id)
        ];
        return $data;
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_author');
    }

    public function reviews()
    {
        return $this->hasMany(BookReview::class);
    }

    public function reviews_count($book_id)
    {
        return $this->hasMany(BookReview::class)->where('book_id',$this->id ?: $book_id)->count();
    }

    public function store_book_author($author_id) {
        $book_id = $this->id;
        $query = \DB::table('book_author')->insert([
            'book_id' => $book_id,
            'author_id' => $author_id
        ]);
        return $query;
    }

    public function avgRating() {
        return $this->reviews()
            ->selectRaw('avg(review) as aggregate, book_id')
            ->groupBy('book_id');
    }

    public function getAvgRatingAttribute() {
        if ( ! array_key_exists('avgRating', $this->relations)) {
            $this->load('avgRating');
        }

        $relation = $this->getRelation('avgRating')->first();

        return ($relation) ? $relation->aggregate : null;
    }
}
