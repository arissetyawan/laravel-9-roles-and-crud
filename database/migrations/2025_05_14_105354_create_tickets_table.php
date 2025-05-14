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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->string('description');
            $table->integer('reporter_id');
            $table->integer('assigned_id');
            $table->integer('status_id');
            $table->dateTime('reported_at', precision: 0);
            $table->dateTime('assigned_at', precision: 0);
            $table->dateTime('last_status_at', precision: 0);
            $table->integer('rating')->default(0);
            $table->string('rating_comment');
            $table->integer('circle_counter')->default(0);
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
        Schema::dropIfExists('tickets');
    }
};
