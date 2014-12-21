<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',
    
    'wrapper' => 'nav',//nav is default, i.e. this line is not needed
 
    // Here comes the menu strcture
    'items' => [

        // This is a menu item
        'home'  => [
            'text'  => 'Rikard Karlsson',   
            'url'   => '',  
            'title' => 'Rikard Karlsson'
        ],

 
        // This is a menu item
        /*
        'redovisning'  => [
            'text'  => 'Redovisning',   
            'url'   => 'redovisning',   
            'title' => 'Redovisning',

            // Here we add the submenu, with some menu items, as part of a existing menu item
            'submenu' => [

                'items' => [

                    // This is a menu item of the submenu
                    'item 1'  => [
                        'text'  => '1. PHP MVC ramverk',   
                        'url'   => 'redovisning',  
                        'title' => '1. PHP MVC ramverk'
                    ],

                    // This is a menu item of the submenu
                    'item 2'  => [
                        'text'  => '2. Kontroller och Modeller',   
                        'url'   => 'redovisning',  
                        'title' => '2. Kontroller och Modeller'
                    ],
                ],
            ],
        ],
        */
        // This is a menu item
        
        'redovisning' => [
            'text'  =>'Redovisning', 
            'url'   =>'redovisning',  
            'title' => 'Redovisning'
        ],
        /*
        'dice' => [
            'text'  =>'Kasta tärning', 
            'url'   =>'kasta-tarning',  
            'title' => 'Kasta tärning'
        ],
        'dice_100' => [
            'text'  =>'Tärningsspel', 
            'url'   =>'tarningsspel',  
            'title' => 'Tärningsspel'
        ],
        'calendar' => [
            'text'  =>'Kalender', 
            'url'   =>'kalender',  
            'title' => 'Kalender'
        ],
         */
        'comment' => [
            'text'  =>'Kommentar', 
            'url'   =>'comment',  
            'title' => 'Kommentar'
        ],
        'regioner' => [
            'text' => 'Regioner',
            'url' => 'regioner',
            'title' => 'Regioner'
        ],
        'regioner-left-main' => [
            'text' => 'Reg left+main',
            'url' => 'regioner-left-main',
            'title' => 'Regioner'
        ],
        'regioner-main-right' => [
            'text' => 'Reg main+right',
            'url' => 'regioner-main-right',
            'title' => 'Regioner'
        ],
        'typografi' => [
            'text' => 'Typografi',
            'url' => 'typografi',
            'title' => 'Typografi'
        ],
        'font-awesome' => [
            'text' => 'Font Awesome',
            'url' => 'font-awesome',
            'title' => 'Font Awesome'
        ],
        // This is a menu item
        'source' => [
            'text'  =>'Källkod', 
            'url'   =>'source',  
            'title' => 'Källkod'
        ],
    ],
 
    // Callback tracing the current selected menu item base on scriptname
    'callback' => function($url) {
        if ($url == $this->di->get('request')->getRoute()) {
            return true;
        }
    },

    // Callback to create the urls
    'create_url' => function($url) {
        return $this->di->get('url')->create($url);
    },
];
