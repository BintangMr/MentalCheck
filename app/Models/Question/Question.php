<?php

namespace App\Models\Question;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'questions';

    /**
     * The attributes that appends to returned entities.
     *
     * @var array
     */
    protected $appends = ['answers'];

    /**
     * The getter that return accessible URL for user photo.
     *
     * @var array
     */
    public function getAnswersAttribute()
    {
        return $this->answerRelation()->get();
    }

    public function answerRelation(){
        return $this->hasMany(QuestionAnswer::class, 'question_id', 'id');
    }
}
