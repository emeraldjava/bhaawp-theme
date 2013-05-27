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

$total=0;
$ro=0;
$bhaa=0;
$online=0;
foreach($runnerCount as $runner){
	error_log($runner->type.' '.$runner->count);
	switch($runner->type){
		case(1):{
			$member=$runner->count;
			$total = $total + ($member*10);
			$ro = $ro + ($member*10);
			break;
		}
		case(2):{
			$inactive_day=$runner->count;
			$total = $total + ($inactive_day*15);
			$ro = $ro + ($inactive_day*10);
			$bhaa = $bhaa + ($inactive_day*5);
			break;
		}
		case(3):{
			$renew=$runner->count;
			$total = $total + ($renew*25);
			$ro = $ro + ($renew*10);
			$bhaa = $bhaa + ($renew*15);
			break;
		}
		case(4):{
			$day=$runner->count;
			$total = $total + ($day*15);
			$ro = $ro + ($day*10);
			$bhaa = $bhaa + ($day*5);
			break;
		}
		case(5):{
			$new=$runner->count;
			$total = $total + ($new*25);
			$ro = $ro + ($new*10);
			$bhaa = $bhaa + ($new*15);
			break;
		}
		case(6):{
			$online_day=$runner->count;
			$total = $total + ($online_day*10);
			$online = $online + ($online_day*15);
			$bhaa = $bhaa + ($online_day*5);
			$ro = $ro + ($online_day*10);
			break;
		}
		case(7):{
			$online_member=$runner->count;
			$total = $total + ($online_member*15);
			$online = $online + ($online_member*10);
			$ro = $ro + ($online_member*10);
			break;
		}
	}
}

echo '<table width=90%>';
echo '<tr>';
echo '<th>Type</th>';
echo '<th>Number</th>';
echo '<th>Rate</th>';
echo '<th>RO</th>';
echo '<th>BHAA</th>';
echo '<th>Total</th>';
echo '<th>RO</th>';
echo '<th>BHAA</th>';
echo '</tr>';

echo '<tr>';
echo '<td>BHAA Member</td>';
echo '<td>'.$runnerCount[1]->count.'</td>';
echo '<td>10</td>';
echo '<td>10</td>';
echo '<td>0</td>';
echo '<td>'.($runnerCount[1]->count*10).'</td>';
echo '<td>'.($runnerCount[1]->count*10).'</td>';
echo '<td>0</td>';
echo '</tr>';
echo '</table>';

echo 'member '.$member.'<br/>';
echo 'inactive_day '.$inactive_day.'<br/>';
echo 'renew '.$renew.'<br/>';
echo 'day '.$day.'<br/>';
echo 'new '.$new.'<br/>';
echo 'online_day '.$online_day.'<br/>';
echo 'online_member '.$online_member.'<br/>';
echo '<hr/>Total '.$total.'<br/>';
echo 'Race organiser '.$ro.'<br/>';
echo 'BHAA '.$bhaa.'<br/>';
echo 'Online '.$online.'<br/>';


get_footer(); 
?>