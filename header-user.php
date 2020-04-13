<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">

 *
 * @package Panda PRO
 */
$panda_option = get_option('panda_option');
$dark_mode = pandapro_get_dark_mode_status();
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<?php wp_head(); ?>
</head>

<body <?php body_class($dark_mode ? 'nice-dark-mode' : ''); ?>>
	