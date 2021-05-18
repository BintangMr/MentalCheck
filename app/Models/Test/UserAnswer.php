<?php

namespace App\Models\Test;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    protected $table = 'user_answers';

    protected $appends = ['history'];

    public function getHistoryAttribute()
    {
        return $this->hasAnswer()->get();
    }

    public function hasAnswer(){
        return $this->hasMany(UserAnswerHistory::class, 'user_answer_id', 'id');
    }
}
