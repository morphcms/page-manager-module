<?php

namespace Modules\PageManager\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Tool;
use Modules\PageManager\Enums\PagePermission;
use Modules\PageManager\Nova\Resources\Page;

class PageManagerTool extends Tool
{
    public function boot()
    {
        \Nova::resources([
            Page::class,
        ]);
    }

    public function menu(Request $request)
    {
        return MenuSection::resource(Page::class)
            ->icon('newspaper')
            ->canSee(fn () => $request->user()->can(PagePermission::ViewAny->value));
    }
}
