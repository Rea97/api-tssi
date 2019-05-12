<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $fillable = [
        'results',
    ];

    protected $casts = [
        'results' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
