<?php

namespace Modules\PageManager\Listeners;

use Modules\PageBuilder\Events\BootPageBuilder;
use Modules\PageManager\Nova\Resources\Page;

class RegisterPageBuilderTypes
{
    /**
     * Handle the event.
     *
     * @param  BootPageBuilder  $event
     * @return void
     */
    public function handle(BootPageBuilder $event)
    {
        $event->pageBuilder->types([
            Page::class,
        ]);
    }
}
