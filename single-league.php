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

$leagueSummaryByDivision=$leagueSummary->getLeagueSummaryByDivision();
//var_dump($leagueSummaryByDivision);

foreach($divisions as $division) :
//	echo $division->code;
endforeach;

$i = 0;
$division='';
$divisionTable = '';
foreach($leagueSummaryByDivision as $summary) :

if($summary->leaguedivision!=$division)
{
	$division=$summary->leaguedivision;
	$divisionTable = '';
	$i++;
	$divisionTable .= '<h3>Division '.$division.'</h3>'.PHP_EOL;
	$divisionTable .= '<table>'.PHP_EOL;
	$divisionTable .= '<tr>
	<th>Position</th>
    <th>Name</th>
    <th>Points</th>
	<th>Races</th>
  	</tr>'.PHP_EOL;
	//error_log("header");
}

if($division!='')
{
	error_log($division.' '.$summary->leagueposition);//.' '.$divisionTable);
	// specific row
	$divisionTable .= '<tr>
	<td>'.$summary->leagueposition.'</td>
    <td>'.$summary->display_name.'</td>
    <td>'.$summary->leaguepoints.'</td>
	<td>'.$summary->leaguescorecount.'</td>
  	</tr>'.PHP_EOL;
}

// close the table
if($summary->leagueposition==10)
{
	$divisionTable .= '</table>'.PHP_EOL;
	$division='';
	echo $divisionTable;
	//break;
}

endforeach;

endwhile;

echo '</section>';

if($data['blog_comments']):
	wp_reset_query();
	comments_template();
endif;
			
get_footer();
?>