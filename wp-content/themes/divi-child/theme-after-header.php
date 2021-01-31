<?php
/**
 * Template partial used to add content to the page in Theme Builder.
 * Duplicates partial content from header.php in order to maintain
 * backwards compatibility with child themes.
 */

if ( et_builder_is_product_tour_enabled() || is_page_template( 'page-template-blank.php' ) ) {
	return;
}
?>
<div id="et-main-area">
	<?php
	/**
	 * Fires after the header, before the main content is output.
	 *
	 * @since 3.10
	 */
	do_action( 'et_before_main_content' );
	?>
<?php if ( !is_front_page() &&  function_exists('yoast_breadcrumb')): ?>
	<section class="breadcrumbs-vm">
		<div class="et_pb_row">
    		<?php yoast_breadcrumb( '<p id="breadcrumbs">','</p>' ); ?>
		</div>
	</section>
<?php endif; ?>
