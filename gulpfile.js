var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.styles([
        'dashboard.css',
    ]);
});

elixir(function(mix) {
    mix.scripts([
        'all.js',
    ]);
});
elixir(function(mix) {
    mix.version(['css/all.css' , "js/all.js"]);
});