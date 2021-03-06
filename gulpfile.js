var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
  var bpath = 'node_modules/bootstrap-sass/assets';
  var jqueryPath = 'resources/assets/vendor/jquery';
  var angularPath = 'resources/assets/vendor/angular';
  var angularRoutePath = 'resources/assets/vendor/angular-route';
  var angularUiPath = 'resources/assets/vendor/angular-bootstrap';
  mix.sass('app.scss')
      .copy(jqueryPath + '/dist/jquery.min.js', 'public/js')
      .copy(bpath + '/fonts', 'public/fonts')
      .copy(bpath + '/javascripts/bootstrap.min.js', 'public/js')
      .copy(angularPath + '/angular.min.js', 'public/js')
      .copy(angularRoutePath + '/angular-route.min.js', 'public/js')
      .copy(angularUiPath + '/ui-bootstrap-tpls.min.js', 'public/js');
});
