<?php
/**
 * Template Name: BHAA Raceday PreRegistered
 */
if ( !current_user_can( 'edit_users' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

global $BHAA;

if(isset($_POST['form-submitted']))
{
	if(trim($_POST['runner']) === '') {
		$runnerError = 'Please enter a runner ID.';
		$hasError = true;
	} else {
		$runner = trim($_POST['runner']);
	}

	if(trim($_POST['number']) === '')  {
		$numberError = 'Please enter a race number.';
		$hasError = true;
	} else {
		$number = trim($_POST['number']);
	}

	if(trim($_POST['raceid']) === '')  {
		$raceError = 'Please select a race.';
		$hasError = true;
	} else {
		$raceid = trim($_POST['raceid']);
	}

	//$standard = trim($_POST['standard']);
	//error_log('pre-reg:'.$raceid.' '.$runner.' '.$number);
	if(!isset($hasError))
	{
		
		$res = $BHAA->registration->preRegisterRunner($raceid,$runner,$number);
		if(gettype($res)=='string')
		{
			$hasError = true;
			$duplicateError = $res;
		}
		else
			$registrationSubmitted = true;
	}
}

get_header();
//echo "<pre>GET "; print_r($_GET); echo "</pre>";
//echo "<pre>POST "; print_r($_POST); echo "</pre>";

include_once 'page-raceday-header.php';

if(isset($hasError) && $hasError==true)
{
	$errorMessages = '';
	if(isset($runnerError))
		$errorMessages .=$runnerError.'</br>';
	if(isset($numberError))
		$errorMessages .=$numberError.'</br>';
	if(isset($duplicateError))
		$errorMessages .=$duplicateError.'</br>';
	if(isset($raceError))
		$errorMessages .=$raceError.'</br>';
	echo apply_filters('the_content','[alert type="error"]'.$errorMessages.'[/alert]');
}

$racetec = $BHAA->registration->listPreRegisteredRunners();

echo '<table id="raceteclist" >
<tr class="row">
<th class="cell">BHAA ID</th>
<th class="cell">Name</th>
<th class="cell">DOB</th>
<th class="cell">Company</th>
<th class="cell">Membership Status</th>
<th class="cell">Assign Race Number</th>
</tr>';

foreach($racetec as $racetec) : ?>
<tr class="row">
<td class="cell"><?php echo $racetec->runner;?></td>
<td class="cell"><?php echo $racetec->firstname;?> <?php echo $racetec->lastname;?></td>
<td class="cell"><?php echo $racetec->dateofbirth;?></td>
<td class="cell"><?php echo $racetec->status;?></td>
<td class="cell"><?php echo $racetec->companyname;?></td>
<td class="cell">
<form action="" id="bhaa-prereg-form" method="POST">
	<input type="text" name="number"/>
	<input type="hidden" name="raceid" value="<?php echo $racetec->race;?>">
	<input type="hidden" name="runner" value="<?php echo $racetec->runner;?>">
	<input type="hidden" name="form-submitted" value="true"/>
	<input type="submit" value="<?php echo $racetec->firstname;?> <?php echo $racetec->lastname;?> Race Number"/>
</form>
</td>
</tr>
<?php endforeach;?>
</table>

<?php 
get_footer(); 
?>