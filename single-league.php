<?php

get_header();
echo '<section id="primary">';

while ( have_posts() ) : the_post();
echo '<h1>'.get_the_title().'</h1>';

$leagueSummary = new LeagueSummary(get_the_ID());

//echo '<h2>'.$leagueSummary->getName().''.get_the_ID().'</h2>';

$limit=25;
$leaguesummary=$leagueSummary->getLeagueSummary($limit);

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
    <th>Position</th>
	<th>Name</th>
    <th>Points</th>
	<th>Races</th>
  	</tr>';
	echo '<tr>
	<td>'.$summary->leagueposition.'</td>
    <td>'.$summary->display_name.'</td>
    <td>'.$summary->leaguepoints.'</td>
	<td>'.$summary->leaguescorecount.'</td>
  	</tr>';
}
else
{
	// specific row
	echo '<tr>
	<td>'.$summary->leagueposition.'</td>
    <td>'.$summary->display_name.'</td>
    <td>'.$summary->leaguepoints.'</td>
	<td>'.$summary->leaguescorecount.'</td>
  	</tr>';
}

// close the table
if($summary->leagueposition==$limit)
{
	echo '</table>';
}

endforeach;

//var_dump($summary,1);

endwhile;

echo '</section>';

echo '<hr/>';

comments_template( '', true );

//$comments = get_comments('post_id='.get_the_ID());
//foreach($comments as $comment) :
//echo($comment->comment_author);
//endforeach;

get_footer();
?>