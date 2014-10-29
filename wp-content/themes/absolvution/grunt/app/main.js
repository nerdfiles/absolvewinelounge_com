(function() {
  (function($) {
    var $search, $vcalendar, aw, w, __;
    $("body").attr('jquery-version', $.fn.jquery);
    __ = function(obj) {
      window.console.log(obj);
    };
    $search = $('#s');
    $search.attr('placeholder', 'Find something new');
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
      offset: '50%'
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
