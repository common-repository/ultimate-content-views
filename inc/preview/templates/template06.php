
<?php $sliderId = uniqid(); ?>
<div class="wpucv-list wpucv-style06 clearfix">
	<div class="owl-carousel" id="<?php echo esc_attr($sliderId); ?>">
		<?php for( $i = 0; $i < $_wpucv_posts_per_page; $i++ ): ?>
		<?php $dp = $demo_posts[ $i ]; ?>
			<article class="cell medium-4" itemscope itemtype="http://schema.org/Article">
				<a class="wpucv-image-link-wrapper wpucv-<?php echo esc_attr($this->options['_wpucv_thumbnail_shape']); ?>-image-wrapper" href="javascript:void(0);">
					<?php $image = ( 'rectangle' == $this->options['_wpucv_thumbnail_shape'] )? $dp['images']['360x240'] : $dp['images']['200x200']; ?>
					<img class="wpucv-image-responsive" src="<?php echo esc_url(plugins_url( 'inc/preview/images/' . esc_attr($image), WPUCV_MAIN_FILE )); ?>" itemprop="image">
				</a>
				
				<h2 class="wpucv-post-title" itemprop="name headline">
					<a href="javascript:void(0);"><?php echo wpucv_esc($dp['title']); ?></a>
				</h2>
				
				<?php $this->get_preview_post_meta( $dp['author'], $dp['date'] ); ?>
				
				<div class="wpucv-read-more-wrapper"><?php echo wpucv_esc($this->get_readmore()); ?></div>
			</article>
		<?php endfor; ?>
	</div>
</div>
<script>
jQuery(function(){
	"use strict";
	jQuery('#<?php echo esc_js($sliderId); ?>').owlCarousel({
		"use strict";
		loop: true,
		margin: 10,
		responsiveClass: true,
		loop: true,
		rewind: true,
		autoplay: true,
		nav: false,
		responsive: {
			0: {
				items:1
			},
			700: {
				items: 2
			},
			900: {
				items: 2
			},
			1100: {
				items: 3
			}
		},
		mergeFit: true,
		dots: <?php echo ( esc_js($this->options['_wpucv_carousel_dots']) )? 'true' : 'false'; ?>
	});
});
</script>