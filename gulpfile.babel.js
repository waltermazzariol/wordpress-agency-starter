import webpack from 'webpack-stream';
import { src, dest, watch, series, parallel } from 'gulp';
import browserSync from "browser-sync";
import replace from "gulp-replace";
import zip from "gulp-zip";
import info from "./package.json";
import wpPot from "gulp-wp-pot";
import del from 'del';
import imagemin from 'gulp-imagemin';
import yargs from 'yargs';
import cleanCss from 'gulp-clean-css';
import gulpif from 'gulp-if';
import postcss from 'gulp-postcss';
import sourcemaps from 'gulp-sourcemaps';
import autoprefixer from 'autoprefixer';
import concat from 'gulp-concat';
import purgecss from '@fullhuman/postcss-purgecss';

const sassCompiler = require('sass');
const sass = require('gulp-sass')(sassCompiler);

// Sass options for modern API - silence deprecations from Bootstrap and legacy code
const sassOptions = {
  silenceDeprecations: ['legacy-js-api', 'import', 'global-builtin', 'color-functions'],
  quietDeps: true,
  logger: sassCompiler.Logger.silent
};
const PRODUCTION = yargs.argv.prod;
const server = browserSync.create();
console.log('Production mode:', PRODUCTION);

// PurgeCSS configuration for WordPress
const purgecssConfig = {
  content: [
    './**/*.php',
    './src/**/*.js',
  ],
  safelist: {
    standard: [
      // WordPress core classes
      /^wp-/,
      /^admin-bar/,
      /^logged-in/,
      /^screen-reader/,
      /^alignwide/,
      /^alignfull/,
      /^has-/,
      /^is-/,
      // Bootstrap classes that may be dynamically added
      /^modal/,
      /^carousel/,
      /^collapse/,
      /^collapsing/,
      /^show/,
      /^fade/,
      /^dropdown/,
      /^navbar/,
      /^nav-/,
      /^active/,
      /^disabled/,
      /^visually-hidden/,
      // Custom dynamic classes
      /^animate/,
      /^entry-/,
      /^widget/,
      /^loading/,
      /^filter-btn/,
      /^category-filters/,
      // Contact Form 7
      /^wpcf7/,
      // Instagram Stories share
      /^ig-share-modal/,
      /^share-instagram-btn/,
    ],
    deep: [
      /modal/,
      /tooltip/,
      /popover/,
    ],
    greedy: []
  },
  defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || []
};

export const serve = done => {
  server.init({
    proxy: "http://waltermazzariolcom.local/"
  });
  done();
};

export const reload = done => {
  server.reload();
  done();
};

export const stylesDev = () => {
  return src('src/scss/bundle.scss')
    .pipe(sourcemaps.init())
    .pipe(sass(sassOptions).on('error', sass.logError))
    .pipe(postcss([autoprefixer]))
    .pipe(sourcemaps.write())
    .pipe(dest('dist/css'))
    .pipe(browserSync.stream());
}

export const stylesProd = () => {
  const plugins = [
    autoprefixer,
    purgecss(purgecssConfig)
  ];

  return src('src/scss/bundle.scss')
    .pipe(sass(sassOptions).on('error', sass.logError))
    .pipe(postcss(plugins))
    .pipe(cleanCss({
      compatibility: 'ie11',
      level: {
        1: {
          specialComments: 0
        },
        2: {
          mergeMedia: true,
          removeEmpty: true,
          removeDuplicateFontRules: true,
          removeDuplicateMediaBlocks: true,
          removeDuplicateRules: true
        }
      }
    }))
    .pipe(dest('dist/css'))
    .pipe(browserSync.stream());
}

// Page-specific scripts that should NOT be concatenated into bundle.js
const standaloneScripts = [
  'src/assets/js/category-filter.js',
  'src/assets/js/front-page.js',
  'src/assets/js/blog-filter.js',
  'src/assets/js/instagram-share.js'
];

export const watchForChanges = () => {
  watch('src/scss/**/*.scss', series(stylesDev, reload));
  watch('src/assets/**/*.{jpg,jpeg,png,svg,gif}', series(images, reload));
  watch(['src/**/*', '!src/{images,js,scss}', '!src/{images,js,scss}/**/*'], series(copy, reload));
  watch(standaloneScripts, series(pageScripts, reload));
  watch(['src/assets/js/**/*.js', ...standaloneScripts.map(s => '!' + s)], series(scriptsConcat, reload));
  watch("**/*.php", reload);
}

export const images = () => {
  return src('src/assets/**/*.{jpg,jpeg,png,svg,gif}')
    .pipe(gulpif(PRODUCTION, imagemin([
      imagemin.mozjpeg({ quality: 80, progressive: true }),
      imagemin.optipng({ optimizationLevel: 5 }),
      imagemin.svgo({
        plugins: [
          { name: 'removeViewBox', active: false },
          { name: 'cleanupIDs', active: false }
        ]
      })
    ])))
    .pipe(dest('dist/images'));
}

export const copy = () => {
  return src(['src/**/*', '!src/{images,js,scss}', '!src/{images,js,scss}/**/*'])
    .pipe(dest('dist'));
}

export const clean = () => del(['dist']);

// Webpack configuration for proper JS bundling
const webpackConfig = {
  mode: PRODUCTION ? 'production' : 'development',
  devtool: PRODUCTION ? false : 'source-map',
  entry: {
    bundle: './src/assets/js/main.js'
  },
  output: {
    filename: '[name].js'
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env']
          }
        }
      }
    ]
  },
  externals: {
    jquery: 'jQuery'
  }
};

export const scripts = () => {
  return src('src/assets/js/main.js')
    .pipe(webpack(webpackConfig))
    .pipe(dest('dist/js'))
    .pipe(browserSync.stream());
}

// Fallback concat-based script bundling if no main.js exists
export const scriptsConcat = () => {
  return src([
    'src/assets/js/*',
    ...standaloneScripts.map(s => '!' + s)
  ])
    .pipe(sourcemaps.init())
    .pipe(concat('bundle.js'))
    .pipe(sourcemaps.write('./'))
    .pipe(dest('dist/js'))
    .pipe(browserSync.stream());
}

// Copy page-specific scripts separately (not bundled)
export const pageScripts = () => {
  return src(standaloneScripts, { allowEmpty: true })
    .pipe(dest('dist/js'))
    .pipe(browserSync.stream());
}

export const compress = () => {
  return src([
    "**/*",
    "!node_modules{,/**}",
    "!bundled{,/**}",
    "!src{,/**}",
    "!.babelrc",
    "!.gitignore",
    "!gulpfile.babel.js",
    "!package.json",
    "!package-lock.json",
  ])
    .pipe(replace("_themename", info.name))
    .pipe(zip(`${info.name}.zip`))
    .pipe(dest('bundled'));
};

export const pot = () => {
  return src("**/*.php")
    .pipe(
      wpPot({
        domain: "_themename",
        package: info.name
      })
    )
    .pipe(dest(`languages/${info.name}.pot`));
};

export const dev = series(clean, parallel(stylesDev, images, copy, scriptsConcat, pageScripts), serve, watchForChanges);
export const build = series(clean, parallel(stylesProd, images, copy, scriptsConcat, pageScripts), pot, compress);
export default dev;
