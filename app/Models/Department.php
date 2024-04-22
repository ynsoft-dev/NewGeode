<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Department extends Model
{
    protected $fillable = [
        'name',
        'directions_id',
       
    ];
    public function direction(): BelongsTo
    {
        return $this->belongsTo(Direction::class, 'directions_id');
    }
}