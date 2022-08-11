<?php

namespace Modules\PageManager\Nova\MenuTypes;

use Modules\Morphling\Services\Morphling;
use Modules\PageManager\Models\Page;
use Outl1ne\MenuBuilder\MenuItemTypes\MenuItemSelectType;

class MenuItemPage extends MenuItemSelectType
{
    /**
     * Get the menu link identifier that can be used to tell different custom
     * links apart (ie 'page' or 'product').
     *
     * @return string
     **/
    public static function getIdentifier(): string
    {
        return 'page';
    }

    /**
     * Get menu link name shown in  a dropdown in CMS when selecting link type
     * ie ('Product Link').
     *
     * @return string
     **/
    public static function getName(): string
    {
        return __('Page Link');
    }

    /**
     * Get list of options shown in a select dropdown.
     *
     * Should be a map of [key => value, ...], where key is a unique identifier
     * and value is the displayed string.
     *
     * @param $locale
     * @return array
     */
    public static function getOptions($locale): array
    {
        // Example usecase
        // return Page::all()->pluck('name', 'id')->toArray();

        return Page::published()->pluck('title', 'id')->toArray();
    }

    /**
     * Get the subtitle value shown in CMS menu items list.
     *
     * @param $value string
     * @param $data array|null The data from item fields.
     * @param $locale string
     * @return ?string
     **/
    public static function getDisplayValue($value, ?array $data, $locale): ?string
    {
        // Example usecase
        // return 'Page: ' . Page::find($value)->name;
        return Page::find($value)?->title;
    }

    /**
     * Get the value of the link visible to the front-end.
     *
     * Can be anything. It is up to you how you will handle parsing it.
     *
     * This will only be called when using the nova_get_menu()
     * and nova_get_menus() helpers or when you call formatForAPI()
     * on the Menu model.
     *
     * @param $value string The key from options list that was selected.
     * @param $data array|null The data from item fields.
     * @param $locale string
     * @return string
     */
    public static function getValue($value, ?array $data, $locale): string
    {
        return Morphling::clientUrl(Page::find($value)->slug);
    }
}
