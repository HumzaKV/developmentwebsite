<?php get_header();
/* 

 * Template Name: Blog Template

 */
$page_builder = get_field('blog_newsletter', 'option');
?>
<div class="content-wrapper full-section">
  <div class="gdl-page-item blog-wrapper">
    <?php  
      $blog_banner = get_field('blog_banner', 'options');
      $banner_option = $blog_banner['banner_option'];
      $background_image = $blog_banner['background_image'];
      $show_categories = $blog_banner['show_categories'];
    ?>
    <?php if ($banner_option == "yes"): ?>
      <div class="blog-banner" style="background-image: url('<?php echo $background_image; ?>');">
        <div class="container">
          <div class="blog-search">
            <form method="get" id="searchform" action="<?php  echo home_url(); ?>/">
              <div class="search-text">
                <input type="text" placeholder="Search the blog" value="<?php the_search_query(); ?>" name="s" id="s" autocomplete="off" />
              </div>
              <div class="search-submit">
                <input type="submit" id="searchsubmit" value="" />
              </div>
            </form>
          </div>
          <?php if ($show_categories == 'yes'): ?>
            <div class="blog-categories">
              <?php
                $categories = get_categories( array(
                    'orderby' => 'name',
                    'order'   => 'ASC',
                    'number' => 4,

                ) );

                foreach( $categories as $category ) { ?> 
                 <a href="<?php echo get_category_link($category->term_id); ?>"><?php echo $category->name; ?> </a>
                <?php } ?>
            </div>  
          <?php endif ?>
        </div>
      </div>
    <?php endif ?>
    <div class="blog-content-area">
      <div class="container">
        <div class="blog-left">
    		  <?php
            $args = array(
              'post_type' => 'post',
              'posts_per_page' => 3,
              'order' => 'ASC',
            );
          $loop = new WP_Query( $args );
            while ( $loop->have_posts() ) : $loop->the_post();  ?>
              <div class="post-wrapper">
                <div class="post-wrapper-inner">
                  <div class="post-thumbnail"> 
                    <?php if ( has_post_thumbnail() ) { ?>
                      <a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail( get_the_ID(), 'post_size' );?></a>      
                    <?php } else { ?>
                      <a href="<?php the_permalink(); ?>"><img src="http://developmentwebsite.biz/wordpress/securicocctv/wp-content/uploads/2021/09/NoImageFound.jpg"></a>      
                    <?php } ?>
                    
                  </div><!-- post-thumbnail -->
                  <div class="post-info">
                    <div class="post-title">
                      <h3><a href="<?php the_permalink(); ?>"> <?php the_title();?> </a></h3>
                    </div><!-- post-title -->
                    <div class="post-detail">
                      <p>Story by: <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>"> <?php the_author();?> </a></p> 
                      <p>|</p>
                      <p><?php the_date('j F Y');?></p>
                    </div><!-- post-detail -->
                  </div><!-- post-info -->
                </div><!-- post-wrapper-inner -->
              </div><!-- post-wrapper -->
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        <div class="blog-right">
          <?php dynamic_sidebar('Blog'); ?>
          <div class="sidebar-post">
            <?php
                $sidebar_blog_options = get_field('sidebar_blog_options', 'option');
              if( $sidebar_blog_options ) : 
                $add_main_class = $sidebar_blog_options['add_main_class'];
                $view_post = $sidebar_blog_options['view_post'];
                $our_id  = $sidebar_blog_options['select_post'];

                $title = get_the_title( $our_id );
                $permalink = get_permalink( $our_id );
                $post_image = wp_get_attachment_url( get_post_thumbnail_id( esc_html( $our_id )) );
                $date = get_the_time('j F Y', $our_id);
                $author_id = get_post_field( 'post_author', $our_id );
                $author_name = get_the_author_meta( 'display_name', $author_id );
                $author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );
            ?>
            <div id="sidebar-blog-option" class="sidebar-blog-option <?php echo $add_main_class; ?>">
              <?php if( $our_id ): ?>
                <!-- <a href="<?php //echo $permalink; ?>"> -->
                  <div class="side-post">
                    <div class="image"><a href="<?php echo $permalink; ?>"><img src="<?php echo $post_image; ?> "></a></div>
                    <div class="title"><h3><a href="<?php echo $permalink; ?>"><?php echo $title; ?></a></h3></div>
                    <div class="details">
                      <p class="story-by">STORY BY: <a href="<?php echo $author_link; ?>"><?php echo $author_name; ?></a></p>
                      <p>|</p>
                      <p class="date"><?php echo $date; ?></p>
                    </div>
                  </div>
                <!-- </a> -->
              <?php endif; ?>
            </div>
            <?php endif; ?>
          </div>
        </div><!-- blog-right -->
      </div><!-- .container -->
    </div><!-- blog-content-area -->
    
    <?php
      $add_main_class = $page_builder['add_main_class'];
      $background_color  = $page_builder['background_color'];
      $background_left_image  = $page_builder['background_left_image'];
      $right_image  = $page_builder['right_image'];
      $content  = $page_builder['content'];
    ?>
    <section id="newsletter-section" class="newsletter-section full-section <?php echo $add_main_class; ?>">
      <div class="container">
        <div class="newsletter-strip" style="background: linear-gradient(90deg, <?php echo $background_color; ?> 95%, transparent 5%);">
          <?php echo $content; ?>     
        </div>
      </div>
      <style>
        section.newsletter-section .newsletter-strip:after { background-image: url('<?php echo $right_image; ?>'); }
        section.newsletter-section .newsletter-strip:before { background-image: url('<?php echo $background_left_image; ?>'); }
      </style>
    </section>

    <?php $blog_btm = get_field('blog_bottom' ,'option') ?>
    <?php if ( $blog_btm ): ?>
    <?php $blogs_count = $blog_btm['blogs_count'] ?>
      <div class="blog-bottom">
        <div class="container">
          <?php foreach ($blogs_count as $key => $bc): ?>
            <?php 
              $our_id = $bc['select_blogs'];
              $title = get_the_title( $our_id );
              $permalink = get_permalink( $our_id );
              $post_image = wp_get_attachment_url( get_post_thumbnail_id( esc_html( $our_id )) );
              $date = get_the_time('j F Y', $our_id);
              $author_id = get_post_field( 'post_author', $our_id );
              $author_name = get_the_author_meta( 'display_name', $author_id ); 
            ?>
              <div class="post-wrapper">
                <div class="post-wrapper-inner">
                  <div class="post-thumbnail"> 
                    <a href="<?php echo $permalink; ?>"><img src="<?php echo $post_image; ?> "></a>
                  </div><!-- post-thumbnail -->
                  <div class="post-info">
                    <div class="post-title">
                      <h3><a href="<?php echo $permalink; ?>"> <?php echo $title; ?> </a></h3>
                    </div><!-- post-title -->
                    <div class="post-detail">
                      <p>Story by: <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>"> <?php the_author();?> </a></p> 
                      <p>|</p>
                      <p><?php echo $date; ?></p>
                    </div><!-- post-detail -->
                  </div><!-- post-info -->
                </div><!-- post-wrapper-inner -->
              </div><!-- post-wrapper -->
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif ?>
  </div><!-- blog-wrapper -->
</div><!-- content-wrapper -->

<?php get_footer(); ?>