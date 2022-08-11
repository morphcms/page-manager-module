<?php

namespace Modules\PageManager\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as BaseEventServiceProvider;
use Modules\Morphling\Events\BootModulesNovaTools;
use Modules\PageBuilder\Events\BootPageBuilder;
use Modules\PageManager\Listeners\RegisterNovaTools;
use Modules\PageManager\Listeners\RegisterPageBuilderTypes;

class EventServiceProvider extends BaseEventServiceProvider
{
    protected $listen = [
        BootModulesNovaTools::class => [
            RegisterNovaTools::class,
        ],

        BootPageBuilder::class => [
            RegisterPageBuilderTypes::class,
        ],
    ];
}
