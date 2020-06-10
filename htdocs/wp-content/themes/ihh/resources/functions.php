<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Helper function for prettying up errors
 *
 * @param string $mesihh
 * @param string $subtitle
 * @param string $title
 */
$ihh_error = function ( $mesihh, $subtitle = '', $title = '' ) {
    $title  = $title ?: pll__( 'IHH &rsaquo; Error' );
    $footer = '<a href="https://roots.io/sage/docs/">roots.io/ihh/docs/</a>';
    $mesihh = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$mesihh}</p><p>{$footer}</p>";
    wp_die( $mesihh, $title );
};

/**
 * Ensure compatible version of PHP is used
 */
if ( version_compare( '7.1', phpversion(), '>=' ) ) {
    $ihh_error( __( 'You must be using PHP 7.1 or greater.', 'ihh' ), __( 'Invalid PHP version', 'ihh' ) );
}

/**
 * Ensure compatible version of WordPress is used
 */
if ( version_compare( '4.7.0', get_bloginfo( 'version' ), '>=' ) ) {
    $ihh_error( __( 'You must be using WordPress 4.7.0 or greater.', 'ihh' ), __( 'Invalid WordPress version', 'ihh' ) );
}

/**
 * Ensure dependencies are loaded
 */
if ( ! class_exists( 'Roots\\Sage\\Container' ) ) {
    if ( ! file_exists( $composer = __DIR__ . '/../vendor/autoload.php' ) ) {
        $ihh_error(
            __( 'You must run <code>composer install</code> from the Sage directory.', 'ihh' ),
            __( 'Autoloader not found.', 'ihh' )
        );
    }
    require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map( function ( $file ) use ( $ihh_error ) {
    $file = "../app/{$file}.php";
    if ( ! locate_template( $file, true, true ) ) {
        $ihh_error( sprintf( __( 'Error locating <code>%s</code> for inclusion.', 'ihh' ), $file ), 'File not found' );
    }
}, [
    'helpers',
    'setup',
    'filters',
    'admin',
    'actions',
    'walker',
    'customizer',
] );

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/ihh/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/ihh/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/ihh/resources
 *
 * We do this so that the Template Hierarchy will look in themes/ihh/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/ihh/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/ihh/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/ihh/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/ihh/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/ihh/resources
 */
array_map(
    'add_filter',
    [ 'theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri' ],
    array_fill( 0, 4, 'dirname' )
);
Container::getInstance()
         ->bindIf( 'config', function () {
             return new Config( [
                 'assets' => require dirname( __DIR__ ) . '/config/assets.php',
                 'theme'  => require dirname( __DIR__ ) . '/config/theme.php',
                 'view'   => require dirname( __DIR__ ) . '/config/view.php',
             ] );
         }, true );
