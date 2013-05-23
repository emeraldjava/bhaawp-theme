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

//if(!$user) {
	//error_log(get_site_url());
//	require_once( ABSPATH . 'wp-includes/pluggable.php');
//	wp_redirect(get_site_url().'/',301); 
//	die;
//}

if(isset($_REQUEST['merge'])&&current_user_can('edit_users')) {
	$BHAA->getRunner()->mergeRunner($_REQUEST['id'],$_REQUEST['merge']);
}

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
	(isset($company) ? '<li>Company : '.sprintf('<a href="/?post_type=house&p=%d"><b>%s</b></a>',$company,get_post($company)->post_title).'</li>':'').
	'</ul>'.
	'[/one_third]');
echo $content;

// second section - personal
global $current_user;
//echo error_log($current_user->ID.' - '.$user->ID);
if( ( is_user_logged_in()&&($current_user->ID==$user->ID) ) ||current_user_can('manage_options'))
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

if(current_user_can('edit_users'))
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

	// get current users details
	$user_info = get_userdata($user->ID);
	$bhaa_runner_dateofbirth = get_user_meta($user->ID,'bhaa_runner_dateofbirth',true);
	
	$queryMatchAll = new WP_User_Query(
		array(
			'exclude' => array($user->ID),
			'fields' => 'all_with_meta',
			'meta_query' => array(
				array(
					'key' => 'last_name',
					'value' => $user_info->user_lastname,
					'compare' => '='),
				array(
					'key' => 'first_name',
					'value' => $user_info->user_firstname,
					'compare' => '='),
				array(
					'key' => 'bhaa_runner_dateofbirth',
					'value' => $bhaa_runner_dateofbirth,
					'compare' => '='
	))));
	
	$queryMatchName = new WP_User_Query(
		array(
			'exclude' => array($user->ID),
			'fields' => 'all_with_meta',
			'meta_query' => array(
				array(
					'key' => 'last_name',
					'value' => $user_info->user_lastname,
					'compare' => '='),
				array(
					'key' => 'first_name',
					'value' => $user_info->user_firstname,
					'compare' => '='
	))));
	
	$queryMatchLastDob = new WP_User_Query(
		array(
			'exclude' => array($user->ID),
			'fields' => 'all_with_meta',
			'meta_query' => array(
				array(
					'key' => 'last_name',
					'value' => $user_info->user_lastname,
					'compare' => '='),
				array(
					'key' => 'bhaa_runner_dateofbirth',
					'value' => $bhaa_runner_dateofbirth,
					'compare' => '='
	))));
	
	// 	var_dump($query->query_where);
	// 	echo '<hr/>';
	// 	var_dump($query->get_results());
	// 	echo '<hr/>';
	
	$users = array_merge( $queryMatchAll->get_results(), $queryMatchName->get_results(), $queryMatchLastDob->get_results());
	//var_dump($users);
	foreach($users as $matcheduser)
	{
		echo sprintf('<div>%d <a href="%s">%s</a> DOB:%s, Status:%s, Email:%s <a href="%s">Delete %d and merge to %d</a></div>',
			$matcheduser->ID,
			add_query_arg(array('id'=>$matcheduser->ID),'/runner'),$matcheduser->display_name,
			$matcheduser->bhaa_runner_dateofbirth,$matcheduser->bhaa_runner_status,$matcheduser->user_email,
			add_query_arg(array('id'=>$user->ID,'merge'=>$matcheduser->ID),'/runner'),$matcheduser->ID,$user->ID
		);
	}
	echo '<hr/>';
}

if( current_user_can('manage_options') )
{
	//var_dump(get_user_meta($user->ID));
}

echo $BHAA->getIndividualResultTable()->renderRunnerTable($user->ID);

get_footer();
?>
