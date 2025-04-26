<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Valoration;
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
        // Users
        $this->seedUsers();
        
        // Categories
        $this->seedCategories();

        // Brands
        $this->seedBrands();

        // Products
        $this->seedProducts();

        // Valorations
        $this->seedValorations();
    }

    /**
     * Seed the users table.
     *
     * @return void
     */
    private function seedUsers(): void
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

    }

    /**
     * Seed the categories table.
     *
     * @return void
     */
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

    /**
     * Seed the brands table.
     *
     * @return void
     */
    private function seedBrands(): void
    {
        $brands = [
            ['name' => 'No Brand'],
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
            ['name' => 'Ducky']
        ];

        foreach ($brands as $brand) {
            if ($brand['name'] == 'No Brand') {
                Brand::create([
                    'name' => $brand['name'],
                    'description' => 'Default brand for products without a specific brand or that have lost their brand through a brand deletion.',
                    'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1744482271/brand-placeholder_loirll.png'

                ]);
            } else {
                Brand::create([
                    'name' => $brand['name'],
                    'description' => $brand['name'] . ' is a well-known brand in the PC hardware industry.',
                    'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1744482271/brand-placeholder_loirll.png'

                ]);
            }
        }
    }

    /**
     * Seed the products table.
     *
     * @return void
     */
    private function seedProducts(): void
    {
        // RAM Products
        Product::factory()->create([
            'name' => 'Corsair Vengeance LPX',
            'description' => 'High-performance DDR4 RAM',
            'category_id' => 1,
            'model' => 'CMK32GX4M2B3200C16',
            'brand_id' => 2,
            'price' => 36.99,
            'quantity' => 50,
            'featured' => true,
            'on_offer' => true,
            'discount' => 15.55,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745003254/3e02faa8-4ac3-4938-868f-4694b0166d2f.png'
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
            'brand_id' => 4,
            'price' => 39.99,
            'quantity' => 30,
            'featured' => false,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745003328/514d6d97-5ade-42b3-ab42-4d71e19ea6d8.png'
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
            'brand_id' => 5,
            'price' => 49.99,
            'quantity' => 20,
            'featured' => false,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745003409/88f42563-3619-4125-8a02-b19a8b685105.png'
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
            'brand_id' => 11,
            'price' => 1499.99,
            'quantity' => 5,
            'featured' => true,
            'on_offer' => true,
            'discount' => 23.85,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745003583/f3d1ff2b-b83e-409e-a7dc-dbeeb7d6026e.png'
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
            'brand_id' => 9,
            'price' => 999.99,
            'quantity' => 8,
            'featured' => true,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745003647/270275a5-c5c5-41f9-a8ca-d28af251e389.png'
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
            'brand_id' => 11,
            'price' => 499.99,
            'quantity' => 12,
            'featured' => true,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745003712/4819614c-c65b-4007-884b-086e79e00750.png'
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
            'brand_id' => 10,
            'price' => 599.99,
            'quantity' => 5,
            'featured' => true,
            'on_offer' => true,
            'discount' => 5.75,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745057264/e3707f05-7261-4953-8833-bdae17d17ca5.png'
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
            'brand_id' => 9,
            'price' => 119.99,
            'quantity' => 10,
            'featured' => false,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745057308/c5aed0ef-603e-4957-97ac-d46eed2c11ec.png'
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
            'brand_id' => 10,
            'price' => 119.99,
            'quantity' => 10,
            'featured' => false,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745057348/2425505f-1fe4-4259-a002-f67bf8084e6b.png'
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
            'brand_id' => 21,
            'price' => 299.99,
            'quantity' => 10,
            'featured' => true,
            'on_offer' => true,
            'discount' => 12.35,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745057495/68da59a8-b6c0-4e01-b8b1-f4c69f5294a9.png'
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
            'brand_id' => 13,
            'price' => 189.99,
            'quantity' => 20,
            'featured' => true,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745057564/dae9cd3e-3462-43ef-bfa9-0d77431d4441.png'
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
            'brand_id' => 12,
            'price' => 159.99,
            'quantity' => 25,
            'featured' => true,
            'on_offer' => true,
            'discount' => 3.35,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745057600/c4b0fb26-6197-45ca-92a9-14e95b4da945.png'
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
            'brand_id' => 32,
            'price' => 109.99,
            'quantity' => 50,
            'featured' => true,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745057639/c7e9552b-9902-4053-9afb-4e7a176fe714.png'
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
            'brand_id' => 52,
            'price' => 129.99,
            'quantity' => 40,
            'featured' => true,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745057725/3cf4904c-5051-45f7-bb7d-ea10fa855ed9.png'
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
            'brand_id' => 41,
            'price' => 159.99,
            'quantity' => 30,
            'featured' => true,
            'on_offer' => true,
            'discount' => 17.85,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745057763/3bfa96cd-b513-4e73-99fb-c1b9cae3727d.png'
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
            'brand_id' => 2,
            'price' => 249.99,
            'quantity' => 10,
            'featured' => true,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745057799/8a5a22a2-9d90-46a9-b788-aa3f7d0065c7.png'
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
            'brand_id' => 21,
            'price' => 169.99,
            'quantity' => 15,
            'featured' => true,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745057843/da2a4059-3915-4c0a-b431-cc238d7d4ab7.png'
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
            'brand_id' => 20,
            'price' => 229.99,
            'quantity' => 20,
            'featured' => true,
            'on_offer' => true,
            'discount' => 22.45,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745057884/5d4122a1-1ac7-4b3b-abfe-3b4d3b6a1f7c.png'
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
            'brand_id' => 52,
            'price' => 129.99,
            'quantity' => 15,
            'featured' => true,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745057925/911c3d82-8207-4b1f-95c4-66ea1046a5da.png'
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
            'brand_id' => 25,
            'price' => 149.99,
            'quantity' => 10,
            'featured' => true,
            'on_offer' => true,
            'discount' => 15.67,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745057957/0cb0e032-fc27-4cd3-b217-28dadc99c005.png'
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
            'brand_id' => 53,
            'price' => 199.99,
            'quantity' => 8,
            'featured' => true,
            'on_offer' => true,
            'discount' => 7.85,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745057985/2627f7d8-04c6-47b6-a000-42b3d3cfb02e.png'
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
            'brand_id' => 30,
            'price' => 49.99,
            'quantity' => 20,
            'featured' => true,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745058027/1b53f30f-b2f5-445f-9017-7dad2558a16d.png'
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
            'brand_id' => 2,
            'price' => 179.99,
            'quantity' => 15,
            'featured' => true,
            'on_offer' => true,
            'discount' => 12.65,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745058062/e4806cdc-342a-4800-9796-d22f43c0c5b5.png'
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
            'brand_id' => 22,
            'price' => 39.99,
            'quantity' => 30,
            'featured' => false,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745058102/bf38c05e-858e-4d94-9c05-07a1aa56ad3e.png'
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
            'brand_id' => 35,
            'price' => 1799.99,
            'quantity' => 5,
            'featured' => true,
            'on_offer' => true,
            'discount' => 8.45,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745058134/b4b56876-8d23-46fe-8240-0bcffd848947.png'
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
            'brand_id' => 33,
            'price' => 1599.99,
            'quantity' => 8,
            'featured' => true,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745058183/f138cf0c-f9e5-45e8-a3cc-cf73f5115bb2.png'
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
            'brand_id' => 32,
            'price' => 399.99,
            'quantity' => 20,
            'featured' => false,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745058219/fb87497e-e6e2-4db3-8312-ca4bd0ee0e1a.png'
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
            'brand_id' => 54,
            'price' => 99.99,
            'quantity' => 20,
            'featured' => true,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745058333/cc579de7-c9d2-47d0-9549-2b873aed807a.png'
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
            'brand_id' => 50,
            'price' => 89.99,
            'quantity' => 25,
            'featured' => true,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745058406/28dde884-f750-4d7f-b991-be086f97a5bc.png'
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
            'brand_id' => 47,
            'price' => 139.99,
            'quantity' => 15,
            'featured' => true,
            'on_offer' => true,
            'discount' => 5.25,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745058478/b752c296-513a-4332-98b7-9839d931afa0.png'
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
            'brand_id' => 46,
            'price' => 49.99,
            'quantity' => 30,
            'featured' => true,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745058534/1c603ecd-3912-46f9-9d74-f475a58798b7.png'
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
            'brand_id' => 47,
            'price' => 69.99,
            'quantity' => 25,
            'featured' => true,
            'on_offer' => true,
            'discount' => 8.75,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745058616/7842e714-3dcf-4ba4-884e-36887e444153.png'
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
            'brand_id' => 48,
            'price' => 79.99,
            'quantity' => 20,
            'featured' => true,
            'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1745058759/62d2fa64-3567-4b5e-ac7f-f392842c7710.png'
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

    /**
     * Seed the valorations table.
     *
     * @return void
     */
    private function seedValorations(): void
    {
        // Get all products and users
        $products = Product::all();
        $users = User::all();

        for ($i = 0; $i < 60; $i++) {
            Valoration::factory()->create([
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
                'rating' => rand(1, 5),
                'comment' => fake()->optional()->sentence(20),
                'image' => 'https://res.cloudinary.com/dlmbw4who/image/upload/v1743097241/product-placeholder_jcgqx4.png',
            ]);
        }
    }
}