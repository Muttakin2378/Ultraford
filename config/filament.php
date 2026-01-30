<?php

return [

    'broadcasting' => [],

    'default_filesystem_disk' => env('FILAMENT_FILESYSTEM_DISK', 'public'),

    'assets_path' => null,


    'panel_providers' => [
        App\Providers\Filament\AdminPanelProvider::class,
    ],

    'cache_path' => base_path('bootstrap/cache/filament'),

    'livewire_loading_delay' => 'default',

];
