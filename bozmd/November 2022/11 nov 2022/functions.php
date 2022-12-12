<?php

define('THEME_PATH', get_template_directory());

define('THEME_URL', get_template_directory_uri());



function theme_files() {

	// Theme Files

	wp_register_style( 'theme-style', get_stylesheet_uri(), false, null);

	wp_enqueue_style( 'theme-style');

	wp_register_style( 'theme-styler', get_stylesheet_directory_uri().'/css/responsive.css', false, null);

	wp_enqueue_style( 'theme-styler');

	wp_register_style( 'font-css', get_stylesheet_directory_uri().'/css/fonts.css', false, null);

	wp_enqueue_style( 'font-css');

	

	

	// Owl Carousel Files

	wp_register_style( 'owl-carousel', get_stylesheet_directory_uri().'/owl-carousel/owl.carousel.min.css', false, '2.2.1' );

	wp_enqueue_style( 'owl-carousel');	

	wp_register_script( 'owl-carousel', get_stylesheet_directory_uri().'/owl-carousel/owl.carousel.min.js', array( 'jquery' ), '2.2.1', true );

	wp_enqueue_script( 'owl-carousel' );

	

	// Font Awesome

	wp_register_script( 'fontawesome', '//kit.fontawesome.com/b69272743e.js', true );

	wp_enqueue_script( 'fontawesome' );

}

add_action( 'wp_enqueue_scripts', 'theme_files' );



// Enable Classic Editor

add_filter('use_block_editor_for_post', '__return_false', 10);



// Disables the block editor from managing widgets in the Gutenberg plugin.

add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );



// Disables the block editor from managing widgets.

add_filter( 'use_widgets_block_editor', '__return_false' );



// Theme Options

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(

		'page_title' 	=> 'Theme Options',

		'menu_title'	=> 'Theme Options',

		'menu_slug' 	=> 'theme-pptions',

		'capability'	=> 'edit_posts',

		'redirect'		=> false

	));

}





// Owl Carousel

function load_owl_carousel() {

?>

<script type="text/javascript">

jQuery(function($) {

//Gallery Carousel

    $(".latest-pod-single-wrapper").owlCarousel({

        loop: true,

        nav: true,

        margin: 20,

        mouseDrag: false,

        autoplay: true,

        dots: false,

        navText: ["<i class='fa fa-arrow-left'></i>", "<i class='fa fa-arrow-right'></i>"],

        responsive: {

            0: {

                items: 1,

                margin: 0,



            },

            600: {

                items: 2,

                margin: 10,

            },

            1000: {

                items: 2,

            }

         }

    });



});

</script>

<?php

}

add_action( 'wp_footer', 'load_owl_carousel', 99 );



// Register Sidebar

add_action( 'widgets_init', 'kv_widgets_init' );

function kv_widgets_init() {

	$sidebar_attr = array(

		'name' 			=> '',

		'before_widget' => '<li id="%1$s" class="widget %2$s">',

		'after_widget'  => '</li>',

		'before_title'  => '<h2 class="widgettitle">',

		'after_title'   => '</h2>',

	);	

	$sidebar_id = 0;

	$gdl_sidebar = array("Blog");

	foreach( $gdl_sidebar as $sidebar_name ){

		$sidebar_attr['name'] = $sidebar_name;

		$sidebar_attr['id'] = 'custom-sidebar' . $sidebar_id++ ;

		register_sidebar($sidebar_attr);

	}

}



// Register Navigation

function register_menu() {

	register_nav_menu('main-menu',__( 'Main Menu' ));

}

add_action( 'init', 'register_menu' );



// Image Crop

function codex_post_size_crop() {

	add_image_size("packages_image", 300, 200, true);

}

add_action("init", "codex_post_size_crop");



// Featured Image Function

add_theme_support( 'post-thumbnails' );



// Woocommerce Support

add_theme_support('woocommerce');





//Custom Post Types

add_action( 'init', 'create_post_type' );

