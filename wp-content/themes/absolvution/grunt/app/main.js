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
      if (direction === 'down') {
        $('.info--location > div').addClass('flip-x-in');
        return $('.info--hours > div').addClass('flip-x-in');
      }
    });
    w = $(".tribe-events-list-widget-events").css('width');
    $vcalendar = $('body.home .vcalendar');
    aw = parseInt(w) + 10;
    $vcalendar.css('margin-top', '-' + aw + 'px');
    $(".tribe-events-list-widget-events").each(function(index, element) {
      var $this;
      __(element);
      if (index === 5) {
        return;
      }
      $this = $(this);
      return $this.css('height', w);
    });
  })(jQuery);

}).call(this);
