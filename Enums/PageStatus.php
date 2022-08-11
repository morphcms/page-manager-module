<?php

namespace Modules\PageManager\Enums;

use Modules\Blog\Enums\PostStatus;
use Modules\Morphling\Enums\HasSelectOptions;
use Modules\Morphling\Enums\HasValues;

enum PageStatus: string
{
    use HasSelectOptions, HasValues;

    case Published = 'published';
    case Review = 'review';
    case Draft = 'draft';

    public static function getNovaBadgeColors(): array
    {
        return [
            PostStatus::Published->value => 'success',
            PostStatus::Review->value => 'warning',
            PostStatus::Draft->value => 'info',
        ];
    }
}
