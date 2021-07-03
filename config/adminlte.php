<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'SISGA',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>SISGA</b>',
    'logo_img' => 'vendor/adminlte/dist/img/logo-sisga.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'SISGA',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type'         => 'navbar-search',
            'text'         => 'search',
            'topnav_right' => false,
        ],
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => false,
        ],

        // Sidebar items:
        /*
        [
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],
        */    
        [
            'text' => 'blog',
            'url'  => 'admin/blog',
            'can'  => 'manage-blog',
        ],
        [
            'text'        => 'Fincas',
            'route'         => 'home',
            'icon'        => 'fas fa-fw fa-home',
            'label'       => 4,
            'label_color' => 'success',
        ],
        ['header' => 'account_settings'],
        [
            'text' => 'Roles',
            'url'  => '/home/sisga-admin/roles',
            'icon' => 'fas fa-fw fa-lock',
        ],
        [
            'text' => 'Usuarios',
            'url'  => '/home/sisga-admin/usuario',
            'icon' => 'fas fa-fw fa-user',

        ],
        ['header' => 'main_navigation'],
        [
            'text'    => 'Variables de Control',
            'icon'    => 'fas fa-fw fa-cog', 
            'submenu' => [
                [
                    'text' => 'Especie',
                    'icon_color' => 'info',
                    'url'  => '#',
                ],
                [
                    'text' => 'Raza',
                    'icon_color' => 'info',
                    'url'  => '#',
                ],
                [
                    'text' => 'Tipolgía',
                    'icon_color' => 'info',
                    'url'  => '#',
                ],
                [
                    'text' => 'Condiciones corporales',
                    'icon_color' => 'info',
                    'url'  => '#',
                ],
                [
                    'text' => 'Colores campo',
                    'icon_color' => 'info',
                    'url'  => '#',
                ],
                [
                    'text' => 'Diagnóstico Palpaciones',
                    'icon_color' => 'info',
                    'url'  => '#',
                ],
                [
                    'text' => 'Parámetros G/R',
                    'icon_color' => 'info',
                    'url'  => '#',
                ],
                [
                    'text' => 'Patología',
                    'icon_color' => 'info',
                    'url'  => '#',
                ],
                [
                    'text' => 'Tipo de Montas',
                    'icon_color' => 'info',
                    'url'  => '#',
                ],
                [
                    'text' => 'Causa de Muerte',
                    'icon_color' => 'info',
                    'url'  => '#',
                ],
                [
                    'text' => 'Destino de Salida',
                    'icon_color' => 'info',
                    'url'  => '#',
                ],
                [
                    'text' => 'Procedencia',
                    'icon_color' => 'info',
                    'url'  => '#',
                ],
                [
                    'text' => 'Sala de Ordeño',
                    'icon_color' => 'info',
                    'url'  => '#',
                    'can' => ['salaordeno','salaordeno.crear'],
                ],
                [
                    'text' => 'Tanque de Enfriamiento',
                    'icon_color' => 'info',
                    'url'  => '#',
                    'can' => ['tanque','tanque.crear'],
                ],



                [
                    'text'    => 'level_one',
                    'url'     => '#',
                    'submenu' => [
                        [
                            'text' => 'level_two',
                            'url'  => '#',
                        ],
                        [
                            'text'    => 'level_two',
                            'url'     => '#',
                            'submenu' => [
                                [
                                    'text' => 'level_three',
                                    'url'  => '#',
                                ],
                                [
                                    'text' => 'level_three',
                                    'url'  => '#',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'text' => 'level_one',
                    'url'  => '#',
                ],
            ],
        ],

        [
            'text'    => 'Ganadería',
            'icon'    => 'fas fa-fw fa-paw', 
            'submenu' => [
                [
                    'text' => 'Crear Ficha de Ganado',
                    'icon_color' => 'warning',
                    'icon' => 'fas fa-fw fa-arrow-right',
                    'url'  => '#',
                ],
                [
                    'text' => 'Lote',
                    'icon' => 'fas fa-fw fa-arrow-right',
                    'icon_color' => 'warning',
                    'url'  => '#',
                ],
                [
                    'text' => 'Transferencia de Animal',
                    'icon' => 'fas fa-fw fa-arrow-right',
                    'icon_color' => 'warning',
                    'url'  => '#',
                ],
                [
                    'text' => 'Cambio de Tipología',
                    'icon' => 'fas fa-fw fa-arrow-right',
                    'icon_color' => 'warning',
                    'url'  => '#',
                ],
                [
                    'text' => 'Salida de Animal',
                    'icon' => 'fas fa-fw fa-arrow-right',
                    'icon_color' => 'warning',
                    'url'  => '#',
                ],
                [
                    'text' => 'Crear Ajuste de Pesos',
                    'icon' => 'fas fa-fw fa-arrow-right',
                    'icon_color' => 'warning',
                    'url'  => '#',
                ],
                [
                    'text' => 'Crear Ficha de Pajuela',
                    'icon' => 'fas fa-fw fa-arrow-right',
                    'icon_color' => 'warning',
                    'url'  => '#',
                ],
             

                [
                    'text'    => 'level_one',
                    'url'     => '#',
                    'submenu' => [
                        [
                            'text' => 'level_two',
                            'url'  => '#',
                        ],
                        [
                            'text'    => 'level_two',
                            'url'     => '#',
                            'submenu' => [
                                [
                                    'text' => 'level_three',
                                    'url'  => '#',
                                ],
                                [
                                    'text' => 'level_three',
                                    'url'  => '#',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'text' => 'level_one',
                    'url'  => '#',
                ],
            ],
        ],

        [
            'text'    => 'Reroducción',
            'icon'    => 'fas fa-fw fa-clone', 
            'submenu' => [
                [
                    'text' => 'Temporada Reprod.',
                    'icon_color' => 'orange',
                    'icon' => 'fas fa-fw fa-calendar',
                    'url'  => '#',
                ],  
            ],
        ],

        [
            'text'    => 'Inventario',
            'icon'    => 'fas fa-fw fa-box', 
            'submenu' => [
                [
                    'text' => 'Trabajo de Campo.',
                    'icon_color' => 'lime',
                    'icon' => 'fas fa-fw fa-arrow-down',
                    'url'  => '#',
                ],  
            ],
        ],

         [
            'text'    => 'Reportes',
            //'url'     => '#',
            'icon'    => 'fas fa-fw fa-print', 
            'submenu' => [
                [
                    'text'    => 'Ganadería',
                    'icon_color'=>'olive',
                    //'url'     => '#',
                    'submenu' => [
                        [
                            'text' => 'Catálogo de Ganado',
                            'url'  => '#',
                        ],
                        [
                            'text' => 'Catálogo de Pajuela',
                            'url'  => '#',
                        ],
                        [
                            'text' => 'Salida de Animal (es)',
                            'url'  => '#',
                        ],
                        [
                            'text' => 'Transferencias',
                            'url'  => '#',
                        ],
                        [
                            'text' => 'Ajuste de Pesos',
                            'url'  => '#',
                        ],
                    ],
                ],
                [
                    'text'    => 'Reproducción',
                    'icon_color'=>'purple',
                    //'url'     => '#',
                    'submenu' => [
                        [
                            'text' => 'Manejo de Vientres',
                            'url'  => '#',
                        ],
                        [
                            'text' => 'Registros de Celos',
                            'url'  => '#',
                        ],
                        [
                            'text' => 'Servicios Registrados',
                            'url'  => '#',
                        ],
                        [
                            'text' => 'Partos Registrados',
                            'url'  => '#',
                        ],
                        [
                            'text' => 'Abortos Registrados',
                            'url'  => '#',
                        ],
                        [
                            'text' => 'Partos No Concluidos',
                            'url'  => '#',
                        ],
                        [
                            'text' => 'Series Próximas Palpar',
                            'url'  => '#',
                        ],
                        [
                            'text' => 'Series Próximas a Parir',
                            'url'  => '#',
                        ],
                    ],
                ],
                
            ],
        ],


        ['header' => 'labels'],
        [
            'text'       => 'Block de Notas',
            'icon_color' => 'white',
            'icon'       => 'fas fa-fw fa-clipboard',
            'route'      => 'blocknotas',
        ],

        
        
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    */

    'livewire' => false,
];
