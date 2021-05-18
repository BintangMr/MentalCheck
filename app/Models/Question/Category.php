<?php

namespace App\Models\Question;

use App\Models\Test\UserTest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'question_categories';

    /**
     * The attributes that appends to returned entities.
     *
     * @var array
     */
    protected $appends = ['image','images','soal','user'];

    /**
     * The getter that return accessible URL for user photo.
     *
     * @var array
     */
    public function getImageAttribute()
    {
        if ($this->hasImage()->first()) {
            return asset('storage/category/' . $this->hasImage()->first()->modified_filename);
        } else {
            return asset('assets/img/new-services-1.jpg');
        }
    }

    public function getSoalAttribute()
    {
        return $this->hasSoal()->get();
    }

    public function getUserAttribute()
    {
        return $this->hasUser()->first();
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
        return $this->hasOne(CategoryImage::class, 'question_category_id', 'id');
    }

    public function hasUser(){
        return $this->hasOne(UserTest::class, 'question_category_id', 'id')->where('user_id',Auth::id());
    }

    public function hasSoal(){
        return $this->hasMany(Question::class, 'question_category_id', 'id');
    }
}
