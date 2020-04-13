<?php

/*
            /$$
    /$$    /$$$$
   | $$   |_  $$    /$$$$$$$
 /$$$$$$$$  | $$   /$$_____/
|__  $$__/  | $$  |  $$$$$$
   | $$     | $$   \____  $$
   |__/    /$$$$$$ /$$$$$$$/
          |______/|_______/
================================
        Keep calm and get rich.
                    Is the best.

  	@Author: Dami
  	@Date:   2017-12-25 12:50:06
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-12-25 13:23:03
*/

$ding = get_post_meta($post->ID,'suxing_ding',true);
$ding = $ding ? $ding : 0;
$category = get_the_category(get_the_ID());
$insert_post = '
<div class="post-pushed-item d-flex flex-row my-4">
    <div class="media media-3x2 rounded col-4 col-md-3">
        <a href="'.get_permalink($post).'" target="_blank" class="media-content" style="background-image:url('.timthumb( pandapro_post_thumbnail_src(), array( 'w' => '160', 'h' => '120' ) ).')"></a>
    </div>
    <div class="post-pushed-body pl-3">
        <div class="post-pushed-content ">
            <a href="'.get_permalink($post).'" target="_blank" class="post-pushed-title text-lg h-2x">'.get_the_title().'</a>
            <div class="post-pushed-desc d-none d-md-block text-sm text-secondary mt-2">
                <div class="h-2x ">'.pandapro_print_excerpt(60,null,false).'</div>
            </div>
        </div>
        <div class="post-pushed-footer text-muted text-xs">
            <span class="d-none d-md-inline-block"><a href="'.get_category_link($category[0]).'" target="_blank">'.$category[0]->cat_name.'</a></span>
            <i class="d-none d-md-inline-block text-primary mx-1 mx-md-2">&#8212;</i>
            <time>'.pandapro_timeago().'</time>
        </div>
    </div>
</div>';

return $insert_post;