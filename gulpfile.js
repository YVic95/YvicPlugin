var gulp = require( 'gulp' );
var rename = require( 'gulp-rename' );
var sass = require( 'gulp-sass' );

var styleSRC = './src/scss/mystyle.scss';
var styleDIST = './assets/css/'
// test comment
gulp.task( 'style', function() {
  return gulp.src( styleSRC )
    .pipe( sass( {
      errorLogToConsole: true,
      outputStyle: 'compressed',
    } ) )
    .on( 'error', console.error.bind( console ) )
    .pipe( rename( { suffix: '.min' } ) )
    .pipe( gulp.dest( styleDIST ) );
});