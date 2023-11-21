(function($) {
  
  'use strict';
  if ($("#lightgallery").length) {
    $("#lightgallery").lightGallery({
      selector: '.light-item',
    });
  }

  if ($("#lightgallery-without-thumb").length) {
    $("#lightgallery-without-thumb").lightGallery({
      thumbnail: true,
      animateThumb: false,
      showThumbByDefault: false
    });
  }

  if ($("#video-gallery").length) {
    $("#video-gallery").lightGallery();
  }
})(jQuery);

window.lightGallery = function() {
  if ($(".lightgallery").length) {
    $(".lightgallery").each(function() {
      $(this).lightGallery({
        selector: '.light-item',
      });

    });
  }
}