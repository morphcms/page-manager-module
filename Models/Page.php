<?php

namespace Modules\PageManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Modules\Morphling\Traits\HasTranslatableSlug;
use Modules\PageBuilder\Traits\HasContents;
use Modules\PageManager\Database\Factories\PageFactory;
use Modules\PageManager\Enums\PageStatus;
use Modules\PageManager\Utils\Table;
use Modules\SeoSorcery\Contracts\ICanBeSeoAnalyzed;
use Modules\SeoSorcery\Traits\HasSeo;
use Modules\SeoSorcery\Utils\SeoOptions;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Page extends Model implements HasMedia, ICanBeSeoAnalyzed
{
    use HasFactory,
        HasTranslatableSlug,
        HasTranslations,
        InteractsWithMedia,
        HasSeo,
        SoftDeletes,
        HasContents,
        Searchable;

    protected $guarded = [];

    public array $translatable = ['title', 'summary', 'slug'];

    protected $casts = [
        'status' => PageStatus::class,
    ];

    protected static function newFactory(): PageFactory
    {
        return PageFactory::new();
    }

    public function getTable(): string
    {
        return Table::pages();
    }

    protected function setSeoOptions(): SeoOptions
    {
        return SeoOptions::make($this)
            ->setThumbnailCollection('banner');
    }

    public function scopePublished($query)
    {
        return $query->whereStatus(PageStatus::Published);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default');
        $this->addMediaCollection('banner')->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->format(Manipulations::FORMAT_WEBP)
            ->performOnCollections('banner', 'default');

        $this->addMediaConversion('thumb')
            ->format(Manipulations::FORMAT_WEBP)
            ->width(150)
            ->height(150)
            ->quality(70);
    }

    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'status' => $this->status,
            ...$this->getContentsIndexing(),
        ];
    }
}
