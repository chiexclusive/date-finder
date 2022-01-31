<?php


use Cloudinary\Cloudinary;


$cloudinary = new Cloudinary(
    [
        'cloud' => [
            'cloud_name' => env("CLOUDINARY_CLOUD_NAME"),
            'api_key'    => env("CLOUDINARY_API_KEY"),
            'api_secret' => env("CLOUDINARY_API_SECRET"),
        ],
    ]
);