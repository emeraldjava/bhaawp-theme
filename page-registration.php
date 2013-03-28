<?php
/**
 * Template Name: BHAA Registration
 * 
 * http://www.catswhocode.com/blog/how-to-create-a-built-in-contact-form-for-your-wordpress-theme
 */


if(isset($_POST['form-submitted'])) 
{
// 	if(trim($_POST['runner']) === '') {
// 		$runnerError = 'Please enter runner runner.';
// 		$hasError = true;
// 	} else {
 		$runner = trim($_POST['runner']);
// 	}

// 	if(trim($_POST['number']) === '')  {
// 		$numberError = 'Please enter a race number.';
// 		$hasError = true;
// 	} else {
 		$number = trim($_POST['number']);
// 	}
	
 	$raceid = trim($_POST['raceid']);

// 	//if(!isset($hasError)) {
 	error_log($raceid.' '.$runner.' '.$number);
// 	global $BHAA;
// 	$BHAA->registration->registerRunner($raceid,$runner,$number);
 	//$registrationSubmitted = true;
// 	//}
}
global $BHAA;
// http://stackoverflow.com/questions/11368368/404-when-using-post-get-parameters-in-wordpress-3-4
get_header();
echo "<pre>GET "; print_r($_GET); echo "</pre>";
echo "<pre>POST "; print_r($_POST); echo "</pre>";
?>

<div id="container">
	
	<?php 
	include_once 'registration-header.php';

	if(isset($registrationSubmitted) && $registrationSubmitted == true) 
	{
		echo '<div class="thanks">
 			<p>The runner has been registered.</p></div>';
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
			$("#runner").val( ui.item.id );
			$("#first").val( ui.item.firstname );
			$("#last").val( ui.item.lastname );
			$("#dob").val( ui.item.dob );
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
			[/one_third]');
		
		$races = $BHAA->registration->getNextRaces();
		var_dump($races);
		$selectRaces = '<select name="raceid">';
		$i=0;
		foreach($races as $race)
		{
			$rname = $race->dist.'-'.$race->unit.'-'.$race->type;
			$selected="";
			if($i==0)
			{
//				$selected='selected="selected"';
				//$selectRaces .= sprintf('<option value=%d selected="selected">%s</option>',$i++,$rname);
			}
			else
			{
				//$selectRaces .= sprintf('<option value=%d>%s</option>',$i++,$rname);
			}
			// http://stackoverflow.com/questions/5189645/how-to-remember-chosen-form-values-in-php
			// http://wordpress.stackexchange.com/questions/85607/theme-option-select-values
			//var_dump('$racez->id '.trim($racez->id));
			//var_dump(sprintf('%s - %s - %d',$racez->id,trim($racez->id),$racez->id));
//			$i = intval($racez->id);
//			$rr = (int) $racez->id;
			
			$selectRaces .= sprintf('<option value=%d>%s</option>',$race->id,$rname);// $race->id,$race->id,$rname);
		}
		$selectRaces .= '</select>';
		
		var_dump('name'.$name);
		var_dump('get_permalink '.get_permalink());
		
		echo apply_filters('the_content','
			<form action="" id="bhaa-registration-form" method="POST">
				[one_half last="no"]
				<b>Race Details</b><br/>
				RaceNumber<input type="text" name="number" id="number"/><br/>
				Race'.$selectRaces.'<br/>
				[/one_half]
				[one_half last="yes"]
				<b>Runner Details</b><br/>
				ID<input type="text" name="runner" id="runner"/><br/>
				Firstname<input type="text" name="first" id="first"/><br/>
				Surname<input type="text" name="last" id="last"/><br/>
				Gender<input type="text" name="gender" id="gender"/><br/>
				DOB<input type="text" name="dob" id="dob"/><br/>
				Standard<input type="text" name="standard" id="standard"/><br/>
				Company<input type="text" name="company" id="company"/><br/>
				[/one_half]
				<input type="submit" value="Register Runner"/>
				<input type="hidden" name="form-submitted" value="true" />
			</form>');
	}
	echo '</div>';
?>
<?php get_footer(); ?>