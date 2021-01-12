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

// Cache key for service statuses.
CONST IHH_SERVICE_CACHE_KEY = 'service_status';

// Cache key for service status timestamp.
CONST IHH_SERVICE_CACHE_TIMESTAMP_KEY = 'ihh_last_status_cache';

// Cache valid for seconds.
CONST IHH_SERVICE_CACHE_EXPIRATION = 300;

// Status api url.
CONST IHH_SERVICE_API_URL = 'https://lt36853.loomis.fi:9090/MobileTicket/branches/1/services/wait-info/';

// Status api key in wp_options table.
CONST IHH_SERVICE_API_TOKEN_WP_OPTION_KEY = 'service_api_token';

// Add wp-cron to fetch the data every 6 minutes
function ihh_cron_schedules($schedules){
  if(!isset($schedules["five_minutes"])){
    $schedules["six_minutes"] = array(
      'interval' => 360,
      'display' => __('Once every 5 minutes'));
  }
  return $schedules;
}

add_filter('cron_schedules', 'IHH\ihh_cron_schedules');
wp_schedule_event(time(), 'six_minutes', 'my_schedule_hook', 'fetch_service_status');

// Fetch the data from api.
function fetch_service_status() {
  // Return cached if possible
  if ($data = get_transient(IHH_SERVICE_CACHE_KEY)) {
    $json = json_decode($data);
    $json['timestamp'] = get_transient(IHH_SERVICE_CACHE_TIMESTAMP_KEY);
    return $json;
  }

  // Api security token should be set to wp_options.
  if (!$token = get_option(IHH_SERVICE_API_TOKEN_WP_OPTION_KEY)) {
    return false;
  }

  $response = fetch_remote_data($token);

  if (!request_ok($response)) {
    return false;
  }

  $time = time();
  handle_cache($response, $time);
  return handle_response_data($response, $time);
}

// Actual GET request.
function fetch_remote_data($token){
  $args = [
    'headers' => [
      'auth-token' => $token
    ]
  ];
  return wp_remote_get(IHH_SERVICE_API_URL, $args);
}

// Is request valid.
function request_ok($request) {
  return !is_wp_error($request) && isset($request['response']) && $request['response']['code'] === 200;
}

// Cache fetched data.
function handle_cache($response, $time){
  $body = $response['http_response'];
  $json = $body->get_data();
  set_transient(IHH_SERVICE_CACHE_TIMESTAMP_KEY, $time);
  set_transient(IHH_SERVICE_CACHE_KEY, $json, IHH_SERVICE_CACHE_EXPIRATION);
}

// Return response
function handle_response_data($response, $time) {
  $body = $response['http_response'];
  $json = $body->get_data();
  $data = json_decode($json);
  $data['timestamp'] = $time;
  return $data;
}
