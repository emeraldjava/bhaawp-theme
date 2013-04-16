<?php
/**
 * Template Name: BHAA Raceday PreRegistered
 */
if ( !current_user_can( 'edit_users' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

global $BHAA;

get_header();

include_once 'page-raceday-header.php';

$racetec = $BHAA->registration->listPreRegisteredRunners();

echo '<table id="raceteclist" >
<tr class="row">
<th class="cell">BHAA ID</th>
<th class="cell">Name</th>
<th class="cell">DOB</th>
<th class="cell">Company</th>
<th class="cell">Assign Race Number</th>
</tr>';

foreach($racetec as $racetec) : ?>
<tr class="row">
<td class="cell"><?php echo $racetec->runner;?></td>
<td class="cell"><?php echo $racetec->firstname;?> <?php echo $racetec->lastname;?></td>
<td class="cell"><?php echo $racetec->dateofbirth;?></td>
<td class="cell"><?php echo $racetec->companyname;?></td>
<td class="cell">
<form>
	<input type="number" name="number"/>
	<input type="hidden" name="raceid" value="2597">
	<input type="hidden" name="runner" value="<?php echo $racetec->runner;?>">
	<input type="submit" value="<?php echo $racetec->firstname;?> <?php echo $racetec->lastname;?> Race Number"/>
</form>
</td>
</tr>
<?php endforeach;?>
</table>

<?php 
get_footer(); 
?>