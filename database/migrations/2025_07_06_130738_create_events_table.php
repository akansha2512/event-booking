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
        Schema::create('events', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();

            $table->id();
        $table->string('title');
        $table->text('description')->nullable();
        $table->string('location');
        $table->integer('total_seats');
        $table->integer('available_seats');
        $table->softDeletes();
        $table->timestamps();
        $table->timestamp('start_time')->nullable();
        $table->timestamp('end_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
