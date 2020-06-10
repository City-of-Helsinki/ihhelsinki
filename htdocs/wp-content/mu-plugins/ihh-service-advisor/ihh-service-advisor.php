<?php
/*
Plugin Name: IHH Service Advisor
Plugin URI:  https://digia.com
Description: Service Advisor Backend
Version:     1.0
Author:      Digialist
Author URI:  https://digia.com
License:     MIT
*/

namespace IHH;

use PostTypes\PostType;
use PostTypes\Taxonomy;

require_once( dirname( __FILE__ ) . '/helpers.php' );
require_once( dirname( __FILE__ ) . '/hooks.php' );

/**
 * Questions
 */
$questions = new PostType( [
    'name'     => 'question',
    'singular' => __( 'Question', 'ihh' ),
    'plural'   => __( 'Questions', 'ihh' ),
    'slug'     => 'questions',
], [
    'supports'            => [ 'title', 'editor' ],
    'menu_position'       => 10,
    'hierarchical'        => true,
    'has_archive'         => true,
    'exclude_from_search' => true,
    'publicly_queryable'  => false,
    'show_ui'             => true,
] );

$questions->columns()->add( [
    'title'     => __( 'Question', 'ihh' ),
    'options'   => __( 'Options', 'ihh' ),
    'hide_when' => __( 'Hide When', 'ihh' ),
] );

$questions->columns()->order( [
    'options'   => 2,
    'hide_when' => 3,
] );

$questions->columns()->populate( 'options', function ( $column, $post_id ) {
    $meta = get_field( 'options', $post_id );
    echo get_labels( $meta );
} );

$questions->columns()->populate( 'hide_when', function ( $column, $post_id ) {
    $meta = get_field( 'hide', $post_id );
    echo get_labels( $meta );
} );

$questions
    ->icon( 'dashicons-megaphone' )
    ->filters( [ 'application' ] )
    ->register();

/**
 * Answers
 */
$answers = new PostType( [
    'name'     => 'answer',
    'singular' => __( 'Answer', 'ihh' ),
    'plural'   => __( 'Answers', 'ihh' ),
    'slug'     => 'answers',
], [
    'supports'            => [ 'title', 'editor' ],
    'menu_position'       => 11,
    'hierarchical'        => true,
    'has_archive'         => true,
    'exclude_from_search' => true,
    'publicly_queryable'  => false,
    'show_ui'             => true,
] );

$answers->columns()->add( [
    'title'     => __( 'Answer', 'ihh' ),
    'show_when' => __( 'Show', 'ihh' ),
    'hide_when' => __( 'Hide', 'ihh' ),
] );

$answers->columns()->order( [
    'show_when' => 2,
    'hide_when' => 3,
] );

$answers->columns()->populate( 'show_when', function ( $column, $post_id ) {
    $meta = get_field( 'show_options', $post_id );
    echo get_labels( $meta );
} );

$answers->columns()->populate( 'hide_when', function ( $column, $post_id ) {
    $meta = get_field( 'answer_hide', $post_id );
    echo get_labels( $meta );
} );

$answers
    ->icon( 'dashicons-welcome-learn-more' )
    ->filters( [ 'application', 'answer_category' ] )
    ->register();

/**
 * Taxonomy to Questions & Answers
 */
$apps = new Taxonomy( [
    'name'     => 'application',
    'singular' => __( 'Application', 'ihh' ),
    'plural'   => __( 'Applications', 'ihh' ),
    'slug'     => 'applications',
], [
    'hierarchical' => true,
] );

/**
 * Taxonomy to Answers
 */
$answer_categories = new Taxonomy( [
    'name'     => 'answer_category',
    'singular' => __( 'Category', 'ihh' ),
    'plural'   => __( 'Categories', 'ihh' ),
    'slug'     => 'categories',
], [
    'hierarchical' => true,
] );

$apps->posttype( 'question' );
$apps->posttype( 'answer' );
$apps->register();

$answer_categories->posttype( 'answer' );
$answer_categories->register();

/**
 * Options-page
 */
if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page( [
        'page_title' => __( 'SA-Settings', 'ihh' ),
        'menu_title' => __( 'SA-Settings', 'ihh' ),
        'menu_slug'  => 'sa-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
    ] );
}
