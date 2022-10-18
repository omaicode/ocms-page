<?php

namespace Modules\Page\Entities;

use Illuminate\Database\Eloquent\Model;
use Omaicode\MediaLibrary\InteractsWithMedia;

class Page extends Model
{
    use InteractsWithMedia;

    protected $fillable = [
        'slug',
        'name',
        'description',
        'content',
        'template',
        'seo_title',
        'seo_description',
        'status'
    ];

    protected $appends = [
        'featured_image'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('page_images')
        ->useFallbackUrl('/images/default-placeholder.png')
        ->useFallbackPath(public_path('/images/default-placeholder.png'));        
    } 
    
    public function getFeaturedImageAttribute()
    {
        return $this->getFirstMediaUrl('page_images');
    }
}
