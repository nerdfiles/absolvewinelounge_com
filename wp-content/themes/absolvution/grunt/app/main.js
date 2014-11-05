(function() {
  (function($) {
    var $search, $vcalendar, aw, i, recentTweets$, s, tHref, twitterHref, twitterTime$, w, __, _href, _i, _ref;
    $("body").attr('jquery-version', $.fn.jquery);

    /*
    Utils
     */
    __ = function(obj) {
      window.console.log(obj);
    };

    /*
    Site Search
     */
    $search = $('#s');
    $search.attr('placeholder', 'Find something new');

    /*
    Twitter Implementation
     */
    recentTweets$ = $('.home--recent-tweets');
    if (recentTweets$.length) {
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
    }

    /*
    Interactive Site Gallery
     */
    _href = void 0;
    $('.foogallery-panel').on('click', function() {
      return $('.foogallery-panel').removeClass('active');
    });
    $('.foogallery-link-image a').on('click', function(e) {
      var $this, href, img;
      $this = $(this);
      href = $this.attr('href');
      if (_href !== href) {
        $('.foogallery-panel').removeClass('active');
      }
      $('.foogallery-panel').toggleClass('active');
      $('.foogallery-panel img').remove();
      img = $("<img />").attr('src', href).load(function() {
        if (!this.complete || typeof this.naturalWidth === "undefined" || this.naturalWidth === 0) {
          return alert('broken image!');
        } else {
          return $(".foogallery-panel").append(img);
        }
      });
      _href = href;
      return e.preventDefault();
    });

    /*
    Site Footer
     */
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

    /*
    Site Calendar and Events
     */
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
