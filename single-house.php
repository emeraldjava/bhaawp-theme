<?php
/**
 * Template Name: BHAA House Template
 * @package WordPress
 */
get_header(); 
?>

<section id="primary">

<?php while ( have_posts() ) : the_post(); ?>

<!-- http://wpsnipp.com/index.php/template/create-multiple-search-templates-for-custom-post-types/ -->
<!-- http://www.studionashvegas.com/development/search-specific-post-type-wordpress/ -->
<!-- HIDE AJAX SEARCH
<div class="ui-widget">
	<label for="humm">Search:</label><input id="house_search" />
</div>-->

	<!-- 
	<nav id="nav-single">
		<h3 class="assistive-text">
			<php _e( 'Post navigation', 'twentyeleven' ); ?>
		</h3>
		<span class="nav-previous"><php //previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Previous', 'twentyeleven' ) ); ?>
		</span> <span class="nav-next"><php //next_post_link( '%link', __( 'Next <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?>
		</span>
	</nav>
	-->
	
		<!-- #nav-single -->
<?php 
$content = apply_filters('the_content', 
	'[one_third last="no"]<h1>'.get_the_title().'</h1>'.
	'<p>'.get_the_term_list(get_the_ID(), 'sector', 'Sector : ', ', ', '').'</p>'.
	'<p>'.get_the_term_list(get_the_ID(), 'teamtype', 'TeamType : ', ', ', '').'</p>'.
	'[/one_third]'.
	'[one_third last="no"]<a href="'.get_post_meta(get_the_ID(),'bhaa_company_website',true).'">website</a>[/one_third]'.
	'[one_third last="yes"]<img src="'.get_post_meta(get_the_ID(),'bhaa_company_image',true).'"/>[/one_third]');
echo $content;
?>

<?php
	// Find connected users
	// https://github.com/scribu/wp-posts-to-posts/wiki/Posts-2-Users
	$terms = wp_get_post_terms($post->ID,'teamtype');
	//var_dump($terms);
	if($terms[0]->name=='sectorteam')
	{
		echo '<h2>Sector Team</h2>';
		$users = get_users( array(
				'connected_type' => Connection::SECTORTEAM_TO_RUNNER,
				'connected_items' => $post
		));
	}
	else
	{	
		echo '<h2>Company Team</h2>';
		$users = get_users( array(
			'connected_type' => Connection::HOUSE_TO_RUNNER,
			'connected_items' => $post
		));
	}
?>
<h4>Runners</h4>
<ul>
	<?php foreach ( $users AS $user ) : ?>
	<li><?php 
	$page = get_page_by_title('runner');
	$permalink = get_permalink( $page );
	echo sprintf('<a href="%s">%s</a>',
		add_query_arg( array ( 'id'=>$user->ID ), $permalink ),
		$user->display_name);

	//echo $user->display_name.'-'.$user->ID;
	//echo sprintf('<a href="/?page_id=%d&id=%d">%s</a>',$page->ID,$user->ID,$user->display_name); ?>
	</li>
	<?php endforeach; ?>
</ul>

<?php 
// Prevent weirdness
//wp_reset_postdata();
//endforeach;
?>
<?php endwhile; // end of the loop. ?>
</section>
<?php get_footer(); ?>