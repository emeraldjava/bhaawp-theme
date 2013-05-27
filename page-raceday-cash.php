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
$online_ro=0;
$online_bhaa=0;
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
			//$total = $total + ($online_day*10);
			$online = $online + ($online_day*15);
			$online_bhaa = $online_bhaa + ($online_day*5);
			$online_ro = $online_ro + ($online_day*10);
			break;
		}
		case(7):{
			$online_member=$runner->count;
			//$total = $total + ($online_member*15);
			$online = $online + ($online_member*10);
			$online_ro = $online_ro + ($online_member*10);
			break;
		}
	}
}

echo '<table width=90%>';
echo '<tr align="left">';
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

echo '<tr>';
echo '<td>Day Member</td>';
echo '<td>'.$runnerCount[4]->count.'</td>';
echo '<td>15</td>';
echo '<td>10</td>';
echo '<td>5</td>';
echo '<td>'.($runnerCount[4]->count*15).'</td>';
echo '<td>'.($runnerCount[4]->count*10).'</td>';
echo '<td>'.($runnerCount[4]->count*5).'</td>';
echo '</tr>';

echo '<tr>';
echo '<td>New Member</td>';
echo '<td>'.$runnerCount[5]->count.'</td>';
echo '<td>25</td>';
echo '<td>10</td>';
echo '<td>15</td>';
echo '<td>'.($runnerCount[5]->count*25).'</td>';
echo '<td>'.($runnerCount[5]->count*10).'</td>';
echo '<td>'.($runnerCount[5]->count*15).'</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Renewed Member</td>';
echo '<td>'.$runnerCount[3]->count.'</td>';
echo '<td>25</td>';
echo '<td>10</td>';
echo '<td>15</td>';
echo '<td>'.($runnerCount[3]->count*25).'</td>';
echo '<td>'.($runnerCount[3]->count*10).'</td>';
echo '<td>'.($runnerCount[3]->count*15).'</td>';
echo '</tr>';


echo '<tr>';
echo '<td>Non-Renewing Member</td>';
echo '<td>'.$runnerCount[2]->count.'</td>';
echo '<td>15</td>';
echo '<td>10</td>';
echo '<td>5</td>';
echo '<td>'.($runnerCount[2]->count*15).'</td>';
echo '<td>'.($runnerCount[2]->count*10).'</td>';
echo '<td>'.($runnerCount[2]->count*5).'</td>';
echo '</tr>';

echo '<tr>';
echo '<td><b>Total Cash</b></td>';
echo '<td> </td>';
echo '<td> </td>';
echo '<td> </td>';
echo '<td> </td>';
echo '<td><b>'.($total).'</b></td>';
echo '<td><b>'.($ro).'</b></td>';
echo '<td><b>'.($bhaa).'</b></td>';
echo '</tr>';

echo '<tr>';
echo '<td>Online Day Member</td>';
echo '<td>'.($runnerCount[6]->count).'</td>';
echo '<td>15</td>';
echo '<td>10</td>';
echo '<td>5</td>';
echo '<td>'.($runnerCount[6]->count*15).'</td>';
echo '<td>'.($runnerCount[6]->count*10).'</td>';
echo '<td>'.($runnerCount[6]->count*5).'</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Online Member</td>';
echo '<td>'.($runnerCount[7]->count).'</td>';
echo '<td>10</td>';
echo '<td>10</td>';
echo '<td>0</td>';
echo '<td>'.($runnerCount[7]->count*10).'</td>';
echo '<td>'.($runnerCount[7]->count*10).'</td>';
echo '<td>'.($runnerCount[7]->count*0).'</td>';
echo '</tr>';

echo '<tr>';
echo '<td><b>Total Online</b></td>';
echo '<td> </td>';
echo '<td> </td>';
echo '<td> </td>';
echo '<td> </td>';
echo '<td><b>'.$online.'</b></td>';
echo '<td><b>'.($online_ro).'</b></td>';
echo '<td><b>'.($online_bhaa).'</b></td>';
echo '</tr>';

echo '</table>';

//echo 'member '.$member.'<br/>';
//echo 'inactive_day '.$inactive_day.'<br/>';
//echo 'renew '.$renew.'<br/>';
//echo 'day '.$day.'<br/>';
//echo 'new '.$new.'<br/>';
//echo 'online_day '.$online_day.'<br/>';
//echo 'online_member '.$online_member.'<br/>';
//echo '<hr/>Total '.$total.'<br/>';
//echo 'Race organiser '.$ro.'<br/>';
//echo 'BHAA '.$bhaa.'<br/>';
//echo 'Online '.$online.'<br/>';


get_footer(); 
?>