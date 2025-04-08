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
        Schema::create('mouse_specs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('dpi');
            $table->string('sensor');
            $table->integer('buttons');
            $table->boolean('bluetooth');
            $table->decimal('weight');
        });

        DB::statement('ALTER TABLE mouse_specs ADD CONSTRAINT check_dpi_range CHECK (dpi BETWEEN 600 AND 20000)');
        DB::statement("ALTER TABLE mouse_specs ADD CONSTRAINT check_sensor_type CHECK (sensor IN ('Optical', 'Laser'))");
        DB::statement('ALTER TABLE mouse_specs ADD CONSTRAINT check_buttons_range CHECK (buttons BETWEEN 2 AND 20)');
        DB::statement('ALTER TABLE mouse_specs ADD CONSTRAINT check_weight_range CHECK (weight BETWEEN 50 AND 150)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mouse_specs');
    }
};
