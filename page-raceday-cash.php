<?php
/**
 * Template Name: BHAA Raceday Cash
 */
if ( !current_user_can( 'edit_users' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

get_header();

global $BHAA;

$runnerCount = $BHAA->registration->getRegistrationTypes(2849);

var_dump($runnerCount,true);

/**
 * 1 - member - 10e
 * 2 - inactive day - 15e
 * 3 - renewing member - 25e
 * 4 - day member - 15e
 * 5 - new member - 25e
 * 6 - online day - 15e
 * 7 - online member - 10e
 */
$member=0;
$inactive_day=0;
$renew=0;
$day=0;
$new=0;
$online_day=0;
$online_member=0;

foreach($runnerCount as $runner){
	switch($runner->type){
		case(1):
			$member=$runner->count;
		case(2):			
			$inactive_day=$runner->count;
		case(3):
			$renew=$runner->count;
		case(4):
			$day=$runner->count;
		case(5):
			$new=$runner->count;
		case(6):
			$online_day=$runner->count;
		case(7):
			$online_member=$runner->count;
	}
}

echo 'member '.$member.'<br/>';
echo 'inactive_day '.$inactive_day.'<br/>';
echo 'renew '.$renew.'<br/>';
echo 'day '.$day.'<br/>';
echo 'new '.$new.'<br/>';
echo 'online_day '.$online_day.'<br/>';
echo 'online_member '.$online_member.'<br/>';

get_footer(); 
?>