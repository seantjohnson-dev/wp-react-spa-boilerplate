// import $ from 'jquery';
// window.jQuery = $;
(function($) {
  // Site title
  if (wp && wp.customize) {
    wp.customize('blogname', function(value) {
      value.bind(function(to) {
        $('.header-logo, .footer-logo').text(to);
      });
    });

    wp.customize('header_logo', function(value) {
      value.bind(function(to) {
        $('.header-logo').css({
          backgroundImage: "url(to)"
        });
      });
    });

    wp.customize('footer_logo', function(value) {
      value.bind(function(to) {
        $('.footer-logo').css({
          backgroundImage: "url(to)"
        });
      });
    });

    wp.customize('favicon', function(value) {
      value.bind(function(to) {
        $('link.favicon').attr('href', to);
      });
    });

    wp.customize('footer_copyright', function(value) {
      value.bind(function(to) {
        var $elem = $('#site-footer .footer-copyright-wrap p');
        $elem.html($elem.attr('data-default'));
      });
    });

    wp.customize('footer_colors', function(value) {
      value.bind(function(to) {
        var $elem = $('#site-footer');
        $elem.css({
          backgroundColor: value.bg,
          color: value.text
        });
      });
    });
  }

})(jQuery);
