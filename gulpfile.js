//GULP
const {src,dest,watch} = require('gulp');

//SASS
const sass = require('gulp-sass')(require('sass'));

//Errores
const plumber = require('gulp-plumber');

//Sourcemaps
const sourcemaps = require('gulp-sourcemaps');

//Performance
const postcss = require('gulp-postcss');
const cssnano = require('cssnano');

//Imagenes
const webp = require('gulp-webp');
const imagemin = require('gulp-imagemin');
const autoprefixer = require('autoprefixer');

//JS
const terser = require('gulp-terser-js');
const concat = require('gulp-concat');

//PATH
const paths = {
    scss: 'src/scss/**/*.scss',
    js: 'src/js/*.js',
    imagenes: 'src/img/**/*'
}

function SassToCss() {
    return src(paths.scss)
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(plumber())
        .pipe(postcss([autoprefixer(),cssnano()]))
        // .pipe(postcss([autoprefixer()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./public/build/css'));
}

function toolwebp() {
    return src(paths.imagenes)
        .pipe(webp({quality : 50}))
        .pipe(dest('./public/build/img'))
}

function minimg() {
    return src(paths.imagenes)
        .pipe(imagemin({optimizationLevel: 3}))
        .pipe(dest('./public/build/img'));
}

function minterser() {
    return src(paths.js)
        .pipe(sourcemaps.init())
        .pipe(concat('bundle.js'))
        .pipe(terser())
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./public/build/js'));
}

function watchf() {
    watch(paths.scss,SassToCss);
    watch(paths.js,minterser);
}

module.exports = {watchf,SassToCss,toolwebp,minimg,minterser};

