<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoxMovement extends Model
{
    use HasFactory;
    protected $fillable = [
        'box_id', 
        'request_number', 
        'transmission_date', 
        'return_date', 
        'real_return_date',  // Ajout du champ
        'status'
    ];

    public function box()
    {
        return $this->belongsTo(Box::class);
    }
}
