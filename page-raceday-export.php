<?php
/**
 * Template Name: BHAA Raceday Export
 */

if ( !current_user_can( 'edit_users' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}
Registration::get_instance()->export();
?>