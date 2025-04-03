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
        return $this->getValidationRules($this->category);
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

    public function getValidationRules(string $category)
    {
        $commonRules = [
            'name' => 'required|max:60|unique:products,name,' . $this->id,
            'description' => 'required|max:255',
            'category' => 'required|max:60',
            'model' => 'required|max:60',
            'brand' => 'required|max:60',
            'price' => 'required|numeric|min:1|max:99999.99',
            'quantity' => 'required|numeric',
            'on_offer' => 'required|boolean',
            'discount' => 'integer|min:0|max:100',
            'featured' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        $categorySpecificRules = [
            'ram' => [
                'speed' => 'required|integer',
                'latency' => 'required|integer',
                'memory' => 'required|integer',
                'memory_type' => 'required|string',
            ],
            'cpu' => [
                'socket' => 'required|string|max:255',
                'core_count' => 'required|integer',
                'thread_count' => 'required|integer',
                'base_clock' => 'required|integer',
                'boost_clock' => 'required|integer',
                'consumption' => 'required|integer',
                'integrated_graphics' => 'required|boolean',
            ],
            'gpu' => [
                'memory' => 'required|integer',
                'memory_type' => 'required|string|max:255',
                'core_clock' => 'required|integer',
                'boost_clock' => 'required|integer',
                'consumption' => 'required|integer',
                'interface' => 'required|string|max:255',
                'length' => 'required|integer',
                'ray_tracing' => 'required|boolean',
            ],
            'motherboard' => [
                'socket' => 'required|string|max:255',
                'chipset' => 'required|string|max:255',
                'form_factor' => 'required|string|max:255',
                'memory_max' => 'required|integer',
                'memory_slots' => 'required|integer',
                'memory_type' => 'required|string|max:255',
                'memory_speed' => 'required|integer',
                'sata_ports' => 'required|integer',
                'm_2_slots' => 'required|integer',
                'pcie_slots' => 'required|integer',
                'usb_ports' => 'required|integer',
                'lan' => 'required|string|max:255',
                'audio' => 'required|string|max:255',
                'wifi' => 'required|boolean',
                'bluetooth' => 'required|boolean',
            ],
            'psu' => [
                'power' => 'required|integer',
                'efficiency' => 'required|string|max:255',
                'modular' => 'required|boolean',
                'form_factor' => 'required|string|max:255',
            ],
            'case' => [
                'form_factor' => 'required|string|max:255',
                'motherboard_support' => 'required|string|max:255',
                'fan_support' => 'required|integer',
                'radiator_support' => 'required|integer',
                'gpu_length' => 'required|integer',
                'psu_length' => 'required|integer',
            ],
            'cooler' => [
                'type' => 'required|string|max:255',
                'fan_speed' => 'required|integer',
                'noise_level' => 'required|integer',
                'compatibility' => 'required|string|max:255',
            ],
            'display' => [
                'size' => 'required|integer',
                'resolution' => 'required|string|max:255',
                'refresh_rate' => 'required|integer',
                'panel_type' => 'required|string|max:255',
                'response_time' => 'required|integer',
            ],
            'keyboard' => [
                'type' => 'required|string|max:255',
                'switch_type' => 'required|string|max:255',
                'backlight' => 'required|boolean',
                'connection' => 'required|string|max:255',
            ],
            'mouse' => [
                'dpi' => 'required|integer',
                'sensor' => 'required|string|max:255',
                'buttons' => 'required|integer',
                'connection' => 'required|string|max:255',
                'weight' => 'required|integer',
            ],
            'storage' => [
                'type' => 'required|string|max:255',
                'capacity' => 'required|integer',
                'rpm' => 'nullable|integer',
                'read_speed' => 'required|integer',
                'write_speed' => 'required|integer',
            ],
        ];
        
        return array_merge($commonRules, $categorySpecificRules[$category] ?? []);
    }
}