function create_post_type() {

//Podcast

  register_post_type( 'podcasts',

    array(

        'labels' => array(

        'name' => __( 'Podcasts' ),

        'singular_name' => __( 'Podcasts' )

      ),

	  'supports' => array(

    'title',

	  'thumbnail'

    ),

      'public' => true,

      'has_archive' => true,

      'menu_icon' => 'dashicons-microphone',

      'rewrite' => array( 'slug' => 'podcast' )

    )

  );

//FAVORITES

  register_post_type( 'favorites',

    array(

        'labels' => array(

        'name' => __( 'Favorites' ),

        'singular_name' => __( 'Favorites' )

      ),

	  'supports' => array(

    'title',

	  'thumbnail'

    ),

      'public' => true,

      'has_archive' => true,

      'menu_icon' => 'dashicons-star-filled',

      'publicly_queryable'  => false,

      'rewrite' => array( 'slug' => 'favorites' )

    )

  );



  register_taxonomy(

        'podcast-cat',

        'podcasts',

        array(

            'label' => __( 'Podcast Categories' ),

            'rewrite' => array( 'slug' => 'podcast-cat' ),

            'hierarchical' => true,

            'show_admin_column' => true,

        )

    );

}



//FAVORITES Post Type Shortcode

add_shortcode('boz_favorites', 'codex_boz_favorites');

function codex_boz_favorites() {

	ob_start();

      wp_reset_postdata();

?>    

  <div class="boz-fav-wrapper">            

		<?php $query = new WP_Query( array('post_status' => 'publish', 'post_type' => 'favorites', 'posts_per_page' => -1, 'order'  => 'DESC')); ?>

		<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>

			<?php 

			$link = get_field('link');

			  $link_url = $link['url'];

			  $link_title = $link['title'];

				$link_target = $link['target'] ? $link['target'] : '_self' ;

			?>

	        <div class="boz-fav-container">

		        <div class="thumbnail">

		        	<a href="<?php echo $link_url; ?>" target="<?php echo $link_target; ?>"><?php echo get_the_post_thumbnail(get_the_ID(), ''); ?></a>

		        </div>

			      <div class="title"><h6><?php the_title();?></h6></div>

				    <div class="more">

								<?php if($link) {

								   echo '<a href="'.$link_url.'" target="'.$link_target.'">'.$link_title.'</a>';

								}

							?>

				    </div>	

	        </div>

		<?php endwhile; endif; ?>

   </div>  

<?php

      wp_reset_postdata();

	return ''.ob_get_clean();

}





// RightSidebar Shortcode

add_shortcode('right_sidebar', 'codex_right_sidebar');

function codex_right_sidebar() {

	ob_start();

	$right_bg_image = get_field('right_bg_image', 'option');

	$right_banner_title = get_field('right_banner_title', 'option');

	$book_image = get_field('book_image', 'option');

	$keto_image = get_field('keto_image', 'option');

	$sub_title = get_field('sub_title', 'option');

	$sidebar_button = get_field('sidebar_button', 'option');

	$right_image = get_field('right_image', 'option');

	$image_after_right_banner = get_field('image_after_right_banner', 'option');

?>

    <div class="right-banner-wrapper">

			<div class="right-banner-container" style="background: url('<?php echo $right_bg_image; ?>') no-repeat;">

				<h3 class="right-main-title"><?php echo $right_banner_title; ?></h3>

				<img class="book-img" src="<?php echo $book_image; ?>">

				<img class="keto-img" src="<?php echo $keto_image; ?>">

				<h4><?php echo $sub_title; ?></h4>

				<?php if($sidebar_button) {

						$link_url = $sidebar_button['url'];

						$link_title = $sidebar_button['title'];

						$link_target = $sidebar_button['target'] ? $sidebar_button['target'] : '_self' ;

							echo '<a href="'.$link_url.'" target="'.$link_target.'">'.$link_title.'</a>';

					}

			  ?>

			  <img class="right-img" src="<?php echo $right_image; ?>">

			</div>

			<div class="after-banner">

        <img src="<?php echo $image_after_right_banner; ?>">

			</div>

		</div>

    <?php

	return ''.ob_get_clean();	

}



//Podcast Post Type Shortcode

add_shortcode('our_podcasts', 'codex_our_podcasts');

