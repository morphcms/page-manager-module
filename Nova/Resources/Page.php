<?php

namespace Modules\PageManager\Nova\Resources;

use App\Nova\Resource;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Eminiarts\Tabs\Tabs;
use Eminiarts\Tabs\Traits\HasTabs;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Modules\Morphling\Nova\Actions\UpdateStatus;
use Modules\Morphling\Nova\Filters\ByStatus;
use Modules\PageBuilder\Traits\HasContentsNova;
use Modules\PageManager\Enums\PageStatus;
use Modules\PageManager\Utils\Table;
use Modules\SeoSorcery\Traits\HasSeoNova;

class Page extends Resource
{
    use HasContentsNova, HasTabs, HasSeoNova;

    public static string $model = \Modules\PageManager\Models\Page::class;

    public static $title = 'title';

    public static $displayInNavigation = false;

    public static $search = [
        'title', 'summary',
    ];

    public function fields(Request $request): array
    {
        $defaultLocale = config('app.locale', 'en');

        return [
            ID::make()->sortable(),

            Images::make(__('Banner'), 'banner')
                ->conversionOnIndexView('thumb')
                ->conversionOnPreview('thumb')
                ->conversionOnDetailView('webp')
                ->conversionOnForm('webp'),

            Stack::make(__('Title'), [
                Line::make('Title')->asHeading(),
                Line::make('Slug')->asBase(),
            ])->sortable()->exceptOnForms(),

            Text::make(__('Title'), 'title')
                ->onlyOnForms()
                ->translatable()
                ->rulesFor($defaultLocale, ['required'])
                ->rules(['nullable']),

            Slug::make(__('Slug'), 'slug')
                ->from("title.{$defaultLocale}")
                ->onlyOnForms()
                ->translatable()
                ->rulesFor($defaultLocale, ['required'])
                ->rules(['max:180', Rule::unique(Table::pages(), 'slug')->ignoreModel($this->model())]),

            Badge::make(__('Status'), 'status')
                ->displayUsing(fn () => $this->status->value)
                ->map(PageStatus::getNovaBadgeColors())
                ->exceptOnForms(),

            Textarea::make(__('Summary'), 'summary')
                ->help(__('A short and descriptive text about this page. Maximum of 200 characters.'))
                ->rows(2)
                ->translatable()
                ->rulesFor($defaultLocale, ['required'])
                ->rules(['max:200', 'nullable']),

            Tabs::make(__('Details'), [
                $this->contentField(),
                $this->seoField(),
            ]),
        ];
    }

    public function filters(Request $request): array
    {
        return [
            ByStatus::make(PageStatus::class),
        ];
    }

    public function actions(Request $request): array
    {
        return [
            UpdateStatus::make(PageStatus::class)->showInline(),
        ];
    }
}
