<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\RamSpec;
use App\Models\GpuSpec;
use App\Models\CpuSpec;
use App\Models\MotherboardSpec;
use App\Models\StorageSpec;
use App\Models\PsuSpec;
use App\Models\CaseSpec;
use App\Models\CoolerSpec;
use App\Models\DisplaySpec;
use App\Models\KeyboardSpec;
use App\Models\MouseSpec;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(30)->create(['role' => 'user']);

        User::factory(1)->create([
            'email' => 'user@user.com',
            'password' => 'User123.',
            'role' => 'user',
        ]);

        User::factory()->create([
            'name' => 'Rafael',
            'email' => 'admin@admin.com',
            'password' => 'Admin123.',
            'role' => 'admin',
            'email_confirmed' => true,
            'activated' => true,
            'email_verified_at' => now()
        ]);

        User::factory()->create([
            'name' => 'Rafael',
            'email' => 'rafael@gmail.com',
            'password' => 'Rafael123.',
            'role' => 'user',
            'email_confirmed' => true,
            'activated' => true,
            'email_verified_at' => now()
        ]);

        // Products
        $this->seedProducts();
    }

    private function seedProducts(): void
    {
        // RAM Products
        Product::factory()->createMany([
            [
                'name' => 'Corsair Vengeance LPX',
                'description' => 'High-performance DDR4 RAM',
                'category' => 'ram',
                'model' => 'CMK16GX4M2B3200C16',
                'brand' => 'Corsair',
                'price' => 89.99,
                'quantity' => 50,
                'featured' => true
            ],
            [
                'name' => 'G.Skill Trident Z RGB',
                'description' => 'RGB DDR4 RAM for gaming',
                'category' => 'ram',
                'model' => 'F4-3200C16D-16GTZR',
                'brand' => 'G.Skill',
                'price' => 109.99,
                'quantity' => 40,
                'featured' => true
            ],
            [
                'name' => 'Kingston HyperX Fury',
                'description' => 'Reliable DDR4 RAM for performance',
                'category' => 'ram',
                'model' => 'HX432C16FB3/16',
                'brand' => 'Kingston',
                'price' => 79.99,
                'quantity' => 60,
                'featured' => false
            ],
            [
                'name' => 'TeamGroup T-Force Delta RGB',
                'description' => 'Stylish RGB DDR4 RAM',
                'category' => 'ram',
                'model' => 'TF4D416G3200HC16CDC01',
                'brand' => 'TeamGroup',
                'price' => 99.99,
                'quantity' => 30,
                'featured' => true
            ],
            [
                'name' => 'Patriot Viper Steel',
                'description' => 'High-speed DDR4 RAM for enthusiasts',
                'category' => 'ram',
                'model' => 'PVS416G320C6',
                'brand' => 'Patriot',
                'price' => 94.99,
                'quantity' => 35,
                'featured' => false
            ],
        ])->each(function ($product) {
            RamSpec::create([
                'product_id' => $product->id,
                'speed' => collect([2000, 2300, 2600, 3000, 3200, 3600])->random(),
                'memory' => collect([8, 16, 32])->random(),
                'memory_type' => collect(['DDR3', 'DDR4', 'DDR5'])->random(),
                'latency' => collect([16, 17, 18, 19, 20])->random(),
            ]);
        });

        // GPU Products
        Product::factory()->createMany([
            [
                'name' => 'NVIDIA GeForce RTX 3060',
                'description' => 'Mid-range gaming GPU',
                'category' => 'gpu',
                'model' => 'RTX3060',
                'brand' => 'NVIDIA',
                'price' => 329.99,
                'quantity' => 20,
                'featured' => true
            ],
            [
                'name' => 'AMD Radeon RX 6700 XT',
                'description' => 'High-performance gaming GPU',
                'category' => 'gpu',
                'model' => 'RX6700XT',
                'brand' => 'AMD',
                'price' => 479.99,
                'quantity' => 15,
                'featured' => true
            ],
            [
                'name' => 'NVIDIA GeForce GTX 1660 Super',
                'description' => 'Affordable gaming GPU',
                'category' => 'gpu',
                'model' => 'GTX1660Super',
                'brand' => 'NVIDIA',
                'price' => 229.99,
                'quantity' => 25,
                'featured' => false
            ],
            [
                'name' => 'AMD Radeon RX 5500 XT',
                'description' => 'Entry-level gaming GPU',
                'category' => 'gpu',
                'model' => 'RX5500XT',
                'brand' => 'AMD',
                'price' => 199.99,
                'quantity' => 30,
                'featured' => false
            ],
            [
                'name' => 'NVIDIA GeForce RTX 3080',
                'description' => 'High-end gaming GPU',
                'category' => 'gpu',
                'model' => 'RTX3080',
                'brand' => 'NVIDIA',
                'price' => 699.99,
                'quantity' => 10,
                'featured' => true
            ],
        ])->each(function ($product) {
            GpuSpec::create([
                'product_id' => $product->id,
                'memory' => collect([6, 8, 10, 12, 16])->random(),
                'memory_type' => 'GDDR6',
                'core_clock' => collect([1200, 1300, 1400, 1500])->random(),
                'boost_clock' => collect([1600, 1700, 1800, 1900])->random(),
                'consumption' => collect([150, 170, 200, 250])->random(),
                'length' => collect([200, 220, 240, 260])->random(),
            ]);
        });

        // CPU Products
        Product::factory()->createMany([
            [
                'name' => 'AMD Ryzen 5 5600X',
                'description' => 'High-performance 6-core processor',
                'category' => 'cpu',
                'model' => 'Ryzen 5 5600X',
                'brand' => 'AMD',
                'price' => 199.99,
                'quantity' => 30,
                'featured' => true
            ],
            [
                'name' => 'Intel Core i5-12600K',
                'description' => '12th Gen Intel Core processor',
                'category' => 'cpu',
                'model' => 'i5-12600K',
                'brand' => 'Intel',
                'price' => 289.99,
                'quantity' => 25,
                'featured' => true
            ],
            [
                'name' => 'AMD Ryzen 7 5800X',
                'description' => '8-core processor for gaming and productivity',
                'category' => 'cpu',
                'model' => 'Ryzen 7 5800X',
                'brand' => 'AMD',
                'price' => 299.99,
                'quantity' => 20,
                'featured' => false
            ],
            [
                'name' => 'Intel Core i7-12700K',
                'description' => 'High-performance 12th Gen Intel processor',
                'category' => 'cpu',
                'model' => 'i7-12700K',
                'brand' => 'Intel',
                'price' => 409.99,
                'quantity' => 15,
                'featured' => true
            ],
            [
                'name' => 'AMD Ryzen 9 5900X',
                'description' => '12-core processor for enthusiasts',
                'category' => 'cpu',
                'model' => 'Ryzen 9 5900X',
                'brand' => 'AMD',
                'price' => 499.99,
                'quantity' => 10,
                'featured' => true
            ],
        ])->each(function ($product) {
            CpuSpec::create([
                'product_id' => $product->id,
                'socket' => collect(['AM4', 'AM5', 'SP3', 'SP5', 'LGA1200', 'LGA1700', 'LGA2066'])->random(),
                'core_count' => collect([6, 8, 12, 16])->random(),
                'thread_count' => collect([12, 16, 24, 32])->random(),
                'base_clock' => collect([3000, 3200, 3500, 3700])->random(),
                'boost_clock' => collect([4000, 4500, 4800, 5000])->random(),
                'consumption' => collect([65, 95, 105, 125])->random(),
                'integrated_graphics' => collect([true, false])->random(),
            ]);
        });

        // MOTHERBOARD Products
        Product::factory()->createMany([
            [
                'name' => 'ASUS ROG Strix B550-F Gaming',
                'description' => 'High-performance gaming motherboard',
                'category' => 'motherboard',
                'model' => 'ROG STRIX B550-F',
                'brand' => 'ASUS',
                'price' => 189.99,
                'quantity' => 20,
                'featured' => true
            ],
            [
                'name' => 'MSI MPG Z490 Gaming Edge WiFi',
                'description' => 'Gaming motherboard with WiFi support',
                'category' => 'motherboard',
                'model' => 'MPG Z490',
                'brand' => 'MSI',
                'price' => 199.99,
                'quantity' => 15,
                'featured' => true
            ],
            [
                'name' => 'Gigabyte AORUS X570 Elite',
                'description' => 'Reliable motherboard for AMD processors',
                'category' => 'motherboard',
                'model' => 'X570 AORUS ELITE',
                'brand' => 'Gigabyte',
                'price' => 179.99,
                'quantity' => 25,
                'featured' => false
            ],
            [
                'name' => 'ASRock B450M Steel Legend',
                'description' => 'Compact motherboard with great features',
                'category' => 'motherboard',
                'model' => 'B450M Steel Legend',
                'brand' => 'ASRock',
                'price' => 109.99,
                'quantity' => 30,
                'featured' => false
            ],
            [
                'name' => 'EVGA Z590 FTW WiFi',
                'description' => 'High-end motherboard for Intel processors',
                'category' => 'motherboard',
                'model' => 'Z590 FTW',
                'brand' => 'EVGA',
                'price' => 299.99,
                'quantity' => 10,
                'featured' => true
            ],
        ])->each(function ($product) {
            MotherboardSpec::create([
                'product_id' => $product->id,
                'socket' => collect(['AM4', 'AM5', 'SP3', 'SP5', 'LGA1200', 'LGA1700', 'LGA2066'])->random(),
                'chipset' => collect([
                    'X570',
                    'B550',
                    'A520',
                    'X470',
                    'X670E',
                    'X670',
                    'B650E',
                    'B650',
                    'A620',
                    'Z490',
                    'H470',
                    'B460',
                    'H410',
                    'Z690',
                    'H670',
                    'B660',
                    'H610',
                    'Z790',
                    'H770',
                    'B760',
                    'H610'
                ])->random(),
                'form_factor' => collect(['ATX', 'Micro-ATX', 'Mini-ITX', 'E-ATX'])->random(),
                'memory_max' => collect([64, 128])->random(),
                'memory_slots' => collect([2, 4])->random(),
                'memory_type' => collect(['DDR3', 'DDR4', 'DDR5'])->random(),
                'memory_speed' => collect([3200, 3600, 4000])->random(),
                'sata_ports' => collect([4, 6, 8])->random(),
                'm_2_slots' => collect([1, 2, 3])->random(),
                'pcie_slots' => collect([2, 3, 4])->random(),
                'usb_ports' => collect([6, 8, 10])->random(),
                'lan' => collect(['1GbE', '2.5GbE', '5GbE', '10GbE'])->random(),
                'audio' => collect(['Realtek ALC1200', 'Realtek ALC1220', 'Realtek ALC887'])->random(),
                'wifi' => collect([true, false])->random(),
                'bluetooth' => collect([true, false])->random(),
            ]);
        });

        // STORAGE Products
        Product::factory()->createMany([
            [
                'name' => 'Samsung 970 EVO Plus',
                'description' => 'High-performance NVMe SSD',
                'category' => 'storage',
                'model' => 'MZ-V7S1T0B/AM',
                'brand' => 'Samsung',
                'price' => 149.99,
                'quantity' => 50,
                'featured' => true
            ],
            [
                'name' => 'Western Digital Blue 1TB',
                'description' => 'Reliable SATA SSD for everyday use',
                'category' => 'storage',
                'model' => 'WDS100T2B0A',
                'brand' => 'Western Digital',
                'price' => 99.99,
                'quantity' => 40,
                'featured' => true
            ],
            [
                'name' => 'Seagate Barracuda 2TB',
                'description' => 'High-capacity HDD for storage needs',
                'category' => 'storage',
                'model' => 'ST2000DM008',
                'brand' => 'Seagate',
                'price' => 59.99,
                'quantity' => 60,
                'featured' => false
            ],
            [
                'name' => 'Crucial MX500 500GB',
                'description' => 'Affordable SATA SSD with great performance',
                'category' => 'storage',
                'model' => 'CT500MX500SSD1',
                'brand' => 'Crucial',
                'price' => 59.99,
                'quantity' => 30,
                'featured' => true
            ],
            [
                'name' => 'Kingston A2000 1TB',
                'description' => 'Budget-friendly NVMe SSD',
                'category' => 'storage',
                'model' => 'SA2000M8/1000G',
                'brand' => 'Kingston',
                'price' => 89.99,
                'quantity' => 35,
                'featured' => false
            ],
        ])->each(function ($product) {
            StorageSpec::create([
                'product_id' => $product->id,
                'type' => collect(['SSD', 'HDD', 'NVMe' . 'NVMe M.2'])->random(),
                'capacity' => collect([500, 1000, 2000])->random(),
                'rpm' => collect([0, 5400, 7200])->random(),
                'read_speed' => collect([500, 1000, 2000, 3500])->random(),
                'write_speed' => collect([400, 800, 1500, 3000])->random(),
            ]);
        });

        // PSU Products
        Product::factory()->createMany([
            [
                'name' => 'Corsair RM850x',
                'description' => 'High-performance 850W PSU with modular cables',
                'category' => 'psu',
                'model' => 'RM850x',
                'brand' => 'Corsair',
                'price' => 139.99,
                'quantity' => 20,
                'featured' => true
            ],
            [
                'name' => 'EVGA SuperNOVA 750 G5',
                'description' => '750W PSU with 80+ Gold efficiency',
                'category' => 'psu',
                'model' => '750 G5',
                'brand' => 'EVGA',
                'price' => 129.99,
                'quantity' => 25,
                'featured' => true
            ],
            [
                'name' => 'Seasonic Focus GX-650',
                'description' => '650W fully modular PSU with 80+ Gold rating',
                'category' => 'psu',
                'model' => 'Focus GX-650',
                'brand' => 'Seasonic',
                'price' => 119.99,
                'quantity' => 30,
                'featured' => false
            ],
            [
                'name' => 'Cooler Master MWE 550',
                'description' => '550W PSU with 80+ Bronze certification',
                'category' => 'psu',
                'model' => 'MWE 550',
                'brand' => 'Cooler Master',
                'price' => 69.99,
                'quantity' => 40,
                'featured' => false
            ],
            [
                'name' => 'Thermaltake Smart RGB 600W',
                'description' => '600W PSU with RGB lighting and 80+ certification',
                'category' => 'psu',
                'model' => 'Smart RGB 600W',
                'brand' => 'Thermaltake',
                'price' => 59.99,
                'quantity' => 35,
                'featured' => true
            ],
        ])->each(function ($product) {
            PsuSpec::create([
                'product_id' => $product->id,
                'efficiency_rating' => collect(['80+ Bronze', '80+ Silver', '80+ Gold', '80+ Platinum'])->random(),
                'wattage' => collect([550, 600, 650, 750, 850])->random(),
                'modular' => collect([true, false])->random(),
                'fanless' => collect([true, false])->random()
            ]);
        });

        // CASE Products
        Product::factory()->createMany([
            [
                'name' => 'NZXT H510',
                'description' => 'Compact mid-tower ATX case with tempered glass',
                'category' => 'case',
                'model' => 'CA-H510B-B1',
                'brand' => 'NZXT',
                'price' => 69.99,
                'quantity' => 40,
                'featured' => true
            ],
            [
                'name' => 'Corsair 4000D Airflow',
                'description' => 'High-airflow mid-tower ATX case',
                'category' => 'case',
                'model' => 'CC-9011200-WW',
                'brand' => 'Corsair',
                'price' => 94.99,
                'quantity' => 30,
                'featured' => true
            ],
            [
                'name' => 'Cooler Master MasterBox Q300L',
                'description' => 'Compact micro-ATX case with excellent airflow',
                'category' => 'case',
                'model' => 'MCB-Q300L-KANN-S00',
                'brand' => 'Cooler Master',
                'price' => 49.99,
                'quantity' => 50,
                'featured' => false
            ],
            [
                'name' => 'Fractal Design Meshify C',
                'description' => 'Stylish mid-tower ATX case with mesh front panel',
                'category' => 'case',
                'model' => 'FD-CA-MESH-C-BKO-TG',
                'brand' => 'Fractal Design',
                'price' => 109.99,
                'quantity' => 20,
                'featured' => true
            ],
            [
                'name' => 'Phanteks Eclipse P400A',
                'description' => 'High-airflow mid-tower ATX case with RGB lighting',
                'category' => 'case',
                'model' => 'PH-EC400ATG_DWT01',
                'brand' => 'Phanteks',
                'price' => 89.99,
                'quantity' => 25,
                'featured' => false
            ],
        ])->each(function ($product) {
            CaseSpec::create([
                'product_id' => $product->id,
                'case_type' => collect(['Mid Tower', 'Full Tower', 'Mini Tower', 'Small Form Factor'])->random(),
                'form_factor_support' => collect(['ATX', 'Micro-ATX', 'Mini-ITX', 'E-ATX'])->random(),
                'tempered_glass' => collect([true, false])->random(),
                'expansion_slots' => collect([4, 5, 6, 7, 8, 9])->random(),
                'max_gpu_length' => collect([280, 300, 320, 350, 400, 420])->random(),
                'max_cpu_cooler_height' => collect([145, 155, 165, 170, 180])->random(),
                'radiator_support' => collect([true, false])->random(),
                'extra_fans_connectors' => collect([2, 3, 4, 5, 6])->random(),
                'depth' => collect([160, 250, 300])->random(),
                'width' => collect([200, 210, 230, 250])->random(),
                'height' => collect([380, 450, 480, 520, 600])->random(),
                'weight' => round(mt_rand(4500, 12000) / 1000, 2), // kg (4.5 a 12 kg)
            ]);
        });

        // Cooler Products
        Product::factory()->createMany([
            [
                'name' => 'Noctua NH-D15',
                'description' => 'Premium dual-tower CPU cooler with quiet operation',
                'category' => 'cooler',
                'model' => 'NH-D15',
                'brand' => 'Noctua',
                'price' => 89.99,
                'quantity' => 20,
                'featured' => true
            ],
            [
                'name' => 'Cooler Master Hyper 212 Black Edition',
                'description' => 'High-performance air cooler with sleek design',
                'category' => 'cooler',
                'model' => 'RR-212S-20PK-R1',
                'brand' => 'Cooler Master',
                'price' => 49.99,
                'quantity' => 30,
                'featured' => true
            ],
            [
                'name' => 'Corsair iCUE H100i Elite Capellix',
                'description' => '240mm liquid cooler with RGB lighting',
                'category' => 'cooler',
                'model' => 'CW-9060046-WW',
                'brand' => 'Corsair',
                'price' => 149.99,
                'quantity' => 15,
                'featured' => true
            ],
            [
                'name' => 'be quiet! Dark Rock Pro 4',
                'description' => 'Silent high-end air cooler for overclocked systems',
                'category' => 'cooler',
                'model' => 'BK022',
                'brand' => 'be quiet!',
                'price' => 89.99,
                'quantity' => 25,
                'featured' => false
            ],
            [
                'name' => 'NZXT Kraken Z73',
                'description' => '360mm liquid cooler with customizable LCD display',
                'category' => 'cooler',
                'model' => 'RL-KRZ73-01',
                'brand' => 'NZXT',
                'price' => 249.99,
                'quantity' => 10,
                'featured' => true
            ],
        ])->each(function ($product) {
            CoolerSpec::create([
                'product_id' => $product->id,
                'type' => collect(['Air', 'Liquid'])->random(),
                'fan_rpm' => collect([1200, 1500, 1800, 2000])->random(),
                'consumption' => collect([5, 10, 15, 20])->random(),
                'socket_support' => collect(['AM4', 'AM5', 'SP3', 'SP5', 'LGA1200', 'LGA1700', 'LGA2066'])->random(),
                'width' => collect([120, 140, 160])->random(),
                'height' => collect([150, 160, 170])->random(),
            ]);
        });

        // Display Products
        Product::factory()->createMany([
            [
                'name' => 'Dell UltraSharp U2723QE',
                'description' => '27-inch 4K UHD monitor with IPS panel',
                'category' => 'display',
                'model' => 'U2723QE',
                'brand' => 'Dell',
                'price' => 649.99,
                'quantity' => 20,
                'featured' => true
            ],
            [
                'name' => 'LG 34GN850-B',
                'description' => '34-inch UltraWide QHD gaming monitor with 160Hz refresh rate',
                'category' => 'display',
                'model' => '34GN850-B',
                'brand' => 'LG',
                'price' => 999.99,
                'quantity' => 15,
                'featured' => true
            ],
            [
                'name' => 'ASUS TUF Gaming VG27AQ',
                'description' => '27-inch WQHD gaming monitor with 165Hz refresh rate',
                'category' => 'display',
                'model' => 'VG27AQ',
                'brand' => 'ASUS',
                'price' => 429.99,
                'quantity' => 25,
                'featured' => false
            ],
            [
                'name' => 'Samsung Odyssey G7',
                'description' => '32-inch QHD curved gaming monitor with 240Hz refresh rate',
                'category' => 'display',
                'model' => 'LC32G75TQSNXDC',
                'brand' => 'Samsung',
                'price' => 799.99,
                'quantity' => 10,
                'featured' => true
            ],
            [
                'name' => 'BenQ EX3501R',
                'description' => '35-inch UltraWide QHD curved monitor with HDR support',
                'category' => 'display',
                'model' => 'EX3501R',
                'brand' => 'BenQ',
                'price' => 699.99,
                'quantity' => 18,
                'featured' => false
            ],
        ])->each(function ($product) {
            DisplaySpec::create([
                'product_id' => $product->id,
                'resolution' => collect(['1920x1080', '2560x1440', '3840x2160'])->random(),
                'refresh_rate' => collect([60, 120, 144, 165, 240])->random(),
                'response_time' => collect([1, 2, 4, 5])->random(),
                'panel_type' => collect(['IPS', 'VA', 'OLED'])->random(),
                'aspect_ratio' => collect(['16:9', '21:9', '32:9'])->random(),
                'curved' => collect([true, false])->random(),
                'brightness' => collect([250, 300, 350, 400])->random(),
                'contrast_ratio' => collect(['1000:1', '3000:1'])->random(),
                'sync_type' => collect(['G-Sync', 'FreeSync', 'V-Sync'])->random(),
                'hdmi_ports' => collect([1, 2, 3])->random(),
                'display_ports' => collect([1, 2])->random(),
                'inches' => collect([24, 27, 32, 34, 35])->random(),
                'weight' => collect([5.5, 6.2, 7.8, 8.5])->random(),
            ]);
        });

        // Keyboard Products
        Product::factory()->createMany([
            [
                'name' => 'Logitech G Pro X',
                'description' => 'Mechanical gaming keyboard with swappable switches',
                'category' => 'keyboard',
                'model' => '920-009388',
                'brand' => 'Logitech',
                'price' => 129.99,
                'quantity' => 20,
                'featured' => true
            ],
            [
                'name' => 'Razer Huntsman Elite',
                'description' => 'Opto-mechanical gaming keyboard with RGB lighting',
                'category' => 'keyboard',
                'model' => 'RZ03-01870100-R3U1',
                'brand' => 'Razer',
                'price' => 199.99,
                'quantity' => 15,
                'featured' => true
            ],
            [
                'name' => 'Corsair K95 RGB Platinum XT',
                'description' => 'Premium mechanical keyboard with macro keys',
                'category' => 'keyboard',
                'model' => 'CH-9127414-NA',
                'brand' => 'Corsair',
                'price' => 199.99,
                'quantity' => 10,
                'featured' => false
            ],
            [
                'name' => 'SteelSeries Apex Pro',
                'description' => 'Adjustable mechanical gaming keyboard',
                'category' => 'keyboard',
                'model' => '64626',
                'brand' => 'SteelSeries',
                'price' => 179.99,
                'quantity' => 25,
                'featured' => true
            ],
            [
                'name' => 'HyperX Alloy Origins',
                'description' => 'Compact mechanical keyboard with RGB lighting',
                'category' => 'keyboard',
                'model' => 'HX-KB6RDX-US',
                'brand' => 'HyperX',
                'price' => 109.99,
                'quantity' => 30,
                'featured' => false
            ],
        ])->each(function ($product) {
            KeyboardSpec::create([
                'product_id' => $product->id,
                'type' => collect(['Mechanical', 'Membrane', 'Hybrid'])->random(),
                'switch_type' => collect(['Red', 'Blue', 'Brown', 'Yellow'])->random(),
                'width' => collect([350, 400, 450])->random(),
                'height' => collect([30, 40, 50])->random(),
                'weight' => collect([800, 1000, 1300])->random(),
            ]);
        });

        // Mouse Products
        Product::factory()->createMany([
            [
                'name' => 'Logitech G502 HERO',
                'description' => 'High-performance gaming mouse with customizable weights',
                'category' => 'mouse',
                'model' => '910-005469',
                'brand' => 'Logitech',
                'price' => 49.99,
                'quantity' => 30,
                'featured' => true
            ],
            [
                'name' => 'Razer DeathAdder V2',
                'description' => 'Ergonomic gaming mouse with optical switches',
                'category' => 'mouse',
                'model' => 'RZ01-03210100-R3U1',
                'brand' => 'Razer',
                'price' => 69.99,
                'quantity' => 25,
                'featured' => true
            ],
            [
                'name' => 'Corsair Dark Core RGB Pro',
                'description' => 'Wireless gaming mouse with ultra-low latency',
                'category' => 'mouse',
                'model' => 'CH-9315411-NA',
                'brand' => 'Corsair',
                'price' => 79.99,
                'quantity' => 20,
                'featured' => false
            ],
            [
                'name' => 'SteelSeries Rival 600',
                'description' => 'Dual sensor gaming mouse with adjustable weight system',
                'category' => 'mouse',
                'model' => '62446',
                'brand' => 'SteelSeries',
                'price' => 59.99,
                'quantity' => 15,
                'featured' => true
            ],
            [
                'name' => 'HyperX Pulsefire FPS Pro',
                'description' => 'RGB gaming mouse with precision sensor',
                'category' => 'mouse',
                'model' => 'HX-MC003B',
                'brand' => 'HyperX',
                'price' => 49.99,
                'quantity' => 40,
                'featured' => false
            ],
        ])->each(function ($product) {
            MouseSpec::create([
                'product_id' => $product->id,
                'dpi' => collect([800, 1600, 3200, 6400, 12000])->random(),
                'sensor' => collect(['Optical', 'Laser'])->random(),
                'buttons' => collect([5, 6, 7, 8, 10])->random(),
                'bluetooth' => collect([true, false])->random(),
                'weight' => collect([60, 70, 80, 90, 100])->random(),
            ]);
        });
    }
}