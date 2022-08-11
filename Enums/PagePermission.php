<?php

namespace Modules\PageManager\Enums;

use Modules\Morphling\Enums\HasValues;

enum PagePermission: string
{
    use HasValues;

    case All = 'pages.*';
    case  ViewAny = 'pages.viewAny';
    case  View = 'pages.view';
    case  Create = 'pages.create';
    case  Update = 'pages.update';
    case  Delete = 'pages.delete';
    case  Replicate = 'pages.replicate';
    case  Restore = 'pages.restore';
}
