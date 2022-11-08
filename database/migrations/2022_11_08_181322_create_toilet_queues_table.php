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
        Schema::create('toilet_queue', function (Blueprint $table) {
            $table->id();
            $table->string('channel_id');
            $table->string('user_name');
            $table->timestamps();
        });
    }
};
