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
        Schema::create('keyboard_specs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('type');
            $table->string('switch_type');
            $table->decimal('width');
            $table->decimal('height');
            $table->decimal('weight');
        });

        DB::statement("ALTER TABLE keyboard_specs ADD CONSTRAINT check_keyboard_type CHECK (type IN ('Mechanical', 'Membrane', 'Hybrid'))");
        DB::statement("ALTER TABLE keyboard_specs ADD CONSTRAINT check_keyboard_switch_type CHECK (switch_type IN ('Cherry MX Red', 'Gateron Red', 'Kailh Red', 'Cherry MX Brown', 'Zealios V2', 'Holy Panda', 'Cherry MX Blue', 'Kailh BOX White', 'Razer Green', 'Cherry MX Speed Silver', 'Kailh Speed', 'Cherry MX Silent Red', 'Silent Black', 'Cherry MX Low Profile Red', 'Kailh Choc'))");
        DB::statement("ALTER TABLE keyboard_specs ADD CONSTRAINT check_keyboard_width CHECK (width BETWEEN 250 AND 450)");
        DB::statement("ALTER TABLE keyboard_specs ADD CONSTRAINT check_keyboard_height CHECK (height BETWEEN 30 AND 60)");
        DB::statement("ALTER TABLE keyboard_specs ADD CONSTRAINT check_keyboard_weight CHECK (weight BETWEEN 600 AND 4000)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keyboard_specs');
    }
};
