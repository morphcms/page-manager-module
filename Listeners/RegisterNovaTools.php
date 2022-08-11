<?php

namespace Modules\PageManager\Listeners;

use Modules\PageManager\Nova\PageManagerTool;

class RegisterNovaTools
{
    public function __invoke(): array
    {
        return [
            PageManagerTool::make(),
        ];
    }
}
