<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    //Que rutas de la api permiten CORS (Cross origin resource sharing), el origen es la combinacion del
    //protocolo, host y puerto (Si es que esta especificado), ej: https://localhost:8000
    //Entonces el CORS es la interaccion entre recursos web que estan en distintos origenes
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    //Post, put, delete, etc
    'allowed_methods' => ['*'],

    //Que origines pueden hacer requests a la Laravel Aplication
    'allowed_origins' => ['*'],

    //Regex
    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    //Los headers que queremos exponer a JS, no se que significa esto
    'exposed_headers' => [],

    //Sirve para hacer cache de una Pre-Flight Request
    //Pre-Flight Request: Es una request que hace el navegador para preguntarle al servidor que tipo de request puede hacer
    //antes de hacer una Cross-Origin Request
    'max_age' => 0,

    //Le indica a Laravel si debe compartir cookies con la SPA
    'supports_credentials' => true,

];
