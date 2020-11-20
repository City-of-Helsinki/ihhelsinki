<?php
/*
Plugin Name: IHH reservation status
Plugin URI:  https://druid.fi
Description: IHH reservation api integration
Version:     1.0
Author:      Druid Oy
Author URI:  https://druid.fi
License:     MIT
*/

namespace IHH;

require_once( dirname( __FILE__ ) . '/hooks.php' );

function fetch_service_status() {
  #https://lt36853.loomis.fi:9090/managementinformation/v2/branches/1/queues/
  $CACHE_KEY = 'service_status';
  $CACHE_EXPIRATION = 120;

  $API_URL = 'https://lt36853.loomis.fi:9090';
  $ENDPOINT = '/MobileTicket/branches/1/services/wait-info/';

  if($data = get_transient($CACHE_KEY)){
    return $data;
  }

  if(!$TOKEN = get_option('service_api_token')){
    // service api's security token has not been set to options.
    return false;
  }

  $token = 'no-tokens-in-git';
  $args = [
    'headers' => [
      'auth-token' => $token
    ]
  ];

  $data = wp_remote_get('https://lt36853.loomis.fi:9090/MobileTicket/branches/1/services/wait-info/', $args);

  if(!request_ok($data)) {
    #var_dump($data);die();
    return false;
  }
  #var_dump($data['body']);die();

  set_transient($CACHE_KEY, json_encode($data), $CACHE_EXPIRATION);

  #die('no');
  return $data;
}

function request_ok($request){
  return !is_wp_error($request) && isset($request['code']) && $request['code'] == 200;
}

