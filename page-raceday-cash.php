<?php
/**
 * Template Name: BHAA Raceday Cash
 */
if ( !current_user_can( 'edit_users' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

get_header();

global $BHAA;

$cash = $BHAA->registration->getRegistrationTypes(2849);

error_log($cash);
var_dump($cash,true);

get_footer(); 
?>