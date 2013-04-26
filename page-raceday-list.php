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
<tr>
<th>Number</th>
<th>BHAA</th>
<th>Name</th>
<th>Standard</th>
<th>Company</th>
</tr>';

foreach($list as $racetec) : ?>
<tr class="row">
<td class="cell"><?php echo $racetec->racenumber;?></td>
<td class="cell"><?php echo $racetec->runner;?></td>
<td class="cell"><?php echo $racetec->firstname;?> <?php echo $racetec->lastname;?></td>
<td class="cell"><?php echo $racetec->standard;?></td>
<td class="cell"><?php echo $racetec->companyname;?></td>
</tr>
<?php endforeach;?>
</table>

<?php 
get_footer(); 
?>