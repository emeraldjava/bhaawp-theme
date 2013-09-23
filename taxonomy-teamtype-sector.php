<?php get_header(); ?>
	<?php
	if($data['blog_full_width']) {
		$content_css = 'width:100%';
		$sidebar_css = 'display:none';
	} elseif($data['blog_sidebar_position'] == 'Left') {
		$content_css = 'float:right;';
		$sidebar_css = 'float:left;';
	} elseif($data['blog_sidebar_position'] == 'Right') {
		$content_css = 'float:left;';
		$sidebar_css = 'float:right;';
	}
	?>
	<div id="content" style="<?php echo $content_css; ?>">
		<?php
		// http://stackoverflow.com/questions/7688591/query-posts-by-custom-taxonomy-id
		$the_query = new WP_Query(array(
				'post_type' => 'house',
				'showposts' => -1,
				'post_status '=>'publish',
				'tax_query' => array(
						array(
								'taxonomy' => 'teamtype',
								'terms' => 'sector',
								'field' => 'slug',
						)
				),
				'orderby' => 'title',
				'order' => 'ASC' 
			)
		);
		if ($the_query->have_posts()) : ?>
		<?php while($the_query->have_posts()): $the_query->the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
			<h5><?php
			$users = get_users( array(
				'connected_type' => 'team_contact',
				'connected_items' => get_the_ID(),
				'suppress_filters' => false,
				'nopaging' => true
			));
			$user = get_user_by('id', $users[0]->ID);
			echo 'Team Contact : '.$user->display_name;
			?></h5>
		</div>
		<?php endwhile; ?>
		<?php 
		// http://www.kriesi.at/archives/how-to-build-a-wordpress-post-pagination-without-plugin
		//kriesi_pagination($pages = '', $range = 2); 
		?>
		<?php else: ?>
		<?php endif; ?>
	</div>
	<?php 
		$args = array(
				'smallest'                  => 12,
				'largest'                   => 16,
				'unit'                      => 'pt',
				'number'                    => 90,
				'format'                    => 'flat',
				//   'separator'                 => \\"\n\\",
				'orderby'                   => 'name',
				'order'                     => 'ASC',
				'exclude'                   => '5',
				//    'include'                   => null,
				//    'topic_count_text_callback' => default_topic_count_text,
				//    'link'                      => 'view',
				'taxonomy'                  => 'teamtype',
				'echo'                      => true );
		wp_tag_cloud($args);
	?>
<?php get_footer(); ?>