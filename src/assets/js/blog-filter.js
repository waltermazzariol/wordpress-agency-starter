(function($) {
    'use strict';
    $(document).ready(function() {
        var $filterButtons = $('.filter-btn');
        var $postsContainer = $('#blog-posts-container');

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
                    action: 'filter_blog_posts',
                    category: category
                },
                success: function(response) {
                    $postsContainer.html(response);
                    $postsContainer.removeClass('loading');
                },
                error: function() {
                    $postsContainer.html('<p>Error loading posts.</p>');
                    $postsContainer.removeClass('loading');
                }
            });
        });
    });
})(jQuery);
