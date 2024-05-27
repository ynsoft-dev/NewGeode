<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanDemand extends Model
{
    protected $fillable = [
        'borrow_id',
        'direction_id',
        'department_id',
        'details_request',
        'box_name',
        'type', 
        'request_date',
        'return_date',
        'Status',
        'Value_Status',
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
}