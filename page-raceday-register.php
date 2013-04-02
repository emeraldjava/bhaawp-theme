<?php
/**
 * Template Name: BHAA Raceday Registration
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

if(isset($registrationSubmitted) && $registrationSubmitted == true) 
{
	// redirect to registration page
	echo '<div class="thanks"><p>The runner has been registered.</p></div>';
}
else
{
	// http://jqueryui.com/autocomplete/#custom-data
	// http://stackoverflow.com/questions/11349205/jqueryui-autocomplete-custom-data-and-display
	echo apply_filters('the_content',
		'[one_third last="yes"]
			<div class="navbar-search pull-left" align="left">
			Search for BHAA Member by Name : <input size="40" type="text" placeholder="Name or ID" id="memberfilter"/>
			[raw]<script type="text/javascript">
jQuery(document).ready( 
	function($){
	var runners = '.file_get_contents("wp-content/bhaa_runners.json.txt").';
	$("#memberfilter").autocomplete({
		source: runners,
		minLength: 3,
		focus: function( event, ui ) {
        	$( "#memberfilter" ).val( ui.item.label );
        	return false;
      	},
		select: function(event, ui) {
			$("#runner").val( ui.item.id );
			$("#firstname").val( ui.item.firstname );
			$("#lastname").val( ui.item.lastname );
			$("#dateofbirth").val( ui.item.dob );
			$("#company").val( ui.item.company );
			$("#standard").val( ui.item.standard );
			$("#gender").val( ui.item.gender );
			return true;	
		}
	})
	.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
		return $("<li></li>")
        	.data("item.autocomplete", item)
        	.append("<a>"+item.label+" "+item.id+"</a><br/><small>DOB:"+item.dob+", Status:"+item.status+"</small>")
			.appendTo(ul);
    };
});
</script>[/raw]
		</div>
	[/one_third]<hr/><br/>');
	
	$races = $BHAA->registration->getNextRaces();
	//var_dump($races);
	$selectRaces = '<select name="raceid">';
	$i=0;
	foreach($races as $race)
	{
		$rname = $race->dist.'-'.$race->unit.'-'.$race->type;
		$selectRaces .= sprintf('<option value=%d>%s</option>',$race->id,$rname);// $race->id,$race->id,$rname);
	}
	$selectRaces .= '</select>';
		
	if(isset($hasError) && $hasError==true)
	{
		$errorMessages = '';
		if(isset($runnerError))
			$errorMessages .=$runnerError.'</br>';
		if(isset($numberError))
			$errorMessages .=$numberError.'</br>';
		echo apply_filters('the_content','[alert type="error"]'.$errorMessages.'[/alert]');
	}
	//var_dump('name'.$name);
	//var_dump('get_permalink '.get_permalink());

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
			Gender<input type="checkbox" name="gender" value="M" id="gender">M<input type="checkbox" name="gender" value="W" id="gender">W<br/> 
			DOB<input type="text" name="dateofbirth" id="dateofbirth"/><br/>
			[/one_third]
			[one_third last="yes"]
			<b>BHAA Details</b><br/>
			ID<input type="text" name="runner" id="runner" value="'.$runner.'"/><br/>
			Standard<input type="text" name="standard" id="standard"/><br/>
			Company<input type="text" name="company" id="company"/><br/>
			[/one_third]
			<input type="hidden" name="form-submitted" value="true" />
		</form>');
}
echo '</div>';
?>
<?php get_footer(); ?>