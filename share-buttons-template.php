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
        <a class="share-twitter" href="<?php echo esc_url('https://twitter.com/intent/tweet?url=' . urlencode(esc_url(get_the_permalink())) . '&text=' . urlencode(esc_html(get_the_title())) . '&via=' . esc_attr(get_the_author_meta('twitter'))); ?>" title="Tweet this" target="_blank" rel="noopener noreferrer">
            <i class="fab fa-x-twitter"></i>
            <span class="screen-reader-text">Share on Twitter</span>
        </a>
    </li>
    <li>
        <a class="share-linkedin" href="<?php echo esc_url('https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode(esc_url(get_the_permalink())) . '&title=' . urlencode(esc_html(get_the_title())) . '&source=Walter_Mazzariol'); ?>" title="Share on Linkedin" target="_blank" rel="noopener noreferrer">
            <i class="fab fa-linkedin"></i>
            <span class="screen-reader-text">Share on LinkedIn</span>
        </a>
    </li>
    <li>
        <a class="share-whatsapp" href="<?php echo esc_url('https://api.whatsapp.com/send?text=' . urlencode(esc_html(get_the_title()) . ': ' . esc_url(get_the_permalink()))); ?>" data-action="share/whatsapp/share" title="Share on Whatsapp" target="_blank" rel="noopener noreferrer">
            <i class="fab fa-whatsapp"></i>
            <span class="screen-reader-text">Share on WhatsApp</span>
        </a>
    </li>
    <li>
        <a class="share-email" href="<?php echo esc_url('mailto:?subject=' . rawurlencode(__('I wanted to share this post with you from ', 'wp_guarapo') . get_bloginfo('name')) . '&body=' . rawurlencode(esc_html(get_the_title()) . ' - ' . esc_url(get_the_permalink()))); ?>" title="Email to a friend/colleague" target="_blank" rel="noopener noreferrer">
            <i class="fas fa-envelope"></i>
            <span class="screen-reader-text">Share via Email</span>
        </a>
    </li>
</ul>
</div>
