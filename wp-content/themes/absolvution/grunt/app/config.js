(function() {
  require.config({
    paths: {
      'components': "../bower_components",
      'jquery': "../bower_components/jquery/dist/jquery",
      'jquery.waypoints': "../bower_components/jquery-waypoints/waypoints.min",
      'main': "./main"
    },
    shim: {
      'jquery': {
        'exports': 'jquery'
      },
      'main': {
        'exports': 'main'
      },
      'jquery.waypoints': {
        'deps': ['jquery']
      }
    }
  });

  if (!window.requireTestMode) {
    require(['jquery', 'jquery.waypoints', 'main'], function(main) {
      return window.console.log(main);
    });
  }

}).call(this);
