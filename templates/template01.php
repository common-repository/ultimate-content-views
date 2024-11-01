<div class="wpucv-list wpucv-style01">
	<?php if ($the_query->have_posts()) : ?>
		<?php while ($the_query->have_posts()) : ?>
			<?php $the_query->the_post(); ?>
			
			<?php $post_id = get_the_ID(); ?>
			<?php $post_permalink = esc_url(get_the_permalink()); ?>
			
			<?php $post_thumbnail_url = esc_url(get_the_post_thumbnail_url($post_id, 'wpucv-classic')); ?>
			<?php $title_attr = the_title_attribute(array('echo' => false)); ?>
			<article id="post-<?php esc_attr(the_ID()); ?>" class="clearfix" itemscope itemtype="http://schema.org/Article">
				<h2 class="wpucv-post-title" itemprop="name headline">
					<a href="<?php echo esc_url(get_the_permalink()); ?>"><?php echo wpucv_esc(get_the_title()); ?></a>
				</h2>
				<?php $this->get_post_meta(); ?>
				<div class="clearfix">
					<a class="wpucv-image-link-wrapper" href="<?php echo $post_permalink; ?>" title="<?php echo esc_attr($title_attr); ?>">
						<?php if (has_post_thumbnail()) : ?>
							<img class="wpucv-image-responsive" src="<?php echo $post_thumbnail_url; ?>" title="<?php echo esc_attr($title_attr); ?>" alt="<?php echo esc_attr($title_attr); ?>" itemprop="image">
						<?php endif; ?>
					</a>
					<?php $this->get_excerpt(get_the_ID()); ?>

				</div>
			</article>
		<?php endwhile; ?>
	<?php else : ?>
		<p class="wpucv-no-found"><?php echo wpucv_esc($this->options['_wpucv_notfound_text']); ?></p>
	<?php endif; ?>
</div>






