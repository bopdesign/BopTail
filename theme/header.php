<?php
/**
 * The header for our theme
 *
 * This is the template that displays the `head` element and everything up
 * until the `#content` element.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BopTail
 */

?><!doctype html>
<html <?php language_attributes(); ?> class="h-full antialiased">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class('flex min-h-full'); ?>>

<?php wp_body_open(); ?>

<div id="page" class="w-full">
	<a href="#content" class="sr-only"><?php esc_html_e( 'Skip to content', 'boptail' ); ?></a>

	<?php get_template_part( 'template-parts/layout/header', 'content' ); ?>

	<div id="content" class="flex flex-col w-full">
