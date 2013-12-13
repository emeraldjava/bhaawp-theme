<?php
/**
 * Template Name: BHAA Standards
 */
get_header();
echo '<section id="primary">';

$distances = array();

$distance = array();
$distance['km'] = 1;
$distance['title'] = '1km';
$distances[0]= $distance;

$distance = array();
$distance['km'] = 1.6;
$distance['title'] = '1Mile';
$distances[1]= $distance;

$distance = array();
$distance['km'] = 5;
$distance['title'] = '5km';
$distances[2]= $distance;

$distance = array();
$distance['km'] = 8;
$distance['title'] = '5Mile';
$distances[3]= $distance;

$distance = array();
$distance['km'] = 10;
$distance['title'] = '10km';
$distances[4]= $distance;

$distance = array();
$distance['km'] = 21.1;
$distance['title'] = 'Half';
$distances[5]= $distance;

$distance = array();
$distance['km'] = 42.2;
$distance['title'] = 'Marathon';
$distances[6]= $distance;

$standardTable = BHAA::get_instance()->standardCalculator->generateTableForDistances($distances);

echo apply_filters(
		'the_content','
[tagline_box title="Standards" description="The BHAA standard is like a golf handicap and give a runner a target time to aim for at races."]
<ul>
	<li>A runner will get a standard after their first race, based on where their times fits into the table</li>
	<li>If a person runs faster to slower than their target standard time, an automatic system will adjust the runners standard up or down</li>
</ul>
'
.$standardTable);

echo '</section>';
get_footer();
?>