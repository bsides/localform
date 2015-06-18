'use strict'

angular.module('localform', [
  'ngAnimate'
  'ngCookies'
  'ngTouch'
  'ngSanitize'
  'firebase'
  'ngResource'
  'ngRoute'
]).config ($routeProvider) ->
  $routeProvider.when('/',
    templateUrl: 'partials/form.html'
    controller: 'MainCtrl').otherwise redirectTo: '/'
  return
