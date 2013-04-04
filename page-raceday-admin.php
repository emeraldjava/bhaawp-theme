<?php
/**
 * Template Name: BHAA Raceday Admin
 */
if ( !current_user_can( 'manage_options' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

global $BHAA;

get_header();

//$racetec = $BHAA->registration->listRegisteredRunners(3);

echo '<h2>BHAA RACE DAY ADMIN</h2>';

get_footer(); 
?>