<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'total_num_of_questions',
        'time_per_question',
        'exam_total_duration',
        'passing_percentage',
        'start_time',
        'end_time',
        'is_active',
    ];
}
