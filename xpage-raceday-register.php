<?php
/**
 * Template Name: BHAA Raceday Register
 */

if ( !current_user_can( 'edit_users' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

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
 	
 	if(trim($_POST['money']) === '')  {
 		$moneyError = 'Please select the money.';
 		$hasError = true;
 	} else {
 		$money = trim($_POST['money']);
 	}
	
 	$standard = trim($_POST['standard']);
 	$firstname = trim($_POST['firstname']);
 	$lastname = trim($_POST['lastname']);
 	
	if(!isset($hasError))
	{
 		error_log($raceid.' '.$runner.' '.$number);
 		$res = Registration::get_instance()->registerRunner($raceid,$runner,$number,$standard,$money);
 		if(gettype($res)=='string')
 		{
 			$hasError = true;
 			$duplicateError = $res;
 		}
 		else
 			$registrationSubmitted = true;
	}
}
elseif(isset($_GET['newmember']))
{
// 	error_log("new member linked!");
	$runner = trim($_GET['runner']);
	$firstname = trim($_GET['firstname']);
	$lastname = trim($_GET['lastname']);
	$gender = trim($_GET['gender']);
	$dateofbirth = trim($_GET['dateofbirth']);
}
// http://stackoverflow.com/questions/11368368/404-when-using-post-get-parameters-in-wordpress-3-4
wp_register_script(
	'bhaa_members',
	content_url().'/bhaa_members.js');
wp_enqueue_script('bhaa_members');

wp_register_script(
	'bhaa-raceday',
	content_url().'/plugins/bhaawp-master/assets/js/bhaa-raceday.js');
wp_enqueue_script('bhaa-raceday');

get_header();
//echo "<pre>GET "; print_r($_GET); echo "</pre>";
//echo "<pre>POST "; print_r($_POST); echo "</pre>";
?>
	
<?php 
echo '<div id="container">';
include_once 'page-raceday-header.php';
echo "<h3>BHAA Member</h3>";
	echo '<div class="main">';

if(isset($registrationSubmitted) && $registrationSubmitted == true) 
{
	// redirect to registration page
	echo '<div class="thanks"><h2>BHAA Runner <b>'.stripslashes($firstname.' '.$lastname).'</b> with ID <b>'.trim($_POST['runner']).'</b> has been registered with number <b>'.$number.'</b></h2></div>';
}
else
{
	// http://jqueryui.com/autocomplete/#custom-data
	// http://stackoverflow.com/questions/11349205/jqueryui-autocomplete-custom-data-and-display
	// http://stackoverflow.com/questions/4717488/jquery-ui-autocomplete-search-more-than-just-label-within-a-local-json-array
	echo apply_filters('the_content',
		'[one_half last="no"]
			<div class="navbar-search pull-left" align="left">
				<input size="35" type="text" placeholder="Search BHAA Member by Name OR ID" id="memberfilter"/>
			</div>
 	[/one_half][one_half last="yes"][/one_half]');
	
	$races = Registration::get_instance()->getNextRaces();
	$selectRaces = '';
	$i=0;
	foreach($races as $race)
	{
		$rname = $race->dist.$race->unit;
		if($i==0)
			$selectRaces .= sprintf('<input type="radio" name="raceid" value="%s" checked>%s</input>',$race->id,$rname);
		else
			$selectRaces .= sprintf('<input type="radio" name="raceid" value="%s">%s</input>',$race->id,$rname);
		$i++;
	}
		
	if(isset($hasError) && $hasError==true)
	{
		$errorMessages = '';
		if(isset($runnerError))
			$errorMessages .=$runnerError.'</br>';
		if(isset($numberError))
			$errorMessages .=$numberError.'</br>';
		if(isset($duplicateError))
			$errorMessages .=$duplicateError.'</br>';
		if(isset($moneyError))
			$errorMessages .=$moneyError.'</br>';
		if(isset($raceError))
			$errorMessages .=$raceError.'</br>';
		echo apply_filters('the_content','[one_half last="no"][alert type="error"]'.$errorMessages.'[/alert][/one_half]');
	}

	echo apply_filters('the_content','
<form action="" id="bhaa-registration-form" name="bhaa-registration-form" method="POST">
[one_third last="no"]
<b>Race Details</b>
[/one_third]
[one_third last="no"]
<b>Runner Details</b>
[/one_third]
[one_third last="yes"]
<b>BHAA Details</b>
[/one_third]

[one_third last="no"]
<b>RaceNumber:</b><input type="text" name="number" id="number" value="'.$number.'"/>
[/one_third]
[one_third last="no"]
<b>Firstname:</b><input type="text" name="firstname" id="firstname" value="'.$firstname.'"/>
[/one_third]
[one_third last="yes"]
<b>ID:</b><input type="text" name="runner" id="runner" readonly=true value="'.$runner.'"/>
[/one_third]
			
[one_third last="no"]
<b>Race:</b>'.$selectRaces.'
[/one_third]
[one_third last="no"]
<b>Surname:</b><input type="text" name="lastname" id="lastname" value="'.$lastname.'"/>
[/one_third]
[one_third last="yes"]
<b>Standard:</b><input type="text" name="standard" id="standard" readonly=true value="'.$standard.'"/>
[/one_third]
	
[one_third last="no"]
<b>Money:</b><input type="radio" name="money" value="1">10e Member</input><input type="radio" name="money" value="3">25e Renewal</input><input type="radio" name="money" value="2">15e Inactive</input>
[/one_third]
[one_third last="no"]
<b>Gender:</b><input type="radio" name="gender" value="M" id="gendermale">M</input><input type="radio" name="gender" value="W" id="genderfemale">W</input>
[/one_third]
[one_third last="yes"]
<b>Company:</b><input type="text" name="company" id="company" readonly=true/>
[/one_third]

[one_third last="no"]
[/one_third]
[one_third last="no"]
<b>DOB:</b><input type="text" value="'.$dateofbirth.'" name="dateofbirth" id="dateofbirth"/>
[/one_third]
[one_third last="yes"]
[/one_third]
			
[one_third last="no"]
<input id="bhaa-raceday-register-submit" type="submit" value="Register Runner"/>
[/one_third]
[one_third last="no"]
<input type="hidden" name="form-submitted" value="true" />
[/one_third]
[one_third last="yes"]
[/one_third]

</form>');
}
	echo '</div>';
echo '</div>';
?>

<?php get_footer(); ?>