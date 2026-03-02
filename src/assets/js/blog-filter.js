(function($) {
    'use strict';
    $(document).ready(function() {
        var $filterButtons = $('.filter-btn');
        var $postsContainer = $('#blog-posts-container');
        var $paginationContainer = $('#blog-pagination');
        var currentCategory = 'all';

        function loadPosts(category, paged) {
            $postsContainer.addClass('loading');

            $.ajax({
                url: wpGuarapoAjax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'filter_blog_posts',
                    category: category,
                    paged: paged
                },
                success: function(response) {
                    if (response.success) {
                        $postsContainer.html(response.data.posts);
                        $paginationContainer.html(response.data.pagination);
                    }
                    $postsContainer.removeClass('loading');
                },
                error: function() {
                    $postsContainer.html('<p>Error loading posts.</p>');
                    $postsContainer.removeClass('loading');
                }
            });
        }

        $filterButtons.on('click', function(e) {
            e.preventDefault();

            var $this = $(this);
            currentCategory = $this.data('category');

            $filterButtons.removeClass('active');
            $this.addClass('active');

            loadPosts(currentCategory, 1);
        });

        $paginationContainer.on('click', 'a', function(e) {
            e.preventDefault();

            var href = $(this).attr('href');
            var match = href.match(/[?&]paged=(\d+)/);
            var paged = match ? parseInt(match[1], 10) : 1;

            loadPosts(currentCategory, paged);
        });
    });
})(jQuery);
