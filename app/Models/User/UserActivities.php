<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserActivities extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'user_activities';
}
