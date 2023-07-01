<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'file_path',
        'file_name',
        'total_rows',
        'processed_rows',
        'completed_at',
    ];
}
