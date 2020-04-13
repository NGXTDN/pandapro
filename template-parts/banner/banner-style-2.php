<?php $panda_option = get_option('panda_option'); ?>
<?php $slides = $panda_option['index_featured_slides']; ?>
<?php if ( is_array($slides) && count($slides) > 0 ) : ?>
    <div class="list-banner list-rounded banner-style-2 banner-has-nav pt-3 pt-md-5">
        <div class="container">
            <div class="owl-carousel owl-theme">
                <?php foreach($slides as $slide): ?>
                    <div class="card item list-item list-overlay-content m-0">
                        <div class="media media-21x9">
                            <a class="media-content" target="_blank" href="<?php echo $slide['link']['url'] ?>" style="background-image: url(<?php echo timthumb($slide['image'], array('w' => 1200, 'h' => 514.3)) ?>)"><span class="overlay"></span></a>
                        </div>
                        <?php if ($slide['link']['title']): ?>
                        <div class="list-content p-3 p-md-5 text-center">
                            <div class="list-body">
                                <a href="<?php echo $slide['link']['url'] ?>" target="_blank" class="h4 text-white h-2x m-0"><?php echo $slide['link']['title'] ?></a>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>