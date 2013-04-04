<?php
/**
 * Template Name: BHAA Raceday Admin
 */
if ( !current_user_can( 'manage_options' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

global $BHAA;

if(isset($_GET['action']))
{
	$runner = trim($_GET['runner']);
	$race = trim($_GET['raceid']);
	error_log("delete action ".$runner.' '.$race);
	$BHAA->registration->deleteRunner($runner,$race);
}

get_header();

$racetec = $BHAA->registration->listRegisteredRunners();

echo '<h2>BHAA RACE DAY ADMIN</h2>';

echo '<table id="raceteclist" >
<tr class="row">
<th class="cell">Name</th>
<th class="cell">Number</th>
<th class="cell">DELETE</th>
</tr>';

foreach($racetec as $racetec) : ?>
<tr class="row">
<td class="cell"><?php echo $racetec->firstname;?> <?php echo $racetec->lastname;?></td>
<td class="cell"><?php echo $racetec->racenumber;?></td>
<td class="cell"><?php echo sprintf('<a href="/raceday-admin/?action=delete&runner=%d&raceid=%d">%d</a>',$racetec->runner,$racetec->race,$racetec->runner);?></td>
</tr>
<?php endforeach;?>
</table>

<?php 
get_footer(); 
?>