'use strict'
gulp = require('gulp')
$ = require('gulp-load-plugins')(pattern: [
  'gulp-*'
  'main-bower-files'
  'uglify-save-license'
])

sourcemaps = require('gulp-sourcemaps')

gulp.task 'styles', ->
  gulp.src('app/styles/main.scss').pipe($.plumber()).pipe($.sass(
    errLogToConsole: false
    onError: (err) ->
      $.notify().write err
  )).pipe($.autoprefixer('last 1 version')).pipe(gulp.dest('.tmp/styles')).pipe $.size()
gulp.task 'coffeescripts', ->
  gulp.src('app/scripts/**/*.coffee')
    .pipe(sourcemaps.init())
    .pipe($.coffee(bare: true)).on('error', -> $.util.log).on('error', -> gutil.log)
    .pipe($.sourcemaps.write())
    .pipe(gulp.dest('.tmp/scripts'))
gulp.task 'scripts', ->
  gulp.src('app/scripts/**/*.js')
    .pipe($.jshint())
    .pipe($.jshint.reporter('jshint-stylish'))
    .pipe $.size()
gulp.task 'partials', ->
  gulp.src('app/partials/**/*.html').pipe($.minifyHtml(
    empty: true
    spare: true
    quotes: true)).pipe($.ngHtml2js(
    moduleName: 'localform'
    prefix: 'partials/')).pipe(gulp.dest('.tmp/partials')).pipe $.size()
gulp.task 'html', [
  'styles'
  'coffeescripts'
  'scripts'
  'partials'
], ->
  jsFilter = $.filter('**/*.js')
  cssFilter = $.filter('**/*.css')
  gulp.src('app/*.html').pipe($.inject(gulp.src('.tmp/partials/**/*.js'),
    read: false
    starttag: '<!-- inject:partials -->'
    addRootSlash: false
    addPrefix: '../')).pipe($.useref.assets()).pipe($.rev()).pipe(jsFilter).pipe($.ngAnnotate()).pipe($.uglify(preserveComments: $.uglifySaveLicense)).pipe(jsFilter.restore()).pipe(cssFilter).pipe($.replace('bower_components/bootstrap-sass-official/vendor/assets/fonts/bootstrap', 'fonts')).pipe($.csso()).pipe(cssFilter.restore()).pipe($.useref.restore()).pipe($.useref()).pipe($.revReplace()).pipe(gulp.dest('dist')).pipe $.size()
gulp.task 'images', ->
  gulp.src('app/images/**/*').pipe($.cache($.imagemin(
    optimizationLevel: 3
    progressive: true
    interlaced: true))).pipe(gulp.dest('dist/images')).pipe $.size()
gulp.task 'fonts', ->
  gulp.src($.mainBowerFiles()).pipe($.filter('**/*.{eot,svg,ttf,woff}')).pipe($.flatten()).pipe(gulp.dest('dist/fonts')).pipe $.size()
gulp.task 'clean', ->
  gulp.src([
    '.tmp'
    'dist'
  ], read: false).pipe $.rimraf()
gulp.task 'build', [
  'html'
  'partials'
  'images'
  'fonts'
]
