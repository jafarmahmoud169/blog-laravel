<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
    'name',
];
    use HasFactory;

    /**
     * The post that belong to the Tag
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany('App\Models\Post');
    }
    public function profiles()
    {
        return $this->belongsToMany('App\Models\profile');
    }
}
