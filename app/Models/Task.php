<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
     public function assignments()
    {
       return $this->hasOne(Assignment::class);
    }
}
