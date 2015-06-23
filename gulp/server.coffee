proxyMiddleware = (req, res, next) ->
  if req.url.indexOf(proxyApiPrefix) != -1
    proxy.web req, res
  else
    next()
  return

browserSyncInit = (baseDir, files, browser) ->
  browser = if browser == undefined then 'default' else browser
  browserSync.instance = browserSync.init(files,
    # startPath: '/index.html'
    server:
      baseDir: baseDir
      middleware: proxyMiddleware
    browser: browser)
  return

'use strict'
gulp = require('gulp')
browserSync = require('browser-sync')
httpProxy = require('http-proxy')
connect = require('gulp-connect-php')

### This configuration allow you to configure browser sync to proxy your backend ###

proxyTarget = 'http://server/context/'
# The location of your backend
proxyApiPrefix = 'api'
# The element in the URL which differentiate between API request and static file request
proxy = httpProxy.createProxyServer(target: proxyTarget)
gulp.task 'serve', [ 'watch' ], ->
  browserSyncInit [
    'app'
    '.tmp'
  ], [
    'app/*.html'
    '.tmp/styles/**/*.css'
    '.tmp/scripts/**/*.js'
    'app/scripts/**/*.coffee'
    'app/scripts/**/*.js'
    'app/partials/**/*.html'
    'app/images/**/*'
  ]
  return

gulp.task 'php-serve', [
  'styles'
  'fonts'
], ->
  connect.server
    port: 9001
    base: 'app'
    open: false
  proxy = httpProxy.createProxyServer({})
  browserSync
    notify: false
    port: 9000
    server:
      baseDir: [
        '.tmp'
        'app'
      ]
      routes: '/bower_components': 'bower_components'
      middleware: (req, res, next) ->
        url = req.url
        if !url.match(/^\/(styles|scripts|fonts|bower_components)\//)
          proxy.web req, res, target: 'http://127.0.0.1:9001'
        else
          next()
        return
  # watch for changes
  # gulp.watch([
  #   'app/*.html'
  #   'app/*.php'
  #   'app/**/*.php'
  #   '.tmp/styles/**/*.css'
  #   'app/scripts/**/*.js'
  #   'app/images/**/*'
  #   '.tmp/fonts/**/*'
  #   'app/partials/**/*.html'
  #   'app/partials/**/*.php'
  # ]).on 'change', reload
  gulp.watch 'app/styles/**/*.scss', [ 'styles' ]
  gulp.watch 'app/fonts/**/*', [ 'fonts' ]
  gulp.watch 'app/scripts/**/*.coffee', [ 'scripts' ]
  gulp.watch 'app/scripts/**/*.js', [ 'scripts' ]
  gulp.watch 'bower.json', [
    'wiredep'
    'fonts'
  ]
  return

gulp.task 'serve:dist', [ 'build' ], ->
  browserSyncInit 'dist'
  return
gulp.task 'serve:e2e', ->
  browserSyncInit [
    'app'
    '.tmp'
  ], null, []
  return
gulp.task 'serve:e2e-dist', [ 'watch' ], ->
  browserSyncInit 'dist', null, []
  return
