<?php
/**
 * Template Name: BHAA Registration
 * 
 * http://www.catswhocode.com/blog/how-to-create-a-built-in-contact-form-for-your-wordpress-theme
 */
get_header();

//echo '<section id="primary">';
//echo apply_filters('the_content',do_shortcode('[bhaa_registration]'));
//echo '</section>';

?>

<?php
global $BHAA;
if(isset($_POST['submitted'])) {
	if(trim($_POST['runner']) === '') {
		$runnerError = 'Please enter runner id.';
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

	if(!isset($hasError)) {
		error_log($runner.' '.$number);
		$BHAA->registration->registerRunner($runner,$number);
		$registrationSubmitted = true;
	}

} ?>

<div id="container">
	
	<?php 
	include_once 'registration-header.php';

	if(isset($registrationSubmitted) && $registrationSubmitted == true) 
	{
		echo '<div class="thanks">
 			<p>The runner has been registered.</p>'.var_dump($BHAA->registration->listRegsiteredRunners()).'</div>';
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
		echo apply_filters('the_content','
			<form action="'.get_permalink().'" id="contactForm" method="post">
				[one_half last="no"]
				<b>Race Details</b><br/>
				RaceNumber<input type="text" name="racenumber" id="racenumber"/><br/>
				Race<input type="text" name="race" id="race"/><br/>
				Fee<input type="text" name="fee" id="fee"/><br/>
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
				<input type="submit">Register</input>
				<input type="hidden" name="submitted" id="submitted" value="true" />
			</form>');
	}
	echo '</div>';

// 	echo '<script type="text/javascript">
// 	jQuery(function() {
// 		var runners = '.file_get_contents("registration-header.php").'});
// 	</script>';	
?>
<?php get_footer(); ?>