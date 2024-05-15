<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Box extends Model
{
    protected $fillable = [
      
        'ref',
        
        
        'content',
        'extreme_date',
        
        'destruction_date',
        'location',
        'status',
        

        'archive_demand_id',  
        'archive_demand_details_id',

    ];
    

    public function archiveRequest(): BelongsTo
    {
        return $this->belongsTo(ArchiveDemand::class,'archive_demand_id');
    }
    public function boxArchiveRequest(): BelongsTo
    {
        return $this->belongsTo(Box::class,'archive_demand_details_id');
    }


}
