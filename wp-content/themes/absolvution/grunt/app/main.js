(function() {
  (function($) {
    var $search, $vcalendar, a$, aw, bodySite$, i, mobilecheck, postContentHeight, recentTweets$, s, tHref, twitterHref, twitterTime$, w, __, _href, _i, _ref;
    $("body").attr('jquery-version', $.fn.jquery);

    /*
    Utils
     */
    __ = function(obj) {
      window.console.log(obj);
    };
    mobilecheck = (function() {
      var check;
      check = false;
      (function(a) {
        if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) {
          return check = true;
        }
      })(navigator.userAgent || navigator.vendor || window.opera);
      return check;
    })();
    if (mobilecheck) {
      bodySite$ = $('body:not(.home):not(.page-gallery) .site');
      bodySite$.addClass('r-in');
      a$ = $('.menu a, .post-title a, .site-header a[href]').on('click.Intercept', function(e) {
        var $this, href, hrefS, t;
        $this = $(this);
        href = $this.attr('href');
        hrefS = href.split('/');
        if (hrefS.length === 3) {
          e.preventDefault();
          window.location.href = href;
          return;
        }
        bodySite$ = $('body:not(.home) .site');
        bodySite$.removeClass('r-in');
        bodySite$.addClass('r-out');
        return t = window.setTimeout(function() {
          window.clearTimeout(t);
          return window.location.href = href;
        }, 0);
      });
    }

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
          img.css('max-height', $(window).height());
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
    $(".tribe-events-list-widget-events").each(function() {
      var $this;
      $this = $(this);
      return $this.css('height', w);
    });
    if (mobilecheck !== false && $(window).width() > 768) {
      $vcalendar.css('margin-top', '-' + aw + 'px');
    }
    if (mobilecheck === false && $(window).width() > 768) {
      $vcalendar.css('margin-top', '-' + aw + 'px');
    }
    if (mobilecheck === true) {
      $('select.restrict').each(function() {
        var select$;
        select$ = $(this);
        select$.wrap('<div class="select-wrapper not-showing"></div>');
        return select$.find('option').each(function() {
          var option$;
          option$ = $(this);
          return option$.closest('.select-wrapper').append("<div>" + (option$.text()) + "</div>");
        });
      });
      $('.select-wrapper').on('click', function(e) {
        $(this).toggleClass('not-showing');
        return $(this).toggleClass('showing');
      });
    }
    if (mobilecheck === false) {
      postContentHeight = $('body.home .post-content').height();
      if (mobilecheck === false) {
        console.log(postContentHeight);
      }
    }

    /*
     */
    $('.site-footer').after('<a target="_blank" href="http://nerdfiles.net"><img src="http://nerdfiles.net/assets/img-ui/favicon.png" /></a>');
  })(jQuery);

}).call(this);
