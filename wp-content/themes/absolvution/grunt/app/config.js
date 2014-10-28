(function() {
  require.config({
    paths: {
      'components': "../bower_components",
      'jquery': "../bower_components/jquery/dist/jquery",
      'main': "./main"
    },
    shim: {
      'jquery': {
        'exports': 'jquery'
      },
      'main': {
        'exports': 'main'
      }
    }
  });

  if (!window.requireTestMode) {
    require(['jquery', 'main'], function(main) {
      return window.console.log(main);
    });
  }

}).call(this);
