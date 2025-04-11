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
        Schema::create('cpu_specs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('socket');
            $table->integer('core_count');
            $table->integer('thread_count');
            $table->decimal('base_clock', 3, 2);
            $table->decimal('boost_clock', 3, 2);
            $table->integer('consumption');
            $table->boolean('integrated_graphics');
        });

        DB::statement("ALTER TABLE cpu_specs ADD CONSTRAINT check_cpu_socket CHECK (socket IN ('AM4', 'AM5', 'SP3', 'SP5', 'LGA1200', 'LGA1700', 'LGA2066'))");
        DB::statement("ALTER TABLE cpu_specs ADD CONSTRAINT check_cpu_core_count CHECK (core_count IN (1, 2, 4, 8, 12, 16))");
        DB::statement("ALTER TABLE cpu_specs ADD CONSTRAINT check_cpu_thread_count CHECK (thread_count IN (1, 2, 4, 8, 12, 16, 24, 32))");
        DB::statement('ALTER TABLE cpu_specs ADD CONSTRAINT check_cpu_base_clock_range CHECK (base_clock BETWEEN 1 AND 8)');
        DB::statement('ALTER TABLE cpu_specs ADD CONSTRAINT check_cpu_boost_clock_range CHECK (boost_clock BETWEEN 1 AND 8)');
        DB::statement('ALTER TABLE cpu_specs ADD CONSTRAINT check_cpu_consumption_range CHECK (consumption BETWEEN 5 AND 500)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cpu_specs');
    }
};
