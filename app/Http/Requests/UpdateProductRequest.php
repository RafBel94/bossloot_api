<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProductRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return $this->getValidationRules($this->category_id);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422)
        );
    }

    public function getValidationRules(int $category)
    {
        $commonRules = [
            'name' => 'required|max:60|unique:products,name,' . $this->id,
            'description' => 'required|max:255',
            'category_id' => 'required|integer',
            'brand_id' => 'required|integer',
            'model' => 'required|max:60',
            'price' => 'required|numeric|min:1|max:99999.99',
            'quantity' => 'required|numeric',
            'on_offer' => 'required|boolean',
            'discount' => 'numeric|min:0|max:100',
            'featured' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'points' => 'nullable|integer|min:0|max:2000',
        ];

        $categorySpecificRules = [
            1 => [
                'speed' => 'required|integer|min:800|max:6000',
                'latency' => 'required|integer|min:7|max:40',
                'memory' => 'required|integer|min:4|max:256',
                'memory_type' => 'required|string|in:DDR3,DDR4,DDR5',
            ],
            2 => [
                'memory' => 'required|integer|min:2|max:24',
                'memory_type' => 'required|string|in:GDDR5,GDDR6',
                'core_clock' => 'required|integer|min:800|max:8000',
                'boost_clock' => 'required|integer|min:800|max:8000',
                'consumption' => 'required|integer|min:25|max:500',
                'length' => 'required|numeric|min:80|max:400',
            ],
            3 => [
                'socket' => 'required|string|in:AM4,AM5,SP3,SP5,LGA1200,LGA1700,LGA2066',
                'core_count' => 'required|integer|in:1,2,4,8,12,16',
                'thread_count' => 'required|integer|in:1,2,4,8,12,16,24,32',
                'base_clock' => 'required|numeric|min:1|max:8',
                'boost_clock' => 'required|numeric|min:1|max:8',
                'consumption' => 'required|numeric|min:5|max:500',
                'integrated_graphics' => 'required|boolean',
            ],
            4 => [
                'socket' => 'required|string|in:AM4,AM5,SP3,SP5,LGA1200,LGA1700,LGA2066',
                'chipset' => 'required|string|in:X570,B550,A520,X470,X670E,X670,B650E,B650,A620,Z490,H470,B460,H410,Z690,H670,B660,H610,Z790,H770,B760',
                'form_factor' => 'required|string|in:E-ATX,ATX,Micro-ATX,Mini-ITX',
                'memory_max' => 'required|integer|in:32,64,128,256',
                'memory_slots' => 'required|integer|in:2,4,8',
                'memory_type' => 'required|string|in:DDR3,DDR4,DDR5',
                'memory_speed' => 'required|integer|min:1000|max:7000',
                'sata_ports' => 'required|integer|in:2,4,6,8',
                'm_2_slots' => 'required|integer|in:0,1,2,3',
                'pcie_slots' => 'required|integer|in:1,2,3,4',
                'usb_ports' => 'required|integer|min:2|max:10',
                'lan' => 'required|string|in:1GbE,2.5GbE,5GbE,10GbE',
                'audio' => 'required|string|in:Realtek ALC887,Realtek ALC892,Realtek ALC1150,Realtek ALC1200,Realtek ALC1220,Realtek ALC4080',
                'wifi' => 'required|boolean',
                'bluetooth' => 'required|boolean',
            ],
            5 => [
                'type' => 'required|string|in:SSD,HDD,NVMe,NVMe M.2',
                'capacity' => 'required|integer|in:120,250,500,1000,2000,4000',
                'rpm' => 'nullable|integer|between:0,7200',
                'read_speed' => 'required|integer|between:100,14000',
                'write_speed' => 'required|integer|between:100,12000',
            ],
            6 => [
                'efficiency_rating' => 'required|string|in:80+ Bronze,80+ Silver,80+ Gold,80+ Platinum,80+ Titanium',
                'wattage' => 'required|integer|min:100|max:1500',
                'modular' => 'required|boolean',
                'fanless' => 'required|boolean',
            ],
            7 => [
                'case_type' => 'required|string|in:Mid Tower,Full Tower,Mini Tower,Small Form Factor',
                'form_factor_support' => 'required|string|in:ATX,Micro ATX,Mini ITX,E-ATX',
                'tempered_glass' => 'required|boolean',
                'expansion_slots' => 'required|integer|between:0,9',
                'max_gpu_length' => 'required|numeric|between:260,420',
                'max_cpu_cooler_height' => 'required|numeric|between:145,180',
                'radiator_support' => 'required|boolean',
                'extra_fans_connectors' => 'required|integer|between:2,10',
                'depth' => 'required|numeric|between:150,300',
                'width' => 'required|numeric|between:300,800',
                'height' => 'required|numeric|between:300,800',
                'weight' => 'required|numeric|between:2,20',
            ],
            8 => [
                'type' => 'required|string|in:Air,Liquid',
                'fan_rpm' => 'required|integer|between:1000,3000',
                'consumption' => 'required|integer|between:5,50',
                'socket_support' => 'required|string|in:LGA1151,LGA1200,AM4,LGA1700,AM5,SP3,SP5,LGA2066',
                'width' => 'required|numeric|between:100,300',
                'height' => 'required|numeric|between:100,300',
            ],
            9 => [
                'resolution' => 'required|string|in:1920x1080,2560x1440,3440x1440,3840x2160',
                'refresh_rate' => 'required|integer|in:30,60,90,120,144,165,240',
                'response_time' => 'required|integer|between:1,10',
                'panel_type' => 'required|string|in:IPS,VA,OLED',
                'aspect_ratio' => 'required|string|in:16:9,21:9,32:9',
                'curved' => 'required|boolean',
                'brightness' => 'required|integer|between:100,1000',
                'contrast_ratio' => 'required|string|in:1000:1,3000:1,5000:1',
                'sync_type' => 'required|string|in:G-Sync,FreeSync,V-Sync',
                'hdmi_ports' => 'required|integer|between:1,5',
                'display_ports' => 'required|integer|between:1,5',
                'inches' => 'required|integer|between:10,50',
                'weight' => 'required|numeric|between:1,20',
            ],
            10 => [
                'type' => 'required|string|in:Mechanical,Membrane,Hybrid',
                'switch_type' => 'required|string|in:Cherry MX Red,Gateron Red,Kailh Red,Cherry MX Brown,Zealios V2,Holy Panda,Cherry MX Blue,Kailh BOX White,Razer Green,Cherry MX Speed Silver,Kailh Speed,Cherry MX Silent Red,Silent Black,Cherry MX Low Profile Red,Kailh Choc',
                'width' => 'required|numeric|between:250,450',
                'height' => 'required|numeric|between:30,60',
                'weight' => 'required|numeric|between:600,4000',
            ],
            11 => [
                'dpi' => 'required|integer|between:600,20000',
                'sensor' => 'required|string|in:Optical,Laser',
                'buttons' => 'required|integer|between:2,20',
                'bluetooth' => 'required|boolean',
                'weight' => 'required|numeric|between:50,150',
            ],
        ];

        return array_merge($commonRules, $categorySpecificRules[$category] ?? []);
    }
}