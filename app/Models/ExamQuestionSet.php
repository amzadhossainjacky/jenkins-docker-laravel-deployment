<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestionSet extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'set_name',
        'is_active',
    ];

}
