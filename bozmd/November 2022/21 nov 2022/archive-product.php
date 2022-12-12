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
defined('ABSPATH') || exit;
get_header();
$term = get_queried_object();
$catz = array(34, 27, 25, 32);
$page_id = wc_get_page_id('shop');
$page_builder = get_field('page_builder', $page_id);
$news_letter = get_field('show_newsletter_form', $page_id);
$insta_feed = get_field('show_instagram_feeds', $page_id);

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action('woocommerce_before_main_content');

?>
<div class="shop-page-content full-section">
	<?php
		if ($page_builder) {
			foreach ($page_builder as $key => $section) {
				include('sections/inc-' . $section['acf_fc_layout'] . '.php');
			}
		} else {
			echo '<div class="container" style="text-align:center;">';
			echo '<h2 style="margin:20px 0 20px;display:inline-block;">';
			echo 'Fields Not Founds';
			echo '</h2>';
			echo '</div>';
		}
	?>
</div>
<div class="woocommerce-archive-page full-section">
	<div class="container">
		<div class="woocommerce-shop-header">
			<?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
				<h2 class="shop-page-title"><?php woocommerce_page_title(); ?></h2>
			<?php endif; ?>
			<?php do_action('woocommerce_archive_description'); ?>
		</div>
		<div class="shop-catgeory-section">
			<?php
			$top_cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => 0]);
			foreach ($top_cats as $term) {
				if (!in_array($term->term_id, $catz)) continue;
				$thumbnail_id = get_woocommerce_term_meta($term->term_id, 'thumbnail_id', true);
				// get the image URL
				$image_url = wp_get_attachment_url($thumbnail_id);

				if ($image_url)
					$image = '<img src="' . $image_url . '"/>';
				else
					$image = '';
			?>
			<?php
				echo '<div class="product-cat">
				 <div class="cat-img">' . $image . '</div>
				 <div class="cat-info">
				   <p class="cat-head">' . $term->name . '</p>
				   <a href="' . esc_url(get_term_link($term)) . '" alt="View all posts">View All</a>
				 </div>
				</div>';
			}
			?>
		</div>
		<div class="shop-products-section">
			<div class="shop-products">
				<?php
				if (woocommerce_product_loop()) {
					/**
					 * Hook: woocommerce_before_shop_loop.
					 *
					 * @hooked woocommerce_output_all_notices - 10
					 * @hooked woocommerce_result_count - 20
					 * @hooked woocommerce_catalog_ordering - 30
					 */
					// do_action( 'woocommerce_before_shop_loop' ); //data sorting and pagination
					woocommerce_product_loop_start();
					if (wc_get_loop_prop('total')) {
						while (have_posts()) {
							the_post();
							/**
							 * Hook: woocommerce_shop_loop.
							 */
							do_action('woocommerce_shop_loop');
							wc_get_template_part('content', 'product');
						}
					}
					woocommerce_product_loop_end();
					/**
					 * Hook: woocommerce_after_shop_loop.
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					do_action('woocommerce_after_shop_loop');
				} else {
					/**
					 * Hook: woocommerce_no_products_found.
					 *
					 * @hooked wc_no_products_found - 10
					 */
					do_action('woocommerce_no_products_found');
				}
				?>
			</div>
			<div class="shop-sidebar">
				<?php
				$sc_terms = get_terms(array(
					'taxonomy' => 'product_cat',
					'hide_empty' => 0,
					// 'number'     => 4,
					// 'order'      => '',
					// 'orderby'  => 'include',
				));
				foreach ($sc_terms as $term) {
					if (!in_array($term->term_id, $catz)) continue;
					echo '<a href="' . esc_url(get_term_link($term)) . '" alt="' . $term->name . '">
					       <h4 class="cat-head">' . $term->name . '</h4>
					      </a>';
					$args = array(
						'post_type'      => 'product',
						'posts_per_page' => 3,
						'product_cat'    => $term->name
					);
					$loop = new WP_Query($args);
					while ($loop->have_posts()) : $loop->the_post();
						global $product;
						echo '<a class="pro-sidebar-info" href="' . get_permalink() . '">
						     ' . woocommerce_get_product_thumbnail() . '
						     <span>' . get_the_title() .'</span>
						     </a>';
					endwhile;
					wp_reset_query();
				}
				?>
			</div>
		</div>
	</div>
</div>
<?php
get_footer();
