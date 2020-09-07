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
require_once( dirname( __FILE__ ) . '/helpers.php' );

function fetch_service_status($url, $args) {
  $externalData = wp_remote_get($url, $args);

  if(!request_ok($externalData)) {
    return false;
  }
  return $externalData['body'];
}
