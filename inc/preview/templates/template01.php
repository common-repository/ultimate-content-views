
<div class="wpucv-list wpucv-style01">
	<?php for( $i = 0; $i < $_wpucv_posts_per_page; $i++ ): ?>
	<?php $dp = $demo_posts[ $i ]; ?>
	<article class="clearfix" itemscope itemtype="http://schema.org/Article">
		<h2 class="wpucv-post-title" itemprop="name headline">
			<a href="javascript:void(0);"><?php echo wpucv_esc($dp['title']); ?></a>
		</h2>
		
		<?php $this->get_preview_post_meta( $dp['author'], $dp['date'] ); ?>
		<div class="clearfix">
			<a class="wpucv-image-link-wrapper" href="javascript:void(0);">
				<img class="wpucv-image-responsive" src="<?php echo esc_url(plugins_url( 'inc/preview/images/' . esc_attr($dp['images']['320x170']), WPUCV_MAIN_FILE )); ?>" itemprop="image">
			</a>
			<?php $this->get_preview_excerpt( wpucv_esc($dp['excerpt']) ); ?>
		</div>
	</article>
	<?php endfor; ?>
</div>