<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanRequest extends Model
{
    protected $fillable = [
        'direction_id',
        'department_id',
        'details_request',
        'box_name',
        'kind', 
        'request_date',
        'return_date',
        'Membership',
        'Status',
        'Value_Status',

    ];
    
    public function direction(): BelongsTo
    {
        return $this->belongsTo(Direction::class, 'direction_id');
    }
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}