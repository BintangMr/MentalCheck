<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $table = 'articles';

    protected $appends = ['image','images'];

    /**
     * The getter that return accessible URL for user photo.
     *
     * @var array
     */
    public function getImageAttribute()
    {
        if ($this->hasImage()->first()) {
            return asset('storage/article/' . $this->hasImage()->first()->modified_filename);
        } else {
            return asset('assets/img/new-services-1.jpg');
        }
    }

    /**
     * The getter that return accessible URL for user photo.
     *
     * @var array
     */
    public function getImagesAttribute()
    {
        return $this->hasImage()->first();
    }

    public function hasImage(){
        return $this->hasOne(ArticleImage::class, 'article_id', 'id');
    }
}
