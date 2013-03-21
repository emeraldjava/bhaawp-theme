<?php
/**
 * Template Name: BHAA Registration
 */

get_header();

echo '<section id="primary">';
echo apply_filters('the_content',do_shortcode('[bhaa_registration]'));
echo '</section>';
?>