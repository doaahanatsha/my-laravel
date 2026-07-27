<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
     public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }

    public function workLocation()
    {
        return $this->belongsTo(WorkLocation::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
