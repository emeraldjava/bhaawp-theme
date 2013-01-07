<?php
/**
 * Template Name: BHAA Join Disabled
 */
get_header(); 

// query for the membership page for its content
$your_query = new WP_Query('pagename=join');
while ( $your_query->have_posts() ) : $your_query->the_post();
echo the_content();
endwhile;
wp_reset_postdata();

echo do_shortcode('[alert type="general"]The online registration form is currently disabled while we prepare for the next event. Registration is available on the day at the next event[/alert]');
?>