(function($) {
  // Site title

  var $videos = $('body#tinymce iframe');
  if ($videos.length) {
    $videos.each(function(index) {
      if (!$(this).parents('.video-wrap').length) {
        $(this).wrap('<div class="video-wrap"></div>');
      }
    });
  }

})(jQuery);
