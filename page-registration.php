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
						
		echo apply_filters('the_content','[one_third last="yes"]Search[/one_third]');
		
		echo apply_filters('the_content','
			<form action="'.get_permalink().'" id="contactForm" method="post">
				[one_half last="no"]
				Race Details
				<input type="text" name="runner" id="runner"/>
				<input type="text" name="number" id="number"/>
				[/one_half]
	
				[one_half last="yes"]
				Runner Details
				<input type="text" name="name" id="name"/>
				<input type="text" name="gender" id="gender"/>
				[/one_half]
				<input type="submit">Register</input>
				<input type="hidden" name="submitted" id="submitted" value="true" />
			</form>');
	}
	?>
				
</div><!-- #container -->
<?php get_footer(); ?>