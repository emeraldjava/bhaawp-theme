bhaawp-theme
============

An avada extended theme with events-manager tweaks

# Events Manager

Events > Settings > Formatting

## Default event list format header

''<table class="events-table" >
    <thead>
        <tr>
			<th class="event-time" width="150">Date/Time</th>
			<th class="event-description" width="*">Event</th>
		</tr>
   	</thead>
    <tbody>''
    
## Default event list format

''<tr class="event-details">
<td>
#_EVENTDATES
#_EVENTTIMES
</td>
<td>#_EVENTLINK
{has_location}<i>#_LOCATIONNAME, #_LOCATIONTOWN #_LOCATIONSTATE</i>{/has_location}<br/>#_EVENTEXCERPT
</td>
</tr>
<tr class="spacer"><td></td></tr>''

