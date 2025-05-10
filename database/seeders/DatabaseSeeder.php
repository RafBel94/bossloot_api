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
            'description' => 'Memoria RAM DDR4 de alto rendimiento diseñada para overclocking. Con un perfil de altura baja que permite su instalación incluso con disipadores de CPU de gran tamaño. Sus 16GB (2x8GB) a 3200MHz ofrecen velocidad y estabilidad excepcionales para gaming y multitarea. El disipador de aluminio garantiza una refrigeración óptima incluso en condiciones de uso intensivo, mientras que su latencia CL16 asegura tiempos de respuesta mínimos. Compatible con placas base Intel y AMD de última generación.',
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
            'description' => 'Memoria RAM DDR4 ideal para gamers con presupuesto ajustado sin comprometer el rendimiento. Este kit de 16GB (2x8GB) a 3200MHz con latencia CL16 ofrece velocidad y estabilidad excepcionales para juegos modernos y aplicaciones exigentes. Cuenta con perfiles XMP 2.0 para un overclocking sencillo con un solo clic, y su diseño térmico mejorado con disipador de calor de aluminio garantiza temperaturas óptimas durante sesiones intensivas. Fabricada con componentes de alta calidad seleccionados y probados exhaustivamente para máxima fiabilidad.',
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
            'description' => 'RAM de alto rendimiento con un equilibrio perfecto entre velocidad y fiabilidad. Este kit de 16GB (2x8GB) a 3200MHz con latencia CL16 está optimizado para plataformas Intel y AMD. Su diseño distintivo con disipadores de calor en forma de aleta proporciona una superficie amplia para disipación térmica eficiente. La serie Ripjaws V utiliza chips de memoria seleccionados para garantizar estabilidad en overclocking, e incorpora PCB de 10 capas para integridad de señal mejorada. Ideal para gaming de alta gama, edición de video y cargas de trabajo intensivas que requieren multitarea sin compromiso.',
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
            'description' => 'La GPU definitiva para gaming y creación de contenido profesional. Con 24GB de memoria GDDR6X ultrarrápida y 10.496 núcleos CUDA, la RTX 3090 ofrece un rendimiento sin precedentes en juegos 4K y 8K. Su arquitectura Ampere de segunda generación incorpora núcleos RT mejorados para ray tracing en tiempo real y núcleos Tensor para DLSS e IA. Con 328 TMUs, 112 ROPs y un ancho de banda de memoria de 936GB/s, domina cualquier tarea gráfica exigente. Incluye tres DisplayPort 1.4a y un puerto HDMI 2.1 para configuraciones multi-monitor. Su sistema de refrigeración de triple ventilador mantiene temperaturas óptimas incluso bajo cargas extremas.',
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
            'description' => 'GPU de alta gama basada en la arquitectura RDNA 2 de AMD, diseñada para gaming 4K de máximo nivel. Con 16GB de memoria GDDR6, 5.120 procesadores de flujo y tecnología AMD Infinity Cache de 128MB, ofrece rendimiento excepcional con menor latencia y mayor eficiencia energética. Soporta Ray Tracing en tiempo real y AMD FidelityFX Super Resolution para mejorar FPS sin sacrificar calidad visual. Su frecuencia base de 1.500MHz con boost hasta 2.100MHz garantiza fluidez en los títulos más exigentes. Incorpora salidas HDMI 2.1 y DisplayPort 1.4, además de tecnología AMD Smart Access Memory para aprovechar al máximo los procesadores Ryzen 5000.',
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
            'description' => 'GPU de gama media-alta con excelente relación rendimiento-precio para gaming en 1440p y 4K. Basada en la arquitectura Ampere, ofrece 8GB de memoria GDDR6 y 5.888 núcleos CUDA para un rendimiento excepcional. Incluye núcleos RT dedicados de segunda generación para ray tracing y núcleos Tensor para DLSS, mejorando drásticamente el rendimiento con IA. Su TDP de 220W la hace energéticamente eficiente para su clase. Con una frecuencia boost de 2.000MHz, maneja fácilmente juegos AAA modernos a altos FPS. Presenta un diseño de refrigeración optimizado con ventiladores axiales y cámara de vapor para mantener temperaturas bajas incluso en sesiones prolongadas. Perfecta para streamers y creadores de contenido que buscan potencia sin llegar al segmento premium.',
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
            'description' => 'Procesador tope de gama de 11ª generación con 8 núcleos y 16 hilos, ideal para gaming extremo y tareas profesionales. Fabricado con tecnología de 14nm+++ SuperFin, ofrece frecuencias base de 3.5GHz y boost de hasta 5.3GHz con Intel Thermal Velocity Boost. Incluye 16MB de caché Intel Smart Cache y soporte para memoria DDR4-3200. Su gráfica integrada Intel UHD Graphics 750 basada en Xe permite uso sin GPU dedicada para tareas básicas. Compatible con socket LGA1200 y tecnologías como PCIe 4.0, Thunderbolt 4 y WiFi 6E. Incorpora Intel Deep Learning Boost para aceleración de IA y AVX-512 para cálculos vectoriales. Ideal para estaciones de trabajo de alto rendimiento, streaming profesional y entornos multicore.',
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
            'description' => 'Procesador de cuatro núcleos y ocho hilos que redefine el segmento de entrada con rendimiento sorprendente a precio asequible. Fabricado con tecnología de 7nm y arquitectura Zen 2, ofrece 18MB de caché total (L2+L3) para reducir latencias en gaming. Con frecuencia base de 3.8GHz y boost de 4.3GHz, supera a competidores de mayor precio en aplicaciones y juegos. Utiliza socket AM4 para amplia compatibilidad con placas base, y su TDP de solo 65W lo hace energéticamente eficiente. Aunque no incluye gráficos integrados, su excepcional rendimiento por núcleo lo convierte en opción ideal para gaming con GPU dedicada en configuraciones económicas. Incluye refrigerador Wraith Stealth para funcionamiento silencioso sin costes adicionales.',
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
            'description' => 'Procesador quad-core de décima generación con excelente rendimiento para tareas cotidianas y gaming casual. Con 4 núcleos y 8 hilos a 3.6GHz de frecuencia base y hasta 4.3GHz en modo turbo, proporciona potencia suficiente para multitarea fluida. Incluye 6MB de caché Intel Smart Cache y gráficos Intel UHD 630 integrados, permitiendo uso sin tarjeta gráfica dedicada para tareas multimedia básicas. Compatible con socket LGA1200 y tecnologías como Hyper-Threading para mejor rendimiento en aplicaciones multihilo. Su TDP de 65W asegura bajo consumo energético y facilita refrigeración con soluciones económicas. Incluye disipador de stock Intel para instalación inmediata. Ideal para equipos de oficina, HTPC y configuraciones gaming de presupuesto moderado.',
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
            'description' => 'Placa base de gama alta para entusiastas con socket LGA1200 para procesadores Intel de 10ª y 11ª generación. Su chipset Z490 ofrece overclocking completo y soporte para DDR4 a 3200MHz+ en sus 4 ranuras DIMM (hasta 128GB). Destaca por sus soluciones térmicas avanzadas con disipadores de VRM sobredimensionados y heat-pipes para estabilidad en OC extremo. Cuenta con 2 ranuras M.2 con disipación activa, 6 puertos SATA 6Gb/s, y 3 PCIe 4.0 reforzados. Su sistema de audio Realtek ALC1220 con capacitores japoneses ofrece experiencia sonora inmersiva. Incluye Wi-Fi 6 y Bluetooth 5.2 integrados, LAN 2.5GbE con Dragon RTL8125BG, e iluminación RGB sincronizable. Su BIOS UEFI con interfaz gráfica facilita ajustes avanzados incluso a novatos.',
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
            'description' => 'Placa base ATX para procesadores AMD Ryzen con socket AM4, construida con componentes de grado militar certificados TUF Alliance para máxima durabilidad y fiabilidad. Su chipset X570 soporta PCIe 4.0 para máximo ancho de banda en tarjetas gráficas y almacenamiento NVMe. Incorpora sistema de refrigeración activa con disipadores extendidos para VRM y chipset, garantizando estabilidad térmica incluso con procesadores de alta gama como Ryzen 9. Sus 4 ranuras DIMM admiten hasta 128GB de RAM DDR4 a 4400MHz con perfiles XMP y DOCP. Destaca su sistema de alimentación DrMOS y condensadores de grado militar, soportando overclocking intensivo con estabilidad superior. Incluye diagnóstico Q-LED, protección contra sobretensiones y diseño TUF Gaming con estética militar. Ideal para usuarios que priorizan fiabilidad y robustez sobre características premium.',
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
            'description' => 'Placa base ATX para procesadores AMD Ryzen con socket AM4, destacando por su excelente equilibrio entre características, calidad y precio. El chipset B550 ofrece soporte PCIe 4.0 para GPU y un SSD NVMe, manteniendo rutas PCIe 3.0 para dispositivos adicionales. Su sistema de alimentación de 10 fases con Core Boost asegura estabilidad para Ryzen de alta gama y overclock moderado. Cuenta con solución térmica avanzada Extended Heatsink Design con heat-pipes extendidos y almohadillas térmicas premium. Sus 4 ranuras DIMM soportan hasta 128GB de RAM DDR4 a 4400MHz+ mediante A-XMP. Destaca su conectividad con LAN 2.5G y Realtek Gigabit, USB 3.2 Gen2, y doble M.2 con escudo térmico para el principal. Su sistema de audio Audio Boost 4 con Nahimic ofrece calidad superior, mientras que su estética militar industrial con iluminación RGB la hace ideal para configuraciones gaming de gama media.',
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
            'description' => 'SSD externo ultraportátil de 1TB que combina rendimiento excepcional con diseño minimalista y ligero (sólo 58 gramos). Utiliza interfaz USB 3.2 Gen 2 para velocidades de transferencia de hasta 1.050MB/s en lectura y 1.000MB/s en escritura, hasta 9.5 veces más rápido que discos externos tradicionales. Su carcasa metálica de aluminio con sistema de disipación pasiva mantiene temperaturas óptimas incluso en uso intensivo, mientras que su resistencia a caídas de hasta 2 metros protege tus datos. Incluye encriptación por hardware AES de 256 bits con autenticación por contraseña o huella digital (en modelos Touch). Compatible con Windows, Mac, Android y dispositivos con USB-C como iPad Pro, viene con cables USB-C a USB-C y USB-C a USB-A para máxima compatibilidad. Ideal para creadores de contenido, fotógrafos y profesionales que necesitan almacenamiento rápido, seguro y portátil.',
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
            'description' => 'SSD portátil ultraresistente de 1TB diseñado para condiciones extremas, con certificación IP55 contra agua y polvo. Su diseño robusto con carcasa de silicona reforzada soporta caídas de hasta 2 metros y protege tus datos en cualquier entorno. Ofrece velocidades de transferencia de hasta 1.050MB/s en lectura y 1.000MB/s en escritura mediante USB 3.2 Gen 2, ideal para trabajo con archivos RAW, edición 4K y transferencia de bibliotecas multimedia. Incluye sistema de seguridad con encriptación AES de 256 bits mediante contraseña y software SanDisk SecureAccess. Su diseño compacto con gancho integrado facilita su transporte en mochilas o como llavero. Compatible con PC, Mac, Android y dispositivos con USB-C, incluye adaptadores para máxima versatilidad. Perfecto para fotógrafos de naturaleza, viajeros, deportistas extremos y profesionales que necesitan almacenamiento fiable en entornos desafiantes.',
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
            'description' => 'SSD NVMe PCIe 4.0 de alto rendimiento optimizado específicamente para gaming extremo y cargas de trabajo profesionales intensivas. Con 1TB de capacidad y velocidades vertiginosas de hasta 7.300MB/s en lectura secuencial y 6.300MB/s en escritura, reduce drásticamente tiempos de carga en juegos AAA y aplicaciones exigentes. Su controlador WD propietario de segunda generación incluye modo Game Mode 2.0 que detecta automáticamente cargas de trabajo de juegos para optimizar rendimiento y reducir latencia. La tecnología nCache 4.0 con SLC dinámico mantiene velocidades máximas incluso cuando el disco está casi lleno. Compatible con Microsoft DirectStorage para revolucionar la carga de activos en juegos next-gen. Su diseño sin DRAM reduce costes manteniendo rendimiento superior gracias a HMB (Host Memory Buffer) y su bajo consumo energético lo hace ideal incluso para laptops gaming. Incluye software WD Dashboard para monitoreo en tiempo real y optimización avanzada.',
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
            'description' => 'Fuente de poder premium de 1200W con certificación 80 PLUS Platinum que garantiza eficiencia superior al 92% bajo cargas típicas, reduciendo consumo y generación de calor. Diseño completamente modular con cables de alta calidad con funda de nylon trenzado para mejor organización y flujo de aire. Sus capacitores japoneses de 105°C aseguran estabilidad eléctrica y longevidad excepcional incluso en sistemas de alta gama con múltiples GPUs. El sistema de raíl único/múltiple conmutable permite elegir entre distribución de potencia para overclocking extremo o mayor seguridad. Su ventilador de 140mm con rodamientos de levitación magnética opera en modo Zero RPM hasta 40% de carga para funcionamiento silencioso, mientras que su monitorización en tiempo real mediante Corsair Link permite supervisar rendimiento y eficiencia. Viene con garantía de 10 años y soporte premium, siendo ideal para entusiastas, overclockers y configuraciones de workstation profesionales.',
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
            'description' => 'Fuente de alimentación 1000W semi-modular con certificación 80 PLUS Gold que ofrece al menos 90% de eficiencia bajo cargas típicas, equilibrando perfecto rendimiento y valor. Su diseño semi-modular permite conectar sólo los cables necesarios manteniendo los esenciales (CPU, motherboard) fijos para garantizar conexión segura. Con raíl único de +12V de 83.3A soporta múltiples GPUs de gama alta y CPUs con overclock. Su ventilador de 135mm con control térmico inteligente ECO mantiene operación silenciosa a cargas bajas y medias, aumentando ventilación sólo cuando es necesario. Incorpora protecciones OVP, UVP, OCP, OPP, SCP y OTP para máxima seguridad de componentes. Su construcción con condensadores japoneses de 105°C asegura estabilidad durante 100.000 horas MTBF, mientras que sus cables con mangos aislados facilitan la instalación. Incluye garantía de 5 años y soporte EVGA, ideal para configuraciones gaming de gama alta-media con buen balance entre calidad, rendimiento y precio.',
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
            'description' => 'Fuente de alimentación de élite con 750W y certificación 80 PLUS Titanium, alcanzando eficiencias excepcionales de hasta 94.5% para minimizar consumo eléctrico y generación de calor. Su tecnología Hybrid Silent Fan Control permite operación completamente pasiva hasta 40% de carga, garantizando silencio absoluto en uso cotidiano. Utiliza topología avanzada LLC resonante con half-bridge y circuitos DC-to-DC para regulación de voltaje ultra-precisa con sólo 0.5% de variación. Sus capacitores japoneses 100% de polímero sólido eliminan riesgo de fugas y ofrecen vida útil superior a 105°C. El diseño completamente modular con cables de alta calidad planos incluye sensor de temperatura y múltiples protecciones (OPP, OVP, UVP, SCP, OCP, OTP). Su construcción interior con chasis de una pieza y PCB con recubrimiento conformal resiste humedad y polvo para máxima longevidad. Respaldada por garantía premium de 12 años, representa lo mejor en fuentes de alimentación para sistemas de alta gama que requieren estabilidad absoluta y eficiencia sin compromisos.',
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
            'description' => 'Gabinete mid-tower de diseño premium con colaboración del famoso Der8auer, que revoluciona la distribución interna para máxima refrigeración y exhibición de componentes. Su estructura dual chamber separa la PSU y cableado en un segundo compartimento para mejorar flujo de aire y estética. Construido con aluminio de grado aeroespacial y paneles de cristal templado de 4mm en lateral y frontal que ofrecen visibilidad total de componentes. Soporta hasta 9 ventiladores de 120mm (3 laterales, 3 inferiores, 3 superiores) o múltiples radiadores simultáneos de hasta 360mm. Con espacio para GPUs de hasta 420mm y refrigeradores CPU de 165mm, admite configuraciones E-ATX sin comprometer refrigeración. Su sistema de filtros antipolvo magnéticos de acceso rápido facilita mantenimiento, mientras que sus puertos USB 3.1 Type-C y USB 3.0 frontales garantizan conectividad moderna. Ideal para entusiastas que buscan exhibir configuraciones custom loop o de alto rendimiento con iluminación RGB.',
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
            'description' => 'Gabinete open-frame revolucionario que redefine el concepto de chasis para PC, ofreciendo una experiencia de exhibición tipo "wall art" con su diseño completamente abierto y modular. Su estructura tripartita permite montaje horizontal estándar, vertical tipo showcase, o directamente en pared mediante soporte VESA incluido. Fabricado con acero SPCC de alta resistencia y panel de cristal templado de 5mm, combina durabilidad y exhibición premium de componentes. Su diseño de pared única con distribución panorámica permite instalar radiadores de hasta 420mm, GPUs de hasta 400mm mediante riser incluido (montaje vertical u horizontal), y depósitos/bombas de refrigeración líquida custom en puntos de anclaje dedicados. Su sistema de bandejas desmontables facilita ensamblado externo de componentes principales antes de integrarlos al chasis. Incluye puertos USB 3.0 y gestión avanzada de cables a pesar de su naturaleza abierta. Perfecto para creadores de contenido, modders y entusiastas que desean una PC funcional y artística.',
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
            'description' => 'Chasis premium mid-tower con capacidad para configuración dual-system, fabricado en aluminio anodizado de 3mm y acero reforzado de calidad industrial. Diseño vanguardista con iluminación RGB direccionable integrada en frontal y superior, sincronizable con placas base Asus Aura, MSI Mystic Light, Gigabyte RGB Fusion y ASRock RGB. Su revolucionario sistema Digital Spectrum controla iluminación mediante botones externos sin software. Incluye gestión de cables avanzada con cubiertas deslizantes, pasacables de goma, canaletas removibles y espacio de 30mm tras motherboard. Su distribución interior flexible permite configuraciones E-ATX estándar o dual-system (ATX+ITX) mediante placa divisoria opcional. Soporta hasta 10 unidades de almacenamiento con bandejas modulares, 7 ventiladores (3x140mm frontales incluidos), radiadores hasta 420mm, y cable management optimizado para sistemas complejos. Incorpora panel I/O superior con USB 3.1 Type-C, botón reset reprogramable como control RGB, y filtros antipolvo magnéticos premium. Su sistema de puerta frontal con apertura 180° y cristales templados con mecanismo de apertura rápida facilita acceso a componentes.',
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
            'description' => 'Disipador de CPU premium en su versión Redux (optimizada en costes) que mantiene el legendario rendimiento y calidad Noctua en formato compacto de 158mm de altura. Incorpora 5 heatpipes de cobre niquelado con tecnología de contacto directo (DTH) para máxima transferencia térmica y disipador de aluminio con aletas optimizadas mediante simulación computacional. Incluye un ventilador NF-P12 Redux de 120mm que funciona a 1500 RPM con tecnología SSO2 (rodamientos autoestabilizantes de segunda generación) y perfil acústico optimizado para mantener ruido por debajo de 25dBA incluso a plena carga. Su sistema de montaje SecuFirm2 garantiza presión óptima y facilita instalación en múltiples sockets, incluyendo LGA1200. Con TDP máximo soportado de 160W, refrigera eficientemente procesadores de gama alta manteniendo pequeña superficie, ideal para placas con restricciones de espacio en zonas DIMM. Incluye pasta térmica NT-H1 de alta calidad y adaptadores para segundo ventilador (push-pull). Diseño optimizado para flujo de aire posterior desimpedido hacia ventilador de extracción del chasis.',
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
            'description' => 'Sistema de refrigeración líquida AIO tope de gama con radiador de 360mm (3x120mm) que redefine el equilibrio entre rendimiento y estética. Su bomba rediseñada incorpora 33 LEDs Capellix de ultra-alta densidad con brillo 60% superior y consumo 40% menor que LEDs convencionales, configurable mediante software iCUE. Incluye tres ventiladores ML120 RGB con tecnología de levitación magnética para eliminar fricción y ruido, operando entre 400-2000 RPM con control PWM preciso y flujo de aire hasta 75 CFM por ventilador. El bloque de refrigeración optimizado utiliza microaletas de cobre de alta densidad y bomba potenciada para TDP hasta 380W, soportando overclocking extremo en CPUs de gama alta. Su controlador Commander CORE incluido centraliza conexiones PWM y RGB de hasta 6 ventiladores con un solo cable a motherboard, simplificando la gestión en configuraciones complejas. Preinstalado con pasta térmica XTM50 de alto rendimiento y compatible con múltiples sockets mediante sistema de montaje modular con anclaje por deslizamiento. Incluye perfiles preconfigurados para equilibrio óptimo entre rendimiento acústico y térmico.',
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
            'description' => 'Disipador CPU de excelente relación calidad-precio que ofrece refrigeración silenciosa y eficiente con TDP máximo de 150W. Su diseño asimétrico evita conflictos con módulos RAM de alto perfil incluso en placas con slots DIMM cercanos al socket. Incorpora 4 heatpipes de 6mm con tecnología HDT (contacto directo) que distribuyen el calor uniformemente hacia el stack de aletas de aluminio optimizado para flujo de aire. Incluye un ventilador Pure Wings 2 de 120mm con 9 aspas y motor rifle bearing que opera a máximo 1200 RPM generando sólo 26.8 dBA, casi imperceptible en uso normal. El sistema de montaje universal con backplate metálica garantiza instalación segura y distribución homogénea de presión sobre el IHS del procesador. Su acabado negro cepillado con detalles plateados ofrece estética minimalista que combina con cualquier configuración. La pasta térmica MX-4 incluida asegura conductividad térmica óptima desde el primer uso. Ideal para sistemas silenciosos, HTPC, workstations y configuraciones gaming de gama media que requieren buena refrigeración sin sacrificar silencio o presupuesto.',
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
            'description' => 'Monitor gaming de referencia que redefine la experiencia visual de alta gama con panel IPS 4K UHD (3840x2160) de 27 pulgadas y tecnología Quantum Dot para volumen de color 99% Adobe RGB. Combina refresco de 144Hz con G-Sync Ultimate para sincronización perfecta sin tearing ni stuttering a cualquier FPS. Su certificación DisplayHDR 1000 con 384 zonas de local dimming proporciona contraste dinámico superior, negros profundos y picos de brillo hasta 1000 nits para HDR inmersivo. El tiempo de respuesta de 4ms (GtG) con tecnología VRB (Visual Response Boost) minimiza ghosting en escenas de acción rápida. Incluye filtro de luz azul Acer VisionCare, tecnología Flicker-less y recubrimiento antirreflejos para sesiones prolongadas sin fatiga visual. Sus opciones de conectividad comprenden DisplayPort 1.4, HDMI 2.0 y hub USB 3.0 de 4 puertos. La base ergonómica permite ajustes completos (altura, giro, inclinación y pivote) y el sistema Acer ErgoStand facilita organización de cables. Incorpora altavoces estéreo de 7W con tecnología MaxxAudio y sensor de luz ambiental para ajuste automático de brillo según condiciones de entorno.',
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
            'description' => 'Monitor gaming curvo ultrapanorámico de 38 pulgadas con resolución WQHD+ (3840x1600) y relación de aspecto 21:9 que ofrece experiencia inmersiva con curvatura 2300R. Su panel Nano IPS proporciona 98% de cobertura DCI-P3 y 1.07 billones de colores con precisión extrema para creación de contenido y gaming. Combina refresco de 144Hz (overclockeable a 160Hz) con tiempo de respuesta de 1ms (GtG) y certificación VESA DisplayHDR 600 para rendimiento visual sin compromiso. Compatible simultáneamente con G-Sync y FreeSync Premium Pro para eliminar tearing y microstuttering independiente de la GPU utilizada. El sistema Sphere Lighting 2.0 con iluminación RGB trasera de 12 zonas se sincroniza con audio y acción en pantalla, mientras que la tecnología DAS (Dynamic Action Sync) minimiza latencia de entrada para gaming competitivo. Sus opciones de conectividad incluyen dos HDMI 2.0, dos DisplayPort 1.4 y hub USB 3.0. Incorpora modos especializados Reader Mode, Color Weakness, Dark Room, y Black Stabilizer para optimizar visibilidad en juegos oscuros. Base ergonómica con ajustes de altura e inclinación y sistema de montaje VESA 100x100mm.',
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
            'description' => 'Monitor inteligente revolucionario de 32 pulgadas con resolución UHD 4K (3840x2160) que integra funcionalidad de Smart TV sin necesidad de PC. Su panel VA con tecnología HDR10 ofrece excelente contraste (3000:1) y ángulos de visión amplios para reproducción multimedia y productividad. Incorpora sistema operativo Tizen que permite acceso directo a aplicaciones de streaming (Netflix, Amazon Prime, YouTube, Disney+) mediante control remoto incluido y asistentes de voz (Bixby, Alexa, Google Assistant). Su conectividad sin precedentes incluye Wi-Fi 5, Bluetooth 4.2, AirPlay 2, DeX inalámbrico, Tap View, Office 365 integrado y control mediante smartphone con app SmartThings. Dispone de puertos USB-C con Power Delivery 65W (carga y transmisión de datos/video en un solo cable), HDMI 2.0, y hub USB para periféricos. Su función Adaptive Picture ajusta automáticamente brillo según condiciones ambientales mientras que Eye Saver Mode y Flicker Free reducen fatiga visual. Incluye altavoces integrados de 5W x2 con optimización de voz y soporte para conectar auriculares Bluetooth. Ideal para teletrabajo, entretenimiento y espacios multifuncionales que requieren versatilidad sin comprometer calidad visual.',
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
            'description' => 'Teclado mecánico premium en formato 60% que elimina teclado numérico y teclas de función para máxima portabilidad y espacio en escritorio. Fabricado con plástico PBT de doble inyección y alta durabilidad (superior al ABS) con acabado texturizado antihuellas que mantiene aspecto original tras uso prolongado. Incorpora switches Cherry MX Red (lineales) con actuación suave a 45g, recorrido de 4mm y punto de actuación a 2mm, ideales para gaming por su respuesta rápida sin feedback táctil ni clicky. Su iluminación RGB per-key con 16.8 millones de colores ofrece efectos personalizables mediante combinaciones de teclas sin software. Cuenta con memoria interna para almacenar hasta 6 perfiles de iluminación y macros. Incluye dip switches para reconfigurar layout y tecnología N-key rollover con anti-ghosting completo para registrar todas las pulsaciones simultáneas. Su sistema de doble PCB con capa intermedia aislante proporciona estabilidad superior y reduce ruido de estabilizadores, mientras que su cable USB-C desmontable facilita transporte y personalización. Incluye keycaps adicionales de colores y extractor. Considerado referente en la comunidad de entusiastas por su calidad de construcción y durabilidad excepcional.',
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
            'description' => 'Teclado mecánico versátil en formato 65% que mantiene teclas de dirección y funciones esenciales sin sacrificar excesivamente la compacidad. Su característica diferencial es la triple conectividad: Bluetooth 5.1 multidispositivo (hasta 3 dispositivos con cambio instantáneo), cable USB-C desmontable y switch para alternar entre sistemas Windows/Mac con keycaps específicos incluidos para ambos. La versión hot-swap permite sustituir switches sin soldar, ideal para entusiastas que quieren experimentar con diferentes perfiles táctiles. Utiliza switches Gateron Red (lineales) con respuesta suave y equilibrada para gaming y escritura. Su estructura de aluminio con placa superior de alta rigidez proporciona solidez eliminando flex durante escritura intensiva. La batería recargable de 4000mAh ofrece hasta 240 horas de autonomía (72h con retroiluminación). Incluye iluminación RGB con 18 efectos predefinidos configurables sin software y sistema N-key rollover completo en modo cableado. Destaca su versatilidad entre plataformas (Windows, macOS, iOS, Android) y su equilibrio entre funcionalidad profesional, estética minimalista y rendimiento gaming. Compatible con software VIA para personalización avanzada de macros y remapeo.',
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
            'description' => 'Teclado mecánico full-size gaming de alta gama con switches Razer Green (táctiles y clicky), diseñados específicamente para gaming con punto de actuación optimizado a 1.9mm, fuerza de 50g y feedback audible y táctil para confirmación de pulsaciones. Su chasis de aluminio con acabado mate resistente a huellas proporciona rigidez estructural superior y durabilidad a largo plazo. Incorpora iluminación Razer Chroma RGB per-key sincronizable con más de 150 juegos y ecosistema de 500+ dispositivos mediante software Razer Synapse 3. Los keycaps de ABS con etiquetado de inyección a doble molde garantizan que las leyendas nunca se desvanezcan, mientras que la tecnología Hypershift permite configurar macros y funciones secundarias en cada tecla. Incluye rueda multimedia multifunción de aluminio con botón digital para control intuitivo de volumen y multimedia, además de reposamuñecas ergonómico magnético acolchado con espuma de alta densidad para sesiones prolongadas sin fatiga. Ofrece memoria interna para 5 perfiles, cable USB trenzado reforzado con Kevlar y tecnología N-key rollover con anti-ghosting completo. Certificación de 80 millones de pulsaciones por switch y construido con consideraciones acústicas para reducir el ruido de estabilizadores y resortes.',
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
            'description' => 'Ratón gaming de alto rendimiento con reconocido diseño ergonómico asimétrico para diestros y 11 botones programables estratégicamente ubicados. Su característica principal es el sensor óptico HERO 25K desarrollado por Logitech, capaz de rastrear con precisión hasta 16.000 DPI reales (sin interpolación) con zero smoothing, acceleration o filtering, garantizando respuesta 1:1 incluso en movimientos rápidos. Incorpora sistema de peso ajustable con 5 pesas de 3.6g que permiten personalizar el equilibrio y la sensación de inercia. Sus switches mecánicos principales utilizan tecnología de tensión con resortes metálicos para mejorar consistencia y reducir la fuerza necesaria para clics rápidos, certificados para 50 millones de clics. La rueda de desplazamiento dual-mode puede alternar entre scroll paso a paso para precisión y modo hiper-rápido con giro libre para navegación veloz. Su iluminación RGB LIGHTSYNC con 16.8 millones de colores se sincroniza con juegos y contenido mientras que su memoria interna almacena hasta 5 perfiles completos. Cable trenzado de alta flexibilidad con refuerzo en puntos críticos y pies PTFE de alta pureza para deslizamiento suave sobre cualquier superficie. Compatible con PowerPlay para carga inalámbrica continua.',
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
            'description' => 'Evolución del icónico ratón gaming que ha vendido más de 10 millones de unidades, ahora con diseño ergonómico refinado para mayor comodidad en sesiones prolongadas gracias a sus laterales texturizados de goma y perfil óptimo para agarre palm y claw. Incorpora el sensor óptico Focus+ de 20.000 DPI reales con precisión de resolución del 99.6% y tecnología Smart Tracking que calibra automáticamente el sensor según la superficie. Sus 8 botones programables utilizan switches ópticos Razer de 2ª generación que activan mediante haces de luz infrarroja eliminando debounce delay y evitando activaciones no deseadas, con durabilidad certificada de 70 millones de clics. El cable Speedflex trenzado con diseño de baja fricción minimiza drag para movimientos fluidos sin necesidad de bungee. Con un peso ultraligero de sólo 82g sin comprometer durabilidad y deslizadores de PTFE de grado 100% puro, ofrece deslizamiento sin fricción incluso en movimientos rápidos. Su memoria interna almacena hasta 5 perfiles completos mientras que la compatibilidad con Razer Synapse 3 permite personalización completa de DPI, polling rate de 1000Hz, mapeo de botones, macros e iluminación Chroma RGB. Diseñado para eSports con características profesionales en un diseño probado durante décadas.',
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
            'description' => 'Ratón gaming revolucionario con sistema exclusivo TrueMove3+ Dual Sensor que combina un sensor óptico principal TrueMove3 de 12.000 DPI para tracking de movimientos y un segundo sensor dedicado específicamente a detectar distancia de despegue con precisión <0.5mm. Esta tecnología elimina el problema de "spin-out" y tracking involuntario durante levantamientos, crucial para jugadores con sensibilidad baja. Su diseño ergonómico para diestros incorpora sistema de peso personalizable con 8 pesas de 4g que permiten 256 configuraciones diferentes ajustando centro de gravedad y distribución lateral para equilibrio óptimo según preferencias individuales. Los 7 botones programables utilizan switches mecánicos SteelSeries con durabilidad de 60 millones de clics y respuesta consistente. Su iluminación RGB de 8 zonas independientes con Prism Sync permite efectos complejos sincronizados con otros dispositivos SteelSeries y eventos en juegos. Las laterales son modulares y desmontables para facilitar limpieza y personalización, con recubrimiento de silicona texturizada para agarre óptimo incluso con manos húmedas. El cable desmontable de fibra trenzada soft-touch permite fácil transporte y sustitución, mientras que el Engine 3 Software permite personalización completa con configuraciones específicas por juego, almacenables en la memoria interna del ratón.',
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
                'image' => rand(0, 1) ? 'https://res.cloudinary.com/dlmbw4who/image/upload/v1743097241/product-placeholder_jcgqx4.png' : null,
            ]);
        }
    }
}