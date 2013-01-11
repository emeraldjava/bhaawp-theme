<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><!-- http://wp-events-plugin.com/documentation/placeholders/ -->
<html><head><title>BHAA Online Ticket : #_BOOKINGNAME</title></head>
<body><div style="">
<table cellspacing="0" cellpadding="8" border="0" summary="" style="width: 100%; font-family: Arial, Sans-serif; 
	border: 1px Solid #ccc; border-width: 1px 2px 2px 1px; background-color: #fff;">
<tr>
<td>
<div style="padding: 2px">
<img class="bhaa-logo" src="http://bhaa.ie/wp-content/uploads/2012/11/headerlogo.jpg"	width="97" height="100" alt="BHAA Logo" style="float: left; padding: 0 20px" /><br/>

<?php 
foreach($EM_Booking->get_tickets_bookings() as $EM_Ticket_Booking):

// TODO - add note section for each ticket
if($EM_Ticket_Booking->get_ticket()->name=='Annual Membership')
{
	$header = '#_EVENTNAME : #_BOOKINGTICKETNAME';
	$eventDetails = false;
	$membershipDetails = false;
}
else
{
	$header = '#_EVENTNAME : #_BOOKINGTICKETNAME';
	$eventDetails = true;
	$membershipDetails = false;
?>

<!-- Please note -->
<!-- - Turn up one hour before the race at #_24HSTARTTIME to collect your race number. -->
<!-- - Chip timing and returning race number. -->
<!-- - BHAA is a vol organisation. -->
<!-- - No HEADPHONES -->
<?php 
}
echo '<h3 style="padding:0 0 6px 0;margin:0;font-family:Arial,Sans-serif;font-size:16px;font-weight:bold;color:#222">'.$header.'</h3><br/>';
?>

<table cellpadding="0" cellspacing="0" border="0" summary="details">

<!-- Who -->
<tr>
<td	style="padding: 0 1em 10px 0; font-family: Arial, Sans-serif; font-size: 13px; color: #888; white-space: nowrap" valign="top">
<div><i style="font-style: normal">Name</i></div></td>
<td	style="padding-bottom: 10px; font-family: Arial, Sans-serif; font-size: 13px; color: #222" valign="top">#_BOOKINGNAME</td>
</tr>

<!-- Company -->
<tr>
<td	style="padding: 0 1em 10px 0; font-family: Arial, Sans-serif; font-size: 13px; color: #888; white-space: nowrap" valign="top">
<div><i style="font-style: normal">Company</i></div></td>
<td	style="padding-bottom: 10px; font-family: Arial, Sans-serif; font-size: 13px; color: #222" valign="top">#_BOOKINGFORMCUSTOM{bhaa_runner_company}</td>
</tr>


<?php if($membershipDetails) {
//<!-- BHAA ID -->
//echo '<tr><td style="padding: 0 1em 10px 0; font-family: Arial, Sans-serif; font-size: 13px; color: #888; white-space: nowrap" valign="top">';
//echo '<div><i style="font-style: normal">BHAA Number</i></div></td>';
//echo '<td style="padding-bottom: 10px; font-family: Arial, Sans-serif; font-size: 13px; color: #222" valign="top">#_BOOKING_USER_ID</td>';
//echo '</tr>';
}
?>

<?php if($eventDetails) {
// <!-- Thank you for registering for the BHAA #_EVENTLINK event.  -->
	
//<!-- When -->
echo '<tr><td	style="padding: 0 1em 10px 0; font-family: Arial, Sans-serif; font-size: 13px; color: #888; white-space: nowrap" valign="top">';
echo '<div><i style="font-style: normal">When</i></div></td>';
echo '<td style="padding-bottom: 10px; font-family: Arial, Sans-serif; font-size: 13px; color: #222" valign="top">#_EVENTDATES @ #_EVENTTIMES</td>';
echo '</tr>';

//<!-- Where -->
echo '<tr><td	style="padding: 0 1em 10px 0; font-family: Arial, Sans-serif; font-size: 13px; color: #888; white-space: nowrap" valign="top">';
echo '<div><i style="font-style: normal">When</i></div></td>';
echo '<td style="padding-bottom: 10px; font-family: Arial, Sans-serif; font-size: 13px; color: #222" valign="top">#_LOCATIONNAME - #_LOCATIONFULLLINE</td>';
echo '</tr>';
}	
?>

<!-- Price -->
<tr>
	<td	style="padding: 0 1em 10px 0; font-family: Arial, Sans-serif; font-size: 13px; color: #888; white-space: nowrap"									valign="top">
		<div>
			<i style="font-style: normal">Paid Online</i>
		</div>
	</td>
	<td	style="padding-bottom: 10px; font-family: Arial, Sans-serif; font-size: 13px; color: #222" valign="top">#_BOOKINGTICKETPRICE</td>
</tr>

<!-- Notes -->
<tr>
	<td	style="padding: 0 1em 10px 0; font-family: Arial, Sans-serif; font-size: 13px; color: #888; white-space: nowrap"									valign="top">
		<div>
			<i style="font-style: normal">BOOKING ID</i>
		</div>
	</td>
	<td	style="padding-bottom: 10px; font-family: Arial, Sans-serif; font-size: 13px; color: #222"	valign="top">#_BOOKINGID | #_BOOKINGTXNID</td>
</tr>

						</table>
					</div>
				</td>
			</tr>

<!-- Footer -->
<tr>
<td	style="background-color: #f6f6f6; color: #888; border-top: 1px Solid #ccc; font-family: Arial, Sans-serif; font-size: 11px">
<p>Reminder from <a href="https://www.bhaa.ie/" target="_blank" style="">Business Houses Athletic Association</a></p>
<p>You are receiving this email at the account '#_BOOKINGEMAIL' because you just used the BHAA payments system.</p>
<p><b style="color: red">You must PRINT and bring this email to the event registration.</b></p>
<p>Please email #_CONTACTEMAIL with any booking queries</p>
</td>
<td	style="background-color: #f6f6f6; color: #888; border-top: 1px Solid #ccc; font-family: Arial, Sans-serif; font-size: 11px">
</td>
</tr>
		</table>
	</div>
</body>
</html>
<?php endforeach; ?>