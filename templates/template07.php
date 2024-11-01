
<div class="wpucv-list wpucv-style07">
	<?php if( $the_query->have_posts() ): ?>
	<?php while( $the_query->have_posts() ): ?>
	<?php $the_query->the_post(); ?>
	<?php $title_attr = the_title_attribute( array('echo' => false) ); ?>
	<article id="post-<?php esc_attr(the_ID()); ?>" class="clearfix" itemscope itemtype="http://schema.org/Article">
		<h2 class="wpucv-post-title" itemprop="name headline">
			<a href="<?php echo esc_url( get_the_permalink() );?>"><?php echo wpucv_esc(get_the_title()); ?></a>
		</h2>
		
		<?php $this->get_post_meta(); ?>
	</article>
	<?php endwhile; ?>
	<?php else: ?>
	<p class="wpucv-no-found"><?php echo wpucv_esc($this->options['_wpucv_notfound_text']); ?></p>
	<?php endif; ?>
</div>