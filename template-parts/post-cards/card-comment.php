<?php $template_params = isset($template_params) ? $template_params : array() ?>
<?php 
    $comment = $template_params['comment'];
    $post = get_post($comment->comment_post_ID);
?>
<div class="list-item block">
    <div class="item-comment depth-1 w-100">
        <article class="item-comment-body">
            <div class="item-comment-info d-flex align-items-center flex-fill mb-3">
                <div class="item-comment-avatar flex-avatar w-48 ">
                    <?php echo get_avatar($comment, 48, '', ''); ?>
                </div>
                <div class="item-comment-author mx-3">
                    <a target="_blank" href="<?php echo $comment->comment_author_url ?>" rel="external nofollow" class="url"><?php echo $comment->comment_author ?></a>
                    <div class="d-block text-muted text-xs mt-1">
                        <time><?php echo pandapro_timeago(mysql2date( 'G', $comment->comment_date), null) ?></time>
                        <i class="d-none d-md-inline-block text-primary mx-1 mx-md-2">—</i>
                        <span><a href="<?php echo get_permalink($post->ID) ?>" target="_blank"><?php echo get_the_title($post) ?></a></span>
                    </div>
                </div>
            </div>
            <!-- .comment-author -->
            <div class="item-comment-text d-flex flex-fill">
                <i class="text-md text-muted iconfont icon-double-quotes-l"></i>
                <div class="item-comment-content mx-2">
                    <p><?php echo $comment->comment_content ?></p>
                </div><!-- .comment-content -->
                <i class="text-md text-muted iconfont icon-double-quotes-r"></i>
            </div>
            <!-- .comment-text -->
        </article>
        <!-- .comment-body -->
    </div>
</div>