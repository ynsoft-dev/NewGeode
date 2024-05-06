<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArchieveRequestDetails extends Model
{
    protected $fillable = [
      
        
        'ref',
        'content',
        'extreme_date',
        
        'destruction_date',
        'location',
        'status',

        'statusRequest',
        'user',
        'box_archive_request_id',
        
    ];


    public function boxArchiveRequest(): BelongsTo
    {
        return $this->belongsTo(BoxArchiveRequest::class,'box_archive_request_id');
    }
}
