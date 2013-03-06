<?php

get_header();
echo '<section id="primary">';

while ( have_posts() ) : the_post();
echo '<h1>'.get_the_title().'</h1>';

$leagueSummary = new LeagueSummary(get_the_ID());

echo '<h2>'.$leagueSummary->getName().''.get_the_ID().'</h2>';

//var_dump(get_terms('division'));
//echo get_the_term_list( get_the_ID(), 'division', 'Divisions: ', ', ', '' );
//$terms = get_the_terms( get_the_ID(), 'division' );
//$taxonomies=get_taxonomies('','division');

$terms = get_terms('division');
echo '<ul>';
foreach ($terms as $term) {
	echo '<li><a href="'.get_term_link($term->slug, 'division').'/id/'.get_the_ID().'">Division '.$term->name.'</a></li>';
}
echo '</ul>';

//var_dump($taxonomies,1);

$leaguesummary=$leagueSummary->getLeagueSummary();

$i = 0;
$division='';
foreach($leaguesummary as $summary) :

if($summary->leaguedivision!=$division)
{
	$i++;
	echo '<h3>Division '.$summary->leaguedivision.'</h3>';
	$division=$summary->leaguedivision;
	
	echo '<table>';
	echo '<tr>
    <th>Name</th>
    <th>Points</th>
	<th>Races</th>
  	</tr>';
}
else
{
	// specific row
	echo '<tr>
    <td>'.$summary->display_name.'</td>
    <td>'.$summary->leaguepoints.'</td>
	<td>'.$summary->leaguescorecount.'</td>
  	</tr>';
}

// close the table
if($summary->leagueposition==10)
{
	echo '</table>';
}

endforeach;

//var_dump($summary,1);

endwhile;

echo '</section>';
get_footer();
?>