<?php

use Modules\PageManager\Http\Controllers\Api\V1\PagesController;
use Orion\Facades\Orion;

Route::group(['prefix' => 'v1'], function () {
    Orion::resource('pages', PagesController::class)->only(['index', 'show']);
});
