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
		<?php if (have_posts()) : ?>
		<?php while(have_posts()): the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
		</div>
		<?php endwhile; ?>
		<?php 
		// http://www.kriesi.at/archives/how-to-build-a-wordpress-post-pagination-without-plugin
		kriesi_pagination($pages = '', $range = 2); 
		?>
		<?php else: ?>
		<?php endif; ?>
	</div>
	<div id="sidebar" style="<?php echo $sidebar_css; ?>">
	<?php 
		$args = array(
				'smallest'                  => 8,
				'largest'                   => 22,
				'unit'                      => 'pt',
				'number'                    => 45,
				'format'                    => 'flat',
				//   'separator'                 => \\"\n\\",
				'orderby'                   => 'name',
				'order'                     => 'ASC',
				'exclude'                   => '5',
				//    'include'                   => null,
				//    'topic_count_text_callback' => default_topic_count_text,
				//    'link'                      => 'view',
				'taxonomy'                  => 'sector',
				'echo'                      => true );
		wp_tag_cloud($args);
	?>
	</div>
<?php get_footer(); ?>