<?php get_header(); ?>
    <div class="content-wrapper full-section">
        <div class='container'>
             <div class="single-post-content">
                <?php
                    if( have_posts() ){
                        while ( have_posts() ){
                            the_post();
                ?>
              <div class="s-post-wrapper">
                <div class="s-post-thumbnail"> <?php echo get_the_post_thumbnail( get_the_ID(), '' );?></div>
                  <div class="s-post-content">
                    <div class="s-post-category"><i class="fa-solid fa-tags"></i><?php foreach((get_the_category()) as $category) { echo $category->cat_name . ' '; } ?></div>
                    <div class="s-post-date"><i class="fa-solid fa-calendar-days"></i><?php echo get_the_time('d M, Y', $custom_post->ID); ?></div>
                    <div class="s-post-author"><i class="fa-solid fa-user"></i><?php echo get_the_author_meta('display_name', $author_id); ?></div>
                  </div>
                  <div class="s-post-title"><h3><?php the_title();?></h3></div>
                  <div class="post-except"><?php the_content(); ?></div>
               </div>
              <?php } } ?>  
             </div>
             <?php echo do_shortcode('[right_sidebar]') ?>
        </div>
    </div>
<?php get_footer(); ?>