<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tbl_cars', function (Blueprint $table) {
            $table->bigInteger('car_type_id')->unsigned();
            $table->foreign('car_type_id')->references('car_type_id')->on('tbl_cars_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_cars', function (Blueprint $table) {
            $table->dropForeign(['car_type_id']);
            $table->dropColumn('car_type_id');
        });
    }
};
