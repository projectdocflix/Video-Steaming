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
        Schema::table('homes', function (Blueprint $table) {
            $table->string('banner_fourth_line_title')->nullable()->after('banner_third_line_title');
            $table->string('banner_video')->nullable()->after('banner_fourth_line_title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('homes', function (Blueprint $table) {
            $table->dropColumn('banner_fourth_line_title');
            $table->dropColumn('banner_video');
        });
    }
};
