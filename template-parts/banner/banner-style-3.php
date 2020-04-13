<?php $panda_option = get_option('panda_option'); ?>
<?php $slides = $panda_option['index_featured_slides']; ?>
<?php if ( is_array($slides) && count($slides) > 0 ) : ?>
    <div class="list-banner list-rounded banner-style-3 banner-has-nav mb-4 mb-md-4">
        <div class="owl-carousel owl-theme">
            <?php foreach($slides as $slide): ?>
                <div class="card item list-item list-overlay-content m-0">
                    <div class="media media-2x1">
                        <a class="media-content" target="_blank" href="<?php echo $slide['link']['url'] ?>" style="background-image: url(<?php echo timthumb($slide['image'], array('w' => 800, 'h' => 400)) ?>)"><span class="overlay"></span></a>
                    </div>
                    <?php if ($slide['link']['title']): ?>
                    <div class="list-content text-center text-md-left p-3 p-md-4">
                        <div class="list-body">
                            <a href="<?php echo $slide['link']['url'] ?>" target="_blank" class="h4 text-white h-2x m-0"><?php echo $slide['link']['title'] ?></a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>