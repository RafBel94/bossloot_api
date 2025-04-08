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

        DB::statement("ALTER TABLE motherboard_specs ADD CONSTRAINT check_socket CHECK (socket IN ('AM4', 'AM5', 'SP3', 'SP5', 'LGA1200', 'LGA1700', 'LGA2066'))");
        DB::statement("ALTER TABLE motherboard_specs ADD CONSTRAINT check_chipset CHECK (chipset IN ('X570', 'B550', 'A520', 'X470', 'X670E', 'X670', 'B650E', 'B650', 'A620', 'Z490', 'H470', 'B460', 'H410', 'Z690', 'H670', 'B660', 'H610', 'Z790', 'H770', 'B760'))");
        DB::statement("ALTER TABLE motherboard_specs ADD CONSTRAINT check_form_factor CHECK (form_factor IN ('E-ATX', 'ATX', 'Micro-ATX', 'Mini-ITX'))");
        DB::statement('ALTER TABLE motherboard_specs ADD CONSTRAINT check_memory_max CHECK (memory_max IN (32, 64, 128, 256))');
        DB::statement("ALTER TABLE motherboard_specs ADD CONSTRAINT check_memory_slots CHECK (memory_slots IN (2, 4, 8))");
        DB::statement("ALTER TABLE motherboard_specs ADD CONSTRAINT check_memory_type CHECK (memory_type IN ('DDR3', 'DDR4', 'DDR5'))");
        DB::statement("ALTER TABLE motherboard_specs ADD CONSTRAINT check_memory_speed CHECK (memory_speed IN (1066, 1333, 1600, 1866, 2133, 2400, 2666, 3000, 3200, 3600, 4800, 5200, 5600, 6000, 6400, 7200))");
        DB::statement("ALTER TABLE motherboard_specs ADD CONSTRAINT check_sata_ports CHECK (sata_ports IN (2, 4, 6, 8))");
        DB::statement("ALTER TABLE motherboard_specs ADD CONSTRAINT check_m_2_slots CHECK (m_2_slots IN (0, 1, 2, 3))");
        DB::statement("ALTER TABLE motherboard_specs ADD CONSTRAINT check_pcie_slots CHECK (pcie_slots IN (1, 2, 3, 4))");
        DB::statement("ALTER TABLE motherboard_specs ADD CONSTRAINT check_usb_ports_range CHECK (usb_ports BETWEEN 2 AND 10)");
        DB::statement("ALTER TABLE motherboard_specs ADD CONSTRAINT check_lan CHECK (lan IN ('1GbE', '2.5GbE', '5GbE', '10GbE'))");
        DB::statement("ALTER TABLE motherboard_specs ADD CONSTRAINT check_audio CHECK (audio IN ('Realtek ALC887', 'Realtek ALC892', 'Realtek ALC1150', 'Realtek ALC1200, 'Realtek ALC1220', 'Realtek ALC4080'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motherboard_specs');
    }
};
