<?php
get_header();
echo '<section id="primary">';

while ( have_posts() ) : the_post();
echo '<h1>'.get_the_title().'</h1>';

$leagueSummary = new LeagueSummary(get_the_ID());
$divisions = $leagueSummary->getDivisions();
//var_dump($divisions);

//echo '<p>After a long delay the league tables are nearly back. There might be an odd sum or two incorrect and we still have to update the Race Organiser points. Hopefully St Patrick will rub a bit of polish onto proceeding over the weekend.</p>';
//echo '<h2>'.$leagueSummary->getName().''.get_the_ID().'</h2>';

//var_dump(get_terms('division'));
//echo get_the_term_list( get_the_ID(), 'division', 'Divisions: ', ', ', '' );
//$terms = get_the_terms( get_the_ID(), 'division' );
//$taxonomies=get_taxonomies('','division');

// $terms = get_terms('division');
// echo '<ul>';
// foreach ($terms as $term) {
// 	echo '<li><a href="'.get_term_link($term->slug, 'division').'">Division '.$term->name.'</a></li>';
// }
// echo '</ul>';

//var_dump($taxonomies,1);

$leagueSummaryByDivision=$leagueSummary->getLeagueSummaryByDivision();
var_dump($leagueSummaryByDivision);

foreach($divisions as $division) :
	echo $division->code;
endforeach;

$i = 0;
$division='';
foreach($leagueSummaryByDivision as $summary) :

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

// //var_dump($summary,1);

endwhile;


echo '</section>';

if($data['blog_comments']):
	wp_reset_query();
	comments_template();
endif;
			
get_footer();
?>