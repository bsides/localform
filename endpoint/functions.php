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

function getUserIPFromIpify() {
  return file_get_contents('https://api.ipify.org') ? : "false";
}
function getGeoByIP($ip) {
  $records = geoip_record_by_name($ip);

  // Gotta return this as UTF-8
  if (is_array($records)) {
    foreach ($records as $recordName => $recordValue) {
      $records[$recordName] = utf8_encode($recordValue);
    }
    if (isset($records['region']) && isset($records['country_code'])) {
      if ($records['region'] != false && $records['country_code'] != false)
        $records['region'] = geoip_region_name_by_code($records['country_code'], $records['region']);
    }
    return $records;
  } else {
    return false;
  }
}

// function getUserIPFromExternal() {
//   $ch = curl_init('http://www.whatsmyip.org/');
//   curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//   $html = curl_exec($ch);

//   // Suppress annoying warnings from malformed html
//   libxml_use_internal_errors(true);
//   $dom = new DOMDocument;
//   $dom->loadHTML($html);
//   libxml_clear_errors();

//   // This is the node id in whatsmyip.org that we want
//   $ip = $dom->getElementById('ip');
//   return $ip->nodeValue ? : 'false';
// }

?>
