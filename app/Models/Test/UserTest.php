<?php

namespace App\Models\Test;

use App\Models\Question\Result;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTest extends Model
{
    use HasFactory;

    protected $table = 'user_tests';

    protected $appends = ['answer','point','user','diagnosa'];

    public function getAnswerAttribute()
    {
        return $this->hasAnswer()->get();
    }

    public function getDiagnosaAttribute()
    {
        $result = $this->hasResult()->first();
        if($this->point >= 100){
            return $result->cat_d;
        }elseif($this->point > 50 ){
            return $result->cat_c;
        }elseif($this->point >25){
            return $result->cat_b;
        }else{
            return $result->cat_a;
        }
    }

    public function getPointAttribute()
    {
        return $this->hasAnswer()->sum('point');
    }

    public function getUserAttribute()
    {
        return $this->hasUser()->first();
    }

    public function hasAnswer(){
        return $this->hasMany(UserAnswer::class, 'user_test_id', 'id');
    }

    public function hasUser(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function hasResult(){
        return $this->hasOne(Result::class, 'question_category_id', 'question_category_id');
    }

}
