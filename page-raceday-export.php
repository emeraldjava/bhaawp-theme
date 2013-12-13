<?php
/**
 * Template Name: BHAA Raceday Export
 */

if ( !current_user_can( 'edit_users' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}
BHAA::get_instance()->registration->export();
?>