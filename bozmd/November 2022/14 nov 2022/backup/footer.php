<?php 
$footer_bg_image = get_field('footer_bg_image', 'option');
$show_newsletter_form = get_field('show_newsletter_form');
$show_instagram_feeds = get_field('show_instagram_feeds');
$instagram_username = get_field('instagram_username', 'option');
$instagram_section_title = get_field('instagram_section_title', 'option');
$insta_image = get_field('insta_image', 'option');
if ($show_instagram_feeds == 'true') {
    echo '<div class="footer-instagram full-section">';
      echo '<div class="container">';
        echo '<a class="insta-link" href="https://www.instagram.com/' . $instagram_username . '" target="_blank">@' . $instagram_username . '</a>';
        echo '<h2 class="sec-title">' . $instagram_section_title . '<img src="'. get_template_directory_uri() .'/images/instagram-icon.svg"></h2>';
	    echo '<img src="' . $insta_image . '">';
      echo '</div>';
    echo '</div>';
}
if ($show_newsletter_form == 'true') {
    echo '<div class="footer-newsletter full-section">';
     echo '<div class="container">';
       echo do_shortcode('[gravityform id=2 title=true description=true ajax=true]'); 
     echo '</div>';   
    echo '</div>';
}
?>
<div class="footer-wrapper full-section" style="background:url('<?php echo $footer_bg_image; ?>') no-repeat center center;background-size:cover;">
	<div class="footer-widget">
	   <div class="container">
         <div class="footer-col-1">
		    <div class="logo-wrapper">
		        <?php
					$logo = get_field('logo_image', 'option');
					echo '<a href="' . home_url( '/' ) . '">';
						if($logo) {
					echo '<img src="' . $logo . '" />';
						}
					echo '</a>';
				?>
            </div>
          <div class="social-media">
            <h5>Social Media</h5>
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
          <div class="footer-info-box">
            <?php
            $rows = get_field('footer_boxes', 'option');
            if ($rows) {
                echo '<ul>';
                foreach ($rows as $row) {
                    $box_title = $row['box_title'];
                    $box_content = $row['box_content'];
                    echo '<li>';
                      if($box_title) {
                        echo '<h6>' . $box_title . '</h6>';
                      }
                      if($box_content) {
                        echo '<p>' . $box_content . '</p>';
                      }
                    echo '</li>';
                }
                echo '</ul>';
            }
            ?>
          </div>
         </div>
         <div class="footer-col-2">
         	<?php
            $facebook_widget_title = get_field('facebook_widget_title', 'option');
            $facebook_widget_code = get_field('facebook_widget_code', 'option');
            if($box_title) {
               echo '<h5>' . $facebook_widget_title . '</h5>';
             }
             if($box_content) {
                        echo '<span>' . $facebook_widget_code . '</span>';
             }
          ?>
         </div>
         <div class="footer-col-3">
         	<?php
            $twitter_widget_title = get_field('twitter_widget_title', 'option');
            $twitter_widget_code = get_field('twitter_widget_code', 'option');
            if($box_title) {
               echo '<h5>' . $twitter_widget_title . '</h5>';
             }
             if($box_content) {
                        echo '<span>' . $twitter_widget_code . '</span>';
             }
          ?>
         </div>
		  </div>
  </div>
  <div class="copyright-wrapper">
    <div class="container">
        <?php
            $copyright_text = get_field('copyright_text', 'option');
             if($copyright_text) {
                echo '<div class="copyright-text">';
                echo '<p>'.$copyright_text.'</p>';
                echo '</div>';                      
             }       
         ?>
        <?php
            $website_credit = get_field('website_credit', 'option');
                if($website_credit) {
                    echo '<div class="website-credit">';
                    echo '<p>'.$website_credit.'</p>';
                    echo '</div>';                      
                }       
        ?>
    </div>
  </div>
</div>
<script>
<!--Responsive Menu-->
  jQuery(document).ready(function(){
		jQuery('.menu-button').click(function() {
			jQuery('.mobile-menu').toggleClass('active');
			jQuery('.mobile-menu').toggle();	
			jQuery('.menu-button').toggleClass('open');
		});
		jQuery('.menu-item-has-children').click(function() {
			jQuery(this).toggleClass('active');
		});
 });
</script>
<?php
echo '</div>'; //Main Wrapper
wp_footer();
?>
</body>
</html>