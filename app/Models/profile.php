<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\BelongsToRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class profile extends Model
{
    use HasFactory;
protected $table ='profile';
    protected $fillable = [
        'gender',
        'user_id',
        'country',
        'bio',
        'age',
        'photo'
    ];
    /**
     * Get the user that owns the profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
