<?php
/**
 * Template Name: BHAA Raceday Latest
 */
if ( !current_user_can( 'edit_users' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

global $BHAA;

get_header();

echo '<div id="raceteclist">
<div class="row">
<span class="cell">Event</span>
<span class="cell">Race Number</span>
<span class="cell">BHAA</span>
<span class="cell">Name</span>
<span class="cell">Standard</span>
<span class="cell">Company</span>
<span class="cell">Team</span>
</div>';

$racetec = $BHAA->registration->listRegisteredRunners(3);

foreach($racetec as $racetec) : ?>
<div class="row">
<span class="cell"><?php echo $racetec->race;?></span>
<span class="cell"><?php echo $racetec->racenumber;?></span>
<span class="cell"><?php echo $racetec->runner;?></span>
<span class="cell"><?php echo $racetec->firstname;?> <?php echo $racetec->lastname;?></span>
<span class="cell"><?php echo $racetec->standard;?></span>
<span class="cell"><?php echo $racetec->companyname;?></span>
<span class="cell"><?php echo $racetec->teamname;?></span>
</div>
<?php endforeach;?>
</div>

<!-- <div align="right">Refreshing in <span id="seconds">15</span> seconds.
    <script>
      var seconds = 15;
      setInterval(
        function(){
          document.getElementById('seconds').innerHTML = --seconds;
        }, 1000
      );
    </script>
</div>-->

<?php 
get_footer(); 
?>