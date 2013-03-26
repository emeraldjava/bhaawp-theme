<?php
/**
 * Template Name: BHAA Registration
 * 
 * http://www.catswhocode.com/blog/how-to-create-a-built-in-contact-form-for-your-wordpress-theme
 */
get_header();
?>

<?php
global $BHAA;
if(isset($_POST['submitted'])) {
	error_log("form submitted");
	if(trim($_POST['id']) === '') {
		$runnerError = 'Please enter runner id.';
		$hasError = true;
	} else {
		$id = trim($_POST['id']);
	}

	if(trim($_POST['racenumber']) === '')  {
		$numberError = 'Please enter a race number.';
		$hasError = true;
	} else {
		$racenumber = trim($_POST['racenumber']);
	}
	
	$race = trim($_POST['race']);

	//if(!isset($hasError)) {
		error_log($race.' '.$id.' '.$racenumber);
		$BHAA->registration->registerRunner($race,$id,$racenumber);
		$registrationSubmitted = true;
	//}

} ?>

<div id="container">
	
	<?php 
	include_once 'registration-header.php';

	if(isset($registrationSubmitted) && $registrationSubmitted == true) 
	{
		echo '<div class="thanks">
 			<p>The runner has been registered.</p>'.var_dump($BHAA->registration->listRegisteredRunners(2278)).'</div>';
	}
	else
	{
		// http://jqueryui.com/autocomplete/#custom-data
		// http://stackoverflow.com/questions/11349205/jqueryui-autocomplete-custom-data-and-display
		echo apply_filters('the_content',
			'[one_third last="yes"]
				<div class="navbar-search pull-left" align="left">
				Full name or ID : <input size="40" type="text" placeholder="Name or ID" id="memberfilter"/>
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
			$("#id").val( ui.item.id );
			$("#firstname").val( ui.item.firstname );
			$("#lastname").val( ui.item.lastname );
			$("#dob").val( ui.item.dob );
			$("#company").val( ui.item.company );
			$("#standard").val( ui.item.standard );
			$("#gender").val( ui.item.gender );
			return false;	
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
			[/one_third]');
		
		$races = $BHAA->registration->getNextRaces();
		$selectRaces = '<select name="race" id="race">';
		foreach($races as $race)
		{
			$name = $race->dist.$race->unit.'-'.$race->type;
			$selected="false";
			if(key($race)==1)
				$selected="true";
			$selectRaces .= sprintf('<option selected="%s" value="%d">%s</option>',$selected,$race->id,$name);
		}
		$selectRaces .= '</select>';
		
		echo apply_filters('the_content','
			<form action="'.get_permalink().'" id="contactForm" method="post">
				[one_half last="no"]
				<b>Race Details</b><br/>
				RaceNumber<input type="text" name="racenumber" id="racenumber"/><br/>
				Race'.$selectRaces.'<br/>
				[/one_half]
				[one_half last="yes"]
				<b>Runner Details</b><br/>
				ID<input type="text" name="id" id="id"/><br/>
				Firstname<input type="text" name="firstname" id="firstname"/><br/>
				Surname<input type="text" name="lastname" id="lastname"/><br/>
				Gender<input type="text" name="gender" id="gender"/><br/>
				DOB<input type="text" name="dob" id="dob"/><br/>
				Standard<input type="text" name="standard" id="standard"/><br/>
				Company<input type="text" name="company" id="company"/><br/>
				[/one_half]
				<input type="submit" value="Register Runner"/>
				<input type="hidden" name="submitted" id="submitted" value="true" />
			</form>');
	}
	echo '</div>';
?>
<?php get_footer(); ?>