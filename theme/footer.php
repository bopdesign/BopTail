<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the `#content` element and all content thereafter.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BopTail
 */

$copyright = get_field( 'copyright', 'option' );
?>

	</div><!-- #content -->

	<?php
	/**
	 * Available Templates:
	 * - 3-menu-columns-with-form
	 * - company-with-3-menu-columns
	 */
	get_template_part( 'template-parts/layout/footer', 'company-with-3-menu-columns', $copyright );
	?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
