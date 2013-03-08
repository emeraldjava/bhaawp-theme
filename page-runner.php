<?php 
/**
 Template Name: BHAA Runner
 */
?>
<?php get_header();?>

<?php 
//echo 'BHAA Runner Page : Name = '.$_REQUEST['user_nicename'];
if(isset($_REQUEST['user_nicename']))
	$user = get_user_by('slug', $_REQUEST['user_nicename']);
else
	$user = get_user_by('id', $_REQUEST['id']);

$metadata = get_user_meta($user->ID);
$status = $metadata['bhaa_runner_status'][0];
$company = $metadata['bhaa_runner_company'][0];

echo '<h1>'.$user->display_name.'</h1>';

// first section - general info
$content = apply_filters(
	'the_content',
	'[one_third last="no"]'.
	'<h2>BHAA Details</h2>'.
	'<ul>'.
	'<li><b>BHAA ID</b> : '.$user->ID.'</li>'.
	'<li>Standard : '.$metadata['bhaa_runner_standard'][0].'</li>'.
	(isset($company) ? '<li>Company : '.sprintf('<a href="/?post_type=house&p=%d"><b>%s</b></a>',$company,get_post($company)->post_title).'</li>':'').//:
	'</ul>'.
	'[/one_third]');
echo $content;

// second section - personal
if(is_user_logged_in()||current_user_can('manage_options'))
{
	$content = apply_filters(
		'the_content',
		'[one_third last="no"]'.
		'<h2>Your Details</h2>'.
		'<ul>'.	
		'<li>dateofbirth : '.$metadata['bhaa_runner_dateofbirth'][0].'</li>'.
		'<li>gender : '.$metadata['bhaa_runner_gender'][0].'</li>'.
		'<li>mobilephone : '.$metadata['bhaa_runner_mobilephone'][0].'</li>'.
		'<li>email : '.$user->user_email.'</li>'.
		'</ul>'.
		'[/one_third]');
	echo $content;
}

if(current_user_can('level_7'))
{
	// third section - admin
	$content = apply_filters(
		'the_content',
		'[one_third last="yes"]'.
		'<h2>Admin Details</h2>'.
		'<ul>'.
		'<li>Status : '.$metadata['bhaa_runner_status'][0].'</li>'.
		'<li>dateofrenewal : '.$metadata['bhaa_runner_dateofrenewal'][0].'</li>'.
		'<li><a href="'.get_site_url().'/wp-admin/edit.php?post_type=event&action=bhaa_runner_renew&id='.$user->ID.'">Renew</a></li>'.
		'[/one_third]');
	echo $content;
}

if( current_user_can('manage_options') )
{
	//var_dump(get_user_meta($user->ID));
}

echo $BHAA->getIndividualResultTable()->renderRunnerTable($user->ID);

get_footer();
?>
