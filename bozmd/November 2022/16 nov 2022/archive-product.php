<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;
get_header( 'shop' );
/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>
<header class="woocommerce-products-header">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
	<?php endif; ?>

	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
	?>
</header>
<div class="top">
	<div class="products">
		<?php
		$category_ids = array( 25, 2, 3, 10 );
		$categories = get_terms( 'product_cat', array(
			'orderby'    => 'count',
			'hide_empty' => 0,
			'number'     => 4,	
			'order'      => 'ASC',
		) );
		foreach( $categories as $category ) {
			$thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true ); 

// get the image URL
			$image_url = wp_get_attachment_url( $thumbnail_id );
			if ($image_url) 
				$image = '<img src="'.$image_url.'" width="152" height="245"/>';
			else
				$image = '';
			?>
			<?php
			echo '<div class="product"><p class="cat-head">'.$category->name.'</p>'.$image.' <a href="' . esc_url( get_term_link( $category ) ) . '" alt="View all posts">View All</a></div>';

		} 
		?>
	</div>
</div>
<div class="left">
	<?php
	if ( woocommerce_product_loop() ) {
	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	// do_action( 'woocommerce_before_shop_loop' ); //data sorting and pagination

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}
?>
</div>
<div class="right">
	<h3>Sidebar</h3>
	<?php 
	$categories = get_terms( 'product_cat', array(
		'orderby'    => 'count',
		'hide_empty' => 0,
		'number'     => 4,	
		'order'      => 'ASC',
	) );
	foreach( $categories as $category ) {
		echo '</br> <a href="' . esc_url( get_term_link( $category ) ) . '" alt="'.$category->name.'"><h4 class="cat-head">'.$category->name.'</h2></a></br>';
		$args = array(
			'post_type'      => 'product',
			'posts_per_page' => 4,
			'product_cat'    => $category->name
		);

		$loop = new WP_Query( $args );

		while ( $loop->have_posts() ) : $loop->the_post();
			global $product;
			echo '<br /><a href="'.get_permalink().'">' . woocommerce_get_product_thumbnail().' '.get_the_title().'</a>';
		endwhile;

		wp_reset_query();
	} 
	?>
</div>
<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
?>
<div class="bottom">
	<?php do_action( 'woocommerce_after_main_content' ); ?>
</div>

<?php
/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );
get_footer( 'shop' );
