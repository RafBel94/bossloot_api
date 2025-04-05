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
        Schema::create('case_specs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('case_type');
            $table->string('form_factor_support');
            $table->boolean('side_panel');
            $table->integer('expansion_slots');
            $table->float('max_gpu_length');
            $table->float('max_cpu_cooler_height');
            $table->boolean('radiator_support');
            $table->integer('extra_fans_connectors');
            $table->float('depth');
            $table->float('width');
            $table->float('height');
            $table->float('weight');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_specs');
    }
};
