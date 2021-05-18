<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that appends to returned entities.
     *
     * @var array
     */
    protected $appends = ['avatar','ava'];

    /**
     * The getter that return accessible URL for user photo.
     *
     * @var array
     */
    public function getAvatarAttribute()
    {
        if ($this->hasAvatar()->first()) {
            return asset('storage/avatars/' . $this->hasAvatar()->first()->modified_filename);
        } else {
            return asset('assets/img/user.png');
        }
    }

    /**
     * The getter that return accessible URL for user photo.
     *
     * @var array
     */
    public function getAvaAttribute()
    {
        return $this->hasAvatar()->first();
    }

    public function hasAvatar(){
        return $this->hasOne(UserImages::class, 'user_id', 'id');
    }

}
