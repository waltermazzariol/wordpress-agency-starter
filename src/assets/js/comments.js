(function ($) {
  'use strict';

  $(document).ready(function () {
    var $form     = $('.comment-form');
    var $textarea = $('#comment');

    if (!$textarea.length) return;

    // Expand on focus/click of the textarea
    $textarea.on('focus click', function () {
      $form.addClass('is-expanded');
    });

    // Collapse on outside click only when textarea is still empty
    $(document).on('click', function (e) {
      if (!$(e.target).closest('.comment-respond').length) {
        if ($textarea.val().trim() === '') {
          $form.removeClass('is-expanded');
        }
      }
    });
  });
})(jQuery);
