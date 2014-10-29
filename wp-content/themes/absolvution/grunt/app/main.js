(function() {
  (function($) {
    var $search, $vcalendar, aw, w, __;
    $("body").attr('jquery-version', $.fn.jquery);
    __ = function(obj) {
      window.console.log(obj);
    };
    $search = $('#s');
    $search.attr('placeholder', 'Find something new');
    $('.page-content').waypoint(function() {
      $('.info--location > div').addClass('flip-x-in').addClass('animated');
      return $('.info--hours > div').addClass('flip-x-in').addClass('animated');
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
