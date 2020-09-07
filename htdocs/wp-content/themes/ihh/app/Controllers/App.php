<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class App extends Controller {

    /**
     * @return string|void
     */
    public function siteName() {
        return get_bloginfo( 'name' );
    }

    /**
     * @return \WP_Query
     */
    public static function notifications() {
        return new \WP_Query( [
            'post_type'  => 'notification',
            'meta_query' => [
                [
                    'key'     => 'expiry_date',
                    'value'   => date( 'Y-m-d H:i:s' ),
                    'compare' => '>=',
                    'type'    => 'DATETIME',
                ],
            ],
        ] );
    }

    /**
     * @return \WP_Query
     */
    public static function services() {
        return new \WP_Query( [
            'post_type'      => 'service',
            'posts_per_page' => - 1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ] );
    }

    /**
     * @return array|bool|mixed|object|void
     */
    public static function tweets() {
        return dude_twitter_feed()->get_user_tweets( get_theme_mod( 'ihh_twitter_username' ) );
    }

    /**
     * @return array|bool|mixed|object|void
     */
    public static function tweet_info() {
        return dude_twitter_feed()->get_user_info( get_theme_mod( 'ihh_twitter_username' ) );
    }

    /**
     * @return string|void
     */
    public static function title() {
        if ( is_home() ) {
            if ( $home = get_option( 'page_for_posts', true ) ) {
                return get_the_title( $home );
            }

            return pll__( 'Latest Posts' );
        }
        if ( is_archive() ) {
            return get_the_archive_title();
        }
        if ( is_search() ) {
            return pll__( 'Search' );
        }
        if ( is_404() ) {
            return pll__( 'Not found' );
        }

        return get_the_title();
    }

    public static function service_status(){
        return get_cached_service_status('service_status');
    }

}
