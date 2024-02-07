<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('labels', function (Blueprint $table) {
            $table->id();
            $table->string('page_size');
            $table->string('label_width');
            $table->string('label_height');
            $table->string('orientation');
            $table->string('date_start');
            $table->string('date_end');
            $table->string('start_label_position')->nullable();
            $table->string('end_label_position')->nullable();
            $table->string('pdf');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('labels');
    }
};