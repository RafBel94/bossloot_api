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
            $table->boolean('tempered_glass');
            $table->integer('expansion_slots');
            $table->decimal('max_gpu_length');
            $table->decimal('max_cpu_cooler_height');
            $table->boolean('radiator_support');
            $table->integer('extra_fans_connectors');
            $table->decimal('depth');
            $table->decimal('width');
            $table->decimal('height');
            $table->decimal('weight');
        });

        DB::statement("ALTER TABLE case_specs ADD CONSTRAINT check_case_type CHECK (case_type IN ('Mid Tower', 'Full Tower', 'Mini Tower', 'Small Form Factor'))");
        DB::statement("ALTER TABLE case_specs ADD CONSTRAINT check_case_form_factor_support CHECK (form_factor_support IN ('ATX', 'Micro ATX', 'Mini ITX', 'E-ATX'))");
        DB::statement('ALTER TABLE case_specs ADD CONSTRAINT check_case_expansion_slots_range CHECK (expansion_slots BETWEEN 0 AND 9)');
        DB::statement('ALTER TABLE case_specs ADD CONSTRAINT check_case_max_gpu_length_range CHECK (max_gpu_length BETWEEN 260 AND 420)');
        DB::statement('ALTER TABLE case_specs ADD CONSTRAINT check_case_max_cpu_cooler_height_range CHECK (max_cpu_cooler_height BETWEEN 145 AND 180)');
        DB::statement('ALTER TABLE case_specs ADD CONSTRAINT check_case_extra_fans_connectors_range CHECK (extra_fans_connectors BETWEEN 2 AND 10)');
        DB::statement('ALTER TABLE case_specs ADD CONSTRAINT check_case_depth_range CHECK (depth BETWEEN 150 AND 300)');
        DB::statement('ALTER TABLE case_specs ADD CONSTRAINT check_case_width_range CHECK (width BETWEEN 300 AND 800)');
        DB::statement('ALTER TABLE case_specs ADD CONSTRAINT check_case_height_range CHECK (height BETWEEN 300 AND 800)');
        DB::statement('ALTER TABLE case_specs ADD CONSTRAINT check_case_weight_range CHECK (weight BETWEEN 2 AND 20)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_specs');
    }
};
