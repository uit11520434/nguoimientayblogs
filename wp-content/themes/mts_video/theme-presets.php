<?php
// make sure to not include translations
$args['presets']['default'] = array(
    'title' => 'Default',
    'demo' => 'http://demo.mythemeshop.com/video/',
    'thumbnail' => get_template_directory_uri().'/options/demo-importer/demo-files/default/thumb.jpg',
    'menus' => array( 'secondary-menu' => 'Primary Menu', 'footer-menu' => 'Footer Menu' ),
);
$args['presets']['learning'] = array(
    'title' => 'Learning',
    'demo' => 'http://demo.mythemeshop.com/video-learning/',
    'thumbnail' => get_template_directory_uri().'/options/demo-importer/demo-files/learning/thumb.jpg',
    'menus' => array( 'secondary-menu' => 'Primary Menu' ),
);
$args['presets']['beauty'] = array(
    'title' => 'Beauty',
    'demo' => 'http://demo.mythemeshop.com/video-beauty/',
    'thumbnail' => get_template_directory_uri().'/options/demo-importer/demo-files/beauty/thumb.jpg',
    'menus' => array( 'secondary-menu' => 'Primary Menu', 'footer-menu' => 'Footer Menu' ),
);
$args['presets']['health'] = array(
    'title' => 'Health',
    'demo' => 'http://demo.mythemeshop.com/video-health/',
    'thumbnail' => get_template_directory_uri().'/options/demo-importer/demo-files/health/thumb.jpg',
    'menus' => array( 'secondary-menu' => 'Primary Menu', 'footer-menu' => 'Footer Menu' ),
);
global $mts_presets;
$mts_presets = $args['presets'];