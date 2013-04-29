<?php
// Template Name: Portfolio Two Column
get_header(); ?>
	<div id="content" class="full-width portfolio portfolio-two">
		<?php
		$portfolio_category = get_terms('portfolio_category');
		if($portfolio_category):
		?>
		<ul class="portfolio-tabs clearfix">
			<li class="active"><a data-filter="*" href="#"><?php echo __('All', 'Avada'); ?></a></li>
			<?php foreach($portfolio_category as $portfolio_cat): ?>
			<?php if(get_post_meta(get_the_ID(), 'pyre_portfolio_category', true)  && !in_array('0', get_post_meta(get_the_ID(), 'pyre_portfolio_category', true))): ?>
			<?php if(in_array($portfolio_cat->term_id, get_post_meta(get_the_ID(), 'pyre_portfolio_category', true))): ?>
			<li><a data-filter=".<?php echo $portfolio_cat->slug; ?>" href="#"><?php echo $portfolio_cat->name; ?></a></li>
			<?php endif; ?>
			<?php else: ?>
			<li><a data-filter=".<?php echo $portfolio_cat->slug; ?>" href="#"><?php echo $portfolio_cat->name; ?></a></li>
			<?php endif; ?>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<div class="portfolio-wrapper">
			<?php
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$args = array(
				'post_type' => 'avada_portfolio',
				'paged' => $paged,
				'posts_per_page' => $data['portfolio_items'],
			);
			$pcats = get_post_meta(get_the_ID(), 'pyre_portfolio_category', true);
			if($pcats && $pcats[0] == 0) {
				unset($pcats[0]);
			}
			if($pcats){
				$args['tax_query'][] = array(
					'taxonomy' => 'portfolio_category',
					'field' => 'ID',
					'terms' => $pcats
				);
			}
			$gallery = new WP_Query($args);
			while($gallery->have_posts()): $gallery->the_post();
				if(has_post_thumbnail() || get_post_meta($post->ID, 'pyre_video', true)):
			?>
			<?php
			$item_classes = '';
			$item_cats = get_the_terms($post->ID, 'portfolio_category');
			if($item_cats):
			foreach($item_cats as $item_cat) {
				$item_classes .= $item_cat->slug . ' ';
			}
			endif;
			?>
			<div class="portfolio-item <?php echo $item_classes; ?>">
				<?php if(has_post_thumbnail()): ?>
				<div class="image">
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail('portfolio-two'); ?>
					</a>
					<div class="image-extras">
						<div class="image-extras-content">
							<a class="icon" href="<?php the_permalink(); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/link-ico.png" alt="<?php the_title(); ?>"/></a>
							<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
							<?php
							if(get_post_meta($post->ID, 'pyre_video_url', true)) {
								$full_image[0] = get_post_meta($post->ID, 'pyre_video_url', true);
							}
							?>
							<a class="icon" href="<?php echo $full_image[0]; ?>" rel="prettyPhoto['gallery']"><img src="<?php bloginfo('template_directory'); ?>/images/finder-ico.png" alt="<?php the_title(); ?>" /></a>
							<h3><?php the_title(); ?></h3>
							<h4><?php echo get_the_term_list($post->ID, 'portfolio_category', '', ', ', ''); ?></h4>
						</div>
					</div>
				</div>
				<?php endif; ?>
			</div>
			<?php endif; endwhile; ?>
		</div>
		<?php kriesi_pagination($gallery->max_num_pages, $range = 2); ?>
	</div>
<?php get_footer(); ?>