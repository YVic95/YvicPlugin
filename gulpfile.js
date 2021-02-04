var gulp = require( 'gulp' );
var rename = require( 'gulp-rename' );
var sass = require( 'gulp-sass' );
var sourcemaps = require('gulp-sourcemaps');

var styleSRC = './src/scss/mystyle.scss';
var styleDIST = './assets/css/';
var styleWatch = './src/scss/**/*.scss';

var jsSRC = './src/js/myscript.js';
var jsDIST = './assets/js/';
var jsWatch = './src/js/**/*.js';

gulp.task( 'style', function() {
  return gulp.src( styleSRC )
    .pipe( sourcemaps.init() )
    .pipe( sass( {
      errorLogToConsole: true,
      outputStyle: 'compressed',
    } ) )
    .on( 'error', console.error.bind( console ) )
    .pipe( rename( { suffix: '.min' } ) )
    .pipe( sourcemaps.write( './' ) )
    .pipe( gulp.dest( styleDIST ) );
});

gulp.task( 'js', function() {
  return gulp.src( jsSRC )
    .pipe( gulp.dest( jsDIST ) );
} );

gulp.task( 'default', gulp.series( 'style', 'js' ) );

gulp.task( 'watch', function() {
  gulp.watch( styleWatch, gulp.series('style') );
  gulp.watch( jsWatch, gulp.series('js') );
} );