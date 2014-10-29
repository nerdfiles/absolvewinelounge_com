(function() {
  (function($) {
    var $search, $vcalendar, aw, i, recentTweets$, s, tHref, twitterHref, twitterTime$, w, __, _i, _ref;
    $("body").attr('jquery-version', $.fn.jquery);
    __ = function(obj) {
      window.console.log(obj);
    };
    $search = $('#s');
    $search.attr('placeholder', 'Find something new');
    recentTweets$ = $('.home--recent-tweets');
    twitterTime$ = recentTweets$.find('.twitter_time');
    twitterHref = twitterTime$.attr('href');
    tHref = twitterHref.split('/');
    window.console.log(tHref);
    s = '';
    for (i = _i = 0, _ref = tHref.length; 0 <= _ref ? _i <= _ref : _i >= _ref; i = 0 <= _ref ? ++_i : --_i) {
      if (i < 4 && i > 2) {
        s += tHref[i];
      }
    }
    recentTweets$.find('.widgettitle').after("<div class='byline'>\n  Follow \n  <a href='https://twitter.com/" + s + "'>\n<span class='handler-symbol'>@</span><span class='label'>" + s + "</span>\n  </a> on <a class=\"source\" href=\"https://twitter.com/\">Twitter</a>\n</div>");
    $('.site-footer').waypoint(function(direction) {
      var infoHours$, infoLocation$;
      infoLocation$ = $('.info--location > div');
      infoHours$ = $('.info--hours > div');
      if (direction === 'down') {
        infoLocation$.addClass('flip-x-in').addClass('animated');
        return infoHours$.addClass('flip-x-in').addClass('animated');
      } else {
        infoLocation$.removeClass('animated').removeClass('flip-x-in');
        return infoHours$.removeClass('animated').removeClass('flip-x-in');
      }
    }, {
      offset: '75%'
    });
    w = $(".tribe-events-list-widget-events").css('width');
    $vcalendar = $('body.home .vcalendar');
    aw = parseInt(w) + 10;
    $vcalendar.css('margin-top', '-' + aw + 'px');
    $(".tribe-events-list-widget-events").each(function() {
      var $this;
      $this = $(this);
      return $this.css('height', w);
    });
  })(jQuery);

}).call(this);
