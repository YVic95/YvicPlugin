var gulp = require( 'gulp' );
var rename = require( 'gulp-rename' );
var sass = require( 'gulp-sass' );
var sourcemaps = require('gulp-sourcemaps');
var browserify = require( 'browserify' );
var babelify = require( 'babelify' );
var source = require( 'vinyl-source-stream' );
var buffer = require( 'vinyl-buffer' );
var uglify = require( 'gulp-uglify' );

var styleSRC = './src/scss/mystyle.scss';
var styleDIST = './assets/css/';
var styleWatch = './src/scss/**/*.scss';

var jsSRC = 'myscript.js';
var jsFolder = './src/js/';
var jsDIST = './assets/js/';
var jsWatch = './src/js/**/*.js';
var jsFILES = [jsSRC];

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

gulp.task( 'js', async function() {
  // return gulp.src( jsSRC )
    //.pipe( gulp.dest( jsDIST ) );
    jsFILES.map( function( entry ) {
    browserify( {
      entries: [jsFolder + entry]
    } )
    .transform( babelify, {presets: ["@babel/preset-env"]} )
    .bundle()
    .pipe( source( entry ) )
    .pipe( rename( { extname: '.min.js' } ) )
    .pipe( buffer() )
    .pipe( sourcemaps.init( { loadMaps: true } ) )
    .pipe( uglify() )
    .pipe( sourcemaps.write( './' ) )
    .pipe( gulp.dest( jsDIST ) )

  } )
} );

gulp.task( 'default', gulp.series( 'style', 'js' ) );

gulp.task( 'watch', function() {
  gulp.watch( styleWatch, gulp.series('style') );
  gulp.watch( jsWatch, gulp.series('js') );
} );