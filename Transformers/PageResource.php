<?php

namespace Modules\PageManager\Transformers;

use Modules\Morphling\Traits\HasMediaTransformer;
use Modules\PageBuilder\Traits\HasContentsTransformer;
use Modules\PageManager\Models\Page;
use Modules\SeoSorcery\Traits\HasSeoTransformer;
use Orion\Http\Resources\Resource;

/**
 * @mixin Page
 */
class PageResource extends Resource
{
    use HasSeoTransformer, HasContentsTransformer, HasMediaTransformer;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'status' => $this->status,
            'meta' => $this->meta,
            'banner' => $this->mediaSingleTransformer('banner'),
            'content' => $this->contentTransformer(),
            'contents' => $this->contentsTransformer(),
            'seo' => $this->seoEntityTransformer(),
        ];
    }
}
