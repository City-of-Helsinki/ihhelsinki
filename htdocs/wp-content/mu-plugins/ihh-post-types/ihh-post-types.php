<?php
/*
Plugin Name: IHH Post Types
Plugin URI:  https://digia.com
Description: Generate post types used in theme
Version:     1.0
Author:      Digialist
Author URI:  https://digia.com
License:     MIT
*/

namespace IHH;

use PostTypes\PostType;

/**
 * Notifications
 */
$notifications = new PostType( [
	'name'     => 'notification',
	'singular' => __( 'Notification', 'ihh' ),
	'plural'   => __( 'Notifications', 'ihh' ),
	'slug'     => 'notifications',
], [
	'supports'            => [ 'title', 'editor' ],
	'menu_position'       => 5,
	'has_archive'         => false,
	'exclude_from_search' => true,
	'publicly_queryable'  => false,
] );

$notifications->icon( 'dashicons-warning' );
$notifications->register();

/**
 * Events
 */
$events = new PostType( [
	'name'     => 'event',
	'singular' => __( 'Event', 'ihh' ),
	'plural'   => __( 'Events', 'ihh' ),
	'slug'     => 'events',
], [
	'supports'      => [ 'title', 'editor', 'thumbnail' ],
	'menu_position' => 6,
	'has_archive'   => false,
	'rewrite'       => [
		'with_front' => false,
	],
] );

$events->icon( 'dashicons-calendar-alt' );
$events->register();

/**
 * Services
 */
$services = new PostType( [
	'name'     => 'service',
	'singular' => __( 'Service', 'ihh' ),
	'plural'   => __( 'Services', 'ihh' ),
	'slug'     => 'services',
], [
	'supports'      => [ 'title', 'editor', 'thumbnail' ],
	'menu_position' => 7,
	'hierarchical'  => true,
	'has_archive'   => false,
	'rewrite'       => [
		'with_front' => false,
	],
] );

$services->icon( 'dashicons-edit' );
$services->register();