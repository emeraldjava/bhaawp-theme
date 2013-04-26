<?php
/**
 * Template Name: BHAA Raceday Latest
 */
if ( !current_user_can( 'edit_users' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

global $BHAA;

get_header();

//include_once 'page-raceday-header.php';

$racetec = $BHAA->registration->listRegisteredRunners(10);

echo '<h2>Latest Runner Total '.sizeof($racetec).'</h2>';
echo '<table width="90%" id="raceteclist" >
<tr>
<th>Number</th>
<th>BHAA</th>
<th>Name</th>
<th>Standard</th>
<th>Company</th>
</tr>';

foreach($racetec as $racetec) : ?>
<tr class="row">
<td class="cell"><?php echo $racetec->racenumber;?></td>
<td class="cell"><?php echo $racetec->runner;?></td>
<td class="cell"><?php echo $racetec->firstname;?> <?php echo $racetec->lastname;?></td>
<td class="cell"><?php echo $racetec->standard;?></td>
<td class="cell"><?php echo $racetec->companyname;?></td>
</tr>
<?php endforeach;?>
</table>

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