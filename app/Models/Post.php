<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates =['deleted_at'];
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'photo',
        'slug',
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }


public function comments()
{
    return $this->hasMany('App\Models\Comment')->whereNull('parent_id');
}

    // public function getFeaturedAttribute($photo)
    // {
    //     return asset($photo);
    // }
}
