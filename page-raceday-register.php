<?php
/**
 * Template Name: BHAA Raceday Register
 */

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
	
 	$standard = trim($_POST['standard']);
 	
	if(!isset($hasError))
	{
 		error_log($raceid.' '.$runner.' '.$number);
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
elseif(isset($_GET['newmember']))
{
	error_log("new member linked!");
	$runner = trim($_GET['runner']);
	$firstname = trim($_GET['firstname']);
	$lastname = trim($_GET['lastname']);
	$gender = trim($_GET['gender']);
	$dateofbirth = trim($_GET['dateofbirth']);
}
// http://stackoverflow.com/questions/11368368/404-when-using-post-get-parameters-in-wordpress-3-4
get_header();
//echo "<pre>GET "; print_r($_GET); echo "</pre>";
//echo "<pre>POST "; print_r($_POST); echo "</pre>";
?>

<div id="container">
	
<?php 
include_once 'page-raceday-header.php';

if(isset($registrationSubmitted) && $registrationSubmitted == true) 
{
	// redirect to registration page
	echo '<div class="thanks"><p>Runner '.trim($_POST['firstname']).' '.trim($_POST['lastname']).' has been registered with number '.$number.'.</p></div>';
}
else
{
	// http://jqueryui.com/autocomplete/#custom-data
	// http://stackoverflow.com/questions/11349205/jqueryui-autocomplete-custom-data-and-display
	// http://stackoverflow.com/questions/4717488/jquery-ui-autocomplete-search-more-than-just-label-within-a-local-json-array
	echo apply_filters('the_content',
		'[one_third last="yes"]
			<div class="navbar-search pull-left" align="left">
			BHAA Member : <input size="40" type="text" placeholder="Search by Name OR ID" id="memberfilter"/>
			[raw]<script type="text/javascript">
jQuery(document).ready( 
	function($){
	var runners = '.file_get_contents("wp-content/bhaa_runners.json.txt").';
	
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
			$("#standard").val( ui.item.standard );
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
	
	$races = $BHAA->registration->getNextRaces();
	$selectRaces = '';
	$i=0;
	foreach($races as $race)
	{
		$rname = $race->dist.$race->unit;
		$selectRaces .= sprintf('<input type="radio" name="raceid" value="%s">%s</input>',$race->id,$rname);
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
		if(isset($raceError))
			$errorMessages .=$raceError.'</br>';
		echo apply_filters('the_content','[alert type="error"]'.$errorMessages.'[/alert]');
	}

	echo apply_filters('the_content','
		<form action="" id="bhaa-registration-form" method="POST">
			[one_third last="no"]
			<b>Race Details</b><br/>
			RaceNumber<input type="text" name="number" id="number" value="'.$number.'"/><br/>
			Race'.$selectRaces.'<br/>
			<input type="submit" value="Register Runner"/>
			[/one_third]
			[one_third]
			<b>Runner Details</b><br/>
			Firstname<input type="text" name="firstname" id="firstname" value="'.$firstname.'"/><br/>
			Surname<input type="text" name="lastname" id="lastname" value="'.$lastname.'"/><br/>
			Gender<input type="radio" name="gender" value="M" id="gendermale">M</input><input type="radio" name="gender" value="W" id="genderfemale">W</input><br/> 
			DOB<input type="date" class="{validate:{required:true, date:true}} name="dateofbirth" id="dateofbirth"/><br/>
			[/one_third]
			[one_third last="yes"]
			<b>BHAA Details</b><br/>
			ID<input type="text" name="runner" id="runner" value="'.$runner.'"/><br/>
			Standard<input type="text" name="standard" id="standard" value="'.$standard.'"/><br/>
			Company<input type="text" name="company" id="company"/><br/>
			[/one_third]
			<input type="hidden" name="form-submitted" value="true" />
		</form>');
}
echo '</div>';
?>
<?php get_footer(); ?>