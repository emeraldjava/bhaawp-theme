<?php get_header(); ?>
	<div id="content" style="width:90%">
		<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		<div class="single-navigation clearfix">
			<?php previous_post_link('%link', __('Last Event', 'Avada')); ?>
			<?php next_post_link('%link', __('Next Event', 'Avada')); ?>
		</div>
		<?php while(have_posts()): the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php
			global $data;
			if((!$data['legacy_posts_slideshow'] && !$data['posts_slideshow']) && get_post_meta($post->ID, 'pyre_video', true)): ?>
			<div class="flexslider post-slideshow">
				<ul class="slides">
					<li class="video">
						<?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
					</li>
				</ul>
			</div>
			<?php endif;
			if($data['featured_images']):
			if($data['legacy_posts_slideshow']):
			$args = array(
			    'post_type' => 'attachment',
			    'numberposts' => $data['posts_slideshow_number']-1,
			    'post_status' => null,
			    'post_parent' => $post->ID,
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'post_mime_type' => 'image',
				'exclude' => get_post_thumbnail_id()
			);
			$attachments = get_posts($args);
			if((has_post_thumbnail() || get_post_meta($post->ID, 'pyre_video', true))):
			?>
			<div class="flexslider post-slideshow">
				<ul class="slides">
					<?php if($data['posts_slideshow']): ?>
					<?php if(get_post_meta($post->ID, 'pyre_video', true)): ?>
					<li class="video">
						<?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
					</li>
					<?php endif; ?>
					<?php endif; ?>
					<?php if(has_post_thumbnail() && !get_post_meta($post->ID, 'pyre_video', true)): ?>
					<?php $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
					<li>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto['gallery']"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo $attachment->post_title; ?>" /></a>
					</li>
					<?php endif; ?>
					<?php if($data['posts_slideshow']): ?>
					<?php foreach($attachments as $attachment): ?>
					<?php $attachment_image = wp_get_attachment_image_src($attachment->ID, 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src($attachment->ID, 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata($attachment->ID); ?>
					<li>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto['gallery']"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo $attachment->post_title; ?>" /></a>
					</li>
					<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
			<?php endif; ?>
			<?php else: ?>
			<?php
			if((kd_mfi_get_featured_image_id('featured-image-2', 'post') || kd_mfi_get_featured_image_id('featured-image-3', 'post') || kd_mfi_get_featured_image_id('featured-image-4', 'post') || kd_mfi_get_featured_image_id('featured-image-5', 'post') || has_post_thumbnail() || get_post_meta($post->ID, 'pyre_video', true))):
			?>
			<div class="flexslider post-slideshow">
				<ul class="slides">
					<?php if($data['posts_slideshow']): ?>
					<?php if(get_post_meta($post->ID, 'pyre_video', true)): ?>
					<li class="video">
						<?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
					</li>
					<?php endif; ?>
					<?php endif; ?>
					<?php if(has_post_thumbnail() && !get_post_meta($post->ID, 'pyre_video', true)): ?>
					<?php $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
					<li>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto['gallery']"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo $attachment->post_title; ?>" /></a>
					</li>
					<?php endif; ?>
					<?php if($data['posts_slideshow']): ?>
					<?php
					$i = 2;
					while($i <= $data['posts_slideshow_number']):
					$attachment->ID = kd_mfi_get_featured_image_id('featured-image-'.$i, 'post');
					if($attachment->ID):
					?>
					<?php $attachment_image = wp_get_attachment_image_src($attachment->ID, 'blog-large'); ?>
					<?php $full_image = wp_get_attachment_image_src($attachment->ID, 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata($attachment->ID); ?>
					<li>
							<a href="<?php the_permalink(); ?>">
								<img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo $attachment->post_title; ?>" />
							</a>
					</li>
					<?php endif; $i++; endwhile; ?>
					<?php endif; ?>
				</ul>
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<?php endif; ?>
			<div class="post-content">
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</div>
			<?php if($data['post_meta']): ?>
			<div class="meta-info">
				<div class="alignleft">
					<?php echo __('By', 'Avada'); ?> <?php the_author_posts_link(); ?><span class="sep">|</span><?php the_time('F jS, Y'); ?><span class="sep">|</span><?php the_category(', '); ?><span class="sep">|</span><?php comments_popup_link(__('0 Comments', 'Avada'), __('1 Comment', 'Avada'), '% '.__('Comments', 'Avada')); ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if($data['social_sharing_box']): ?>
			<div class="share-box">
				<h4><?php echo __('Share This Story, Choose Your Platform!', 'Avada'); ?></h4>
				<ul>
					<?php if($data['sharing_facebook']): ?>
					<li class="facebook">
						<a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&amp;t=<?php the_title(); ?>">
							Facebook
						</a>
						<div class="popup">
							<div class="holder">
								<p>Facebook</p>
							</div>
						</div>
					</li>
					<?php endif; ?>
					<?php if($data['sharing_twitter']): ?>
					<li class="twitter">
						<a href="http://twitthis.com/twit?url=<?php the_permalink(); ?>">
							Twitter
						</a>
						<div class="popup">
							<div class="holder">
								<p>Twitter</p>
							</div>
						</div>
					</li>
					<?php endif; ?>
					<?php if($data['sharing_linkedin']): ?>
					<li class="linkedin">
						<a href="http://linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>">
							LinkedIn
						</a>
						<div class="popup">
							<div class="holder">
								<p>LinkedIn</p>
							</div>
						</div>
					</li>
					<?php endif; ?>
					<?php if($data['sharing_reddit']): ?>
					<li class="reddit">
						<a href="http://reddit.com/submit?url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>">
							Reddit
						</a>
						<div class="popup">
							<div class="holder">
								<p>Reddit</p>
							</div>
						</div>
					</li>
					<?php endif; ?>
					<?php if($data['sharing_tumblr']): ?>
					<li class="tumblr">
						<a href="http://www.tumblr.com/share/link?url=<?php echo urlencode(get_permalink()); ?>&amp;name=<?php echo urlencode($post->post_title); ?>&amp;description=<?php echo urlencode(get_the_excerpt()); ?>">
							Tumblr
						</a>
						<div class="popup">
							<div class="holder">
								<p>Tumblr</p>
							</div>
						</div>
					</li>
					<?php endif; ?>
					<?php if($data['sharing_google']): ?>
					<li class="google">
						<a href="http://google.com/bookmarks/mark?op=edit&amp;bkmk=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>">
							Google +1
						</a>
						<div class="popup">
							<div class="holder">
								<p>Google +1</p>
							</div>
						</div>
					</li>
					<?php endif; ?>
					<?php if($data['sharing_email']): ?>
					<li class="email">
						<a href="mailto:?subject=<?php the_title(); ?>&amp;body=<?php the_permalink(); ?>">
							Email
						</a>
						<div class="popup">
							<div class="holder">
								<p>Email</p>
							</div>
						</div>
					</li>
					<?php endif; ?>
				</ul>
			</div>
			<?php endif; ?>
			<?php if($data['author_info']): ?>
			<div class="about-author">
				<div class="title"><h2><?php echo __('About the Author:', 'Avada'); ?> <?php the_author_posts_link(); ?></h2></div>
				<div class="about-author-container">
					<div class="avatar">
						<?php echo get_avatar(get_the_author_meta('email'), '72'); ?>
					</div>
					<div class="description">
						<?php the_author_meta("description"); ?>
					</div>
				</div>
			</div>
			<?php endif; ?>

			<?php if($data['related_posts']): ?>
			<?php $related = get_related_posts($post->ID); ?>
			<?php if($related->have_posts()): ?>
			<div class="related-posts">
				<div class="title"><h2><?php echo __('Related Posts', 'Avada'); ?></h2></div>
				<div id="carousel" class="es-carousel-wrapper">
					<div class="es-carousel">
						<ul>
							<?php while($related->have_posts()): $related->the_post(); ?>
							<?php if(has_post_thumbnail()): ?>
							<li>
								<div class="image">
										<?php the_post_thumbnail('related-img'); ?>
										<div class="image-extras">
											<div class="image-extras-content">
							<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
							<a class="icon" href="<?php the_permalink(); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/link-ico.png" alt="<?php the_title(); ?>"/></a>
							<?php
							if(get_post_meta($post->ID, 'pyre_video_url', true)) {
								$full_image[0] = get_post_meta($post->ID, 'pyre_video_url', true);
							}
							?>
							<a class="icon" href="<?php echo $full_image[0]; ?>" rel="prettyPhoto['gallery']"><img src="<?php bloginfo('template_directory'); ?>/images/finder-ico.png" alt="<?php the_title(); ?>" /></a>
												<h3><?php the_title(); ?></h3>
											</div>
										</div>
								</div>
							</li>
							<?php endif; endwhile; ?>
						</ul>
					</div>
				</div>
			</div>
			<?php endif; ?>
			<?php endif; ?>

			<?php if($data['blog_comments']): ?>
				<?php wp_reset_query(); ?>
				<?php comments_template(); ?>
			<?php endif; ?>
		</div>
		<?php endwhile; ?>
	</div>
<?php get_footer(); ?>