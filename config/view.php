<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | The view paths tell Laravel where to find the Blade templates used by
    | the application.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | Keep this as a direct storage_path() call instead of realpath(). This
    | also works on a fresh Windows/XAMPP installation before the directory
    | has been cached by Laravel.
    |
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        storage_path('framework/views')
    ),

];
