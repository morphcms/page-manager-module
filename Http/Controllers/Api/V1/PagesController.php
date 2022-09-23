<?php

namespace Modules\PageManager\Http\Controllers\Api\V1;

use Illuminate\Database\Eloquent\Builder;
use Modules\PageManager\Models\Page;
use Modules\PageManager\Transformers\PageResource;
use Orion\Http\Controllers\Controller;
use Orion\Http\Requests\Request;

class PagesController extends Controller
{
    protected $model = Page::class;

    protected $resource = PageResource::class;

    public function includes(): array
    {
        return [
            'contentPublished',
            'contentsPublished',
            'media',
            'seo',
        ];
    }

    public function exposedScopes(): array
    {
        return ['latest', 'oldest'];
    }

    protected function keyName(): string
    {
        $locale = app()->getLocale();

        return "slug->$locale";
    }

    public function searchableBy(): array
    {
        $locale = app()->getLocale();

        return ["title->$locale", "slug->$locale", "summary->$locale"];
    }

    public function sortableBy(): array
    {
        $locale = app()->getLocale();

        return [
            'id',
            "title->$locale",
        ];
    }

    /**
     * Builds Eloquent query for fetching entities in index method.
     *
     * @param  Request  $request
     * @param  array  $requestedRelations
     * @return Builder
     */
    protected function buildIndexFetchQuery(Request $request, array $requestedRelations): Builder
    {
        $query = parent::buildIndexFetchQuery($request, $requestedRelations);

        $query->published();

        return $query;
    }
}
