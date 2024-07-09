<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media as MediaModel;
use App\Models\Media;

class Box extends Model implements HasMedia
{
    use SoftDeletes;
    use HasFactory, InteractsWithMedia;
    protected $dates = ['deleted_at'];
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

        // Pour la modification de l'emplacement de la boite 
        'site_id',
        'ray_id',
        'column_id',

        'request_number', 'transmission_date', 'return_date',
        'Deleted At'

    ];


    public function archiveRequest(): BelongsTo
    {
        return $this->belongsTo(ArchiveDemand::class, 'archive_demand_id');
    }
    public function boxArchiveRequest(): BelongsTo
    {
        return $this->belongsTo(Box::class, 'archive_demand_details_id');
    }


    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('files')
            ->acceptsMimeTypes(['application/pdf']);

        $this
            ->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png']);
    }



    public function shelf(): BelongsTo
    {
        return $this->belongsTo(Shelf::class, 'shelf_id');
    }

    // Pour la modification de l'emplacement de la boite 
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function ray(): BelongsTo
    {
        return $this->belongsTo(Ray::class, 'ray_id');
    }

    public function column(): BelongsTo
    {
        return $this->belongsTo(Column::class, 'column_id');
    }

    public function scopeBorrowed($query)
    {
        return $query->where('status', 'Not available');
    }

    public function isOverdue()
    {
        return $this->return_date && Carbon::parse($this->return_date)->isPast();
    }
    public function isPendingDestruction()
    {
        return $this->destruction_date !== null && $this->destruction_date !== 'not defined';
    }
    public function scopeOverdue($query)
    {
        return $query
            ->where('return_date', '<', Carbon::now());
    }

    public function scopeDestroyed($query)
    {
        return $query->onlyTrashed();
    }
}
