### global Firebase ###

'use strict'
angular.module('localform').controller 'MainCtrl', ($scope, $firebase, $http, vcRecaptchaService) ->
  # Firebase
  # now we can use $firebase to synchronize data between clients and the server!
  ref = new Firebase('https://localform.firebaseio.com/')
  sync = $firebase(ref).$asArray()

  # Start by defining
  $scope.showform = false
  $scope.showdialog = false
  $scope.showoptions = true
  $scope.visitor = {}

  # Handling IP and GeoIP stuff
  $scope.Ipify = $http.get('https://api.ipify.org/?format=json')
    .success (data) ->
      $scope.ip = data.ip
      $scope.visitor.ip = $scope.ip
      $scope.Endpoint = $http.get('//local.dev/endpoint/?ip=' + $scope.ip)
        .success (data) ->
          $scope.local = data
          $scope.visitor.region = $scope.local.region
          $scope.visitor.city = $scope.local.city
          return
      return

  # Captcha validation
  $scope.response = null
  $scope.widgetId = null
  $scope.model =
    key: '6LdafwgTAAAAACBGZu0GTka9Kie6TPoIimMMNjTb'

  $scope.setResponse = (response) ->
    $scope.response = response

  $scope.setWidgetId = (widgetId) ->
    $scope.widgetId = widgetId

  $scope.register = ->
    valid = undefined

    ###*
    # SERVER SIDE VALIDATION
    #
    # You need to implement your server side validation here.
    # Send the reCaptcha response to the server and use some of the server side APIs to validate it
    # See https://developers.google.com/recaptcha/docs/verify
    ###

    urlValidateCaptcha = '//local.dev/endpoint/recaptcha/'
    result = $http.post(urlValidateCaptcha).success((data, status) ->
      # this callback will be called asynchronously
      # when the response is available
      # console.log 'status: ' + status
      # console.log 'sending the captcha response to the server', $scope.response
      if status is 200
        valid = true
        # console.log 'Success'
        $scope.visitor.timestamp = Firebase.ServerValue.TIMESTAMP
        sync.$add($scope.visitor)
        $scope.showdialog = true
        $scope.showform = false
        $scope.hidesubmit = true
    ).error (data, status) ->
      # called asynchronously if an error occurs
      # or server returns response with an error status.
      # console.log 'Failed validation'
      # In case of a failed validation you need to reload the captcha
      # because each response can be checked just once
      vcRecaptchaService.reload $scope.widgetId
      $scope.showdialog = false
      $scope.showform = true

    valid

