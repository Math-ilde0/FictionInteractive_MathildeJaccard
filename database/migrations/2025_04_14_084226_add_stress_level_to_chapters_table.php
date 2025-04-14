<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('chapters', function (Blueprint $table) {
            $table->integer('stress_level')->default(5)->after('content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('chapters', function (Blueprint $table) {
        $table->dropColumn('stress_level');
    });
}

};
