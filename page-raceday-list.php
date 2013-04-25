<?php
/**
 * Template Name: BHAA Raceday List
 */
if ( !current_user_can( 'edit_users' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

global $BHAA;

get_header();

include_once 'page-raceday-header.php';

$list = $BHAA->registration->listRegisteredRunners();

echo '<h2>Total Runners '.sizeof($list).'</h2>';
echo '<table width="90%" id="raceteclist" >
<tr class="row">
<th class="cell">Race</th>
<th class="cell">Number</th>
<th class="cell">BHAA</th>
<th class="cell">Name</th>
<th class="cell">Standard</th>
<th class="cell">Company</th>
<th class="cell">Team</th>
</tr>';

foreach($list as $racetec) : ?>
<tr class="row">
<td class="cell"><?php echo $racetec->race;?></td>
<td class="cell"><?php echo $racetec->racenumber;?></td>
<td class="cell"><?php echo $racetec->runner;?></td>
<td class="cell"><?php echo $racetec->firstname;?> <?php echo $racetec->lastname;?></td>
<td class="cell"><?php echo $racetec->standard;?></td>
<td class="cell"><?php echo $racetec->companyname;?></td>
<td class="cell"><?php echo $racetec->teamname;?></td>
</tr>
<?php endforeach;?>
</table>

<?php 
get_footer(); 
?>