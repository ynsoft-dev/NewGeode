<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoxArchiveRequest extends Model
{
    protected $fillable = [
      
        'ref',
        
        
        'content',
        'extreme_date',
        'destruction_date',
        'location',
        'status',
        
        'department_id',
        'direction_id',
        'archive_request_id',  

    ];

    public function archiveRequest(): BelongsTo
    {
        return $this->belongsTo(ArchiveRequest::class,'archive_request_id');
    }

    public function direction(): BelongsTo
    {
        return $this->belongsTo(Direction::class, 'direction_id');
    }
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
