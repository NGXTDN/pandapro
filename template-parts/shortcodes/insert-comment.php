<?php

$comment = '
<div class="media comment-embed-item mt-3 mt-md-4 mt-lg-4-2 mb-3 mb-md-4 mb-lg-4-2">
    <div class="author-avatar mr-2 mr-md-3">'.get_avatar( $value, 50).'</div>
    <div class="media-body embed-content">
        <div class="embed-author mb-2">
            <span class="author-name font-14">'.$value->comment_author.'</span>
        </div>
        <div class="embed-comment">'.apply_filters( 'comment_text', $value->comment_content,$value).'</div>
        <div class="embed-post-title font-12 text-muted mt-2">
            <time class="comment-date">'.timeago( get_gmt_from_date( $value->comment_date ) ).'</time> 发表在 <a href="'.get_comment_link(  $value->comment_ID ).'">'.get_the_title( $value->comment_post_ID ).'</a>
        </div>
    </div>
</div>
';

return $comment;