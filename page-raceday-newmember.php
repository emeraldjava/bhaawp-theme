<?php
/**
 * Template Name: BHAA Raceday New Member
 */
if ( !current_user_can( 'edit_users' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

global $BHAA;

if(isset($_POST['form-submitted'])) 
{
	$runner = trim($_POST['runner']);
	
 	if(trim($_POST['firstname']) === '') {
 		$firstNameError = 'Please enter firstname.';
 		$hasError = true;
 	} else {
 		$firstname = trim($_POST['firstname']);
 	}
 	
 	if(trim($_POST['lastname']) === '') {
 		$lastNameError = 'Please enter lastname.';
 		$hasError = true;
 	} else {
 		$lastname = trim($_POST['lastname']);
 	}

 	if(trim($_POST['gender']) === '')  {
 		$genderError = 'Please enter gender.';
 		$hasError = true;
 	} else {
 		$gender = trim($_POST['gender']);
 	}
 	
 	$mysql_dob;
 	if(trim($_POST['dateofbirth']) === '')  {
 		$dobError = 'Please enter dateofbirth.';
 		$hasError = true;
 	} else {
 		$dateofbirth = trim($_POST['dateofbirth']);
 		
 		
 		if(preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $dateofbirth, $matches)) {
 			if (!checkdate($matches[2], $matches[1], $matches[3])) {
 				$dobError =  'Date '.$dateofbirth.' has an incorrect DD/MM/YYYY value somewhere.';
 				$hasError = true;
 			} else {
 				$mysql_dob = DateTime::createFromFormat('d/m/Y', $dateofbirth)->format('Y-m-d');
 				error_log($dateofbirth.' -> '.$mysql_dob);
 			}
 		} 
 		else {
 			$dobError =  'Date '.$dateofbirth.' is not in the correct DD/MM/YYYY format.';
 			$hasError = true; 			
 		} 		
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
	
	if(!isset($hasError))
	{
		// check if runner exists
		error_log('runner '.isset($runner).' $'.$runner.'$ '.$mysql_dob);
		if($runner=='')
		{
	 		$runner = $BHAA->registration->addNewMember($firstname,$lastname,$gender,$mysql_dob,$email);
		}
		// register new runner		
		$res = $BHAA->registration->registerRunner($raceid,$runner,$number,$standard);
		if(gettype($res)=='string')
		{
			$hasError = true;
			$duplicateError = $res;
		}
		else
			$registrationSubmitted = true;
	}
}

// wp_register_script(
// 	'bhaa_day_members',
// 	content_url().'/bhaa_day_members.js');
// wp_enqueue_script('bhaa_day_members');

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
	// http://stackoverflow.com/questions/2090366/date-validation-using-jquery-validation - datepicker
	// http://localhost/raceday-newmember/raceday-registration/?runner=&d&firstname=23004&stname=POC&g=M&dob=12
	echo '<div class="thanks"><h2>Day/New Runner <b>'.esc_html($firstname.' '.$lastname).'</b> with ID <b>'.$runner.'</b> has been registered with number <b>'.$number.'</b>.</h2></div>';
	//echo sprintf('<a href="/raceday-register/?newmember=xxy&runner=%s&firstname=%s&lastname=%s&gender=%s&dateofbirth=%s">Assign Runner %s a race number</a></p></div>'
		//,$runner,$firstname,$lastname,$gender,$dateofbirth,$runner);
}
else
{
// 	echo apply_filters('the_content',
// 			'[one_third last="yes"]
// 			<div class="navbar-search pull-left" align="left">
// 			Check for an existing day members : <input size="40" type="text" placeholder="Search by Name OR ID" id="memberfilter"/>
// 			[raw]<script type="text/javascript">
// jQuery(document).ready(
// 	function($){
	
// 	$("#dateofbirth").datepicker({ 
// 		dateFormat: "yy-mm-dd",
// 		defaultDate: "-30y", 
//         yearRange: "1920:1995",
// 		changeYear: true,
// 		changeMonth: true
//     	//maxDate: "-18y"
// 	}).val()
// 	$("#dateofbirth").keypress(function (e)	{
// 		e.preventDefault();
// 	});		
// 	$("#memberfilter").autocomplete({
// 		source: bhaa_day_members,
// 		minLength: 3,
// 		source: function (request, response) {
// 		    var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
// 		    response($.grep(bhaa_day_members, function(value) {
// 		        return matcher.test(value.label) || matcher.test(value.value);
// 		    }));
// 		},
// 		focus: function( event, ui ) {
//         	$("#memberfilter").val(ui.item.label);
//         	return false;
//       	},
// 		select: function(event, ui) {
// 			$("#runner").val( ui.item.id );
// 			$("#firstname").val( ui.item.firstname );
// 			$("#lastname").val( ui.item.lastname );
// 			$("#dateofbirth").val( ui.item.dob );
// 			$("#company").val( ui.item.company );
// 			if(ui.item.gender=="M") {
// 				$("#gendermale").prop("checked",true);
// 			} else {
// 				$("#genderfemale").prop("checked",true);
// 			}
// 			return true;
// 		}
// 	})
// 	.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
// 		return $("<li></li>")
//         	.data("item.autocomplete", item)
//         	.append("<a>"+item.label+" "+item.id+"</a><small>DOB:"+item.dob+", Status:"+item.status+"</small>")
// 			.appendTo(ul);
//     };
// });
// </script>[/raw]
// 		</div>
// 	[/one_third]<hr/>');
	
	$races = $BHAA->registration->getNextRaces();
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
		if(isset($firstNameError))
			$errorMessages .=$firstNameError.'</br>';
		if(isset($lastNameError))
			$errorMessages .=$lastNameError.'</br>';
		if(isset($genderError))
			$errorMessages .=$genderError.'</br>';
		if(isset($dobError))
			$errorMessages .=$dobError.'</br>';
		if(isset($numberError))
			$errorMessages .=$numberError.'</br>';
		if(isset($duplicateError))
			$errorMessages .=$duplicateError.'</br>';
		if(isset($raceError))
			$errorMessages .=$raceError.'</br>';
		echo apply_filters('the_content','[alert type="error"]'.$errorMessages.'[/alert]');
	}
	
	// http://jqueryui.com/autocomplete/#custom-data
	// http://stackoverflow.com/questions/11349205/jqueryui-autocomplete-custom-data-and-display
	echo apply_filters('the_content','
		<form action="" id="bhaa-raceday-newmember" name="bhaa-raceday-newmember" method="POST">
			[one_half last="no"]
			<b>15e Day or 25e New Member</b><br/>
			Firstname<input type="text" id="firstname" name="firstname" value="'.$firstname.'"/><br/>
			Surname<input type="text" id="lastname" name="lastname" value="'.$lastname.'"/><br/>
			Gender<input type="radio" name="gender" value="M" id="gendermale">M</input><input type="radio" name="gender" value="W" id="genderfemale">W</input><br/> 
			DOB<input type="text" placeholder="DD/MM/YYYY" name="dateofbirth" id="dateofbirth" value="'.$dateofbirth.'"/><br/>
			RaceNumber<input type="text" name="number" id="number" value="'.$number.'"/><br/>
			Race'.$selectRaces.'<br/>
			<input type="submit" value="Register New Runner"/>
			[/one_half]
			<input type="hidden" name="form-submitted" value="true" />
		</form>');
// [one_half last="yes"]
// <b>Extra Details</b><br/>
// Email<input type="text" name="email"/><br/>
// Mobile<input type="text" name="mobile"/><br/>
// Company<input type="text" name="company"/><br/>
// [/one_half]
}
echo '</div>';
?>
<?php get_footer(); ?>
