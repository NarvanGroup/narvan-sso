<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIranCountiesTable extends Migration
{
    /**
     * Migration for Shahrestan
     *
     * Run the migrations.
     *
     * This table is equal to shahrestan in farsi
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iran_counties', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code', 50)->unique();
            $table->string('short_code', 20);
            $table->boolean('status')->default(1);

            $table->foreignId('province_id')->constrained('iran_provinces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iran_counties');
    }
}
