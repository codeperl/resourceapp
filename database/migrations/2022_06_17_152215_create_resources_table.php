<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resource_type_id')->constrained();
            $table->string('title', 191);
            $table->text('url')->nullable();
            $table->longText('description')->nullable();
            $table->longText('code_snippet')->nullable();
            $table->boolean('open_in_new_tab')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropConstrainedForeignId('resource_type_id');
        });

        Schema::dropIfExists('resources');
    }
};
