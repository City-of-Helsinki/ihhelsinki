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
        #https://lt36853.loomis.fi:9090/managementinformation/v2/branches/1/queues/
        $CACHE_KEY = 'service_status';
        $CACHE_EXPIRATION = 120;

        $API_URL = 'https://lt36853.loomis.fi:9090';
        $ENDPOINT = '/managementinformation/v2/branches/1/queues/';

        if(!$TOKEN = get_option('service_api_token')){
          //TODO: THIS IS NOT SUPPOSED TO GO TO GIT
          $TOKEN = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxx';
        }

        if($data = get_cached_service_status($CACHE_KEY)){
          return $data;
        }

        $args = [
          'headers' => [
            'auth-token' => $TOKEN
          ]
        ];

        if($data = fetch_service_status($API_URL.$ENDPOINT, $args)){
          set_cached_service_status($CACHE_KEY, json_encode($data), $CACHE_EXPIRATION);
        }

        $data = 'asd';
        return $data;

      }
    ]
  );

});


