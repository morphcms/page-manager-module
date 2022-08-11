<?php

namespace Modules\PageManager\Utils;

use Modules\Morphling\Traits\TableHelper;

/**
 * @method static pages(string $column = null)
 */
class Table
{
    use TableHelper;

    public static $configPath = 'page-manager.table_prefix';
}
