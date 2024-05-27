<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class LoanDetails extends Model
{
    protected $fillable = [
        'loan_demand_id',
        'borrow_id',
        'direction_id',
        'department_id',
        'type',
        'box_name',
        'request_date',
        'return_date',
        'Status',
        'Value_Status',
        'user',
        // 'accept_reason',
        // 'rejection_reason',

    ];
    public function loan(): BelongsTo
    {
        return $this->belongsTo(LoanDemand::class, 'loan_demand_id');
    }
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
 
}