<?php

namespace Modules\Page\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Interfaces\HasMedia;
use Modules\Media\Traits\InteractsWithMedia;
use Modules\Page\Enums\PageTemplateEnum;

class Page extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'slug',
        'name',
        'content',
        'template',
        'seo_title',
        'seo_description',
        'status',
        'featured_image'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = [
        'title'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
        ->useFallbackUrl('/images/default-placeholder.png')
        ->useFallbackPath(public_path('/images/default-placeholder.png'));        
    } 

    public function getTitleAttribute()
    {
        return $this->name;
    }
}
