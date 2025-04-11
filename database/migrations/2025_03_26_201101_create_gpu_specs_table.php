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
        Schema::create('gpu_specs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('memory');
            $table->string('memory_type');
            $table->integer('core_clock');
            $table->integer('boost_clock');
            $table->integer('consumption');
            $table->decimal('length');
        });

        DB::statement('ALTER TABLE gpu_specs ADD CONSTRAINT check_gpu_memory_range CHECK (memory BETWEEN 2 AND 24)');
        DB::statement("ALTER TABLE gpu_specs ADD CONSTRAINT check_gpu_memory_type CHECK (memory_type IN ('GDDR5', 'GDDR6'))");
        DB::statement('ALTER TABLE gpu_specs ADD CONSTRAINT check_gpu_core_clock_range CHECK (core_clock BETWEEN 800 AND 8000)');
        DB::statement('ALTER TABLE gpu_specs ADD CONSTRAINT check_gpu_boost_clock_range CHECK (boost_clock BETWEEN 800 AND 8000)');
        DB::statement('ALTER TABLE gpu_specs ADD CONSTRAINT check_gpu_consumption_range CHECK (consumption BETWEEN 25 AND 500)');
        DB::statement('ALTER TABLE gpu_specs ADD CONSTRAINT check_gpu_length_range CHECK (length BETWEEN 80 AND 400)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gpu_specs');
    }
};
