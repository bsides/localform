'use strict'
gulp = require('gulp')
$ = require('gulp-load-plugins')()
wiredep = require('wiredep')
gulp.task 'test', ->
  bowerDeps = wiredep(
    directory: 'app/bower_components'
    exclude: [ 'bootstrap-sass-official' ]
    dependencies: true
    devDependencies: true)
  testFiles = bowerDeps.js.concat([
    'app/scripts/**/*.js'
    'test/unit/**/*.js'
  ])
  gulp.src(testFiles).pipe($.karma(
    configFile: 'test/karma.conf.js'
    action: 'run')).on 'error', (err) ->
    # Make sure failed tests cause gulp to exit non-zero
    throw err
    return
