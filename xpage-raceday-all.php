<?php
/**
 * Template Name: BHAA Raceday All
 */
if ( !current_user_can( 'edit_users' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

get_header();

include_once 'page-raceday-header.php';

include_once ABSPATH.'wp-content/bhaa_all_members.html';

get_footer(); 
?>