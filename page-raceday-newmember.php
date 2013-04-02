<?php
/**
 * Template Name: BHAA Raceday New Member
 */

global $BHAA;

if(isset($_POST['form-submitted'])) 
{
 	if(trim($_POST['firstname']) === '') {
 		$runnerError = 'Please enter firstname.';
 		$hasError = true;
 	} else {
 		$firstname = trim($_POST['firstname']);
 	}
 	
 	if(trim($_POST['lastname']) === '') {
 		$runnerError = 'Please enter lastname.';
 		$hasError = true;
 	} else {
 		$lastname = trim($_POST['lastname']);
 	}

 	if(trim($_POST['gender']) === '')  {
 		$numberError = 'Please enter gender.';
 		$hasError = true;
 	} else {
 		$gender = trim($_POST['gender']);
 	}
 	
 	if(trim($_POST['dateofbirth']) === '')  {
 		$numberError = 'Please enter dateofbirth.';
 		$hasError = true;
 	} else {
 		$dateofbirth = trim($_POST['dateofbirth']);
 	}
	
	if(!isset($hasError))
	{
 		error_log($firstname.' '.$lastname.' '.$gender.' '.$dateofbirth);
 		$runner = $BHAA->registration->addNewMember($firstname,$lastname,$gender,$dateofbirth,$email);
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
	// http://localhost/raceday-newmember/raceday-registration/?runner=&d&firstname=23004&stname=POC&g=M&dob=12
	echo '<div class="thanks"><p>New runner with ID '.$runner.' has been registered.</p></div>';
	echo sprintf('<a href="./raceday-registration/?newmember=xxy&runner=&s&firstname=%s&lastname=%s&gender=%s&dateofbirth=%s">Next Step Register Runner %s</a>'
		,$runner,$firstname,$lastname,$gender,$dateofbirth,$runner);
}
else
{
	// http://jqueryui.com/autocomplete/#custom-data
	// http://stackoverflow.com/questions/11349205/jqueryui-autocomplete-custom-data-and-display
	echo apply_filters('the_content','
		<form action="" id="bhaa-raceday-newmember" method="POST">
			[one_half last="no"]
			<b>Runner Details - REQUIRED</b><br/>
			Firstname<input type="text" name="firstname"/><br/>
			Surname<input type="text" name="lastname"/><br/>
			Gender<input type="checkbox" name="gender" value="M">M<input type="checkbox" name="gender" value="W">W<br/>
			DOB<input type="text" name="dateofbirth"/><br/>
			[/one_half]
			[one_half last="yes"]
			<b>Extra Details</b><br/>
			Email<input type="text" name="email"/><br/>
			Mobile<input type="text" name="mobile"/><br/>
			Company<input type="text" name="company"/><br/>
			<input type="submit" value="Register New Runner"/>
			[/one_half]
			<input type="hidden" name="form-submitted" value="true" />
		</form>');
}
echo '</div>';
?>
<?php get_footer(); ?>