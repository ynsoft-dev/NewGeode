    <?php

    use Illuminate\Validation\Rules\Can;

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

        'title' => 'AdminLTE 3',
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
        | Google Fonts
        |--------------------------------------------------------------------------
        |
        | Here you can allow or not the use of external google fonts. Disabling the
        | google fonts may be useful if your admin panel internet access is
        | restricted somehow.
        |
        | For detailed instructions you can look the google fonts section here:
        | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
        |
        */

        'google_fonts' => [
            'allowed' => true,
        ],

        /*
        |--------------------------------------------------------------------------
        | Admin Panel Logo
        |--------------------------------------------------------------------------
        |
        | Here you can change the logo of your admin panel.
        |
        | For detailed instructions you can look the logo section here:
        | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
        |
        */

        // 'logo' => '<b>Admin</b>LTE',
        // // 'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
        // // 'logo_img_class' => 'brand-image img-circle elevation-3',
        // 'logo_img_xl' => null,
        // 'logo_img_xl_class' => 'brand-image-xs',
        // 'logo_img_alt' => 'Admin Logo',



       
        'logo_img' => '/images/logo25.png',
        'logo_img_class' => 'small',
        'logo_img_xl' => '/images/logo25.png',
        'logo_img_xl_class' => 'try',
        'logo_img_alt' => 'Box flow',

        /*
        |--------------------------------------------------------------------------
        | Authentication Logo
        |--------------------------------------------------------------------------
        |
        | Here you can setup an alternative logo to use on your login and register
        | screens. When disabled, the admin panel logo will be used instead.
        |
        | For detailed instructions you can look the auth logo section here:
        | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
        |
        */

        'auth_logo' => [
            'enabled' => true,
            'img' => [
                'path' => '/images/logo.png',
                'alt' => 'Box flow',
                'class' => '',
                'width' => 140,
                'height' => 100,
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Preloader Animation
        |--------------------------------------------------------------------------
        |
        | Here you can change the preloader animation configuration. Currently, two
        | modes are supported: 'fullscreen' for a fullscreen preloader animation
        | and 'cwrapper' to attach the preloader animation into the content-wrapper
        | element and avoid overlapping it with the sidebars and the top navbar.
        |
        | For detailed instructions you can look the preloader section here:
        | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
        |
        */

        'preloader' => [
            'enabled' => false,
            'mode' => 'fullscreen',
            'img' => [
                'path' => '/images/logo.png',
                'alt' => 'AdminLTE Preloader Image',
                'effect' => 'animation__shake',
                'width' => 200,
                'height' => 200,
            ],
        ],

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
        'usermenu_header' => false,
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
        'layout_fixed_sidebar' => true,
        'layout_fixed_navbar' => null,
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
        'sidebar_collapse' => true,
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
                'type' => 'navbar-search',
                'text' => 'search',
                'topnav_right' => true,
            ],
            [
                'type' => 'fullscreen-widget',
                'topnav_right' => true,
            ],

            [
                'type' => 'navbar-notification',
                'id' => 'my-notification',                // An ID attribute (required).
                'icon' => 'fas fa-bell',                  // A font awesome icon (required).
                'url' => 'notifications/show',            // The url to access all notifications/elements (required).
                'topnav_right' => true,                   // Or "topnav => true" to place on the left (required).
                'dropdown_mode' => true,                  // Enables the dropdown mode (optional).
                'dropdown_flabel' => 'All notifications', // The label for the dropdown footer link (optional).
                'update_cfg' => [
                    'url' => 'notifications/get',         // The url to periodically fetch new data (optional).
                    'period' => 30,                       // The update period for get new data (in seconds, optional).
                ],
            ],


            // Sidebar items:
            [
                'type' => 'sidebar-menu-search',
                'text' => 'search',
            ],
            [
                'text' => 'blog',
                'url' => 'admin/blog',
                'can' => 'manage-blog',
            ],



            [
                'text' => 'Home',
                'url' => '/home',
                'icon' => 'far fa-fw fa-file',
                'label_color' => 'success',
            ],


            ['header' => 'ADMIN', 'can' => 'admin',],

            [
                'text' => 'Locations',
                'icon' => 'fas fa-map-marked-alt',
                'can' => 'locations',
                'submenu' => [
                    [
                        'text' => 'Rooms',
                        'url' => 'sites',
                        'icon' => 'fas fa-industry',
                        'can' => 'sites',


                    ],
                    [
                        'text' => 'Rays',
                        'url' => 'rays',
                        'icon' => 'fas fa-cubes',
                        'can' => 'rays',
                    ],
                    [
                        'text' => 'Columns',
                        'url' => 'columns',
                        'icon' => 'fas fa-columns',
                        'can' => 'columns',
                    ],
                    [
                        'text' => 'Shelves',
                        'url' => 'shelves',
                        'icon' => 'fas fa-layer-group',
                        'can' => 'shelves',
                    ],
                ],
            ],


            [
                'text' => 'Directions',
                'url' => 'directions',
                'icon' => 'fas fa-city',
                'can' => 'structure',
                'submenu' => [
                    [
                        'text' => 'Directions',
                        'url' => 'directions',
                        'icon' => 'fas fa-building',
                        'can' => 'directions',
                    ],
                    [
                        'text' => 'Departments',
                        'url' => 'departments',
                        'icon' => 'far fa-building',
                        'can' => 'departments',
                    ],
                ],
            ],


            [
                'text' => 'Users and Roles',
                'icon' => 'fas fa-users',
                'can' => 'users',
                'submenu' => [
                    [
                        'text' => 'Users',
                        'url' => 'users',
                        'icon' => 'fas fa-user',
                        'can' => 'users_lists',
                    ],
                    [
                        'text' => 'roles',
                        'url' => 'roles',
                        'icon' => 'fas fa-user-friends',
                        'can' => 'users_permissions',
                    ],

                ],
            ],

            // ,'can' => 'structureApplicant',
            ['header' => 'APPLICANT', 'class' => 'bg-info', 'can' => 'structureApplicant',],
            [
                'text' => 'Archive demand',
                'url' => 'archiveDemand',
                'icon' => 'fas fa-file-export',
                'can' => 'archiveRequest',
            ],
            [
                'text' => 'Loan demand ',
                'url' => 'loanDemand',
                'icon' => 'fas fa-file-export',
                'can' => 'loanRequest',
            ],
            // [
            //     'text' => 'Copies',
            //     'url' => '#',
            //     'icon' => 'fas fa-file-export',
            // ],

            ['header' => 'ARCHIVISTE', 'can' => 'structureArchiviste'],
            [
                'text' => 'Boxes Archived',
                'url' => 'boxArchived',
                'icon' => 'fas fa-file-import',
                'can' => 'archive_boxes',

            ],
            // [
            //     'text' => 'Box payments',
            //     'url' => '#',
            //     'icon' => 'fas fa-file-import',
            // ],
            // [
            //     'text' => 'Box Loaned',
            //     'url' => '#',
            //     'icon' => 'fas fa-file-import',
            //     'can' => 'loans',
            // ],
            [
                'text' => 'Box Loaned', 'can' => 'structureArchiviste',
                'url' => 'boxLoaned',
                'icon' => 'fas fa-file-import',
                'can' => 'loans',
            ],

            [
                'text' => 'Box Movement', 'can' => 'structureArchiviste',
                'url' => 'boxMovements',
                'icon' => 'fas fa-file-import',
            ],
            [
                'text' => 'Box Pending Destruction', 'can' => 'structureArchiviste',
                'url' => 'boxpendingDestruction',
                'icon' => 'fas fa-file-import',
            ],
            [
                'text' => 'Box Destroyed', 'can' => 'structureArchiviste',
                'url' => 'boxdestroyed',
                'icon' => 'fas fa-file-import',
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
            'CustomCSS' => [
                'active' => true,
                'files' => [
                    [
                        'type' => 'css',
                        'asset' => true,
                        'location' => '/css/custom.css',
                    ],
                ],
            ],
            'BsCustomFileInput' => [
                'active' => false,
                'files' => [
                    [
                        'type' => 'js',
                        'asset' => true,
                        'location' => 'vendor/bs-custom-file-input/bs-custom-file-input.min.js',
                    ],
                ],
            ],

            'toastr' => [
                'active' => true,
                'files' => [
                    [
                        'type' => 'css',
                        'asset' => true,
                        'location' => 'vendor/toastr/toastr.min.css',
                    ],
                    [
                        'type' => 'js',
                        'asset' => true,
                        'location' => 'vendor/toastr/toastr.min.js',
                    ],
                ],
            ],
            'Sweetalert2' => [
                'active' => false,
                'files' => [
                    [
                        'type' => 'js',
                        'asset' => true,
                        'location' => 'vendor/sweetalert2/sweetalert2.min.js',
                    ],
                    [
                        'type' => 'css',
                        'asset' => true,
                        'location' => 'vendor/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css',
                    ],
                    [
                        'type' => 'js',
                        'asset' => true,
                        'location' => '//unpkg.com/sweetalert/dist/sweetalert.min.js',
                    ],
                ],
            ],
            'Datatables' => [
                'active' => true,
                'files' => [
                    [
                        'type' => 'js',
                        'asset' => true,
                        'location' => 'vendor/datatables/js/jquery.dataTables.min.js',
                    ],
                    [
                        'type' => 'js',
                        'asset' => true,
                        'location' => 'vendor/datatables/js/dataTables.bootstrap4.min.js',
                    ],
                    [
                        'type' => 'css',
                        'asset' => true,
                        'location' => 'vendor/datatables/css/dataTables.bootstrap4.min.css',
                    ],
                ],
            ],
            'DatatablesPlugins' => [
                'active' => true,
                'files' => [
                    [
                        'type' => 'js',
                        'asset' => true,
                        'location' => 'vendor/datatables-plugins/buttons/js/dataTables.buttons.min.js',
                    ],
                    [
                        'type' => 'js',
                        'asset' => true,
                        'location' => 'vendor/datatables-plugins/buttons/js/buttons.bootstrap4.min.js',
                    ],
                    [
                        'type' => 'js',
                        'asset' => true,
                        'location' => 'vendor/datatables-plugins/buttons/js/buttons.html5.min.js',
                    ],
                    [
                        'type' => 'js',
                        'asset' => true,
                        'location' => 'vendor/datatables-plugins/buttons/js/buttons.print.min.js',
                    ],
                    [
                        'type' => 'js',
                        'asset' => true,
                        'location' => 'vendor/datatables-plugins/jszip/jszip.min.js',
                    ],
                    [
                        'type' => 'js',
                        'asset' => true,
                        'location' => 'vendor/datatables-plugins/pdfmake/pdfmake.min.js',
                    ],
                    [
                        'type' => 'js',
                        'asset' => true,
                        'location' => 'vendor/datatables-plugins/pdfmake/vfs_fonts.js',
                    ],
                    [
                        'type' => 'css',
                        'asset' => true,
                        'location' => 'vendor/datatables-plugins/buttons/css/buttons.bootstrap4.min.css',
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
            'TempusDominusBs4' => [
                'active' => true,
                'files' => [
                    [
                        'type' => 'js',
                        'asset' => true,
                        'location' => 'vendor/moment/moment.min.js',
                    ],
                    [
                        'type' => 'js',
                        'asset' => true,
                        'location' => 'vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
                    ],
                    [
                        'type' => 'css',
                        'asset' => true,
                        'location' => 'vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
                    ],
                ],
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | IFrame
        |--------------------------------------------------------------------------
        |
        | Here we change the IFrame mode configuration. Note these changes will
        | only apply to the view that extends and enable the IFrame mode.
        |
        | For detailed instructions you can look the iframe mode section here:
        | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
        |
        */

        'iframe' => [
            'default_tab' => [
                'url' => null,
                'title' => null,
            ],
            'buttons' => [
                'close' => true,
                'close_all' => true,
                'close_all_other' => true,
                'scroll_left' => true,
                'scroll_right' => true,
                'fullscreen' => true,
            ],
            'options' => [
                'loading_screen' => 1000,
                'auto_show_new_tab' => true,
                'use_navbar_items' => true,
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
        |
        */

        'livewire' => false,
    ];
