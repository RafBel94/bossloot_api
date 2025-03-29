<?php

namespace App\Utils;

use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class CloudinaryImageClient
{
    
    protected $cloudinaryInstance;
    
    public function __construct()
    {
        $this->cloudinaryInstance = Configuration::instance([
            'cloud' => [
                'cloud_name' => Config::get('cloudinary.cloud_name'),
                'api_key' => Config::get('cloudinary.api_key'),
                'api_secret' => Config::get('cloudinary.api_secret')
            ],
            'url' => [
                'secure' => true
            ]]);
    }

    
}