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
		$registrationSubmitted = true;
	}

} ?>
<?php get_header(); ?>
<div id="container">
	<div id="content">
	
	<?php 
	echo include_once 'registration-header.php';
	?>
		<div id="post-reg">
			<h1 class="entry-title">Registration</h1>
				<div class="entry-content">
					<?php if(isset($registrationSubmitted) && $registrationSubmitted == true) { ?>
						<div class="thanks">
							<p>The runner has been registered.</p>
						</div>
					<?php } else { ?>
					<form action="<?php the_permalink(); ?>" id="contactForm" method="post">
						<ul class="contactform">
						<li>
							<label for="contactName">Runner:</label>
							<input type="text" name="runner" id="runner" value="<?php if(isset($_POST['$runner'])) echo $_POST['$runner'];?>" class="required requiredField" />
							<?php if($runnerError != '') { ?>
								<span class="error"><?=$runnerError;?></span>
							<?php } ?>
						</li>

						<li>
							<label for="email">Number</label>
							<input type="text" name="number" id="number" value="<?php if(isset($_POST['number']))  echo $_POST['number'];?>" class="required requiredField" />
						</li>
						<li>
							<input type="submit">Register</input>
						</li>
					</ul>
					<input type="hidden" name="submitted" id="submitted" value="true" />
				</form>
			<?php } ?>
			</div><!-- .entry-content -->
		</div><!-- .post -->
	</div><!-- #content -->
</div><!-- #container -->
