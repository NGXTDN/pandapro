<?php $template_params = isset($template_params) ? $template_params : array() ?>
<?php if ($template_params['ajax_loading']): ?>
    <div class="list-ajax-load">
        <span class="ajax-loading loading-text-svg">
            <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                <path fill="#448ef6" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50" transform="rotate(215.689 50 50)">
                  <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
                </path>
            </svg>
        </span>
        <button
            type="button" 
            class="dposts-ajax-load btn btn-light btn-block text-sm"
            data-page="<?php echo $template_params['page'] ?>"
            data-query="<?php echo $template_params['query']; ?>"
            data-action="ajax_load_posts"
            data-paged="2"
            data-append="<?php echo $template_params['append'] ?>"
        ><?php _e('Load more...', 'pandapro') ?></button>
    </div>
<?php else: ?>
    <?php
        the_posts_pagination( array(
            'prev_text'          =>'<span class="btn btn-light btn-icon btn-rounded btn-sm"><span><i class="text-md iconfont icon-arrow-left-s-line"></i></span></span>',
            'next_text'          =>'<span class="btn btn-light btn-icon btn-rounded btn-sm"><span><i class="text-md iconfont icon-arrow-right-s-line"></i></span></span>',
            'screen_reader_text' => 'Posts Navigation',
            'mid_size' => 1,
        ) );
    ?>
<?php endif; ?>