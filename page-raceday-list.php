<?php
/**
 * Template Name: BHAA Raceday List
 */

global $BHAA;

get_header();
//echo "<pre>GET "; print_r($_GET); echo "</pre>";
//echo "<pre>POST "; print_r($_POST); echo "</pre>";

include_once 'page-raceday-header.php';

echo "LIST BHAA RUNNERS";
echo var_dump($BHAA->registration->listRegisteredRunners());

get_footer(); 
?>