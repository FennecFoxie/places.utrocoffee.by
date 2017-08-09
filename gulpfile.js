//gulpfile.js

var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');

var autoprefixerOptions = {
  browsers: ['last 2 versions', '> 0.05%', 'Firefox ESR Safari']
};


//style paths
var sassFiles = 'assets/styles/sass/**/*.scss',
    cssDest = 'assets/styles/css/';

gulp.task('styles', function(){
    gulp.src(sassFiles)
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer(autoprefixerOptions))
        .pipe(gulp.dest(cssDest));
});

// gulp.task('prefix', () =>
//     gulp.src(cssDest)
//         .pipe(autoprefixer({
//             browsers: ['last 2 versions'],
//             cascade: false
//         }))
//         .pipe(gulp.dest(cssDest))
// );

gulp.task('watch',function() {
    gulp.watch(sassFiles,['styles']);
});
