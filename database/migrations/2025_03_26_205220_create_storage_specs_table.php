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
        Schema::create('storage_specs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('type');
            $table->integer('capacity');
            $table->integer('rpm');
            $table->integer('read_speed');
            $table->integer('write_speed');
        });

        DB::statement("ALTER TABLE storage_specs ADD CONSTRAINT check_type CHECK (type IN ('SSD', 'HDD', 'NVMe', 'NVMe M.2'))");
        DB::statement("ALTER TABLE storage_specs ADD CONSTRAINT check_capacity CHECK (capacity IN (120, 250, 500, 1000, 2000, 4000))");
        DB::statement('ALTER TABLE storage_specs ADD CONSTRAINT check_rpm_range CHECK (rpm BETWEEN 0 AND 7200)');
        DB::statement('ALTER TABLE storage_specs ADD CONSTRAINT check_read_speed_range CHECK (read_speed BETWEEN 100 AND 14000)');
        DB::statement('ALTER TABLE storage_specs ADD CONSTRAINT check_write_speed_range CHECK (write_speed BETWEEN 100 AND 12000)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storage_specs');
    }
};
