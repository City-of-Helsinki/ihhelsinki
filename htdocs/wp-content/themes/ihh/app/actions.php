<?php

namespace App;

/**
 * @param \WP_Query $query
 *
 * @return array|mixed
 */
function create_meta_query( \WP_Query $query ) {
    $meta_query   = $query->get( 'meta_query', [] );
    $meta_query[] = [
        'relation' => 'OR',
        [
            'relation' => 'OR',
            [
                'key'     => 'end_time',
                'value'   => date( 'Y-m-d H:i:s' ),
                'compare' => '>=',
                'type'    => 'DATETIME',
            ],
            [
                'key'     => 'end_time',
                'value'   => '',
                'compare' => '==',
            ],
        ],
        [
            [
                'key'     => 'end_time',
                'compare' => 'NOT EXISTS',
                'value'   => '',
            ],
        ],
    ];

    return $meta_query;
}

/**
 * Unregister tag
 */
add_action( 'init', function () {
    unregister_taxonomy_for_object_type( 'post_tag', 'post' );
} );

/**
 * Add events to main query
 */
add_action( 'pre_get_posts', function ( \WP_Query $query ) {
    if ( $query->is_posts_page && ! $query->is_admin && $query->is_main_query() ) {
        $query->set( 'post_type', [ 'post', 'event' ] );

        $query->set( 'meta_query', create_meta_query( $query ) );
    }

    if ( $query->is_search ) {
        $query->set( 'meta_query', create_meta_query( $query ) );
    }

    return $query;
} );

/**
 * Add chat-script to head
 */
add_action( 'wp_head', function () {
    if ( ! get_theme_mod( 'ihh_hide_chat' ) ) {
        echo get_theme_mod( 'ihh_chat_script' );
    }
}, 999 );
