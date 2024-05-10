<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class LoanDetails extends Model
{
    protected $fillable = [
        'loan_request_id',
        'direction_id',
        'department_id',
        'kind',
        'box_name',
        'request_date',
        'return_date',
        'Membership',
        'Status',
        'Value_Status',
        'user',

    ];
    public function loan(): BelongsTo
    {
        return $this->belongsTo(LoanRequest::class, 'loan_request_id');
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