function codex_our_podcasts() {

	ob_start();

      wp_reset_postdata();

?>    

  <div class="podcast-wrapper">            

	<?php $query = new WP_Query( array('post_status' => 'publish', 'post_type' => 'podcasts', 'posts_per_page' => -1, 'order'  => 'DESC')); ?>

	<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>	

        <div class="podcast-container">

          <div class="thumbnail"><a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail( get_the_ID(), '' );?></a></div>

		      <div class="title"><h5><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h5></div>	

        </div>

	<?php endwhile; endif; ?>		

   </div>  

<?php

      wp_reset_postdata();

	return ''.ob_get_clean();

}





//Podcast Taxonomy Shortcode

add_shortcode('podcast_category', 'podcast_category');

function podcast_category() {

	ob_start();

	$cats = get_terms( 'podcast-cat', array(

	    'hide_empty' => false,

	    'parent' => 0,

	));

?>

	<div class="podcast-cat-wrap">

		<?php foreach ($cats as $key => $cat):

				 $cat_image = get_field('category_image', $cat);

		 ?>

			<div class="podcast-container">

				<a href="<?php echo get_term_link($cat->term_id) ?>"><img src="<?php echo $cat_image; ?>"></a>

				<h2><a href="<?php echo get_term_link($cat->term_id) ?>"><?php echo $cat->name ?></a></h2>

			</div>

		<?php endforeach ?>

	</div>

<?php 

	return ''.ob_get_clean();

}





// Podcast Collections Shortcode

add_shortcode('podcast_collections', 'codex_podcast_collections');

function codex_podcast_collections() {

	ob_start();

	$section_bg_image = get_field('section_bg_image', 'option');

	$collection_title = get_field('collection_title', 'option');

	$collection_text = get_field('collection_text', 'option');

	$collection_button = get_field('collection_button', 'option');

?>

    <div class="collections-wrapper" style="background: url('<?php echo $section_bg_image; ?>') no-repeat center / cover;">

    	<div class="container">

				<h5 class="collections-title"><?php echo $collection_title; ?></h5>

				<?php echo $collection_text; ?>

				<?php if($collection_button) {

						$link_url = $collection_button['url'];

						$link_title = $collection_button['title'];

						$link_target = $collection_button['target'] ? $collection_button['target'] : '_self' ;

							echo '<a class="all-collections" href="'.$link_url.'" target="'.$link_target.'">'.$link_title.'</a>';

					}

			  ?>

			</div>

		</div>

    <?php

	return ''.ob_get_clean();	

}



//Blog Page Full Posts

add_shortcode('full_blog_page', 'codex_full_blog_page');

function codex_full_blog_page() {

	ob_start();

      wp_reset_postdata();

?>

<div class="blog-content-area">

	<?php 

	   // Example for adding WP PageNavi to a new WP_Query call

	      $paged = get_query_var('paged') ? get_query_var('paged') : 1;

	      $args = array('post_type' => '', 'posts_per_page' => 3, 'paged' => $paged);

	      $loop = new WP_Query( $args );

	      while ( $loop->have_posts() ) : $loop->the_post();

	?>

       <div class="post-wrapper">

		<div class="post-thumbnail"> <?php echo get_the_post_thumbnail( get_the_ID(), '' );?></div>

	    <div class="post-content">

	      <div class="post-category"><?php foreach((get_the_category()) as $category) { echo $category->cat_name . ' '; } ?></div>

	      <div class="post-date"><i class="fa-solid fa-calendar-days"></i><?php echo get_the_time('d M, Y', $custom_post->ID); ?></div>

	      <div class="post-author"><i class="fa-solid fa-user"></i><?php echo get_the_author_meta('display_name', $author_id); ?></div>

		  <div class="post-title"><h4><?php the_title();?></h4></div>

		  <div class="post-more"><a href="<?php the_permalink(); ?>">Read More</a></div>

        </div>

       </div>

<?php

endwhile; ?>

<div class="page-navi"><?php wp_pagenavi( array( 'query' => $loop ) ); ?></div>

</div>

<?php

      wp_reset_postdata();

	return ''.ob_get_clean();

}