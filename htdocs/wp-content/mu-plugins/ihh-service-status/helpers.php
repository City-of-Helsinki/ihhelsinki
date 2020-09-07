<?php

namespace IHH;

function request_ok($request){
  return !is_wp_error($request) && isset($request['code']) && $request['code'] == 200;
}

function get_cached_service_status($key = '') {
  return get_transient($key);
}

function set_cached_service_status($key, $data, $expiration){
  set_transient($key, $data, $expiration);
}

