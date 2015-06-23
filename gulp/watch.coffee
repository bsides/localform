'use strict'
gulp = require('gulp')
gulp.task 'watch', [
  'wiredep'
  'styles'
], ->
  gulp.watch 'app/styles/**/*.scss', [ 'styles' ]
  gulp.watch 'app/scripts/**/*.coffee', [ 'coffeescripts' ]
  gulp.watch 'app/scripts/**/*.js', [ 'scripts' ]
  gulp.watch 'app/images/**/*', [ 'images' ]
  gulp.watch 'bower.json', [ 'wiredep' ]
  return
