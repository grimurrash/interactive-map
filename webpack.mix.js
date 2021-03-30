const mix = require('laravel-mix');
const path = require('path')
global.path = path
require('laravel-mix-alias');

mix.alias({
    '~': '/resources/js',
    '@': '/resources/sass',
});

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .vue();

mix.sourceMaps();

// if (mix.inProduction()) {
//     mix.version();
// }
// mix.browserSync(process.env.APP_URL)


