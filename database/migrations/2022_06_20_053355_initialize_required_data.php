<?php

use App\Enums\ResourceType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('resource_types')->insert([
            [
                'id' => 1,
                'name' => ResourceType::PDF,
                'slug' => Str::slug(ResourceType::PDF),
            ],
            [
                'id' => 2,
                'name' => ResourceType::HTML,
                'slug' => Str::slug(ResourceType::HTML),
            ],
            [
                'id' => 3,
                'name' => ResourceType::LINK,
                'slug' => Str::slug(ResourceType::LINK),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('resource_types')->truncate();
    }
};
