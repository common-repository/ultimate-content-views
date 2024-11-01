<div class="wpucv-list wpucv-style02">
	<div class="grid-x">
		<?php for( $i = 0; $i < $_wpucv_posts_per_page; $i++ ): ?>
		<?php $dp = $demo_posts[ $i ]; ?>
		<article class="cell small-12 medium-6 large-4" itemscope itemtype="http://schema.org/Article">
			<a class="wpucv-image-link-wrapper" href="javascript:void(0);">
				<img class="wpucv-image-responsive" src="<?php echo esc_url(plugins_url( 'inc/preview/images/' . esc_attr($dp['images']['360x240']), WPUCV_MAIN_FILE )); ?>" itemprop="image">
			</a>
			
			<h2 class="wpucv-post-title" itemprop="name headline">
				<a href="javascript:void(0);"><?php echo wpucv_esc($dp['title']); ?></a>
			</h2>
			
			<?php  $this->get_preview_post_meta( $dp['author'], $dp['date'] ); ?>
			
			<?php  $this->get_preview_excerpt( $dp['excerpt'] ); ?>
		</article>
		<?php endfor; ?>
	</div>
</div>