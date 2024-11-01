
<div class="wpucv-list wpucv-style03">
	<?php if( $the_query->have_posts() ): ?>
	<div class="grid-x wpucv-first-block">
	<?php $index = 0; ?>
	<?php while( $the_query->have_posts() ): ?>
	<?php $the_query->the_post(); ?>
	<?php $this->pointer = ( 0 == $index )? 'featured' : 'other'; ?>
	<?php $title_attr = the_title_attribute( array('echo' => false) ); ?>
	<?php $thumb = ( 0 == $index )? 'wpucv-classic' : 'wpucv-classic-small'; ?>
	<article id="post-<?php esc_attr(the_ID()); ?>" class="cell <?php echo ( 0 == $index )? 'medium-12 wpucv-featured-post' : 'medium-6'; ?>" itemscope itemtype="http://schema.org/Article">
		<div class="clearfix">
			<a class="wpucv-image-link-wrapper" href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr($title_attr); ?>">
			<?php if( has_post_thumbnail() ): ?>
				<img class="wpucv-image-responsive" src="<?php esc_url(the_post_thumbnail_url( $thumb )); ?>" title="<?php echo esc_attr($title_attr); ?>" alt="<?php echo esc_attr($title_attr); ?>" itemprop="image">
				<?php endif; ?>
			</a>
			
			<div class="">
				<h2 class="wpucv-post-title" itemprop="name headline">
					<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo wpucv_esc(get_the_title()); ?></a>
				</h2>
				
				<?php $this->get_post_meta(); ?>
				<?php if( 0 == $index ): ?>
				<?php $this->get_excerpt( get_the_ID() ); ?>
				<?php endif; ?>
			</div>
		</div>
	</article>
	
	<?php if( 0 == $index ): ?>
	</div>
	<div class="grid-x wpucv-second-block">
	<?php endif; ?>
	
	<?php $index++; ?>
	<?php endwhile; ?>
	</div>
	
	<?php else: ?>
	<p class="wpucv-no-found"><?php echo wpucv_esc($this->options['_wpucv_notfound_text']); ?></p>
	<?php endif; ?>
</div>