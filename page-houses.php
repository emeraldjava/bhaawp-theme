<?php
/**
 * Template Name: BHAA Houses
 */
global $EM_Event;
get_header();
echo '<section id="primary">';
echo apply_filters(
	'the_content','
[tagline_box title="Houses" description="The basic aim of the BHAA is to encourage people who work together to run together, registration is free and there are a few simple rules."]

[content_boxes]
[content_box title="Teams"]
Once you have three runners with a standard in a race this forms a team. 
Registration is free but we do require a contact name for each team.
A runner will get a BHAA standard after their first event and will score towards a team at the second race.
[/content_box]

[content_box title="Company Teams" link="/teamtype/company" linktext="See Company Teams"]
A company team can have as multiple runners and there is no upper limit.
If there are say 9 runners at an event, this will make up three teams on the day.
We suggest a minimum of four runners should be registered before the team is activated.		
[/content_box]

[content_box title="Sector Teams" link="/teamtype/sector" linktext="See Sector Teams"]
For people working in smaller companies with no other runners there is the option to form a sector team.
There is a limit of 6 runners on a sector team.
All the runners should be employed by companies working in the same sector.
A runner cannot switch between teams during the year.
This allows teachers, nurses and tradesmen to form teams
[/content_box]
[/content_boxes]

[content_boxes]
[content_box title="Sectors"]
Sectors are the way we group companies based on the industry they operate in.
[/content_box]

[content_box title="Prizes"]
There are 15 team prizes at each event in 5 divisions.
We group the three runner by their position.
We then sum their standard and this allows use to break mutliple teams in divisions A,B,C,D.
Within each division we then order by the total positions to determine the final order.
[/content_box]

[content_box title="Leagues"]
There is a winter and summer league in which teams complete.
Based on the team position in an event, teams are given points from 6 to 1.
[/content_boxes]

Please use the contact form if you want to register a new team.
');
echo '</section>';
get_footer();
?>