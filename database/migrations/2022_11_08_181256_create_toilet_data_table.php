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
        Schema::create('toilet_data', static function (Blueprint $table) {
            $table->id();
            $table->boolean('motion')->default(false);
            $table->boolean('tamper')->default(false);
            $table->integer('battery')->default(0);
            $table->integer('lux')->default(0);
            $table->string('temperature')->default('0.0');
            $table->timestamps();
        });
    }
};
