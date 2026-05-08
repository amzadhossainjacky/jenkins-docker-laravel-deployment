<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attachment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'file',
        'extension',
        'original_file_name'
    ];

    /**
     * Get the user who created this project
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function attachmentable(): MorphTo
    {
        return $this->morphTo();
    }
}
