(function($) {
    'use strict';

    $(document).ready(function() {
        var $filterButtons = $('.filter-btn');
        var $postsContainer = $('#posts-container');

        $filterButtons.on('click', function(e) {
            e.preventDefault();

            var $this = $(this);
            var category = $this.data('category');

            // Update active state
            $filterButtons.removeClass('active');
            $this.addClass('active');

            // Add loading state
            $postsContainer.addClass('loading');

            // AJAX request
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
                    $postsContainer.html('<div class="col-12"><p>Error loading posts. Please try again.</p></div>');
                    $postsContainer.removeClass('loading');
                }
            });
        });
    });
})(jQuery);
