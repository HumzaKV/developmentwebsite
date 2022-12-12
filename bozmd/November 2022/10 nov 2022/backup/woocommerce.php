<?php get_header(); ?>
	<div class="content-wrapper full-section">	
		<div class="page-wrapper">
			<?php
				echo "<div class='container'>";				
				echo '<div class="gdl-woo-commerce-wrapper">';
				woocommerce_content();
				echo '</div>';		
				echo "</div>"; // end of gdl-page-item
			?>
		</div>
	</div> <!-- content-wrapper -->	
<?php get_footer(); ?>