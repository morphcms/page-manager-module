<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\PageManager\Enums\PageStatus;
use Modules\PageManager\Utils\Table;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Table::pages(), function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('slug');
            $table->string('status')->default(PageStatus::Draft->value);
            $table->json('summary')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Table::pages());
    }
};
