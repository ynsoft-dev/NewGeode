<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = [
        'name',
        'loan_detail_id',

    ];
    public function loanDetails(): BelongsTo
    {
        return $this->belongsTo(LoanDetails::class, 'loan_detail_id');
    }
 
    public function registerMediaCollections(Media $media = null): void
    {
        
        $this
            ->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg']);
        $this->addMediaConversion('thumb')
            ->width(100)
            ->height(100)
            ->sharpen(10);
        $this
            ->addMediaCollection('files')
            ->acceptsMimeTypes(['application/pdf']);
    }
  
}