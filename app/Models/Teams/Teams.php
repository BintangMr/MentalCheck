<?php

namespace App\Models\Teams;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    use HasFactory;

    protected $table = 'teams';

    protected $appends = ['image','images'];

    /**
     * The getter that return accessible URL for user photo.
     *
     * @var array
     */
    public function getImageAttribute()
    {
        if ($this->hasImage()->first()) {
            return asset('storage/teams/' . $this->hasImage()->first()->modified_filename);
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
        return $this->hasOne(TeamsImage::class, 'teams_id', 'id');
    }
}
