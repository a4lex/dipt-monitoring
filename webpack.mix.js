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
        'resources/dist/css/ownslyle.css',
        'resources/plugins/fontawesome-free/css/all.min.css',
        'resources/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
        'resources/plugins/icheck-bootstrap/icheck-bootstrap.min.css',
        'resources/plugins/jqvmap/jqvmap.min.css',
        'resources/dist/css/adminlte.min.css',
        'resources/plugins/overlayScrollbars/css/OverlayScrollbars.min.css',
        'resources/plugins/daterangepicker/daterangepicker.css',
        'resources/plugins/datatables-bs4/css/dataTables.bootstrap4.css',
        'resources/plugins/datatables-responsive/css/responsive.bootstrap4.css',
        'resources/plugins/datatables-buttons/css/buttons.bootstrap4.css',
        'resources/plugins/select2/css/select2.min.css',
        'resources/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css',
        'resources/plugins/toastr/toastr.css',
        'resources/plugins/chart.js/Chart.min.css',
        'resources/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css',
        'resources/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css',
        'resources/plugins/bs-stepper/css/bs-stepper.min.css',
        'resources/plugins/dropzone/min/dropzone.min.css'
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
        'resources/plugins/chart.js/Chart.min.js',
        'resources/plugins/datatables/jquery.dataTables.js',
        'resources/plugins/datatables-bs4/js/dataTables.bootstrap4.js',
        'resources/plugins/datatables-responsive/js/dataTables.responsive.js',
        'resources/plugins/datatables-responsive/js/responsive.bootstrap4.js',
        'resources/plugins/datatables-buttons/js/dataTables.buttons.js',
        'resources/plugins/datatables-buttons/js/buttons.bootstrap4.js',
        'resources/plugins/jszip/jszip.js',
        'resources/plugins/pdfmake/pdfmake.js',
        'resources/plugins/pdfmake/vfs_fonts.js',
        'resources/plugins/datatables-buttons/js/buttons.html5.js',
        'resources/plugins/datatables-buttons/js/buttons.print.js',
        'resources/plugins/datatables-buttons/js/buttons.colVis.min.js',
        'resources/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js',
        'resources/plugins/inputmask/jquery.inputmask.min.js',
        'resources/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js',
        'resources/plugins/bootstrap-switch/js/bootstrap-switch.min.js',
        'resources/plugins/bs-stepper/js/bs-stepper.min.js',
        'resources/plugins/dropzone/min/dropzone.min.js'
    ], 'public/js/app.js');
