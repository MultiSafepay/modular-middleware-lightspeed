<?php

// config for ModularLightspeed/ModularLightspeed
return [
    'enabled' => env('Lightspeed_ENABLED', true),
    'app_key' => env('Lightspeed_KEY'),
    'app_secret' => env('Lightspeed_SECRET'),
    'apiUrl' => env('Lightspeed_URL', 'https://api.webshopapp.com'),
];
