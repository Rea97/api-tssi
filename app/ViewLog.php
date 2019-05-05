<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewLog extends Model
{
    protected $fillable = [
        'imdb_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
