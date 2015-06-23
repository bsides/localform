<?php
  header("Access-Control-Allow-Origin: *");
  header("content-type: application/json");

  if (isset($_GET['ip'])) {

    include ('functions.php');

    require_once __DIR__ . '/functions.php';

    $visitor['ip'] = isset($_GET['ip']) ? $_GET['ip'] : false;
    $locals = getGeoByIP($visitor['ip']);

    if (is_array($locals)) {
      foreach($locals as $key => $value) {
        $visitor[$key] = $value;
      }
    }
    // echo $region = geoip_region_name_by_code($visitor['country_code'], $visitor['region']);

    $visitor = json_encode($visitor, JSON_UNESCAPED_UNICODE);
    echo $visitor;

  } else {
    require_once __DIR__ . '/lib/vendor/autoload.php';

    // Register API keys at https://www.google.com/recaptcha/admin
    $siteKey = '6LdafwgTAAAAACBGZu0GTka9Kie6TPoIimMMNjTb';
    $secret = '6LdafwgTAAAAACYJST4DI_AxcAe3GPDB5EhXvtzf';

    if (isset($_POST['g-recaptcha-response'])) {
      // If the form submission includes the "g-captcha-response" field
      // Create an instance of the service using your secret
      $recaptcha = new \ReCaptcha\ReCaptcha($secret);
      // If file_get_contents() is locked down on your PHP installation to disallow
      // its use with URLs, then you can use the alternative request method instead.
      // This makes use of fsockopen() instead.
      //  $recaptcha = new \ReCaptcha\ReCaptcha($secret, new \ReCaptcha\RequestMethod\SocketPost());

      // Make the call to verify the response and also pass the user's IP address
      $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

      if ($resp->isSuccess()) {
        $r = ['response' => 'true'];
        echo json_encode($r, JSON_UNESCAPED_UNICODE);
      } else {
        foreach ($resp->getErrorCodes() as $code) {
          $r[] = $code;
        }
        echo json_encode($r, JSON_UNESCAPED_UNICODE);;
      }
    }
  }
?>
