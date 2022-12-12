<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

<meta charset="<?php bloginfo( 'charset' ); ?>">

<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<div class="main-wrapper full-section">

<!--Header-->

<div class="header-wrapper full-section">

	<div class="container">

		<div class="social-media">

            <?php

            $rows = get_field('social_icons', 'option');

            if ($rows) {

                echo '<ul>';

                foreach ($rows as $row) {

                    $social_icon = $row['social_icon'];

                    $social_link = $row['social_link'];

                    echo '<li>';

                    if ($social_link) {

                        echo '<a href="' . $social_link . '" target="_blank"><i class="fa ' . $social_icon . '"></i></a>';

                    }

                    echo '</li>';

                }

                echo '</ul>';

            }

            ?>

        </div>

    	<div class="logo-wrapper">

        	<?php

				$logo = get_field('logo_image', 'option');

				echo '<a href="' . home_url( '/' ) . '">';

					if($logo) {

						echo '<img src="' . $logo . '" />';

					} else {

						echo '<img src="' . get_stylesheet_directory_uri() . '/images/logo.png" />';

					}

				echo '</a>';

			?>

        </div>

        <div class="cart-area">


        </div>

    </div>
</div>

<?php

	if( has_nav_menu('main-menu') ){   

		echo '<div class="navigation-wrapper full-section">';

		echo '<div class="container">';

			wp_nav_menu(

			array(

			'theme_location'  => 'main-menu',

			'container_class' => 'main-menu'

		));

		echo '</div>';

		echo '</div>';

	}

?>

<?php if ( wp_is_mobile() ) { ?> 

    <div class="menu-button">&nbsp;</div>

     <div class="mobile-menu"> 

			<?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>

     </div> 

<?php } ?>