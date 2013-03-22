<?php
get_header();
echo '<section id="primary">';

while ( have_posts() ) : the_post();
echo '<h1>'.get_the_title().'</h1>';

//echo '<h2>'.$_GET('division').'</h2>';
if(isset($wp_query->query_vars['division'])) {
	$sMsdsCat = urldecode($wp_query->query_vars['division']);
	echo '<h3>div '.$sMsdsCat.'</h3>';
}
else
	echo '<h3>no div'.$sMsdsCat.'</h3>';
	
$leagueSummary = new LeagueSummary(get_the_ID());
$divisions = $leagueSummary->getDivisions();
//var_dump($divisions);

//echo '<p>After a long delay the league tables are nearly back. There might be an odd sum or two incorrect and we still have to update the Race Organiser points. Hopefully St Patrick will rub a bit of polish onto proceeding over the weekend.</p>';
//echo '<h2>'.$leagueSummary->getName().''.get_the_ID().'</h2>';

$rows_in_summary=5;
$leagueSummaryByDivision=$leagueSummary->getLeagueSummaryByDivision($rows_in_summary);
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
	
	$divisionTable .= sprintf('<h3><a href="%s">Division %s</a><h3>'.PHP_EOL,
		add_query_arg(array('division'=>$division)),
		$division);
	
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
	// specific row
	$divisionTable .= '<tr>
	<td>'.$summary->leagueposition.'</td>
    <td>'.$summary->display_name.'</td>
    <td>'.$summary->leaguepoints.'</td>
	<td>'.$summary->leaguescorecount.'</td>
  	</tr>'.PHP_EOL;
}

// close the table
if($summary->leagueposition==$rows_in_summary)
{
	$divisionTable .= '</table>'.PHP_EOL;
	$division='';
	echo $divisionTable;
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