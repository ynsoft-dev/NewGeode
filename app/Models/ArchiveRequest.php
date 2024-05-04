<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArchiveRequest extends Model
{
    protected $fillable = [
        'name',
        'request_date',
        'status',

    ];

    
}
