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
        Schema::create('motherboard_specs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('socket');
            $table->string('chipset');
            $table->string('form_factor');
            $table->integer('memory_max');
            $table->integer('memory_slots');
            $table->string('memory_type');
            $table->integer('memory_speed');
            $table->integer('sata_ports');
            $table->integer('m_2_slots');
            $table->integer('pcie_slots');
            $table->integer('usb_ports');
            $table->string('lan');
            $table->string('audio');
            $table->boolean('wifi');
            $table->boolean('bluetooth');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motherboard_specs');
    }
};
