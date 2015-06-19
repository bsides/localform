<!doctype html>
<html class="no-js" ng-app="localform">
  <head>
    <meta charset="utf-8">
    <title>localform</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <!-- build:css({.tmp,app}) styles/main.css -->
    <link rel="stylesheet" href="styles/main.css">
    <!-- endbuild -->

    <!-- build:js scripts/modernizr.js -->
    <script src="bower_components/modernizr/modernizr.js"></script>
    <!-- endbuild -->
  </head>
  <body>
    <?php include('functions.php') ?>
    <script>
      window.theIP = <?php echo empty($user_ip) ? 'false' : $user_ip; ?>;
    </script>
    <!--[if lt IE 10]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <div ng-view></div>

    <div class="container">
    <div class="row">
    <div class="col-md-12">

    </div>
    </div>
    </div>

    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    <script>
      (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
      function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
      e=o.createElement(i);r=o.getElementsByTagName(i)[0];
      e.src='//www.google-analytics.com/analytics.js';
      r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
      ga('create','UA-XXXXX-X');ga('send','pageview');
    </script>

    <!-- build:js scripts/vendor.js -->
    <!-- bower:js -->
    <script src="bower_components/jquery/dist/jquery.js"></script>
    <script src="bower_components/angular/angular.js"></script>
    <script src="bower_components/angular-animate/angular-animate.js"></script>
    <script src="bower_components/angular-cookies/angular-cookies.js"></script>
    <script src="bower_components/angular-touch/angular-touch.js"></script>
    <script src="bower_components/angular-sanitize/angular-sanitize.js"></script>
    <script src="bower_components/angular-resource/angular-resource.js"></script>
    <script src="bower_components/angular-route/angular-route.js"></script>
    <script src="bower_components/firebase/firebase.js"></script>
    <script src="bower_components/firebase-simple-login/firebase-simple-login.js"></script>
    <script src="bower_components/mockfirebase/dist/mockfirebase.js"></script>
    <script src="bower_components/angularfire/dist/angularfire.min.js"></script>
    <!-- endbower -->
    <!-- endbuild -->

    <!-- build:js({app,.tmp}) scripts/main.js -->
    <script src="scripts/localform.js"></script>
    <script src="scripts/main/main-ctrl.js"></script>
    <!-- inject:partials -->
    <!-- endinject -->
    <!-- endbuild -->

  </body>
</html>
