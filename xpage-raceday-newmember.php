<?php
/**
 * Template Name: BHAA Raceday New Member
 */
if ( !current_user_can( 'edit_users' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

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
 	
 	$mysql_dob = '';
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
 		} else {
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
 	
 	if(trim($_POST['money']) === '')  {
 		$moneyError = 'Please select the money.';
 		$hasError = true;
 	} else {
 		$money = trim($_POST['money']);
 	}
	
	if(!isset($hasError))
	{
		// check if runner exists
		error_log('runner '.isset($runner).' $'.$runner.'$ '.$mysql_dob);
		if($runner=='')
		{
	 		$runner = Registration::get_instance()->addNewMember($firstname,$lastname,$gender,$mysql_dob,$email);
		}
		// register new runner		
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

wp_register_script(
 	'bhaa_day_members',
 	content_url().'/bhaa_day_members.js');
wp_enqueue_script('bhaa_day_members');

// http://stackoverflow.com/questions/11368368/404-when-using-post-get-parameters-in-wordpress-3-4
get_header();
//echo "<pre>GET "; print_r($_GET); echo "</pre>";
//echo "<pre>POST "; print_r($_POST); echo "</pre>";
?>
<div id="container">
<?php 
include_once 'page-raceday-header.php';

echo "<h3>BHAA New Member</h3>";
echo '<div class="main">';

if(isset($registrationSubmitted) && $registrationSubmitted == true) 
{
	// http://stackoverflow.com/questions/2090366/date-validation-using-jquery-validation - datepicker
	// http://localhost/raceday-newmember/raceday-registration/?runner=&d&firstname=23004&stname=POC&g=M&dob=12
	echo '<div class="thanks"><h2>Day/New Runner <b>'.stripslashes($firstname.' '.$lastname).'</b> with ID <b>'.$runner.'</b> has been registered with number <b>'.$number.'</b>.</h2></div>';
	//echo sprintf('<a href="/raceday-register/?newmember=xxy&runner=%s&firstname=%s&lastname=%s&gender=%s&dateofbirth=%s">Assign Runner %s a race number</a></p></div>'
		//,$runner,$firstname,$lastname,$gender,$dateofbirth,$runner);
}
else
{
	// 	<input size="35" type="text" placeholder="Search Day Members by Name OR ID" id="memberfilter"/>
 	echo apply_filters('the_content',
 			'[one_half last="no"]
 			<div class="navbar-search pull-left" align="left">
 			</div>
 			<script type="text/javascript">
jQuery(document).ready(
 	function($){
	
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
 	$("#memberfilter").autocomplete({
 		source: bhaa_day_members,
 		minLength: 3,
 		source: function (request, response) {
 		    var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
 		    response($.grep(bhaa_day_members, function(value) {
 		        return matcher.test(value.label) || matcher.test(value.value);
 		    }));
 		},
 		focus: function( event, ui ) {
         	$("#memberfilter").val(ui.item.label);
         	return false;
       	},
 		select: function(event, ui) {
 			$("#runner").val( ui.item.id );
 			$("#firstname").val( ui.item.firstname );
 			$("#lastname").val( ui.item.lastname );
 			
 			$year = ui.item.dob.substring(0,4);
 			$month = ui.item.dob.substring(5,7);
 			$day = ui.item.dob.substring(8,10);
 			$("#dateofbirth").val( $day+"/"+$month+"/"+$year );
 			$("#company").val( ui.item.company );
 			if(ui.item.gender=="M") {
 				$("#gendermale").prop("checked",true);
 			} else {
 				$("#genderfemale").prop("checked",true);
 			}
 			return true;
 		}
 	})
 	.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
 		return $("<li></li>")
         	.data("item.autocomplete", item)
         	.append("<a>"+item.label+" "+item.id+"</a><small>DOB:"+item.dob+", Status:"+item.status+"</small>")
 			.appendTo(ul);
     };
});
</script>
 	[/one_half]');
	
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
		if(isset($moneyError))
			$errorMessages .=$moneyError.'</br>';
		if(isset($duplicateError))
			$errorMessages .=$duplicateError.'</br>';
		if(isset($raceError))
			$errorMessages .=$raceError.'</br>';
		echo apply_filters('the_content','[one_half last="no"][alert type="error"]'.$errorMessages.'[/alert][/one_half]');
	}
	
	// http://jqueryui.com/autocomplete/#custom-data
	// http://stackoverflow.com/questions/11349205/jqueryui-autocomplete-custom-data-and-display
	echo apply_filters('the_content','
<form action="" id="bhaa-raceday-newmember" name="bhaa-raceday-newmember" method="POST">
[one_half last="no"]
<b>Race Details</b>
[/one_half]			
[one_half last="yes"]
<b>Runner Details</b>
[/one_half]

[one_half last="no"]
<b>RaceNumber:</b><input type="text" name="number" id="number" value="'.$number.'"/>
[/one_half]			
[one_half last="yes"]
<b>Firstname:</b><input type="text" id="firstname" name="firstname" value="'.$firstname.'"/>
[/one_half]			

[one_half last="no"]
<b>Race:</b>'.$selectRaces.'
[/one_half]
[one_half last="yes"]
<b>Surname:</b><input type="text" id="lastname" name="lastname" value="'.$lastname.'"/>
[/one_half]

[one_half last="no"]
<b>Money:</b><input type="radio" name="money" value="4">Day Member 15e</input><input type="radio" name="money" value="5">New Member 25e</input>
[/one_half]
[one_half last="yes"]
<b>DOB:</b><input type="text" value="'.$dateofbirth.'" placeholder="DD/MM/19YY" name="dateofbirth" id="dateofbirth"/>
[/one_half]
         			
[one_half last="no"]
<input type="hidden" name="form-submitted" value="true" />
[/one_half]		
[one_half last="yes"]
<b>Gender:</b><input type="radio" name="gender" value="M" id="gendermale">M</input><input type="radio" name="gender" value="W" id="genderfemale">W</input>
[/one_half]			
[one_half last="no"]
<input type="submit" value="Register New Runner"/>
[/one_half]
</form>');
// [one_half last="yes"]
// <b>Extra Details</b><br/>
// Email<input type="text" name="email"/><br/>
// Mobile<input type="text" name="mobile"/><br/>
// Company<input type="text" name="company"/><br/>
// [/one_half]
}
	echo '</div>';
echo '</div>';
?>
<?php get_footer(); ?>