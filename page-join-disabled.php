<?php
/**
 * Template Name: BHAA Join Disabled
 */
get_header();

echo '<section>';
// query for the membership page for its content
$your_query = new WP_Query('pagename=join');
while ( $your_query->have_posts() ) : $your_query->the_post();
echo the_content();
endwhile;

echo '<div class="alert notice">';
echo '<div class="msg">The online registration form is currently disabled while we prepare for the next event. Registration is available on the day at the next event</div>';
echo '</div>';

echo '</section>';

get_footer();
?>