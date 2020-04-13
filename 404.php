<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Panda PRO
 */

get_header();
?>
<main class="py-3 py-md-5">
    <div class="container">
    	<div class="content-error text-center h-v-75 py-5">
    		<div class="d-inline-block w"> <?php get_template_part('template-parts/svg/404-svg'); ?></div>
            <h1 class="display-1 font-theme">404</h1>
            <h4 class="py-4"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'pandapro' ); ?></h4>
            <p class="text-muted"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'pandapro' ); ?></p>
        </div>
    </div>
</main>
<?php
get_footer();
