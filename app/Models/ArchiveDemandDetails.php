<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArchiveDemandDetails extends Model
{
    protected $fillable = [

        'name',
        'details_request',
        'request_date',
        'status',
        'department',
        'direction',

        'user',
        'archive_demand_id',

    ];


    public function archiveRequest(): BelongsTo
    {
        return $this->belongsTo(ArchiveDemand::class, 'archive_demand_id');
    }

    public function boxes(): HasMany
    {
        return $this->hasMany(Box::class);
    }

    public function getRealBoxQuantity(): int
    {
        return $this->boxes()->count();
    }
}
