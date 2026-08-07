<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkLocation extends Model
{
    protected $fillable = [
        'name',
        'address',
    ];

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}