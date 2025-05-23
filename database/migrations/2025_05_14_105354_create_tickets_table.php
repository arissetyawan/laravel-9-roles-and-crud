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
            $table->integer('category_id')->default(0);
            $table->string('description');
            $table->integer('reporter_id')->default(0);
            $table->integer('assigned_id')->default(0);
            $table->integer('priority_id')->default(0);
            $table->integer('status_id')->default(1);
            $table->dateTime('reported_at', precision: 0)->default(now());
            $table->dateTime('assigned_at', precision: 0)->default(now());
            $table->dateTime('last_status_at', precision: 0)->default(now());
            $table->integer('rating')->default(0);
            $table->string('rating_comment')->nullable();
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
