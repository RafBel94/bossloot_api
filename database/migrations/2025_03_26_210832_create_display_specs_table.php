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
        Schema::create('display_specs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('resolution');
            $table->integer('refresh_rate');
            $table->integer('response_time');
            $table->string('panel_type');
            $table->string('aspect_ratio');
            $table->boolean('curved');
            $table->integer('brightness');
            $table->string('contrast_ratio');
            $table->string('sync_type');
            $table->integer('hdmi_ports');
            $table->integer('display_ports');
            $table->integer('inches');
            $table->float('weight');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('display_specs');
    }
};
