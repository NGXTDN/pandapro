<li id="comment-<?php comment_ID() ?>" <?php comment_class(); ?>>
    <article id="div-comment-<?php comment_ID() ?>" class="comment-body d-flex flex-fill ">
        <div class="comment-avatar-author vcard mr-2 mr-md-3 ">
            <div class="flex-avatar w-48"><?php echo get_avatar( $comment, 48 ); ?></div>
        </div><!-- .comment-author -->
        <div class="comment-text d-flex flex-fill flex-column">
            <div class="comment-info d-flex align-items-center mb-1">
                <div class="comment-author text-sm">
                	<?php comment_author_link() ?>
                </div>
            </div>
            <div class="comment-content d-inline-block text-sm">
                <?php
                	comment_text();
                ?>
                <?php if ( $comment->comment_approved == '0' ) : ?>
                <p class="tip-comment-check"><?php echo esc_html_e( 'Your comment is awaiting moderation.', 'pandapro' ) ?></p>
	            <?php endif; ?>
            </div><!-- .comment-content -->
            <div class="d-flex flex-fill text-xs text-muted pt-2">
                <div>
                    <?php pandapro_comment_official( $comment->user_id ); ?>
                    <time class="comment-date"><?php echo pandapro_timeago(get_comment_time('G', false) ) ?></time>
                </div>
                <div class="flex-fill"></div>
                <a class="comment-reply-link" onclick="return addComment.moveForm( 'comment-<?php comment_ID() ?>','<?php comment_ID() ?>', 'respond','<?php echo $comment->comment_post_ID; ?>' ) " href="?replytocom=<?php comment_ID() ?>#respond" class="text-secondary comment-reply-link" rel="nofollow"><i class="fal fa-repeat"></i> <?php esc_html_e( 'Reply', 'pandapro' ) ?></a>
            </div>
        </div><!-- .comment-text -->
    </article><!-- .comment-body -->