<?php $panda_option = get_option('panda_option') ?>
<?php $ajax_loading = $panda_option['index_ajax_loading'] ?>
<?php if ($ajax_loading): ?>
<?php $index_tab = $panda_option['index_tab'] ?>
    <?php if (is_array($index_tab['list'])): ?>
    <div class="list-ajax-nav author-list-ajax-nav list-ajax-index pb-2 mb-2 mb-md-3">
        <ul>
            <li><button class="btn btn-sm btn-primary current" data-cid="-2.1"><?php echo empty( $index_tab['display_name'] ) ? __('Recommended', 'pandapro') : $index_tab['display_name']; ?></button></li>
            <?php
                foreach ($index_tab['list'] as $index => $tab) {
                    echo sprintf( '<li><button class="btn btn-sm btn-link" data-cid="%s">%s</button></li>', $tab['cat'], $tab['display_name'] );
                }
            ?>
        </ul>
    </div>
    <?php endif; ?>
<?php endif; ?>