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
 	
 	if(trim($_POST['dateofbirth']) === '')  {
 		$dobError = 'Please enter dateofbirth.';
 		$hasError = true;
 	} else {
 		$dateofbirth = trim($_POST['dateofbirth']);
 	}
	
	if(!isset($hasError))
	{
		error_log('runner '.isset($runner).' $'.$runner.'$');
		if($runner=='')// !isset($runner) || $runner!='')
		{
	 		$runner = $BHAA->registration->addNewMember($firstname,$lastname,$gender,$dateofbirth,$email);
		}
		error_log($firstname.' '.$lastname.' '.$gender.' '.$dateofbirth.' -> '.$runner);
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
	// http://stackoverflow.com/questions/2090366/date-validation-using-jquery-validation - datepicker
	// http://localhost/raceday-newmember/raceday-registration/?runner=&d&firstname=23004&stname=POC&g=M&dob=12
	echo '<div class="thanks"><p>Runner '.$firstname.' '.$lastname.' has been registered. Next Step ';
	echo sprintf('<a href="/raceday-register/?newmember=xxy&runner=%s&firstname=%s&lastname=%s&gender=%s&dateofbirth=%s">Assign Runner %s a race number</a></p></div>'
		,$runner,$firstname,$lastname,$gender,$dateofbirth,$runner);
}
else
{
	echo apply_filters('the_content',
			'[one_third last="yes"]
			<div class="navbar-search pull-left" align="left">
			Check for an existing day members : <input size="40" type="text" placeholder="Search by Name OR ID" id="memberfilter"/>
			[raw]<script type="text/javascript">
jQuery(document).ready(
	function($){
	var runners = '.file_get_contents("wp-content/bhaa_day_runners.json.txt").';
	$("#memberfilter").autocomplete({
		source: runners,
		minLength: 3,
		source: function (request, response) {
		    var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
		    response($.grep(runners, function(value) {
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
			$("#dateofbirth").val( ui.item.dob );
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
</script>[/raw]
		</div>
	[/one_third]<hr/>');
	
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
		echo apply_filters('the_content','[alert type="error"]'.$errorMessages.'[/alert]');
	}
	
	// http://jqueryui.com/autocomplete/#custom-data
	// http://stackoverflow.com/questions/11349205/jqueryui-autocomplete-custom-data-and-display
	echo apply_filters('the_content','
		<form action="" id="bhaa-raceday-newmember" method="POST">
			[one_half last="no"]
			<b>Runner Details - REQUIRED</b><br/>
			Firstname<input type="text" id="firstname" name="firstname"/><br/>
			Surname<input type="text" id="lastname" name="lastname"/><br/>
			Gender<input type="radio" name="gender" value="M" id="gendermale">M</input><input type="radio" name="gender" value="W" id="genderfemale">W</input><br/> 
			DOB<input type="text" placeholder="YYYY-MM-DD" name="dateofbirth" id="dateofbirth"/><br/>
			<input type="submit" value="Register New Runner"/>
			[/one_half]
			[one_half last="yes"]
			<b>Extra Details</b><br/>
			ID<input type="text" name="runner" id="runner" value="'.$runner.'"/><br/>
			Email<input type="text" name="email"/><br/>
			Mobile<input type="text" name="mobile"/><br/>
			Company<input type="text" name="company"/><br/>
			[/one_half]
			<input type="hidden" name="form-submitted" value="true" />
		</form>');
}
echo '</div>';
?>
<?php get_footer(); ?>
