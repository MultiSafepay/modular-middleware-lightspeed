<?php

// config for ModularLightspeed/ModularLightspeed
return [
    'enabled' => env('LIGHTSPEED_ENABLED', true),
    'app_key' => env('LIGHTSPEED_KEY'),
    'app_secret' => env('LIGHTSPEED_SECRET'),
    'apiUrl' => env('LIGHTSPEED_CLUSTER', 'https://api.webshopapp.com'),
];
