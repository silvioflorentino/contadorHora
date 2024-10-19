<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentTime extends Model
{
    protected $fillable = ['student_name', 'start_time', 'end_time', 'total_time'];
}

