(function($) {
    'use strict';

    $(document).ready(function() {
        console.log('Category filter JS loaded');
        console.log('wpGuarapoAjax:', typeof wpGuarapoAjax !== 'undefined' ? wpGuarapoAjax : 'NOT DEFINED');

        var $filterButtons = $('.filter-btn');
        var $postsContainer = $('#posts-container');

        console.log('Filter buttons found:', $filterButtons.length);
        console.log('Posts container found:', $postsContainer.length);

        $filterButtons.on('click', function(e) {
            console.log('Button clicked, category:', $(this).data('category'));
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
