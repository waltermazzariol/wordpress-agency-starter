<!-- Share button HTML, CSS & PHP code by www.jonakyblog.com -->

<div>
<ul class="share-buttons">
    <li>
        <a class="share-facebook" href="<?php echo esc_url('https://www.facebook.com/sharer/sharer.php?u=' . urlencode(esc_url(get_the_permalink()))); ?>" title="Share on Facebook" target="_blank" rel="noopener noreferrer">
            <i class="fab fa-facebook" aria-label='icon'></i>
            <span class="screen-reader-text">Share on Facebook</span>
        </a>
    </li>
    <li>
        <a class="share-twitter" href="<?php echo esc_url('https://twitter.com/intent/tweet?url=' . urlencode(esc_url(get_the_permalink())) . '&text=' . urlencode(esc_html(get_the_title())) . '&via=' . urlencode(get_the_author_meta('twitter'))); ?>" title="Tweet this" target="_blank" rel="noopener noreferrer">
            <i class="fab fa-x-twitter"></i>
            <span class="screen-reader-text">Share on Twitter</span>
        </a>
    </li>
    <li>
        <a class="share-linkedin" href="<?php echo esc_url('https://www.linkedin.com/sharing/share-offsite/?url=' . urlencode(esc_url(get_the_permalink()))); ?>" title="Share on Linkedin" target="_blank" rel="noopener noreferrer">
            <i class="fab fa-linkedin"></i>
            <span class="screen-reader-text">Share on LinkedIn</span>
        </a>
    </li>
    <li>
        <a class="share-whatsapp" href="<?php echo esc_url('https://api.whatsapp.com/send?text=' . urlencode(get_the_title() . ': ' . esc_url(get_the_permalink()))); ?>" data-action="share/whatsapp/share" title="Share on Whatsapp" target="_blank" rel="noopener noreferrer">
            <i class="fab fa-whatsapp"></i>
            <span class="screen-reader-text">Share on WhatsApp</span>
        </a>
    </li>
    <li>
        <a class="share-email" href="<?php echo esc_url('mailto:?subject=' . rawurlencode(__('I wanted to share this post with you from ', 'wp_guarapo') . get_bloginfo('name')) . '&body=' . rawurlencode(get_the_title() . ' - ' . esc_url(get_the_permalink()))); ?>" title="Email to a friend/colleague" target="_blank" rel="noopener noreferrer">
            <i class="fas fa-envelope"></i>
            <span class="screen-reader-text">Share via Email</span>
        </a>
    </li>
    <li>
        <a class="share-threads" href="<?php echo esc_url('https://www.threads.net/intent/post?text=' . urlencode(get_the_title() . ' ' . esc_url(get_the_permalink()))); ?>" title="Share on Threads" target="_blank" rel="noopener noreferrer">
            <i class="fab fa-threads"></i>
            <span class="screen-reader-text">Share on Threads</span>
        </a>
    </li>
    <li class="share-instagram-li">
        <button
            class="share-instagram-btn"
            title="Share on Instagram Stories"
            data-title="<?php echo esc_attr(get_the_title()); ?>"
            data-url="<?php echo esc_attr(home_url()); ?>"
            data-reading-time="<?php echo esc_attr(reading_time()); ?>"
            data-category="<?php
  $cats = get_the_category();
  echo esc_attr(!empty($cats) ? $cats[0]->name : '');
?>"
            data-author="<?php echo esc_attr(get_the_author_meta('display_name')); ?>"
            data-avatar="<?php echo esc_attr(get_avatar_url(get_the_author_meta('ID'))); ?>"
            data-image="<?php echo esc_attr(get_the_post_thumbnail_url(null, 'large') ?: get_template_directory_uri() . '/dist/images/hero.jpg'); ?>"
            data-excerpt="<?php echo esc_attr(wp_strip_all_tags(get_the_excerpt())); ?>"
        >
            <i class="fab fa-instagram" aria-hidden="true"></i>
            <span class="screen-reader-text">Share on Instagram Stories</span>
        </button>
    </li>
</ul>
</div>
