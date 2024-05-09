<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArchiveRequest extends Model
{
    protected $fillable = [
        'name',
        'details_request',
        'box_quantity',
        'request_date',
        'status',

        'department_id',
        'direction_id',

    ];
    public function direction(): BelongsTo
    {
        return $this->belongsTo(Direction::class, 'direction_id');
    }
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    // public function boxes()
    // {
    //     return $this->hasMany(BoxArchiveRequest::class);
    // }

    public function boxes(): HasMany
    {
        return $this->hasMany(BoxArchiveRequest::class);
    }


    
    public function getRealBoxQuantity(): int
    {
        return $this->boxes()->count();
    }

    public function lastBox(): ?BoxArchiveRequest
{
    return $this->boxes()->latest()->first();
}

    
}
