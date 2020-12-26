const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
let productionSourceMaps = true;

mix
    // .js(['resources/js/app.js', 'resources/dist/js/adminlte.js'], 'public/js')
    // .sass('resources/sass/app.scss', 'public/css')
    // .styles('resources/dist/css/adminlte.css', 'public/css/app.css')
    .sourceMaps(productionSourceMaps, 'source-map')
    .styles([
        'resources/dist/css/ownstyle.css',
        'resources/plugins/fontawesome-free/css/all.min.css',
        'resources/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
        'resources/plugins/icheck-bootstrap/icheck-bootstrap.min.css',
        'resources/plugins/jqvmap/jqvmap.min.css',
        'resources/dist/css/adminlte.min.css',
        'resources/plugins/overlayScrollbars/css/OverlayScrollbars.min.css',
        'resources/plugins/daterangepicker/daterangepicker.css',
        'resources/plugins/datatables-bs4/css/dataTables.bootstrap4.css',
        'resources/plugins/select2/css/select2.min.css',
        'resources/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css',
        'resources/plugins/toastr/toastr.css',
        'resources/plugins/chart.js/Chart.min.css'
    ], 'public/css/app.css')
    .scripts([
        'resources/plugins/jquery/jquery.min.js',
        'resources/plugins/jquery-ui/jquery-ui.min.js',
        'resources/plugins/bootstrap/js/bootstrap.bundle.min.js',
        'resources/plugins/moment/moment.min.js',
        'resources/plugins/daterangepicker/daterangepicker.js',
        'resources/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
        'resources/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js',
        'resources/plugins/select2/js/select2.full.min.js',
        'resources/plugins/toastr/toastr.min.js',
        'resources/dist/js/adminlte.js',
        'resources/plugins/chart.js/Chart.min.js'
    ], 'public/js/app.js');

