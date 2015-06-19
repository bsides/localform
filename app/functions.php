<?php
function getUserIP() {
  $client  = @$_SERVER['HTTP_CLIENT_IP'];
  $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
  $remote  = $_SERVER['REMOTE_ADDR'];

  if (filter_var($client, FILTER_VALIDATE_IP)) {
    $ip = $client;
  } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
    $ip = $forward;
  } else {
    $ip = $remote;
  }

  return $ip;
}


function getGeoByIP($ip) {
  return geoip_record_by_name($ip);
}

$visitor['ip'] = getUserIP();
$visitor['city'] = getGeoByIP($visitor['ip']) ? $visitor['city'] : 'false';
$visitor = json_encode($visitor);
echo $visitor;
?>
