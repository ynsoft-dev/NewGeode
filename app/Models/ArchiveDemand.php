<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArchiveDemand extends Model
{
    protected $fillable = [
        'demand_archive_id',
        'name',
        'details_request',
        'box_quantity',
        'request_date',
        'status',

        'department_id',
        'direction_id',
        'user_id',

    ];
    public function direction(): BelongsTo
    {
        return $this->belongsTo(Direction::class, 'direction_id');
    }
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function boxes(): HasMany
    {
        return $this->hasMany(Box::class);
    }

    
    public function getRealBoxQuantity(): int
    {
        return $this->boxes()->count();
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'Accepted');
    }

    public function getDemandArchiveId(): string
{
    return $this->demand_archive_id;
}

    
}
