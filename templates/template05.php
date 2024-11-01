<?php
switch($this->options['_wpucv_gallary_row_items']){
	case '1':
	$cells_classes = 'small-up-1';
	break;
	
	case '2':
	$cells_classes = 'small-up-1 medium-up-2';
	break;
	
	case '3':
	$cells_classes = 'small-up-1 medium-up-2 large-up-3';
	break;
	
	case '4':
	$cells_classes = 'small-up-1 medium-up-2 large-up-4';
	break;
	
	case '5':
	$cells_classes = 'small-up-2 medium-up-3 large-up-5';
	break;
	
	case '6':
	$cells_classes = 'small-up-2 medium-up-3 large-up-6';
	break;
	
	case '7':
	$cells_classes = 'small-up-2 medium-up-4 large-up-7';
	break;
	
	case '8':
	$cells_classes = 'small-up-2 medium-up-4 large-up-8';
	break;
	
	default:
	$cells_classes = 'small-up-2 medium-up-4 large-up-7';
}
?>
<div class="wpucv-list wpucv-style05 clearfix">
	<?php if( $the_query->have_posts() ): ?>
		<div class="grid-x <?php echo esc_attr($cells_classes); ?>">
		<?php while( $the_query->have_posts() ): ?>
			<?php $the_query->the_post(); ?>
			<?php $post_id = get_the_ID(); ?>
			<?php $post_thumbnail_url = esc_url(get_the_post_thumbnail_url($post_id, 'wpucv-classic')); ?>

			<?php if( has_post_thumbnail() ): ?>
				<div class="cell">
				<?php $title_attr = the_title_attribute( array('echo' => false) ); ?>
					<a class="wpucv-image-link-wrapper" href="<?php echo esc_url( get_the_permalink() );?>" title="<?php echo esc_attr($title_attr); ?>">
						<img class="wpucv-image-responsive" src="<?php echo $post_thumbnail_url; ?>" title="<?php echo esc_attr($title_attr); ?>" alt="<?php echo esc_attr($title_attr); ?>" itemprop="image">
					</a>
				</div>
			<?php endif; ?>
		<?php endwhile; ?>
		</div>
	<?php else: ?>
		<p class="wpucv-no-found"><?php echo wpucv_esc($this->options['_wpucv_notfound_text']); ?></p>
	<?php endif; ?>
</div>