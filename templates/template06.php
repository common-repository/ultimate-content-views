
<?php $sliderId = uniqid(); ?>
<div class="wpucv-list wpucv-style06 clearfix">
	<?php if( $the_query->have_posts() ): ?>
		
	<div class="owl-carousel" id="<?php echo esc_attr($sliderId); ?>">
		<?php while( $the_query->have_posts() ): ?>
			<?php $the_query->the_post(); ?>
			<?php $post_id = get_the_ID(); ?>
			<?php $post_thumbnail_url = esc_url(get_the_post_thumbnail_url($post_id, 'wpucv-classic')); ?>
			<?php $title_attr = the_title_attribute( array('echo' => false) ); ?>

			<article id="post-<?php esc_attr(the_ID()); ?>" itemscope itemtype="http://schema.org/Article">
				<a class="wpucv-image-link-wrapper wpucv-<?php echo esc_attr($_wpucv_thumbnail_shape); ?>-image-wrapper" href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr($title_attr); ?>">
				<?php if( has_post_thumbnail() ): ?>
					<?php $thumb = ( 'rectangle' == $_wpucv_thumbnail_shape )? 'wpucv-grid-three' : 'wpucv-galary'; ?>
					<img class="wpucv-image-responsive" src="<?php echo $post_thumbnail_url; ?>" title="<?php echo esc_attr($title_attr); ?>" alt="<?php echo esc_attr($title_attr); ?>" itemprop="image">
					<?php endif; ?>
				</a>
				
				<h2 class="wpucv-post-title" itemprop="name headline">
					<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo wpucv_esc(get_the_title()); ?></a>
				</h2>
				
				
				<?php $this->get_post_meta(); ?>
				
				<div class="wpucv-read-more-wrapper"><?php $this->get_readmore(); ?></div>
			</article>
			
		<?php endwhile; ?>
	</div>
	
	<?php else: ?>
	<p class="wpucv-no-found"><?php echo wpucv_esc($this->options['_wpucv_notfound_text']); ?></p>
	<?php endif; ?>
</div>
<?php if( $the_query->have_posts() ): ?>
<script>
jQuery(function(){
	"use strict";
	jQuery('#<?php echo esc_js($sliderId); ?>').owlCarousel({
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
<?php endif; ?>


