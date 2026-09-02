<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}