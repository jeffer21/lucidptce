var gulp = require('gulp');
var livereload = require('gulp-livereload');
var uglify = require('gulp-uglifyjs');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');

// var imagemin = require('gulp-imagemin');
// var pngquant = require('imagemin-pngquant');

// gulp.task('imagemin', function () {
//     return gulp.src('images/*')
//         .pipe(imagemin({
//             progressive: true,
//             svgoPlugins: [{removeViewBox: false}],
//             use: [pngquant()]
//         }))
//         .pipe(gulp.dest('./images'));
// });
gulp.task('default', function(){
	console.log('hi');
})

//  gulp.task('connect', function(){
//   connect.server({
//     root: '_root',
//     livereload: true
//   });
// });

// gulp.task('html', function () {
//   gulp.src('app/*.html')
//     .pipe(livereload());
// });

gulp.task('sass', function () {
  gulp.src('./sass/**/*.scss')
    .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 7', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
    .pipe(sourcemaps.write(''))
    .pipe(gulp.dest('_root/'))
    .pipe(livereload());
});


// gulp.task('uglify', function() {
//   gulp.src('./lib/*.js')
//     .pipe(uglify('main.min.js'))
//     .pipe(gulp.dest('js/'))
// });

gulp.task('watch', function(){

    var server = livereload();
    livereload.listen();

    gulp.watch('./sass/**/*.scss', ['sass']);
    // gulp.watch('./lib/*.js', ['uglify']);
    // gulp.watch(['./app/*.html'], ['html']);
    // gulp.watch(['css.css', 'js/*.js'], function (files){
    gulp.watch(['style.css'], function (files){
        livereload.changed(files)
    });
});

// gulp.task('default', ['connect', 'watch', 'sass', 'uglify']);
gulp.task('default', ['watch', 'sass']);
