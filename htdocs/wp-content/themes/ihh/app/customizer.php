<?php

namespace App;

/**
 * Theme customizer
 */
add_action( 'customize_register', function ( \WP_Customize_Manager $wp_customize ) {

    // Remove redundand sections
    $wp_customize->remove_section( 'colors' );
    $wp_customize->remove_section( 'custom_css' );
    $wp_customize->remove_section( 'static_front_page' );

    $wp_customize->add_section( 'ihh_content_settings', [
        'title'    => __( 'Content defaults', 'ihh' ),
        'priority' => 200,
    ] );

    $wp_customize->add_section( 'ihh_twitter_feed_settings', [
        'title'    => __( 'Twitter feed', 'ihh' ),
        'priority' => 210,
    ] );

    $wp_customize->add_section( 'ihh_footer_settings', [
        'title'    => __( 'Footer', 'ihh' ),
        'priority' => 220,
    ] );

    $wp_customize->add_section( 'ihh_chat_settings', [
        'title'    => __( 'Chat', 'ihh' ),
        'priority' => 230,
    ] );

    /**
     * Content defaults
     */
    $wp_customize->add_setting( 'ihh_default_lift_image' );
    $wp_customize->add_control( new \WP_Customize_Media_Control( $wp_customize, 'ihh_default_lift_image', [
        'label'       => pll__( 'Default lift image' ),
        'section'     => 'ihh_content_settings',
        'settings'    => 'ihh_default_lift_image',
        'description' => pll__( 'The default lift image if item does not have one.' ),
    ] ) );

    /**
     * Twitter-feed
     */
    $wp_customize->add_setting( 'ihh_twitter_username' );
    $wp_customize->add_control( 'ihh_twitter_username', [
        'type'    => 'text',
        'section' => 'ihh_twitter_feed_settings',
        'label'   => 'Twitter username',
    ] );

    $wp_customize->add_setting( 'ihh_twitter_oauth_consumer_key' );
    $wp_customize->add_control( 'ihh_twitter_oauth_consumer_key', [
        'type'        => 'text',
        'section'     => 'ihh_twitter_feed_settings',
        'label'       => 'Twitter oAuth consumer key',
        'input_attrs' => [],
    ] );

    $wp_customize->add_setting( 'ihh_twitter_oauth_consumer_secret' );
    $wp_customize->add_control( 'ihh_twitter_oauth_consumer_secret', [
        'type'        => 'password',
        'section'     => 'ihh_twitter_feed_settings',
        'label'       => 'Twitter oAuth consumer secret',
        'input_attrs' => [],
    ] );

    $wp_customize->add_setting( 'ihh_twitter_oauth_access_token' );
    $wp_customize->add_control( 'ihh_twitter_oauth_access_token', [
        'type'        => 'text',
        'section'     => 'ihh_twitter_feed_settings',
        'label'       => 'Twitter oAuth access token',
        'input_attrs' => [],
    ] );

    $wp_customize->add_setting( 'ihh_twitter_oauth_access_token_secret' );
    $wp_customize->add_control( 'ihh_twitter_oauth_access_token_secret', [
        'type'        => 'password',
        'section'     => 'ihh_twitter_feed_settings',
        'label'       => 'Twitter oAuth access token secrets',
        'input_attrs' => [],
    ] );

    /**
     * Social media
     */
    $wp_customize->add_setting( 'ihh_some_twitter' );
    $wp_customize->add_control( 'ihh_some_twitter', [
        'type'        => 'url',
        'section'     => 'ihh_footer_settings',
        'label'       => 'Twitter',
        'input_attrs' => [
            'placeholder' => 'https://twitter.com/pagename',
        ],
    ] );

    $wp_customize->add_setting( 'ihh_some_facebook' );
    $wp_customize->add_control( 'ihh_some_facebook', [
        'type'        => 'url',
        'section'     => 'ihh_footer_settings',
        'label'       => 'Facebook',
        'input_attrs' => [
            'placeholder' => 'https://facebook.com/pagename',
        ],
    ] );

    $wp_customize->add_setting( 'ihh_some_youtube' );
    $wp_customize->add_control( 'ihh_some_youtube', [
        'type'        => 'url',
        'section'     => 'ihh_footer_settings',
        'label'       => 'Youtube',
        'input_attrs' => [
            'placeholder' => 'https://youtube.com/pagename',
        ],
    ] );

    $wp_customize->add_setting( 'ihh_footer_image' );
    $wp_customize->add_control( new \WP_Customize_Media_Control( $wp_customize, 'ihh_footer_image', [
        'label'       => pll__( 'Footer image' ),
        'section'     => 'ihh_footer_settings',
        'settings'    => 'ihh_footer_image',
        'description' => pll__( 'Footer image' ),
    ] ) );

    $wp_customize->add_setting( 'ihh_footer_text' );
    $wp_customize->add_control( 'ihh_footer_text', [
        'type'        => 'textarea',
        'section'     => 'ihh_footer_settings',
        'label'       => 'Footer text',
        'input_attrs' => [],
    ] );

    $wp_customize->add_setting( 'ihh_footer_contact' );
    $wp_customize->add_control( 'ihh_footer_contact', [
        'type'        => 'textarea',
        'section'     => 'ihh_footer_settings',
        'label'       => 'Contact text',
        'input_attrs' => [],
    ] );

    $wp_customize->add_setting( 'ihh_chat_script' );
    $wp_customize->add_control( 'ihh_chat_script', [
        'type'        => 'textarea',
        'section'     => 'ihh_chat_settings',
        'label'       => 'Chat script',
        'input_attrs' => [],
    ] );

    $wp_customize->add_setting( 'ihh_hide_chat' );
    $wp_customize->add_control( 'ihh_hide_chat', [
        'type'        => 'checkbox',
        'section'     => 'ihh_chat_settings',
        'label'       => 'Hide Chat',
        'input_attrs' => [],
    ] );
} );

/**
 * Customizer JS
 */
add_action( 'customize_preview_init', function () {
    wp_enqueue_script( 'ihh/customizer.js', asset_path( 'scripts/customizer.js' ), [ 'customize-preview' ], null,
        true );
} );
