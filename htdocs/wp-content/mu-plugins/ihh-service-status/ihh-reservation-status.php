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
CONST IHH_SERVICE_TRANSLATIONS_CACHE_KEY = 'service_status_translations';

// Cache key for service status timestamp.
CONST IHH_SERVICE_CACHE_TIMESTAMP_KEY = 'ihh_last_status_cache';

// Cache valid for seconds.
CONST IHH_SERVICE_CACHE_EXPIRATION = 300;

// Status api url.
CONST IHH_SERVICE_API_URL = 'https://lt36853.loomis.fi:9090/MobileTicket/branches/1/services/wait-info';
CONST IHH_SERVICE_API_URL_FOR_NAME_TRANSLATIONS = 'https://lt36853.loomis.fi:9090/rest/entrypoint/branches/1/services';

// Status api key in wp_options table.
CONST IHH_SERVICE_API_TOKEN_WP_OPTION_KEY = 'service_api_token';

// Add wp-cron to fetch the data every 6 minutes
function ihh_cron_schedules($schedules) {
  if (!isset($schedules["five_minutes"])) {
    $schedules["six_minutes"] = array(
      'interval' => 360,
      'display' => __('Once every 6 minutes'));
  }
  return $schedules;
}

add_filter('cron_schedules', 'IHH\ihh_cron_schedules');
wp_schedule_event(time(), 'six_minutes', 'my_schedule_hook', 'fetch_service_status');

// Fetch the data from api or cache.
function fetch_service_status() {
  // Api security token should be set to wp_options.
  if (!$token = get_option(IHH_SERVICE_API_TOKEN_WP_OPTION_KEY)) {
    return false;
  }

  if(!$services = fetch_remote_data(IHH_SERVICE_API_URL, $token, IHH_SERVICE_CACHE_KEY)) {
    return false;
  }

  $time = time();
  if($translations = fetch_remote_data(IHH_SERVICE_API_URL_FOR_NAME_TRANSLATIONS, $token, IHH_SERVICE_TRANSLATIONS_CACHE_KEY)){
    $services = handle_translations($services, $translations);
    handle_service_cache($services, $time);
  } else {
    handle_service_cache($services, $time);
  }

  return $services;
  // return handle_response_data($services_response, $time);
}

// Return either cached data or fetch from api.
function fetch_remote_data($url, $token, $cache_key = false) {
  if ($cache_key && $data = get_transient(IHH_SERVICE_CACHE_KEY)) {
    $json = json_decode($data);
    $json['timestamp'] = get_transient(IHH_SERVICE_CACHE_TIMESTAMP_KEY);
    return $json;
  }

  $args = [
    'headers' => [
      'auth-token' => $token
    ]
  ];

  $response = wp_remote_get($url, $args);

  if(request_ok($response)){
    $body = $response['http_response'];
    $json = $body->get_data();
    return json_decode($json);
  }

  return false;
}

// Is request valid.
function request_ok($request) {
  return !is_wp_error($request) && isset($request['response']) && $request['response']['code'] === 200;
}

// Cache fetched data.
function handle_service_cache($data, $time) {
  $json = json_encode($data);
  set_transient(IHH_SERVICE_CACHE_TIMESTAMP_KEY, $time);
  set_transient(IHH_SERVICE_CACHE_KEY, $json, IHH_SERVICE_CACHE_EXPIRATION);
}

// Match the translated name with the service data.
function handle_translations($services, $translations){
  if(!$translations){
    return $services;
  }

  // The api returns translations in a bit extraordinary way.
  // The only common factor is the original name(serviceName).
  // Therefore string comparison must be used to figure out the correct translation.
  foreach($services as $service){
    // Use the first word of the original name
    // Otherwise strpos might not return correct value
    $name = explode(' ', $service->serviceName) ? explode(' ', $service->serviceName)[0] : $service->serviceName;
    $service_translations = array_filter($translations,
    function($translation) use ($name) {
      return ((strpos($translation->internalName, $name) !== false) && (strpos($translation->internalName, '-EN') !== false));
    });

    if(!empty($service_translations)){
      if(reset($service_translations)){
        $service->serviceName = reset($service_translations)->externalName;
      }
    }
  }
  return $services;
}
