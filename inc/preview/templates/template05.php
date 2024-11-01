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
	<div class="grid-x <?php echo esc_attr($cells_classes); ?>">
		<?php for( $i = 0; $i < $_wpucv_posts_per_page; $i++ ): 
		if(isset($demo_posts[ $i ]))
		   {
			   $dp = $demo_posts[ $i ];
		?>
		 
		<div class="cell">
			<a class="wpucv-image-link-wrapper" href="javascript:void(0);">
				<img class="wpucv-image-responsive" src="<?php echo esc_url(plugins_url( 'inc/preview/images/' . esc_attr($dp['images']['200x200']), WPUCV_MAIN_FILE )); ?>" itemprop="image">
			</a>
		</div>
		<?php }
		  endfor; ?>
	</div>
</div>