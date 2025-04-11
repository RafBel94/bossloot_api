<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
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

        // Categories
        $this->seedCategories();

        // Brands
        $this->seedBrands();

        // Products
        $this->seedProducts();
    }

    private function seedCategories(): void
    {
        $categories = [
            ['name' => 'ram'],
            ['name' => 'gpu'],
            ['name' => 'cpu'],
            ['name' => 'motherboard'],
            ['name' => 'storage'],
            ['name' => 'psu'],
            ['name' => 'case'],
            ['name' => 'cooler'],
            ['name' => 'display'],
            ['name' => 'keyboard'],
            ['name' => 'mouse'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }

    private function seedBrands(): void
    {
        $brands = [
            ['name' => 'Corsair'],
            ['name' => 'Kingston'],
            ['name' => 'Crucial'],
            ['name' => 'G.Skill'],
            ['name' => 'ADATA'],
            ['name' => 'Patriot'],
            ['name' => 'HyperX'],
            ['name' => 'AMD'],
            ['name' => 'Intel'],
            ['name' => 'NVIDIA'],
            ['name' => 'MSI'],
            ['name' => 'ASUS'],
            ['name' => 'GIGABYTE'],
            ['name' => 'Zotac'],
            ['name' => 'PNY'],
            ['name' => 'ASRock'],
            ['name' => 'Sapphire'],
            ['name' => 'PowerColor'],
            ['name' => 'Seasonic'],
            ['name' => 'EVGA'],
            ['name' => 'Be Quiet!'],
            ['name' => 'NZXT'],
            ['name' => 'Cooler Master'],
            ['name' => 'Thermaltake'],
            ['name' => 'SilverStone'],
            ['name' => 'Deepcool'],
            ['name' => 'Antec'],
            ['name' => 'Aerocool'],
            ['name' => 'Noctua'],
            ['name' => 'Arctic'],
            ['name' => 'Samsung'],
            ['name' => 'LG'],
            ['name' => 'Dell'],
            ['name' => 'Acer'],
            ['name' => 'HP'],
            ['name' => 'BenQ'],
            ['name' => 'Philips'],
            ['name' => 'AOC'],
            ['name' => 'Lenovo'],
            ['name' => 'Western Digital'],
            ['name' => 'SK Hynix'],
            ['name' => 'Seagate'],
            ['name' => 'Sabrent'],
            ['name' => 'Lexar'],
            ['name' => 'Logitech'],
            ['name' => 'Razer'],
            ['name' => 'SteelSeries'],
            ['name' => 'Glorious PC Gaming Race'],
            ['name' => 'Keychron'],
            ['name' => 'Fnatic'],
            ['name' => 'Lian Li'],
            ['name' => 'Phanteks'],
            ['name' => 'Ducky'],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }

    private function seedProducts(): void
    {
        // RAM Products
        Product::factory()->create([
            'name' => 'Corsair Vengeance LPX',
            'description' => 'High-performance DDR4 RAM',
            'category_id' => 1,
            'model' => 'CMK32GX4M2B3200C16',
            'brand_id' => 1,
            'price' => 36.99,
            'quantity' => 50,
            'featured' => true
        ])->each(function ($product) {
            RamSpec::create([
                'product_id' => $product->id,
                'speed' => 3200,
                'memory' => 16,
                'memory_type' => 'DDR4',
                'latency' => 16,
            ]);
        });

        Product::factory()->create([
            'name' => 'Crucial Ballistix',
            'description' => 'Affordable DDR4 RAM for gaming',
            'category_id' => 1,
            'model' => 'BL2K8G36C16U4B',
            'brand_id' => 3,
            'price' => 39.99,
            'quantity' => 30,
            'featured' => false
        ])->each(function ($product) {
            RamSpec::create([
                'product_id' => $product->id,
                'speed' => 3200,
                'memory' => 16,
                'memory_type' => 'DDR4',
                'latency' => 16,
            ]);
        });

        Product::factory()->create([
            'name' => 'G.Skill Ripjaws V',
            'description' => 'High-performance RAM for gaming and productivity',
            'category_id' => 1,
            'model' => 'F4-3200C16D-16GVKB',
            'brand_id' => 4,
            'price' => 49.99,
            'quantity' => 20,
            'featured' => false
        ])->each(function ($product) {
            RamSpec::create([
                'product_id' => $product->id,
                'speed' => 3200,
                'memory' => 16,
                'memory_type' => 'DDR4',
                'latency' => 16,
            ]);
        });

        // GPU Products
        Product::factory()->create([
            'name' => 'NVIDIA GeForce RTX 3090',
            'description' => 'Top-tier gaming GPU with 24GB VRAM',
            'category_id' => 2,
            'model' => 'RTX3090',
            'brand_id' => 10,
            'price' => 1499.99,
            'quantity' => 5,
            'featured' => true
        ])->each(function ($product) {
            GpuSpec::create([
                'product_id' => $product->id,
                'memory' => 24,
                'memory_type' => 'GDDR6',
                'core_clock' => 1400,
                'boost_clock' => 1900,
                'consumption' => 350,
                'length' => 300,
            ]);
        });

        Product::factory()->create([
            'name' => 'AMD Radeon RX 6900 XT',
            'description' => 'High-end gaming GPU with 16GB VRAM',
            'category_id' => 2,
            'model' => 'RX6900XT',
            'brand_id' => 8,
            'price' => 999.99,
            'quantity' => 8,
            'featured' => true
        ])->each(function ($product) {
            GpuSpec::create([
                'product_id' => $product->id,
                'memory' => 16,
                'memory_type' => 'GDDR6',
                'core_clock' => 1500,
                'boost_clock' => 2100,
                'consumption' => 300,
                'length' => 280,
            ]);
        });

        Product::factory()->create([
            'name' => 'NVIDIA GeForce RTX 3070',
            'description' => 'Mid-range gaming GPU with 8GB VRAM',
            'category_id' => 2,
            'model' => 'RTX3070',
            'brand_id' => 10,
            'price' => 499.99,
            'quantity' => 12,
            'featured' => true
        ])->each(function ($product) {
            GpuSpec::create([
                'product_id' => $product->id,
                'memory' => 8,
                'memory_type' => 'GDDR6',
                'core_clock' => 1500,
                'boost_clock' => 2000,
                'consumption' => 220,
                'length' => 240,
            ]);
        });

        // CPU Products
        Product::factory()->create([
            'name' => 'Intel Core i9-11900K',
            'description' => 'High-performance 8-core processor',
            'category_id' => 3,
            'model' => 'i9-11900K',
            'brand_id' => 9,
            'price' => 599.99,
            'quantity' => 5,
            'featured' => true
        ])->each(function ($product) {
            CpuSpec::create([
                'product_id' => $product->id,
                'socket' => 'LGA1200',
                'core_count' => 8,
                'thread_count' => 16,
                'base_clock' => 3.5,
                'boost_clock' => 5.3,
                'consumption' => 125,
                'integrated_graphics' => true,
            ]);
        });

        Product::factory()->create([
            'name' => 'AMD Ryzen 3 3300X',
            'description' => 'Budget-friendly 4-core processor',
            'category_id' => 3,
            'model' => 'Ryzen 3 3300X',
            'brand_id' => 8,
            'price' => 119.99,
            'quantity' => 10,
            'featured' => false
        ])->each(function ($product) {
            CpuSpec::create([
                'product_id' => $product->id,
                'socket' => 'AM4',
                'core_count' => 4,
                'thread_count' => 8,
                'base_clock' => 3.8,
                'boost_clock' => 4.3,
                'consumption' => 65,
                'integrated_graphics' => false,
            ]);
        });

        Product::factory()->create([
            'name' => 'Intel Core i3-10100',
            'description' => 'Budget-friendly 4-core processor',
            'category_id' => 3,
            'model' => 'i3-10100',
            'brand_id' => 9,
            'price' => 119.99,
            'quantity' => 10,
            'featured' => false
        ])->each(function ($product) {
            CpuSpec::create([
                'product_id' => $product->id,
                'socket' => 'LGA1200',
                'core_count' => 4,
                'thread_count' => 8,
                'base_clock' => 3.6,
                'boost_clock' => 4.3,
                'consumption' => 65,
                'integrated_graphics' => true,
            ]);
        });

        // MOTHERBOARD Products
        Product::factory()->create([
            'name' => 'EVGA Z590 FTW WiFi',
            'description' => 'High-end motherboard for Intel processors',
            'category_id' => 4,
            'model' => 'Z590 FTW',
            'brand_id' => 20,
            'price' => 299.99,
            'quantity' => 10,
            'featured' => true
        ])->each(function ($product) {
            MotherboardSpec::create([
                'product_id' => $product->id,
                'socket' => 'LGA1200',
                'chipset' => 'Z490',
                'form_factor' => 'ATX',
                'memory_max' => 128,
                'memory_slots' => 4,
                'memory_type' => 'DDR4',
                'memory_speed' => 3200,
                'sata_ports' => 6,
                'm_2_slots' => 2,
                'pcie_slots' => 3,
                'usb_ports' => 10,
                'lan' => '2.5GbE',
                'audio' => 'Realtek ALC1220',
                'wifi' => true,
                'bluetooth' => true,
            ]);
        });

        Product::factory()->create([
            'name' => 'ASUS TUF Gaming X570-Plus',
            'description' => 'Durable motherboard with military-grade components',
            'category_id' => 4,
            'model' => 'TUF GAMING X570-PLUS',
            'brand_id' => 12,
            'price' => 189.99,
            'quantity' => 20,
            'featured' => true
        ])->each(function ($product) {
            MotherboardSpec::create([
                'product_id' => $product->id,
                'socket' => 'AM4',
                'chipset' => 'X570',
                'form_factor' => 'ATX',
                'memory_max' => 128,
                'memory_slots' => 4,
                'memory_type' => 'DDR4',
                'memory_speed' => 4400,
                'sata_ports' => 8,
                'm_2_slots' => 2,
                'pcie_slots' => 3,
                'usb_ports' => 10,
                'lan' => '1GbE',
                'audio' => 'Realtek ALC1200',
                'wifi' => false,
                'bluetooth' => false,
            ]);
        });

        Product::factory()->create([
            'name' => 'MSI MAG B550 TOMAHAWK',
            'description' => 'Reliable motherboard with advanced thermal solutions',
            'category_id' => 4,
            'model' => 'MAG B550 TOMAHAWK',
            'brand_id' => 11,
            'price' => 159.99,
            'quantity' => 25,
            'featured' => true
        ])->each(function ($product) {
            MotherboardSpec::create([
                'product_id' => $product->id,
                'socket' => 'AM4',
                'chipset' => 'B550',
                'form_factor' => 'ATX',
                'memory_max' => 128,
                'memory_slots' => 4,
                'memory_type' => 'DDR4',
                'memory_speed' => 4400,
                'sata_ports' => 6,
                'm_2_slots' => 2,
                'pcie_slots' => 3,
                'usb_ports' => 8,
                'lan' => '2.5GbE',
                'audio' => 'Realtek ALC1200',
                'wifi' => false,
                'bluetooth' => false,
            ]);
        });

        // STORAGE Products
        Product::factory()->create([
            'name' => 'Samsung T7 Portable SSD',
            'description' => 'Portable SSD with USB 3.2 Gen 2 interface',
            'category_id' => 5,
            'model' => 'MU-PC1T0T/AM',
            'brand_id' => 31,
            'price' => 109.99,
            'quantity' => 50,
            'featured' => true
        ])->each(function ($product) {
            StorageSpec::create([
                'product_id' => $product->id,
                'type' => 'SSD',
                'capacity' => 1000,
                'rpm' => 0,
                'read_speed' => 1050,
                'write_speed' => 1000,
            ]);
        });

        Product::factory()->create([
            'name' => 'SanDisk Extreme Portable SSD',
            'description' => 'Durable and fast portable SSD',
            'category_id' => 5,
            'model' => 'SDSSDE61-1T00-G25',
            'brand_id' => 51,
            'price' => 129.99,
            'quantity' => 40,
            'featured' => true
        ])->each(function ($product) {
            StorageSpec::create([
                'product_id' => $product->id,
                'type' => 'SSD',
                'capacity' => 1000,
                'rpm' => 0,
                'read_speed' => 1050,
                'write_speed' => 1000,
            ]);
        });

        Product::factory()->create([
            'name' => 'WD Black SN850X',
            'description' => 'High-performance NVMe SSD for gaming',
            'category_id' => 5,
            'model' => 'WDS100T2X0E',
            'brand_id' => 40,
            'price' => 159.99,
            'quantity' => 30,
            'featured' => true
        ])->each(function ($product) {
            StorageSpec::create([
                'product_id' => $product->id,
                'type' => 'NVMe',
                'capacity' => 1000,
                'rpm' => 0,
                'read_speed' => 7300,
                'write_speed' => 6300,
            ]);
        });

        // PSU Products
        Product::factory()->create([
            'name' => 'Corsair HX1200',
            'description' => '1200W PSU with 80+ Platinum efficiency and modular cables',
            'category_id' => 6,
            'model' => 'HX1200',
            'brand_id' => 1,
            'price' => 249.99,
            'quantity' => 10,
            'featured' => true
        ])->each(function ($product) {
            PsuSpec::create([
                'product_id' => $product->id,
                'efficiency_rating' => '80+ Platinum',
                'wattage' => 1200,
                'modular' => true,
                'fanless' => false
            ]);
        });

        Product::factory()->create([
            'name' => 'EVGA 1000 GQ',
            'description' => '1000W PSU with 80+ Gold efficiency and semi-modular design',
            'category_id' => 6,
            'model' => '1000 GQ',
            'brand_id' => 20,
            'price' => 169.99,
            'quantity' => 15,
            'featured' => true
        ])->each(function ($product) {
            PsuSpec::create([
                'product_id' => $product->id,
                'efficiency_rating' => '80+ Gold',
                'wattage' => 1000,
                'modular' => false,
                'fanless' => false
            ]);
        });

        Product::factory()->create([
            'name' => 'Seasonic PRIME TX-750',
            'description' => '750W PSU with 80+ Titanium efficiency and silent operation',
            'category_id' => 6,
            'model' => 'PRIME TX-750',
            'brand_id' => 19,
            'price' => 229.99,
            'quantity' => 20,
            'featured' => true
        ])->each(function ($product) {
            PsuSpec::create([
                'product_id' => $product->id,
                'efficiency_rating' => '80+ Titanium',
                'wattage' => 750,
                'modular' => true,
                'fanless' => true
            ]);
        });

        // CASE Products
        Product::factory()->create([
            'name' => 'Lian Li PC-O11 Dynamic',
            'description' => 'Stylish and spacious mid-tower case with tempered glass',
            'category_id' => 7,
            'model' => 'PC-O11DX',
            'brand_id' => 51,
            'price' => 129.99,
            'quantity' => 15,
            'featured' => true
        ])->each(function ($product) {
            CaseSpec::create([
                'product_id' => $product->id,
                'case_type' => 'Mid Tower',
                'form_factor_support' => 'ATX',
                'tempered_glass' => true,
                'expansion_slots' => 8,
                'max_gpu_length' => 420,
                'max_cpu_cooler_height' => 165,
                'radiator_support' => true,
                'extra_fans_connectors' => 6,
                'depth' => 300,
                'width' => 450,
                'height' => 446,
                'weight' => 10.5,
            ]);
        });

        Product::factory()->create([
            'name' => 'Thermaltake Core P3',
            'description' => 'Open-frame mid-tower case with panoramic viewing',
            'category_id' => 7,
            'model' => 'CA-1G4-00M1WN-00',
            'brand_id' => 24,
            'price' => 149.99,
            'quantity' => 10,
            'featured' => true
        ])->each(function ($product) {
            CaseSpec::create([
                'product_id' => $product->id,
                'case_type' => 'Mid Tower',
                'form_factor_support' => 'ATX',
                'tempered_glass' => true,
                'expansion_slots' => 8,
                'max_gpu_length' => 400,
                'max_cpu_cooler_height' => 180,
                'radiator_support' => true,
                'extra_fans_connectors' => 5,
                'depth' => 300,
                'width' => 333,
                'height' => 512,
                'weight' => 12.3,
            ]);
        });

        Product::factory()->create([
            'name' => 'Phanteks Enthoo Evolv X',
            'description' => 'Premium mid-tower case with dual system support',
            'category_id' => 7,
            'model' => 'PH-ES518XTG_DAG01',
            'brand_id' => 52,
            'price' => 199.99,
            'quantity' => 8,
            'featured' => true
        ])->each(function ($product) {
            CaseSpec::create([
                'product_id' => $product->id,
                'case_type' => 'Mid Tower',
                'form_factor_support' => 'E-ATX',
                'tempered_glass' => true,
                'expansion_slots' => 7,
                'max_gpu_length' => 420,
                'max_cpu_cooler_height' => 180,
                'radiator_support' => true,
                'extra_fans_connectors' => 6,
                'depth' => 300,
                'width' => 520,
                'height' => 520,
                'weight' => 15.0,
            ]);
        });

        // Cooler Products
        Product::factory()->create([
            'name' => 'Noctua NH-U12S Redux',
            'description' => 'Compact and efficient air cooler for small builds',
            'category_id' => 8,
            'model' => 'NH-U12S Redux',
            'brand_id' => 29,
            'price' => 49.99,
            'quantity' => 20,
            'featured' => true
        ])->each(function ($product) {
            CoolerSpec::create([
                'product_id' => $product->id,
                'type' => 'Air',
                'fan_rpm' => 1500,
                'consumption' => 10,
                'socket_support' => 'LGA1200',
                'width' => 125,
                'height' => 158,
            ]);
        });

        Product::factory()->create([
            'name' => 'Corsair H150i Elite Capellix',
            'description' => '360mm liquid cooler with RGB lighting and high performance',
            'category_id' => 8,
            'model' => 'CW-9060048-WW',
            'brand_id' => 1,
            'price' => 179.99,
            'quantity' => 15,
            'featured' => true
        ])->each(function ($product) {
            CoolerSpec::create([
                'product_id' => $product->id,
                'type' => 'Liquid',
                'fan_rpm' => 2000,
                'consumption' => 25,
                'socket_support' => 'AM4',
                'width' => 120,
                'height' => 157,
            ]);
        });

        Product::factory()->create([
            'name' => 'be quiet! Pure Rock 2',
            'description' => 'Affordable and quiet air cooler for budget builds',
            'category_id' => 8,
            'model' => 'BK006',
            'brand_id' => 21,
            'price' => 39.99,
            'quantity' => 30,
            'featured' => false
        ])->each(function ($product) {
            CoolerSpec::create([
                'product_id' => $product->id,
                'type' => 'Air',
                'fan_rpm' => 1200,
                'consumption' => 8,
                'socket_support' => 'LGA1700',
                'width' => 121,
                'height' => 155,
            ]);
        });

        // Display Products
        Product::factory()->create([
            'name' => 'Acer Predator X27',
            'description' => '27-inch 4K UHD gaming monitor with 144Hz refresh rate',
            'category_id' => 9,
            'model' => 'X27',
            'brand_id' => 34,
            'price' => 1799.99,
            'quantity' => 5,
            'featured' => true
        ])->each(function ($product) {
            DisplaySpec::create([
                'product_id' => $product->id,
                'resolution' => '3840x2160',
                'refresh_rate' => 144,
                'response_time' => 4,
                'panel_type' => 'IPS',
                'aspect_ratio' => '16:9',
                'curved' => false,
                'brightness' => 1000,
                'contrast_ratio' => '1000:1',
                'sync_type' => 'G-Sync',
                'hdmi_ports' => 2,
                'display_ports' => 1,
                'inches' => 27,
                'weight' => 9.5,
            ]);
        });

        Product::factory()->create([
            'name' => 'LG UltraGear 38GN950-B',
            'description' => '38-inch UltraWide QHD+ gaming monitor with Nano IPS panel',
            'category_id' => 9,
            'model' => '38GN950-B',
            'brand_id' => 32,
            'price' => 1599.99,
            'quantity' => 8,
            'featured' => true
        ])->each(function ($product) {
            DisplaySpec::create([
                'product_id' => $product->id,
                'resolution' => '3840x2160',
                'refresh_rate' => 144,
                'response_time' => 1,
                'panel_type' => 'IPS',
                'aspect_ratio' => '21:9',
                'curved' => true,
                'brightness' => 450,
                'contrast_ratio' => '1000:1',
                'sync_type' => 'FreeSync',
                'hdmi_ports' => 2,
                'display_ports' => 2,
                'inches' => 38,
                'weight' => 10.2,
            ]);
        });

        Product::factory()->create([
            'name' => 'Samsung Smart Monitor M7',
            'description' => '32-inch 4K UHD monitor with smart features',
            'category_id' => 9,
            'model' => 'LS32AM702UNXZA',
            'brand_id' => 31,
            'price' => 399.99,
            'quantity' => 20,
            'featured' => false
        ])->each(function ($product) {
            DisplaySpec::create([
                'product_id' => $product->id,
                'resolution' => '3840x2160',
                'refresh_rate' => 60,
                'response_time' => 8,
                'panel_type' => 'VA',
                'aspect_ratio' => '16:9',
                'curved' => false,
                'brightness' => 300,
                'contrast_ratio' => '3000:1',
                'sync_type' => 'V-Sync',
                'hdmi_ports' => 2,
                'display_ports' => 1,
                'inches' => 32,
                'weight' => 6.8,
            ]);
        });

        // Keyboard Products
        Product::factory()->create([
            'name' => 'Ducky One 2 Mini',
            'description' => 'Compact 60% mechanical keyboard with RGB lighting',
            'category_id' => 10,
            'model' => 'DKON2061ST',
            'brand_id' => 53,
            'price' => 99.99,
            'quantity' => 20,
            'featured' => true
        ])->each(function ($product) {
            KeyboardSpec::create([
                'product_id' => $product->id,
                'type' => 'Mechanical',
                'switch_type' => 'Cherry MX Red',
                'width' => 300,
                'height' => 40,
                'weight' => 800,
            ]);
        });

        Product::factory()->create([
            'name' => 'Keychron K6',
            'description' => 'Wireless mechanical keyboard with hot-swappable switches',
            'category_id' => 10,
            'model' => 'K6',
            'brand_id' => 49,
            'price' => 89.99,
            'quantity' => 25,
            'featured' => true
        ])->each(function ($product) {
            KeyboardSpec::create([
                'product_id' => $product->id,
                'type' => 'Mechanical',
                'switch_type' => 'Gateron Red',
                'width' => 320,
                'height' => 45,
                'weight' => 1000,
            ]);
        });

        Product::factory()->create([
            'name' => 'Razer BlackWidow V3',
            'description' => 'Full-sized mechanical keyboard with Razer Green switches',
            'category_id' => 10,
            'model' => 'RZ03-03540100-R3U1',
            'brand_id' => 46,
            'price' => 139.99,
            'quantity' => 15,
            'featured' => true
        ])->each(function ($product) {
            KeyboardSpec::create([
                'product_id' => $product->id,
                'type' => 'Mechanical',
                'switch_type' => 'Razer Green',
                'width' => 440,
                'height' => 50,
                'weight' => 1200,
            ]);
        });

        // Mouse Products
        Product::factory()->create([
            'name' => 'Logitech G502 HERO',
            'description' => 'High-performance gaming mouse with HERO sensor',
            'category_id' => 11,
            'model' => '910-005469',
            'brand_id' => 45,
            'price' => 49.99,
            'quantity' => 30,
            'featured' => true
        ])->each(function ($product) {
            MouseSpec::create([
                'product_id' => $product->id,
                'dpi' => 16000,
                'sensor' => 'Optical',
                'buttons' => 11,
                'bluetooth' => true,
                'weight' => 121,
            ]);
        });

        Product::factory()->create([
            'name' => 'Razer DeathAdder V2',
            'description' => 'Ergonomic gaming mouse with Focus+ Optical Sensor',
            'category_id' => 11,
            'model' => 'RZ01-03210100-R3U1',
            'brand_id' => 46,
            'price' => 69.99,
            'quantity' => 25,
            'featured' => true
        ])->each(function ($product) {
            MouseSpec::create([
                'product_id' => $product->id,
                'dpi' => 20000,
                'sensor' => 'Optical',
                'buttons' => 8,
                'bluetooth' => false,
                'weight' => 82,
            ]);
        });

        Product::factory()->create([
            'name' => 'SteelSeries Rival 600',
            'description' => 'Dual sensor system for precise gaming performance',
            'category_id' => 11,
            'model' => '62446',
            'brand_id' => 47,
            'price' => 79.99,
            'quantity' => 20,
            'featured' => true
        ])->each(function ($product) {
            MouseSpec::create([
                'product_id' => $product->id,
                'dpi' => 12000,
                'sensor' => 'Optical',
                'buttons' => 7,
                'bluetooth' => true,
                'weight' => 96,
            ]);
        });
    }
}