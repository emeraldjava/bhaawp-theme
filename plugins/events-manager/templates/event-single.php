<?php
/*
 * Remember that this file is only used if you have chosen to override event pages with formats in your event settings!
* You can also override the single event page completely in any case (e.g. at a level where you can control sidebars etc.), as described here - http://codex.wordpress.org/Post_Types#Template_Files
* Your file would be named single-event.php
*/
/*
 * This page displays a single event, called during the em_content() if this is an event page.
* You can override the default display settings pages by copying this file to yourthemefolder/plugins/events-manager/templates/ and modifying it however you need.
* You can display events however you wish, there are a few variables made available to you:
*
* $args - the args passed onto EM_Events::output()

http://wordpress.org/support/topic/plugin-events-manager-how-to-customise-events-list-page
http://wp-events-plugin.com/documentation/advanced-usage/
http://docs.jquery.com/UI/API/1.9/Menu

*/
global $EM_Event;
/* @var $EM_Event EM_Event */

get_header();

echo '<section id="primary">';
//echo '<div id="eventmenu"><ul>'.
//	'<li><a href="#details">Details</a></li>'.
//	'<li><a href="#register">Register</a></li>'.
//	'<li><a href="#results">Results</a></li>'.
//	'<li><a href="#teams">Teams</a></li>'.
//	'</ul>';

if( $EM_Event->end >= time() )
{
	//$booking = $EM_Event->output('{has_bookings}#_BOOKINGFORM{/has_bookings}');
	echo $EM_Event->output(
				
			'[one_third last="no"]<p>#_EVENTEXCERPT</p>[/one_third]'.
			'[one_third last="no"]<strong>Date/Time</strong><br/>Date - #_EVENTDATES<br/><i>#_EVENTTIMES</i>[/one_third]'.
			'[one_third last="yes"]
			<a href="#details">Details</a>
			<a href="#register">Register</a>
			<a href="#location">Location</a>
			[/one_third]'.

			// details
			'<div id="details">'.
			'<h3>Details</h3>'.
			'#_EVENTNOTES'.
			'</div>'.
			'</br>'.

			// register
			'<div id="register">'.
			'<h3>Register</h3>'.
			'{has_bookings}'.
			'#_BOOKINGFORM'.
			'{/has_bookings}'.
			'</div>'.
			'</br>'.
			
			// location
			'<div id="location">'.
			'<h3>Location</h3>'.
			'{has_location}'.
			'[one_third last="no"]<p>'.
			'<strong>Address</strong><br/>'.
			'#_LOCATIONADDRESS<br/>'.
			'#_LOCATIONTOWN<br/>'.
			'#_LOCATIONCOUNTRY<br/>'.
			'</p>[/one_third]'.
			'[two_third last="yes"]<div id="details" style="float:right; margin:0px 0px 15px 15px;">#_MAP</div>[/two_third]'.
			'{/has_location}'.
			'</div>'.
			'</br>'
					);
}
else
{
	// past event
	echo $EM_Event->output(
			//'<h1>BHAA #_EVENTNAME : #_EVENTDATES</h1>'.
			'<br style="clear:both"/>'.
			'POC1 #_EVENTEXCERPT'.
			'<br/>'.
			'POC2 #_EVENTNOTES'.
			'<div id="details" style="float:right; margin:0px 0px 15px 15px;">#_MAP</div>'.
			'<p>'.
			'<strong>Date/Time</strong><br/>'.
			'Date(s) - #_EVENTDATES<br /><i>#_EVENTTIMES</i>'.
			'</p>'.
			'{has_location}'.
			'<p>'.
			'<strong>Location</strong><br/>'.
			'#_LOCATIONLINK'.
			'</p>'.
			'{/has_location}');
	//'{has_bookings}'.
	//'<div id="register"><h3>Register</h3></div>'.
	//'#_BOOKINGFORM'.
	//'{/has_bookings}'

	// Find connected pages
	$connected = new WP_Query( array(
			'connected_type' => 'event_to_race',
			'connected_items' => get_queried_object(),
			'nopaging' => true,
	));

	global $loader;
	if ( $connected->have_posts() ) :

	//echo '<h2 id="results">Full Race Results</h2>';
	while ( $connected->have_posts() ) :
	$connected->the_post();
	//echo 'race id'.get_the_ID();
	echo $loader->raceresult->getTable()->renderTable(get_the_ID());
	endwhile;

	// Prevent weirdness
	wp_reset_postdata();

	echo '<div id="teams"><h3>Teams</h3></div>';
	echo $loader->teamresult->getTable()->renderTable(get_the_ID());

	else :
	echo "No races have been linked to this event yet.";
	endif;
}
echo '</section>';
?>