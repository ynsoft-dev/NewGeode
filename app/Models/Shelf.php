<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class shelf extends Model
{
    protected $fillable = [
        'name',
        'site_id',
        'ray_id',
        'column_id',
        
       
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class, 'site_id');
    }
    public function ray(): BelongsTo
    {
        return $this->belongsTo(Ray::class, 'ray_id');
    }
    public function column(): BelongsTo
    {
        return $this->belongsTo(Column::class, 'column_id');
    }
}
