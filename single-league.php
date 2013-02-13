<?php

get_header();
echo '<section id="primary">';

while ( have_posts() ) : the_post();
echo '<h1>'.get_the_title().'</h1>';

$leagueSummary = new LeagueSummary(get_the_ID());

echo '<h2>'.$leagueSummary->getName().''.get_the_ID().'</h2>';

$summary=$leagueSummary->getLeageSummary();
var_dump($summary,1);

//echo get_the_ID();
endwhile;

echo '</section>';
get_footer();
?>