<?php
/**
 * Template Name: BHAA Raceday New Member
 */

global $BHAA;

if(isset($_POST['form-submitted'])) 
{
 	if(trim($_POST['runner']) === '') {
 		$runnerError = 'Please enter runner runner.';
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
	
 	$raceid = trim($_POST['raceid']);

	if(!isset($hasError))
	{
 		error_log($raceid.' '.$runner.' '.$number);
 		$BHAA->registration->registerRunner($raceid,$runner,$number);
 		$registrationSubmitted = true;
	}
}

// http://stackoverflow.com/questions/11368368/404-when-using-post-get-parameters-in-wordpress-3-4
get_header();
//echo "<pre>GET "; print_r($_GET); echo "</pre>";
//echo "<pre>POST "; print_r($_POST); echo "</pre>";
?>

<div id="container">
	
<?php 
include_once 'page-raceday-header.php';

echo "<h3>BHAA New Member</h3>";

if(isset($registrationSubmitted) && $registrationSubmitted == true) 
{
	echo '<div class="thanks"><p>The runner has been registered.</p></div>';
}
else
{
	// http://jqueryui.com/autocomplete/#custom-data
	// http://stackoverflow.com/questions/11349205/jqueryui-autocomplete-custom-data-and-display
	echo apply_filters('the_content','
		<form action="" id="bhaa-raceday-newmember" method="POST">
			[one_half last="no"]
			<b>Runner Details - REQUIRED</b><br/>
			Firstname<input type="text" name="first" id="first"/><br/>
			Surname<input type="text" name="last" id="last"/><br/>
			Gender<input type="text" name="gender" id="gender"/><br/>
			DOB<input type="text" name="dob" id="dob"/><br/>
			[/one_half]
			[one_half last="yes"]
			<b>Extra Details</b><br/>
			Email<input type="text" name="company" id="company"/><br/>
			Mobile<input type="text" name="company" id="company"/><br/>
			Company<input type="text" name="company" id="company"/><br/>
			<input type="submit" value="Register New Runner"/>
			[/one_half]
			<input type="hidden" name="form-submitted" value="true" />
		</form>');
}
echo '</div>';
?>
<?php get_footer(); ?>