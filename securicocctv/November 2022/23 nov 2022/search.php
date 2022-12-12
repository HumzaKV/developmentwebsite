<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>

<?php
if ($layout['text_align'] == 'center'):
    $justify = 'justify-content-center';
    $text_align = 'text-center';
elseif ($layout['text_align'] == 'right'):
    $justify = 'justify-content-end';
    $text_align = 'text-right';
    $padding = 'pr-lg-5';
elseif ($layout['text_align'] == 'left'):
    $justify = 'justify-content-start';
    $text_align = 'text-left';
    $padding = 'pl-lg-5';
endif;

if ($layout['text_colour'] == 'Light') {
    $colour = 'light_text';
} elseif ($layout['text_colour'] == 'Dark') {
    $colour = 'dark_text';
}

if ($layout['margin'] == 'Top') {
    $margin = 'mt-5';
} elseif ($layout['margin'] == 'Bottom') {
    $margin = 'mb-5';
} elseif ($layout['margin'] == 'Top and Bottom') {
    $margin = 'my-5';
} elseif ($layout['margin'] == 'None') {
    $margin = 'my-0';
}

if ($layout['container'] == 'Container Fluid') {
    $container = 'container-fluid p-0';
} elseif ($layout['container'] == 'Container') {
    $container = 'container';
}

if ($layout['column_size'] == 'Small') {
    $column_size = 'col-12 col-md-5';
} elseif ($layout['column_size'] == 'Large') {
    $column_size = 'col-12';
}

?>
    <div class="clear_both tall-hero-wrapper w-100 my-0"
         style="background:url('http://acd.wowdev.co.uk/assets/2020/07/books.jpg');background-size:cover;background-repeat:no-repeat;background-position:center;">
        <div class="overlay"></div>
        <div class="container">
            <div class="d-flex justify-content-end">
                <div class="col-12 col-md-5 text-right">
                    <div class="tall-hero-text light_text">
                        <h1>SEARCH RESULTS</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="search-container">
        <section id="primary" class="content-area col-sm-12 col-lg-15">
            <main id="main" class="site-main" role="main">
                <div class="container">
                    <!-- Display Search Form On the Top of the search page -->
                    <div class="search-page-form" id="ss-search-page-form"><?php get_search_form(); ?></div>

                    <?php if (have_posts()) : ?>

                        <header class="page-header" id="search-title">
                            <span class="search-page-title"><?php printf(esc_html__('Search Results for: %s', 'stackstar'), '<span>' . get_search_query() . '</span>'); ?></span>
                        </header><!-- .page-header -->
                        <div class="d-flex flex-wrap row">
                            <?php while (have_posts()) : the_post();
                                $excerpt = get_the_excerpt();
                                $excerpt_small = substr($excerpt, 0, 125) . '...';
                                ?>
                                <?php 
                                echo ('SRC'.!empty(get_the_post_thumbnail_url(null, 'full')) ? get_the_post_thumbnail_url(null, 'full') :  EB_PLUGIN_URL. '/images/no-image.jpg');?>
                                <div class="col-md-6 mb-5 col-lg-3 text-center course-box">
                                    <div class="course-info">
                                        <div class="image"><img style="height:183px !important; object-fit:cover;"
                                                                src=""
                                                                class="w-100" alt="Animal Care Courses" loading="lazy">
                                        </div>
                                        <h2 style=" text-overflow: ellipsis;overflow: hidden; white-space: nowrap;"
                                            class="cat-title text-overflow"><?php the_title(); ?></h2>
                                        <a class="button btn_green_new"
                                           href="<?php the_permalink(); ?>">View</a>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else : ?>

                        <?php //get_template_part( 'template-parts/content', 'none' ); ?>
                        <div class="no-content">
                            <h3>Ooopss, looks like nothing matches your result.</h3>
                        </div>


                    <?php endif; ?>

                </div>

            </main><!-- #main -->
        </section><!-- #primary -->
    </div>

<?php
get_footer();
