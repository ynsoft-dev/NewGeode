<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArchieveRequestDetails extends Model
{
    protected $fillable = [

        'name',
        'details_request',
        'request_date',
        'status',
        'department',
        'direction',

        'user',
        'archive_request_id',

    ];


    public function archiveRequest(): BelongsTo
    {
        return $this->belongsTo(ArchiveRequest::class, 'archive_request_id');
    }

    public function boxes(): HasMany
    {
        return $this->hasMany(Box::class);
    }
}
