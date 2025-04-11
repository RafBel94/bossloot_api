<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ram_specs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('speed');
            $table->integer('memory');
            $table->string('memory_type');
            $table->integer('latency');
        });

        DB::statement('ALTER TABLE ram_specs ADD CONSTRAINT check_ram_speed_range CHECK (speed BETWEEN 800 AND 6000)');
        DB::statement('ALTER TABLE ram_specs ADD CONSTRAINT check_ram_memory_range CHECK (memory BETWEEN 4 AND 256)');
        DB::statement("ALTER TABLE ram_specs ADD CONSTRAINT check_ram_memory_type CHECK (memory_type IN ('DDR3', 'DDR4', 'DDR5'))");
        DB::statement('ALTER TABLE ram_specs ADD CONSTRAINT check_ram_latency_range CHECK (latency BETWEEN 7 AND 40)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ram_specs');
    }
};
