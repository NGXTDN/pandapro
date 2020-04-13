<?php if (defined('NC_APOLLO_DIR')): ?>
    <?php $users_id = get_post_meta(get_the_ID(), 'suxing_ding_users', true); ?>
    <?php if (is_array($users_id) && !empty($users_id)): ?>
    <div class="mt-3" id="apollo-postlike-section">
        <div class="avatar-group">
                <?php foreach(array_slice($users_id, 0, 10) as $user_id): ?>
                    <a href="<?php echo get_author_posts_url($user_id) ?>" target="_blank" class="flex-avatar w-32">
                        <?php echo get_avatar( $user_id, 32, '', '' ); ?>
                    </a>
                <?php endforeach; ?>
            <span class="text-muted text-xs mx-2">
                <?php printf( __( '%d member(s) like this post', 'pandapro'  ), pandapro_get_hearts(get_the_ID()) ); ?>
            </span>
        </div>
    </div>
    <?php endif; ?>
<?php endif; ?>

