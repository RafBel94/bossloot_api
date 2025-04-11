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
        Schema::create('cooler_specs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('type');
            $table->integer('fan_rpm');
            $table->integer('consumption');
            $table->string('socket_support');
            $table->decimal('width');
            $table->decimal('height');
        });

        DB::statement("ALTER TABLE cooler_specs ADD CONSTRAINT check_cooler_type CHECK (type IN ('Air', 'Liquid'))");
        DB::statement('ALTER TABLE cooler_specs ADD CONSTRAINT check_cooler_fan_rpm_range CHECK (fan_rpm BETWEEN 1000 AND 3000)');
        DB::statement('ALTER TABLE cooler_specs ADD CONSTRAINT check_cooler_consumption_range CHECK (consumption BETWEEN 5 AND 50)');
        DB::statement("ALTER TABLE cooler_specs ADD CONSTRAINT check_cooler_socket_support CHECK (socket_support IN ('LGA1151', 'LGA1200', 'AM4', 'LGA1700', 'AM5', 'SP3', 'SP5', 'LGA2066'))");
        DB::statement('ALTER TABLE cooler_specs ADD CONSTRAINT check_cooler_width_range CHECK (width BETWEEN 100 AND 300)');
        DB::statement('ALTER TABLE cooler_specs ADD CONSTRAINT check_cooler_height_range CHECK (height BETWEEN 100 AND 300)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cooler_specs');
    }
};
