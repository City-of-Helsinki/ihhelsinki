<?php

namespace IHH;

add_action( 'rest_api_init', function() {

  /**
   * GET /reservation/v1/status
   *
   * Get the question array with options etc.
   */
  register_rest_route( 'reservation/v1', '/status', [
      'methods'  => 'GET',
      'callback' => function ( \WP_REST_Request $request ) {
        return get_service_status();
      }
    ]
  );

});


