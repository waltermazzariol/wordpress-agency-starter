(function($) {
    'use strict';
    $(document).ready(function() {
        var $filterButtons = $('.filter-btn');
        var $postsContainer = $('#posts-container');

        $filterButtons.on('click', function(e) {
            e.preventDefault();

            var $this = $(this);
            var category = $this.data('category');

            $filterButtons.removeClass('active');
            $this.addClass('active');
            $postsContainer.addClass('loading');

            $.ajax({
                url: wpGuarapoAjax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'filter_posts_by_category',
                    category: category
                },
                success: function(response) {
                    $postsContainer.html(response);
                    $postsContainer.removeClass('loading');
                },
                error: function() {
                    $postsContainer.html('<div class="col-12"><p>Error loading posts.</p></div>');
                    $postsContainer.removeClass('loading');
                }
            });
        });

        // Gallery Lightbox
        var $lightbox = $('#gallery-lightbox');
        var $lightboxImg = $lightbox.find('.lightbox-img');

        $('.gallery-img').on('click', function() {
            var imgSrc = $(this).attr('src');
            $lightboxImg.attr('src', imgSrc);
            $lightbox.addClass('active');
            $('body').css('overflow', 'hidden');
        });

        $lightbox.on('click', function(e) {
            if (e.target === this || $(e.target).hasClass('lightbox-close')) {
                $lightbox.removeClass('active');
                $('body').css('overflow', '');
            }
        });

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $lightbox.hasClass('active')) {
                $lightbox.removeClass('active');
                $('body').css('overflow', '');
            }
        });
    });
})(jQuery);
