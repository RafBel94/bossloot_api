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
        Schema::create('psu_specs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('efficiency_rating');
            $table->integer('wattage');
            $table->boolean('modular');
            $table->boolean('fanless');
        });

        DB::statement("ALTER TABLE psu_specs ADD CONSTRAINT check_psu_efficiency_rating CHECK (efficiency_rating IN ('80+ Bronze', '80+ Silver', '80+ Gold', '80+ Platinum', '80+ Titanium'))");
        DB::statement("ALTER TABLE psu_specs ADD CONSTRAINT check_psu_wattage_range CHECK (wattage BETWEEN 100 AND 1500)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psu_specs');
    }
};
