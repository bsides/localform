proxyMiddleware = (req, res, next) ->
  if req.url.indexOf(proxyApiPrefix) != -1
    proxy.web req, res
  else
    next()
  return

browserSyncInit = (baseDir, files, browser) ->
  browser = if browser == undefined then 'default' else browser
  browserSync.instance = browserSync.init(files,
    startPath: '/index.html'
    server:
      baseDir: baseDir
      middleware: proxyMiddleware
    browser: browser)
  return

'use strict'
gulp = require('gulp')
browserSync = require('browser-sync')
httpProxy = require('http-proxy')

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
    'app/scripts/**/*.js'
    'app/partials/**/*.html'
    'app/images/**/*'
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
