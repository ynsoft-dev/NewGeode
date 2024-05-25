<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
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
        'shelf_id',
        'request_number', 'transmission_date', 'return_date'

    ];
    

    public function archiveRequest(): BelongsTo
    {
        return $this->belongsTo(ArchiveDemand::class,'archive_demand_id');
    }
    public function boxArchiveRequest(): BelongsTo
    {
        return $this->belongsTo(Box::class,'archive_demand_details_id');
    }

    public function shelf(): BelongsTo
    {
        return $this->belongsTo(Shelf::class,'shelf_id');
    }
    public function scopeBorrowed($query)
    {
        return $query->where('status', 'Not available');
    }
    public function scopeOverdue($query)
    {
        return $query->where('return_date', '<', Carbon::now());
    }
   


}
