<?php

namespace App;

/**
 * Add <body> classes
 */
add_filter( 'body_class', function ( array $classes ) {
    /** Add page slug if it doesn't exist */
    if ( is_single() || is_page() && ! is_front_page() ) {
        if ( ! in_array( basename( get_permalink() ), $classes ) ) {
            $classes[] = basename( get_permalink() );
        }
    }

    /** Add class if sidebar is active */
    if ( display_sidebar() ) {
        $classes[] = 'sidebar-primary';
    }

    /** Clean up class names for custom templates */
    $classes = array_map( function ( $class ) {
        return preg_replace( [ '/-blade(-php)?$/', '/^page-template-views/' ], '', $class );
    }, $classes );

    return array_filter( $classes );
} );

/**
 * Add "… Continued" to the excerpt
 */
add_filter( 'excerpt_more', function () {
    return '&hellip; <a href="' . get_permalink() . '" class="search-read-more">' . pll__( 'Read more' ) . '</a>';
} );

/**
 * Template Hierarchy should search for .blade.php files
 */
collect( [
    'index',
    '404',
    'archive',
    'author',
    'category',
    'tag',
    'taxonomy',
    'date',
    'home',
    'frontpage',
    'page',
    'paged',
    'search',
    'single',
    'singular',
    'attachment',
    'embed',
] )->map( function ( $type ) {
    add_filter( "{$type}_template_hierarchy", __NAMESPACE__ . '\\filter_templates' );
} );

/**
 * Render page using Blade
 */
add_filter( 'template_include', function ( $template ) {
    collect( [ 'get_header', 'wp_head' ] )->each( function ( $tag ) {
        ob_start();
        do_action( $tag );
        $output = ob_get_clean();
        remove_all_actions( $tag );
        add_action( $tag, function () use ( $output ) {
            echo $output;
        } );
    } );
    $data = collect( get_body_class() )->reduce( function ( $data, $class ) use ( $template ) {
        return apply_filters( "ihh/template/{$class}/data", $data, $template );
    }, [] );
    if ( $template ) {
        echo template( $template, $data );

        return get_stylesheet_directory() . '/index.php';
    }

    return $template;
}, PHP_INT_MAX );

/**
 * Render comments.blade.php
 */
add_filter( 'comments_template', function ( $comments_template ) {
    $comments_template = str_replace(
        [ get_stylesheet_directory(), get_template_directory() ],
        '',
        $comments_template
    );

    $data = collect( get_body_class() )->reduce( function ( $data, $class ) use ( $comments_template ) {
        return apply_filters( "ihh/template/{$class}/data", $data, $comments_template );
    }, [] );

    $theme_template = locate_template( [ "views/{$comments_template}", $comments_template ] );

    if ( $theme_template ) {
        echo template( $theme_template, $data );

        return get_stylesheet_directory() . '/index.php';
    }

    return $comments_template;
}, 100 );

/**
 * Search-form
 */
add_filter( 'get_search_form', function () {
    return template( 'searchform' );
} );

/**
 * Register local ACF-json
 */
add_filter( 'acf/settings/save_json', function () {
    return get_theme_file_path() . '/resources/acf-data';
} );

add_filter( 'acf/settings/load_json', function () {
    $paths[] = get_theme_file_path() . '/resources/acf-data';

    return $paths;
} );

/**
 * Init Twitter
 */
add_filter( 'dude-twitter-feed/oauth_consumer_key', function () {
    return get_theme_mod( 'ihh_twitter_oauth_consumer_key' );
} );
add_filter( 'dude-twitter-feed/oauth_consumer_secret', function () {
    return get_theme_mod( 'ihh_twitter_oauth_consumer_secret' );
} );
add_filter( 'dude-twitter-feed/oauth_access_token', function () {
    return get_theme_mod( 'ihh_twitter_oauth_access_token' );
} );
add_filter( 'dude-twitter-feed/oauth_access_token_secret', function () {
    return get_theme_mod( 'ihh_twitter_oauth_access_token_secret' );
} );
add_filter( 'dude-twitter-feed/user_tweets_parameters', function ( $args ) {
    $args['count']       = 6;
    $args['include_rts'] = true;

    return $args;
} );

/**
 * Mail
 */

add_filter( 'wp_mail_from', function () {
    return "no_reply@ihhelsinki.fi";
} );

add_filter( 'wp_mail_from_name', function () {
    return "International House Helsinki";
} );

/**
 * Change menu language selector to button. The pll_the_languages-function won't work on menu-dropdown widget.
 */
add_filter('wp_nav_menu_items', function($items, $args){
    if(!function_exists('pll_the_languages')){
        return $items;
    }
    if( $args->theme_location == 'primary_navigation' ){
        $from = '<a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button" href="#pll_switcher">'.pll_current_language('name').' <b class="caret"></b></a>';
        $to = '<button class="nav-link dropdown-toggle custom-language-selector" data-toggle="dropdown" aria-haspopup="true" aria-owns="language-selection-list"><span aria-hidden="true">'.pll_current_language('name').'</span><span class="ihh-visually-hidden">'.pll_current_language("name").' '.pll__('Switch language').'</span><b class="caret"></b></button>';

        $ulListFrom = '<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
        $ulListTo = '<ul id="language-selection-list" class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';

        if(strpos($items, $from) !== false){
            $items = str_replace($from, $to, $items);
        }
        if(strpos($items, $ulListFrom) !== false){
            $items = str_replace($ulListFrom, $ulListTo, $items);
        }

        return $items;
    }
    return $items;
} ,9, 2);
