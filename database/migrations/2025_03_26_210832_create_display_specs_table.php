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
        Schema::create('display_specs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('resolution');
            $table->integer('refresh_rate');
            $table->integer('response_time');
            $table->string('panel_type');
            $table->string('aspect_ratio');
            $table->boolean('curved');
            $table->integer('brightness');
            $table->string('contrast_ratio');
            $table->string('sync_type');
            $table->integer('hdmi_ports');
            $table->integer('display_ports');
            $table->integer('inches');
            $table->decimal('weight');
        });

        DB::statement("ALTER TABLE display_specs ADD CONSTRAINT check_resolution_values CHECK (resolution IN ('1920x1080', '2560x1440', '3440x1440', '3840x2160'))");
        DB::statement("ALTER TABLE display_specs ADD CONSTRAINT check_refresh_rate_values CHECK (refresh_rate IN (30, 60, 90, 120, 144, 165, 240))");
        DB::statement("ALTER TABLE display_specs ADD CONSTRAINT check_response_time_values CHECK (response_time BETWEEN 1 AND 10)");
        DB::statement("ALTER TABLE display_specs ADD CONSTRAINT check_panel_type_values CHECK (panel_type IN ('IPS', 'VA', 'OLED'))");
        DB::statement("ALTER TABLE display_specs ADD CONSTRAINT check_aspect_ratio_values CHECK (aspect_ratio IN ('16:9', '21:9', '32:9'))");
        DB::statement("ALTER TABLE display_specs ADD CONSTRAINT check_brightness_values CHECK (brightness BETWEEN 100 AND 1000)");
        DB::statement("ALTER TABLE display_specs ADD CONSTRAINT check_contrast_ratio_values CHECK (contrast_ratio IN ('1000:1', '3000:1', '5000:1'))");
        DB::statement("ALTER TABLE display_specs ADD CONSTRAINT check_sync_type_values CHECK (sync_type IN ('G-Sync', 'FreeSync', 'V-Sync'))");
        DB::statement("ALTER TABLE display_specs ADD CONSTRAINT check_hdmi_ports_values CHECK (hdmi_ports BETWEEN 1 AND 5)");
        DB::statement("ALTER TABLE display_specs ADD CONSTRAINT check_display_ports_values CHECK (display_ports BETWEEN 1 AND 5)");
        DB::statement("ALTER TABLE display_specs ADD CONSTRAINT check_inches_values CHECK (inches BETWEEN 10 AND 50)");
        DB::statement("ALTER TABLE display_specs ADD CONSTRAINT check_weight_values CHECK (weight BETWEEN 1 AND 20)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('display_specs');
    }
};
