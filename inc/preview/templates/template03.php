
<div class="wpucv-list wpucv-style03">
	<div class="grid-x wpucv-first-block">
	<?php $index = 0; ?>
	<?php for( $i = 0; $i < $_wpucv_posts_per_page; $i++ ): ?>
	<?php $dp = $demo_posts[ $i ]; ?>
	<?php $this->pointer = ( 0 == $index )? 'featured' : 'other'; ?>
	<?php $thumb = ( 0 == $index )? '320x170' : '150x110'; ?>
	<article class="cell <?php echo ( 0 == $index )? 'medium-12 wpucv-featured-post' : 'medium-6'; ?>" itemscope itemtype="http://schema.org/Article">
		<div class="clearfix">
			<a class="wpucv-image-link-wrapper" href="javascript:void(0);">
				<img class="wpucv-image-responsive" src="<?php echo esc_url(plugins_url( 'inc/preview/images/' . esc_attr($dp['images'][ $thumb ]), WPUCV_MAIN_FILE )); ?>" itemprop="image">
			</a>
			
			<div class="">
				<h2 class="wpucv-post-title" itemprop="name headline">
					<a href="javascript:void(0);"><?php echo wpucv_esc($dp['title']); ?></a>
				</h2>
				
				<?php  $this->get_preview_post_meta( $dp['author'], $dp['date'] ); ?>
				<?php if( 0 == $index ): ?>
				<?php  $this->get_preview_excerpt( $dp['excerpt'] ); ?>
				<?php endif; ?>
			</div>
		</div>
	</article>
	
	<?php if( 0 == $index ): ?>
	</div>
	<div class="grid-x wpucv-second-block">
	<?php endif; ?>
	
	<?php $index++; ?>
	<?php endfor; ?>
	</div>
</div>