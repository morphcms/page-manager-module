<?php

namespace Modules\PageManager\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Acl\Utils\AclSeederHelper;
use Modules\PageManager\Enums\PagePermission;

class PageManagerDatabaseSeeder extends Seeder
{
    use AclSeederHelper;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->acl('page-manager')
            ->attachEnum(PagePermission::class, PagePermission::All->value)
            ->create();
    }
}
