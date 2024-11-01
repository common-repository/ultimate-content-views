<?php
if( ! class_exists( 'WPUCV_List_Renderer' ) ) {

class WPUCV_List_Renderer{
	
	private $list;
	private $options;
	private $parameters;
	private static $options_names = array(
		'_wpucv_notfound_text',
		'_wpucv_show_pagination',
		'_wpucv_template',
		'_wpucv_show_author',
		'_wpucv_show_date',
		'_wpucv_show_excerpt',
		'_wpucv_excerpt_length',
		'_wpucv_title_size',
		'_wpucv_title_lineheight',
		'_wpucv_title_weight',
		'_wpucv_title_color',
		'_wpucv_title_h_color',
		'_wpucv_meta_size',
		'_wpucv_meta_lineheight',
		'_wpucv_meta_weight',
		'_wpucv_meta_color',
		'_wpucv_excerpt_size',
		'_wpucv_excerpt_lineheight',
		'_wpucv_excerpt_weight',
		'_wpucv_excerpt_color',
		'_wpucv_show_read_more',
		'_wpucv_read_more_text',
		'_wpucv_read_more_type',
		'_wpucv_read_more_color',
		'_wpucv_read_more_h_color',
		'_wpucv_read_more_bg_color',
		'_wpucv_read_more_h_bg_color',
		'_wpucv_read_more_size',
		'_wpucv_read_more_lineheight',
		'_wpucv_read_more_weight',
		'_wpucv_show_list_title',
		'_wpucv_list_title_tag',
		'_wpucv_list_title_color',
		'_wpucv_custom_css',
		'_wpucv_feat_show_author',
		'_wpucv_feat_show_date',
		'_wpucv_feat_title_size',
		'_wpucv_feat_title_lineheight',
		'_wpucv_feat_title_weight',
		'_wpucv_feat_title_color',
		'_wpucv_feat_title_h_color',
		'_wpucv_feat_meta_size',
		'_wpucv_feat_meta_lineheight',
		'_wpucv_feat_meta_weight',
		'_wpucv_feat_meta_color',
		'_wpucv_feat_show_excerpt',
		'_wpucv_feat_show_read_more',
		'_wpucv_feat_excerpt_length',
		'_wpucv_feat_excerpt_size',
		'_wpucv_feat_excerpt_lineheight',
		'_wpucv_feat_excerpt_weight',
		'_wpucv_feat_excerpt_color',
		'_wpucv_feat_read_more_text',
		'_wpucv_feat_read_more_type',
		'_wpucv_feat_read_more_color',
		'_wpucv_feat_read_more_h_c',
		'_wpucv_feat_read_more_bg_c',
		'_wpucv_feat_read_more_h_bgc',
		'_wpucv_feat_read_more_size',
		'_wpucv_feat_read_more_lineheight',
		'_wpucv_feat_read_more_weight',
		'_wpucv_posts_number',
		'_wpucv_posts_per_page',
		'_wpucv_show_pagination',
		'_wpucv_show_next_previous',
		'_wpucv_next_text',
		'_wpucv_previous_text',
		'_wpucv_pagination_type',
		'_wpucv_pagination_c',
		'_wpucv_pagination_h_c',
		'_wpucv_pagination_bg_c',
		'_wpucv_pagination_bg_h_c',
		'_wpucv_next_previous_type',
		'_wpucv_first_text',
		'_wpucv_last_text',
		'_wpucv_ignore_sticky_posts',
		'_wpucv_carousel_dots',
		'_wpucv_carousel_dots_color',
		'_wpucv_carousel_dots_h_color',
		'_wpucv_carousel_text_align',
		'_wpucv_bottom_border',
		'_wpucv_bottom_border_color',
		'_wpucv_thumbnail_shape',
		'_wpucv_list_name',
		'_wpucv_grid_columns_num',
		'_wpucv_grid_columns_spacing',
		'_wpucv_grid_rows_spacing',
		'_wpucv_gallary_row_items',
		'_wpucv_gallary_item_spacing',
	);
	private $pointer;
	private $uniqid;
	private $preview;
	private $preview_real_data;
	
	
	public function __construct( $id, $preview = false, $preview_real_data = false ) {
		global $_SESSION;
		
		if( $preview && isset($id) ) {
		    
			$this->parameters = $_SESSION[ $id ]['query_parameters'];
			$this->options = $_SESSION[ $id ]['list_options'];
		} else {
			$this->list = get_post( $id, OBJECT, 'raw' );
			if( ! $this->list ) {
				return;
			}
			
			$this->parameters = get_post_meta( $this->list->ID, '_wpucv_list_parameters', true );
			if( empty( $this->parameters ) ) {
				$this->parameters = array();
			}
			
			$this->options = array();
			foreach( static::$options_names as $name )
			{
				$this->options[ $name ] = wpucv_esc(get_post_meta( $this->list->ID, $name, true ));
			}
		}
		
		$this->preview = $preview;
		$this->preview_real_data = $preview_real_data;
		$this->uniqid = 'list_' . uniqid();
		
		add_filter( 'excerpt_length', array($this, 'excerpt_length'), 9998 );
		add_filter( 'excerpt_more', array($this, 'set_excerpt_more'), 9999 );
	}
	
	public function render_styles() {
		

		?>
		
		
		<style>
		
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article.wpucv-featured-post h2.wpucv-post-title {
			<?php if( $this->options['_wpucv_feat_title_size'] != '' ) { ?>
			font-size: <?php echo wpucv_esc($this->options['_wpucv_feat_title_size']); ?>px !important;
			<?php } ?>
			
			<?php if( $this->options['_wpucv_feat_title_lineheight'] != '' ) { ?>
			line-height: <?php echo wpucv_esc($this->options['_wpucv_feat_title_lineheight']); ?>px !important;
			<?php } ?>
			
			<?php if( $this->options['_wpucv_feat_title_weight'] != '' ) { ?>
			font-weight: <?php echo wpucv_esc($this->options['_wpucv_feat_title_weight']); ?> !important;
			<?php } ?>
		}
		
		<?php if( $this->options['_wpucv_feat_title_color'] != '' ) { ?>
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article.wpucv-featured-post .wpucv-post-title,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article.wpucv-featured-post .wpucv-post-title a,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article.wpucv-featured-post .wpucv-post-title a:visited{
			color: <?php echo wpucv_esc($this->options['_wpucv_feat_title_color']); ?> !important;
		}
		<?php } ?>
		
		<?php if( $this->options['_wpucv_feat_title_h_color'] != '' ) { ?>
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article.wpucv-featured-post .wpucv-post-title a:hover,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article.wpucv-featured-post .wpucv-post-title a:active {
			color: <?php echo wpucv_esc($this->options['_wpucv_feat_title_h_color']); ?> !important;
		}
		<?php } ?>
		
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article.wpucv-featured-post .wpucv-post-meta,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article.wpucv-featured-post .wpucv-post-meta a{
			<?php if( $this->options['_wpucv_feat_meta_size'] != '' ) { ?>
			font-size: <?php echo wpucv_esc($this->options['_wpucv_feat_meta_size']); ?>px !important;
			<?php } ?>
			
			<?php if( $this->options['_wpucv_feat_meta_lineheight'] != '' ) { ?>
			line-height: <?php echo wpucv_esc($this->options['_wpucv_feat_meta_lineheight']); ?>px !important;
			<?php } ?>
			
			<?php if( $this->options['_wpucv_feat_meta_weight'] != '' ) { ?>
			font-weight: <?php echo wpucv_esc($this->options['_wpucv_feat_meta_weight']); ?> !important;
			<?php } ?>
			
			<?php if( $this->options['_wpucv_feat_meta_color'] != '' ) { ?>
			color: <?php echo wpucv_esc($this->options['_wpucv_feat_meta_color']); ?> !important;
			<?php } ?>
		}
		
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article.wpucv-featured-post p.wpucv-excerpt{
			<?php if( $this->options['_wpucv_feat_excerpt_size'] != '' ) { ?>
			font-size: <?php echo wpucv_esc($this->options['_wpucv_feat_excerpt_size']); ?>px !important;
			<?php } ?>
			
			<?php if( $this->options['_wpucv_feat_excerpt_lineheight'] != '' ) { ?>
			line-height: <?php echo wpucv_esc($this->options['_wpucv_feat_excerpt_lineheight']); ?>px !important;
			<?php } ?>
			
			<?php if( $this->options['_wpucv_feat_excerpt_weight'] != '' ) { ?>
			font-weight: <?php echo wpucv_esc($this->options['_wpucv_feat_excerpt_weight']); ?> !important;
			<?php } ?>
			
			<?php if( $this->options['_wpucv_feat_excerpt_color'] != '' ) { ?>
			color: <?php echo wpucv_esc($this->options['_wpucv_feat_excerpt_color']); ?> !important;
			<?php } ?>
		}
		
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article.wpucv-featured-post a.wpucv-read-more,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article.wpucv-featured-post a.wpucv-read-more.wpucv-button{
			<?php if( $this->options['_wpucv_feat_read_more_color'] != '' ) { ?>
			color: <?php echo wpucv_esc($this->options['_wpucv_feat_read_more_color']); ?> !important;
			<?php } ?>
			
			<?php if( $this->options['_wpucv_feat_read_more_size'] != '' ) { ?>
			font-size: <?php echo wpucv_esc($this->options['_wpucv_feat_read_more_size']); ?>px !important;
			<?php } ?>
			
			<?php if( $this->options['_wpucv_feat_read_more_lineheight'] != '' ) { ?>
			line-height: <?php echo wpucv_esc($this->options['_wpucv_feat_read_more_lineheight']); ?>px !important;
			<?php } ?>
			
			<?php if( $this->options['_wpucv_feat_read_more_weight'] != '' ) { ?>
			font-weight: <?php echo wpucv_esc($this->options['_wpucv_feat_read_more_weight']); ?> !important;
			<?php } ?>
			
			-webkit-transition: all 0.7s !important;
			-moz-transition: all 0.7s !important;
			-o-transition: all 0.7s !important;
			transition: all 0.7s !important;
		}
		
		<?php if( $this->options['_wpucv_feat_read_more_bg_c'] != '' ) { ?>
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article.wpucv-featured-post a.wpucv-read-more,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article.wpucv-featured-post a.wpucv-read-more.wpucv-button{
			background-color: <?php echo wpucv_esc($this->options['_wpucv_feat_read_more_bg_c']); ?> !important;
		}
		<?php } ?>
		
		<?php if( $this->options['_wpucv_feat_read_more_h_c'] != '' ) { ?>
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article.wpucv-featured-post a.wpucv-read-more:hover,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article.wpucv-featured-post a.wpucv-read-more:active,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article.wpucv-featured-post a.wpucv-read-more.wpucv-button:hover,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article.wpucv-featured-post a.wpucv-read-more.wpucv-button:active{
			color: <?php echo wpucv_esc($this->options['_wpucv_feat_read_more_h_c']); ?> !important;
		}
		<?php } ?>
		
		<?php if( $this->options['_wpucv_feat_read_more_h_bgc'] != '' ) { ?>
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article.wpucv-featured-post a.wpucv-read-more.wpucv-button:hover,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article.wpucv-featured-post a.wpucv-read-more.wpucv-button:active{
			background-color: <?php echo wpucv_esc($this->options['_wpucv_feat_read_more_h_bgc']); ?> !important;
		}
		<?php } ?>
		
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article h2.wpucv-post-title{
			<?php if( $this->options['_wpucv_title_size'] != '' ) { ?>
			font-size: <?php echo wpucv_esc($this->options['_wpucv_title_size']); ?>px !important;
			<?php } ?>
			
			<?php if( $this->options['_wpucv_title_lineheight'] != '' ) { ?>
			line-height: <?php echo wpucv_esc($this->options['_wpucv_title_lineheight']); ?>px !important;
			<?php } ?>
			
			<?php if( $this->options['_wpucv_title_weight'] != '' ) { ?>
			font-weight: <?php echo wpucv_esc($this->options['_wpucv_title_weight']); ?> !important;
			<?php } ?>
		}
		
		<?php if( $this->options['_wpucv_title_color'] != '' ) { ?>
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article .wpucv-post-title,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article .wpucv-post-title a,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article .wpucv-post-title a:visited{
			color: <?php echo wpucv_esc($this->options['_wpucv_title_color']); ?> !important;
		}
		<?php } ?>
		
		<?php if( $this->options['_wpucv_title_h_color'] != '' ) { ?>
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article .wpucv-post-title a:hover,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article .wpucv-post-title a:active {
			color: <?php echo wpucv_esc($this->options['_wpucv_title_h_color']); ?> !important;
		}
		<?php } ?>
		
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article .wpucv-post-meta{
			<?php if( $this->options['_wpucv_meta_size'] != '' ) { ?>
			font-size: <?php echo wpucv_esc($this->options['_wpucv_meta_size']); ?>px !important;
			<?php } ?>
			
			<?php if( $this->options['_wpucv_meta_lineheight'] != '' ) { ?>
			line-height: <?php echo wpucv_esc($this->options['_wpucv_meta_lineheight']); ?>px !important;
			<?php } ?>
			
			<?php if( $this->options['_wpucv_meta_weight'] != '' ) { ?>
			font-weight: <?php echo wpucv_esc($this->options['_wpucv_meta_weight']); ?> !important;
			<?php } ?>
		}
		
		<?php if( $this->options['_wpucv_meta_color'] != '' ) { ?>
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article .wpucv-post-meta,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article .wpucv-post-meta a,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article .wpucv-post-meta a:visited,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article .wpucv-post-meta a:hover,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article .wpucv-post-meta a:active{
			color: <?php echo wpucv_esc($this->options['_wpucv_meta_color']); ?> !important;
		}
		<?php } ?>
		
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article p.wpucv-excerpt{
			<?php if( $this->options['_wpucv_excerpt_size'] != '' ) { ?>
			font-size: <?php echo wpucv_esc($this->options['_wpucv_excerpt_size']); ?>px !important;
			<?php } ?>
			
			<?php if( $this->options['_wpucv_excerpt_lineheight'] != '' ) { ?>
			line-height: <?php echo wpucv_esc($this->options['_wpucv_excerpt_lineheight']); ?>px !important;
			<?php } ?>
			
			<?php if( $this->options['_wpucv_excerpt_weight'] != '' ) { ?>
			font-weight: <?php echo wpucv_esc($this->options['_wpucv_excerpt_weight']); ?> !important;
			<?php } ?>

			<?php if( $this->options['_wpucv_excerpt_color'] != '' ) { ?>
			color: <?php echo wpucv_esc($this->options['_wpucv_excerpt_color']); ?> !important;
			<?php } ?>
		}
		
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article a.wpucv-read-more,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article a.wpucv-read-more.wpucv-button{
			<?php if( $this->options['_wpucv_read_more_color'] != '' ) { ?>
			color: <?php echo wpucv_esc($this->options['_wpucv_read_more_color']); ?> !important;
			<?php } ?>
			
			<?php if( $this->options['_wpucv_read_more_size'] != '' ) { ?>
			font-size: <?php echo wpucv_esc($this->options['_wpucv_read_more_size']); ?>px !important;
			<?php } ?>
			
			<?php if( $this->options['_wpucv_read_more_lineheight'] != '' ) { ?>
			line-height: <?php echo wpucv_esc($this->options['_wpucv_read_more_lineheight']); ?>px !important;
			<?php } ?>
			
			<?php if( $this->options['_wpucv_read_more_weight'] != '' ) { ?>
			font-weight: <?php echo wpucv_esc($this->options['_wpucv_read_more_weight']); ?> !important;
			<?php } ?>

			-webkit-transition: all 0.7s !important;
			-moz-transition: all 0.7s !important;
			-o-transition: all 0.7s !important;
			transition: all 0.7s !important;
		}
		
		<?php if( $this->options['_wpucv_read_more_bg_color'] != '' ) { ?>
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article a.wpucv-read-more.wpucv-button{
			background-color: <?php echo wpucv_esc($this->options['_wpucv_read_more_bg_color']); ?> !important;
		}
		<?php } ?>
		
		<?php if( $this->options['_wpucv_read_more_h_color'] != '' ) { ?>
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article a.wpucv-read-more:hover,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article a.wpucv-read-more:active,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article a.wpucv-read-more.wpucv-button:hover,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article a.wpucv-read-more.wpucv-button:active{
			color: <?php echo wpucv_esc($this->options['_wpucv_read_more_h_color']); ?> !important;
		}
		<?php } ?>
		
		<?php if( $this->options['_wpucv_read_more_h_bg_color'] != '' ) { ?>
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article a.wpucv-read-more.wpucv-button:hover,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article a.wpucv-read-more.wpucv-button:active{
			background-color: <?php echo wpucv_esc($this->options['_wpucv_read_more_h_bg_color']); ?> !important;
		}
		<?php } ?>
		
		<?php if( 'circle' == $this->options['_wpucv_pagination_type'] ) { ?>
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-pagination-wrapper .wpucv-pagination li a,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-pagination-wrapper .wpucv-pagination li span{
			border-radius: 50%;
		}
		<?php } ?>
		
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-pagination-wrapper .wpucv-pagination li a{
			<?php if( $this->options['_wpucv_pagination_c'] != '' ) { ?>
			color: <?php echo wpucv_esc($this->options['_wpucv_pagination_c']); ?> !important;
			<?php } ?>
			
			<?php if( ( 'square' == $this->options['_wpucv_pagination_type'] || 'circle' == $this->options['_wpucv_pagination_type'] ) && $this->options['_wpucv_pagination_bg_c'] != '' ) { ?>
			background-color: <?php echo wpucv_esc($this->options['_wpucv_pagination_bg_c']); ?> !important;
			<?php } ?>
		}
		
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-pagination-wrapper .wpucv-pagination li a:hover,
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-pagination-wrapper .wpucv-pagination li span{
			<?php if( $this->options['_wpucv_pagination_h_c'] != '' ) { ?>
			color: <?php echo wpucv_esc($this->options['_wpucv_pagination_h_c']); ?> !important;
			<?php } ?>
			
			<?php if( ( 'square' == $this->options['_wpucv_pagination_type'] || 'circle' == $this->options['_wpucv_pagination_type'] ) && $this->options['_wpucv_pagination_bg_h_c'] != '' ) { ?>
			background-color: <?php echo wpucv_esc($this->options['_wpucv_pagination_bg_h_c']); ?> !important;
			<?php } ?>
		}
		
		<?php if( $this->options['_wpucv_carousel_dots'] && !empty( $this->options['_wpucv_carousel_dots_color'] ) ) { ?>
		#<?php echo wpucv_esc($this->uniqid); ?> .owl-dots .owl-dot span{
			background-color: <?php echo wpucv_esc($this->options['_wpucv_carousel_dots_color']); ?> !important;
		}
		<?php } ?>
		
		<?php if( $this->options['_wpucv_carousel_dots'] && !empty( $this->options['_wpucv_carousel_dots_h_color'] ) ) { ?>
		#<?php echo wpucv_esc($this->uniqid); ?> .owl-dots .owl-dot.active span, #<?php echo wpucv_esc($this->uniqid); ?> .owl-dots .owl-dot span:hover{
			background-color: <?php echo wpucv_esc($this->options['_wpucv_carousel_dots_h_color']); ?> !important;
		}
		<?php } ?>
		
		<?php if( $this->options['_wpucv_carousel_text_align'] != '' ) { ?>
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list.wpucv-style06 article {
			 text-align: <?php echo wpucv_esc($this->options['_wpucv_carousel_text_align']); ?>;
		}
		<?php } ?>
		
		<?php if( !$this->options['_wpucv_bottom_border'] ) { ?>
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article{
			border-bottom: none !important;
			margin-bottom: 5px !important;
		}
		<?php } ?>
		
		<?php if( $this->options['_wpucv_bottom_border'] && !empty( $this->options['_wpucv_bottom_border_color'] ) ) { ?>
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list article{
			border-bottom-color: <?php echo wpucv_esc($this->options['_wpucv_bottom_border_color']); ?> !important;
		}
		<?php } ?>
		
		<?php if( $this->options['_wpucv_grid_columns_spacing'] != '' ) { ?>
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list.wpucv-style02 article {
			padding-left: <?php echo wpucv_esc($this->options['_wpucv_grid_columns_spacing']); ?>px !important;
			padding-right: <?php echo wpucv_esc($this->options['_wpucv_grid_columns_spacing']); ?>px !important;
		}
		<?php } ?>
		
		<?php if( $this->options['_wpucv_grid_rows_spacing'] != '' ) { ?>
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list.wpucv-style02 article {
			padding-top: <?php echo wpucv_esc($this->options['_wpucv_grid_rows_spacing']); ?>px !important;
			padding-bottom: <?php echo wpucv_esc($this->options['_wpucv_grid_rows_spacing']); ?>px !important;
		}
		<?php } ?>
		
		<?php if( $this->options['_wpucv_gallary_item_spacing'] != '' ) { ?>
		#<?php echo wpucv_esc($this->uniqid); ?> .wpucv-list.wpucv-style05 .cell {
			padding: <?php echo wpucv_esc($this->options['_wpucv_gallary_item_spacing']); ?>px !important;
		}
		<?php } ?>
		
		<?php echo wpucv_esc($this->options['_wpucv_custom_css']); ?>
		</style>
		<?php
	}
	
	/**
	 * Render list
	 *
	 * @return string (HTML)
	 */
	public function render() {
		if( ( ! $this->preview && ! $this->list ) || ( ! $this->preview && $this->list->post_status != 'publish' ) ) {
			return;
		}
		
		if( $this->preview ) {
			$post_title = $this->options['_wpucv_list_name'];
		} else {
			$post_title = $this->list->post_title;
		}
		
		ob_start();
		$this->render_styles();
		$_wpucv_posts_number = ( !empty( $this->options['_wpucv_posts_number'] ) )? $this->options['_wpucv_posts_number'] : -1;
		?>
		<div class="wpucv" id="<?php echo esc_attr($this->uniqid); ?>">
			<?php if( $this->preview ) { ?><div class="wpucv-container"><?php } ?>
				<?php if( $this->options['_wpucv_show_list_title'] ) { ?>
				<header>
				<?php $tag = ( !empty( $this->options['_wpucv_list_title_tag'] ) )? $this->options['_wpucv_list_title_tag'] : 'h3'; ?>
				<<?php echo $tag; ?> <?php echo ( !empty( $this->options['_wpucv_list_title_color'] ) )? 'style="color: ' . $this->options['_wpucv_list_title_color'] . ';"' : ''; ?>>
				<?php echo $post_title; ?></<?php echo $tag; ?>>
				</header>
				<?php } ?>
				
				<div class="wpucv-list-wrapper">
					<?php $this->render_list(); ?>
				</div>
				
				<?php if( 'template06' != $this->options['_wpucv_template'] && $this->options['_wpucv_show_pagination'] && !empty( $this->options['_wpucv_posts_per_page'] ) ) { ?>
				<div class="wpucv-pagination-wrapper clearfix">
					<?php $this->render_pagination($this->uniqid); ?>
				</div>
				<?php } ?>
			<?php if( $this->preview ) { ?></div><?php } ?>
		</div>
		<?php
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
	
	public function render_list( $page = 1 ) {
		$_wpucv_posts_per_page = ( $this->options['_wpucv_show_pagination'] && !empty( $this->options['_wpucv_posts_per_page'] ) )? $this->options['_wpucv_posts_per_page'] : $this->options['_wpucv_posts_number'];
		$args = $this->parameters;
		$args['posts_per_page'] = ( $_wpucv_posts_per_page == '' )? -1 : $_wpucv_posts_per_page;
		if( $this->options['_wpucv_template'] != 'template06' && $this->options['_wpucv_show_pagination'] ) {
			$args['offset'] = ( $page - 1 ) * $_wpucv_posts_per_page;
		}
		$args['ignore_sticky_posts'] = $this->options['_wpucv_ignore_sticky_posts'];
		$the_query = new WP_Query( $args );
		extract( $this->options );
		
		if( !empty( $this->options['_wpucv_template'] ) && file_exists( WPUCV_MAIN_DIR . '/templates/' . $this->options['_wpucv_template'] . '.php' ) ) {
			$template = WPUCV_MAIN_DIR . '/templates/' . $this->options['_wpucv_template'] . '.php';
		} else {
			$template = WPUCV_MAIN_DIR . '/templates/template01.php';
		}
		
		include( $template );
		wp_reset_postdata();
	}
	
	public function render_pagination($wrapper, $current = 1) {
		$count_posts = $this->count_posts();
		$total = ( !empty( $this->options['_wpucv_posts_number'] ) && $this->options['_wpucv_posts_number'] < $count_posts )? $this->options['_wpucv_posts_number'] : $count_posts;
		$pages = (float) ( $total / $this->options['_wpucv_posts_per_page'] );
		$pages = ceil( $pages );
		
		if( $pages < 2 ) {
			return;
		}
		
		$showen = ( $pages > 5 )? 5 : $pages;
		$pagination = array($current);
		$remain = $showen - 1;
		$forward = $current + 1;
		$backward = $current - 1;
		
		$_wpucv_show_next_previous = $this->options['_wpucv_show_next_previous'];
		$_wpucv_next_previous_type = $this->options['_wpucv_next_previous_type'];
		
		if( 'icon' == $_wpucv_next_previous_type ) {
			$_wpucv_next_text = '<i class="wpucv-angle-right" aria-hidden="true"></i>';
			$_wpucv_previous_text = '<i class="wpucv-angle-left" aria-hidden="true"></i>';
			$_wpucv_first_text = '<i class="wpucv-angle-double-left" aria-hidden="true"></i>';
			$_wpucv_last_text = '<i class="wpucv-angle-double-right" aria-hidden="true"></i>';
		} else {
			$_wpucv_next_text = ( '' != $this->options['_wpucv_next_text'] )? $this->options['_wpucv_next_text'] : esc_html__( 'Next', 'ultimate-content-views' );
			$_wpucv_previous_text = ( '' != $this->options['_wpucv_previous_text'] )? $this->options['_wpucv_previous_text'] : esc_html__( 'Prev', 'ultimate-content-views' );
			$_wpucv_first_text = ( '' != $this->options['_wpucv_first_text'] )? $this->options['_wpucv_first_text'] : esc_html__( 'First', 'ultimate-content-views' );
			$_wpucv_last_text = ( '' != $this->options['_wpucv_last_text'] )? $this->options['_wpucv_last_text'] : esc_html__( 'Last', 'ultimate-content-views' );
		}
		
		while($remain){
			if($forward <= $showen){
				array_push( $pagination, $forward++ );
				$remain--;
			}
			
			if($backward > 0){
				array_unshift( $pagination, $backward-- );
				$remain--;
			}
		}
		
		if( $this->preview ) {
			$ID = 'none';
		} else {
			$ID = $this->list->ID;
		}
		?>
		<nav aria-label="Pagination">

			<ul class="wpucv-pagination">
				<?php if( $_wpucv_show_next_previous && $pagination[0] > 1 ) { ?>
				<li><a href="javascript:void(0);" onclick="wpucv_change_page('<?php echo esc_js($ID); ?>', '<?php echo esc_js($wrapper); ?>', 1)"><?php echo strip_tags($_wpucv_first_text, '<p><a><i><em><b><strong>'); ?></a></li>
				<?php } ?>
				
				<?php if( $_wpucv_show_next_previous && $current > 1 ) { ?>
				<li><a href="javascript:void(0);" onclick="wpucv_change_page('<?php echo esc_js($ID); ?>', '<?php echo esc_js($wrapper); ?>', <?php echo esc_js($current) - 1; ?>)"><?php echo strip_tags($_wpucv_previous_text, '<p><a><i><em><b><strong>'); ?></a></li>
				<?php } ?>
				
				<?php foreach( $pagination as $item ) { ?>
					
					<?php if( $item == $current ) { ?>
					<li class="current"><span><?php echo wpucv_esc($item); ?></span></li>
					<?php } else { ?>
					<li><a href="javascript:void(0);" onclick="wpucv_change_page('<?php echo esc_js($ID); ?>', '<?php echo esc_js($wrapper); ?>', <?php echo esc_js($item); ?>)"><?php echo wpucv_esc($item); ?></a></li>
					<?php } ?>
					
				<?php } ?>
				
				<?php if( $_wpucv_show_next_previous && $pages > $current ) { ?>
				<li><a href="javascript:void(0);" onclick="wpucv_change_page('<?php echo esc_js($ID); ?>', '<?php echo esc_js($wrapper); ?>', <?php echo esc_js($current) + 1; ?>)"><?php strip_tags($_wpucv_next_text, '<p><a><i><em><b><strong>'); ?></a></li>
				<?php } ?>
				
				<?php if( $_wpucv_show_next_previous && $pagination[ count($pagination) - 1 ] < $pages ) { ?>
				<li><a href="javascript:void(0);" onclick="wpucv_change_page('<?php echo esc_js($ID); ?>', '<?php echo esc_js($wrapper); ?>', <?php echo esc_js($pages); ?>)"><?php echo strip_tags($_wpucv_last_text, '<p><a><i><em><b><strong>'); ?></a></li>
				<?php } ?>
			</ul>
		</nav>
		<?php
	}
	
	private function count_posts() {
		$the_query = new WP_Query( $this->parameters );
		return $the_query->found_posts;
	}
	
	/**
	 * Return post excerpt
	 *
	 * @uses has_excerpt()
	 * @uses apply_filters()
	 * @uses wp_trim_words()
	 * @uses strip_shortcodes()
	 * @uses get_the_excerpt()
	 * @uses wp_trim_excerpt()
	 * @uses get_permalink()
	 * @uses the_title_attribute()
	 * @return string
	 */
	public function get_excerpt( $ID ) {
		if( 'featured' == $this->pointer ) {
			$show_excerpt = $this->options['_wpucv_feat_show_excerpt'];
			$show_read_more = $this->options['_wpucv_feat_show_read_more'];
			$read_more_type = $this->options['_wpucv_feat_read_more_type'];
			$read_more_text = $this->options['_wpucv_feat_read_more_text'];
		} else {
			$show_excerpt = $this->options['_wpucv_show_excerpt'];
			$show_read_more = $this->options['_wpucv_show_read_more'];
			$read_more_type = $this->options['_wpucv_read_more_type'];
			$read_more_text = $this->options['_wpucv_read_more_text'];
		}
		
		
		if( $show_excerpt ) {
			$excerpt = '';
			// if( has_excerpt( $ID ) ) {
			// 	$excerpt_length = $this->excerpt_length();
			// 	$excerpt = wp_trim_words( strip_shortcodes( get_the_excerpt() ), $excerpt_length );
			// }
			$excerpt_length = $this->excerpt_length();
			$excerpt = wp_trim_words( strip_shortcodes( get_the_excerpt() ), $excerpt_length );
			echo '<p class="wpucv-excerpt">' . wp_trim_excerpt( wpucv_esc($excerpt) ) . '</p>';
			
			if( $show_read_more ) {
				echo '<a class="' . ( ( 'button' == $read_more_type )? 'wpucv-button' : '') . ' wpucv-read-more" href="' . esc_url(get_permalink()) . '" title="' . the_title_attribute( array('echo' => false) ).'">' . wpucv_esc($read_more_text) . '</a>';
			}
		}
		
	}
	
	/**
	 * Return post readmore
	 *
	 * @uses get_permalink()
	 * @uses the_title_attribute()
	 * @return string
	 */
	public function get_readmore() {
		if( 'featured' == $this->pointer ) {
			$show_read_more = $this->options['_wpucv_feat_show_read_more'];
			$read_more_type = $this->options['_wpucv_feat_read_more_type'];
			$read_more_text = $this->options['_wpucv_feat_read_more_text'];
		} else {
			$show_read_more = $this->options['_wpucv_show_read_more'];
			$read_more_type = $this->options['_wpucv_read_more_type'];
			$read_more_text = $this->options['_wpucv_read_more_text'];
		}
		
		
		if( $show_read_more ) {
			echo '<a class="' . ( ( 'button' == esc_attr($read_more_type) )? 'wpucv-button' : '') . ' wpucv-read-more" href="' . esc_url(get_permalink()) . '" title="' . esc_attr(the_title_attribute( array('echo' => false) )).'">' . wpucv_esc($read_more_text) . '</a>';
		}
		
	}
	
	/**
	 * Return the meta label
	 *
	 * @uses get_the_author_posts_link()
	 * @uses get_the_time()
	 * @return string
	 */
	public function get_post_meta() {
		if( 'featured' == $this->pointer ) {
			$show_author = wpucv_esc($this->options['_wpucv_feat_show_author']);
			$show_date = wpucv_esc($this->options['_wpucv_feat_show_date']);
		} else {
			$show_author = wpucv_esc($this->options['_wpucv_show_author']);
			$show_date = wpucv_esc($this->options['_wpucv_show_date']);
		}
		
		if( $show_author || $show_date ) {
			echo '<div class="wpucv-post-meta">';
			echo  ( $show_author )? get_the_author_posts_link() : '';
			echo  ( $show_author && $show_date )? '&nbsp;|&nbsp;' : '';
			echo  ( $show_date )? '<time datetime="' . esc_attr(get_the_time( 'Y-m-d' )) . '">' . get_the_time( get_option( 'date_format' ) ) . '</time>' : '';
			echo  '</div>';
		}	
		
	}
	
	/**
	 * Returns the specified excerpt length in the options
	 *
	 * @return integer
	 */
	public function excerpt_length() {
		if( 'featured' == $this->pointer ) {
			return ( empty( $this->options['_wpucv_feat_excerpt_length'] ) )? 0 : $this->options['_wpucv_feat_excerpt_length'];
		} else {
			return ( empty( $this->options['_wpucv_excerpt_length'] ) )? 0 : $this->options['_wpucv_excerpt_length'];
		}
	}
	
	/**
	 * For excerpt more
	 *
	 * @return string
	 */
	public function set_excerpt_more() {
		return '&hellip;';
	}
	
	/**
	 * Render list for preview
	 *
	 * @return string (HTML)
	 */
	
	public function wpucv_previewcss()
	{
		?>
		<style>
			html{
				margin: 0;
			}
			
			
			#wpadminbar{
				display: none !important;
			}
			
			.wpucv .wpucv-container{
				padding: 30px 25px 40px;
				margin-right: auto;
				margin-left: auto;
			}
			@media (min-width: 768px){
				.wpucv .wpucv-container{
					width: 750px;
				}
			}
			@media (min-width: 992px){
				.wpucv .wpucv-container{
					width: 970px;
				}
			}
			@media (min-width: 1200px){
				.wpucv .wpucv-container{
					width: 1170px;
				}
			}
		</style>
		<?php 
	}
	public function render_preview() {
		
		?>
		<!DOCTYPE html>
		<html>
		<head>
		<?php
		$this->enqueue_preview_scripts();
		
		wp_print_styles( array('codepress-foundation', 'wpucv-style', 'owl-carousel', 'owl-carousel-theme', 'font-awesome') );
		
		if( !$this->preview_real_data ) {
			
			wp_register_style( 'dummy-handle', false );
			wp_enqueue_style( 'dummy-handle' );
			wp_add_inline_style( 'dummy-handle', $this->render_styles() );

		}

		wp_print_scripts( array('jquery') );
		add_action( 'run_css_previewcss', array($this, "wpucv_previewcss") );
		do_action( 'run_css_previewcss' );
		
		?>

		</head>
		<body>
		
		<?php
		if( $this->preview_real_data ) {
			$this->render(); // esc inside the function
			?>
			<script>
				jQuery(function(){
					"use strict";
					jQuery('.wpucv-container a').on('click', function(evnt){
						"use strict";
						evnt.preventDefault();
					});
				});
			</script>
			<?php
		} else {
		?>
		<div class="wpucv" id="<?php echo esc_attr($this->uniqid); ?>">
			<div class="wpucv-container">
			<?php if( $this->options['_wpucv_show_list_title'] ) { ?>
			<header>
			<?php $tag = ( !empty( $this->options['_wpucv_list_title_tag'] ) )? $this->options['_wpucv_list_title_tag'] : 'h3'; ?>
			<<?php echo wpucv_esc($tag); ?> <?php echo ( !empty( $this->options['_wpucv_list_title_color'] ) )? 'style="color: ' . esc_attr($this->options['_wpucv_list_title_color']) . ';"' : ''; ?>>
			<?php echo wpucv_esc($this->options['_wpucv_list_name']); ?></<?php echo wpucv_esc($tag); ?>>
			</header>
			<?php } ?>
			
			<div class="wpucv-list-wrapper">
			<?php
			$_wpucv_posts_per_page = ( $this->options['_wpucv_show_pagination'] && !empty( $this->options['_wpucv_posts_per_page'] ) )? $this->options['_wpucv_posts_per_page'] : $this->options['_wpucv_posts_number'];
			$_wpucv_posts_per_page = ( empty( $_wpucv_posts_per_page ) )? 30 : $_wpucv_posts_per_page;
			if( !empty( $this->options['_wpucv_template'] ) && file_exists( WPUCV_MAIN_DIR . '/inc/preview/templates/' . $this->options['_wpucv_template'] . '.php' ) ) {
				$template = WPUCV_MAIN_DIR . '/inc/preview/templates/' . $this->options['_wpucv_template'] . '.php';
			} else {
				$template = WPUCV_MAIN_DIR . '/inc/preview/templates/template01.php';
			}
			
			$demo_posts = file_get_contents( WPUCV_MAIN_DIR . '/inc/preview/dummy-data.json' );
			$demo_posts = json_decode( $demo_posts, true );
			
			include( $template );
			?>
			</div>
			
			<?php
			if( 'template06' != $this->options['_wpucv_template'] && $this->options['_wpucv_show_pagination'] && !empty( $this->options['_wpucv_posts_per_page'] ) ) {
				$_wpucv_show_next_previous = $this->options['_wpucv_show_next_previous'];
				$_wpucv_next_previous_type = $this->options['_wpucv_next_previous_type'];
				
				if( 'icon' == $_wpucv_next_previous_type ) {
					$_wpucv_next_text = '<i class="wpucv-angle-right" aria-hidden="true"></i>';
					$_wpucv_previous_text = '<i class="wpucv-angle-left" aria-hidden="true"></i>';
					$_wpucv_first_text = '<i class="wpucv-angle-double-left" aria-hidden="true"></i>';
					$_wpucv_last_text = '<i class="wpucv-angle-double-right" aria-hidden="true"></i>';
				} else {
					$_wpucv_next_text = ( '' != $this->options['_wpucv_next_text'] )? $this->options['_wpucv_next_text'] : esc_html__( 'Next', 'ultimate-content-views' );
					$_wpucv_previous_text = ( '' != $this->options['_wpucv_previous_text'] )? $this->options['_wpucv_previous_text'] : esc_html__( 'Prev', 'ultimate-content-views' );
					$_wpucv_first_text = ( '' != $this->options['_wpucv_first_text'] )? $this->options['_wpucv_first_text'] : esc_html__( 'First', 'ultimate-content-views' );
					$_wpucv_last_text = ( '' != $this->options['_wpucv_last_text'] )? $this->options['_wpucv_last_text'] : esc_html__( 'Last', 'ultimate-content-views' );
				}
			?>
			<div class="wpucv-pagination-wrapper clearfix">
				<nav aria-label="Pagination">
					<ul class="wpucv-pagination">
						<?php if( $_wpucv_show_next_previous ) { ?>
						<li><a href="javascript:void(0);"><?php echo strip_tags($_wpucv_first_text, '<p><a><i><em><b><strong>'); ?></a></li>
						<?php } ?>
						
						<li class="current"><span>1</span></li>
						
						<li><a href="javascript:void(0);">2</a></li>
						
						<li><a href="javascript:void(0);">3</a></li>
						
						<li><a href="javascript:void(0);">4</a></li>
						
						<?php if( $_wpucv_show_next_previous ) { ?>
						<li><a href="javascript:void(0);"><?php echo strip_tags($_wpucv_last_text, '<p><a><i><em><b><strong>'); ?></a></li>
						<?php } ?>
					</ul>
				</nav>
			</div>
			<?php } ?>
			</div>
		</div>
		
		<?php } ?>
		
		<?php wp_print_scripts( array('owl-carousel', 'wpucv-js') ); ?>
		
		</body>
		</html>
		<?php
		exit;
	}
	
	/**
	 * Enqueue preview styles and scripts
	 *
	 * @return void
	 */
	public function enqueue_preview_scripts() {
		wp_enqueue_style( 'codepress-foundation', plugins_url( 'css/foundation.css', WPUCV_MAIN_FILE ) );
		wp_enqueue_style( 'wpucv-style', plugins_url( 'css/style.css', WPUCV_MAIN_FILE ), array(), '1.1' );
		wp_enqueue_style( 'owl-carousel', plugins_url( 'css/owl.carousel.min.css', WPUCV_MAIN_FILE ) );
		wp_enqueue_style( 'owl-carousel-theme', plugins_url( 'css/owl.theme.default.min.css', WPUCV_MAIN_FILE ) );
		wp_enqueue_style( 'font-awesome', plugins_url( 'fonts/font-awesome/css/font-awesome.min.css', WPUCV_MAIN_FILE ), array(), '4.7.0' );
		
		wp_enqueue_script( 'owl-carousel', plugins_url( 'js/owl.carousel.min.js', WPUCV_MAIN_FILE ), array('jquery'), '2.3.4', true );
		wp_enqueue_script( 'wpucv-js', plugins_url( 'js/js.js', WPUCV_MAIN_FILE ), array('jquery') );
	}
	
	/**
	 * Return the meta label for preview
	 *
	 * @return string
	 */
	public function get_preview_post_meta( $author, $date ) {
		if( 'featured' == $this->pointer ) {
			$show_author = wpucv_esc($this->options['_wpucv_feat_show_author']);
			$show_date = wpucv_esc($this->options['_wpucv_feat_show_date']);
		} else {
			$show_author = wpucv_esc($this->options['_wpucv_show_author']);
			$show_date = wpucv_esc($this->options['_wpucv_show_date']);
		}
		
		
		if( $show_author || $show_date ) {
			echo '<div class="wpucv-post-meta">';
			echo ( $show_author )? wpucv_esc($author) : '';
			echo ( $show_author && $show_date )? '&nbsp;|&nbsp;' : '';
			echo ( $show_date )? '<time>' . wpucv_esc($date) . '</time>' : '';
			echo '</div>';
		}	
		
	}
	
	/**
	 * Return excerpt for preview
	 *
	 * @return string
	 */
	public function get_preview_excerpt( $excerpt ) {
		if( 'featured' == $this->pointer ) {
			$show_excerpt = wpucv_esc($this->options['_wpucv_feat_show_excerpt']);
			$show_read_more = wpucv_esc($this->options['_wpucv_feat_show_read_more']);
			$read_more_type = wpucv_esc($this->options['_wpucv_feat_read_more_type']);
			$read_more_text = wpucv_esc($this->options['_wpucv_feat_read_more_text']);
		} else {
			$show_excerpt = wpucv_esc($this->options['_wpucv_show_excerpt']);
			$show_read_more = wpucv_esc($this->options['_wpucv_show_read_more']);
			$read_more_type = wpucv_esc($this->options['_wpucv_read_more_type']);
			$read_more_text = wpucv_esc($this->options['_wpucv_read_more_text']);
		}
		
		
		if( $show_excerpt ) {
			$excerpt_length = $this->excerpt_length();
			$excerpt = wp_trim_words( $excerpt, $excerpt_length );
			echo '<p class="wpucv-excerpt">' .wpucv_esc(wp_trim_excerpt( $excerpt ) ). '</p>';
			
			if( $show_read_more ) {
				echo '<a class="' . ( ( 'button' == $read_more_type )? 'wpucv-button' : '') . ' wpucv-read-more" href="#">' . wpucv_esc($read_more_text) . '</a>';
			}
		}
		
	}
	
	public function __destruct() {
		remove_filter( 'excerpt_length', array($this, 'excerpt_length'), 9998 );
		remove_filter( 'excerpt_more', array($this, 'set_excerpt_more'), 9999 );
	}
	
	/**
	 * Render list
	 *
	 * @uses get_post()
	 * @param $atts array
	 * @return string (HTML)
	 */
	public static function do_list_shortcode( $atts ) {
		$list = new static( $atts['id'] );
		return $list->render();
	}
	
	public static function prepare_for_preview() {
		session_start();
		global $_SESSION;
		$query_parameters = static::get_list_parameters();
		$list_options = array();
		foreach( static::$options_names as $name ) {
			$list_options[ $name ] = array_key_exists( $name, $_POST )? wpucv_sanitizing($_POST[ $name ]) : NULL;
		}
		
		$uniqid = uniqid();
		$_SESSION[ $uniqid ]['query_parameters'] = $query_parameters;
		$_SESSION[ $uniqid ]['list_options'] = $list_options;
		
		echo wpucv_esc($uniqid);
		exit;
	}
	
	public static function destroy_preview_session(){
		session_start();
		global $_SESSION;
		$preview_id = ( isset( $_POST['preview_id'] ) )? wpucv_sanitizing($_POST['preview_id'],'text') : NULL;
		if( !empty( $preview_id ) ) {
			unset( $_SESSION[ $preview_id ] );
		}
		exit;
	}
	
	public static function get_list_parameters() {
		$params = array();
		// post types
		$_wpucv_post_types = array_key_exists( '_wpucv_post_types', $_POST )? ($_POST['_wpucv_post_types']) : array();
		if( !empty( $_wpucv_post_types ) ) {
			$params['post_type'] = $_wpucv_post_types;
		}
		
		// taxonomies & terms
		if( !empty( $_wpucv_post_types ) ) {
			$tax_queries = array('relation' => 'AND');
			$terms_in_query = false;
			foreach( $_wpucv_post_types as $type ) {
				$terms = ( array_key_exists( '_wpucv_' . $type, $_POST ) )? ($_POST['_wpucv_' . $type]) : array();
				$exclude_terms = ( array_key_exists( '_wpucv_exclude_' . $type, $_POST ) )? ($_POST['_wpucv_exclude_' . $type]) : array();
				
				foreach( $terms as $key => $value ) {
					$value = static::removeEmptyValues( $value );
					if( !empty( $value ) ) {
						$terms_in_query = true;
						$tax_queries[] = array(
							'taxonomy' => $key,
							'field'    => 'term_id',
							'terms'    => array_values($value),
							'operator' => 'IN',
						);
					}
				}
				
				foreach( $exclude_terms as $key => $value ) {
					$value = static::removeEmptyValues( $value );
					if( !empty( $value ) ) {
						$terms_in_query = true;
						$tax_queries[] = array(
							'taxonomy' => $key,
							'field'    => 'term_id',
							'terms'    => array_values($value),
							'operator' => 'NOT IN',
						);
					}
				}
			}
			
			if( $terms_in_query ) {
				$params['tax_query'] = $tax_queries;
			}
		}
		
		// authors
		$_wpucv_authors = array_key_exists( '_wpucv_authors', $_POST )? $_POST['_wpucv_authors'] : array();
		if( is_array( $_wpucv_authors ) && !empty( $_wpucv_authors ) ) {
			$params['author__in'] = $_wpucv_authors;
		}
		
		// exclude authors
		$_wpucv_exclude_authors = array_key_exists( '_wpucv_exclude_authors', $_POST )? ($_POST['_wpucv_exclude_authors']) : array();
		if( is_array( $_wpucv_exclude_authors ) && !empty( $_wpucv_exclude_authors ) ) {
			$params['author__not_in'] = $_wpucv_exclude_authors;
		}
		
		$php_version = phpversion();
		$php_version = substr( $php_version, 0, strpos( $php_version, '.' ) + 2 );
		
		// Date from
		$_wpucv_date_from = array_key_exists( '_wpucv_date_from', $_POST )? wpucv_sanitizing($_POST['_wpucv_date_from']) : NULL;
		if( !empty( $_wpucv_date_from ) ) {
			$_wpucv_date_from = implode( '-', array_reverse( explode( '/', $_wpucv_date_from ) ) );
			$_wpucv_date_from = new DateTime( $_wpucv_date_from );
			if( (float) $php_version >= 5.3 ){
				$interval = new DateInterval('P1D');
				$_wpucv_date_from->sub($interval);
				
			} else {
				$_wpucv_date_from->modify("-1 days");
				
			}
			
			$params['date_query']['after'] = array(
				'year'   => $_wpucv_date_from->format( 'Y' ),
				'month'  => $_wpucv_date_from->format( 'n' ),
				'day'    => $_wpucv_date_from->format( 'j' ),
			);
		}
		
		// Date to
		$_wpucv_date_to = array_key_exists( '_wpucv_date_to', $_POST )? wpucv_sanitizing($_POST['_wpucv_date_to']) : NULL;
		if( !empty( $_wpucv_date_to ) ) {
			$_wpucv_date_to = implode( '-', array_reverse( explode( '/', $_wpucv_date_to ) ) );
			$_wpucv_date_to = new DateTime( $_wpucv_date_to );
			if( (float) $php_version >= 5.3 ){
				$interval = new DateInterval('P1D');
				$_wpucv_date_to->add($interval);
				
			} else {
				$_wpucv_date_to->modify("+1 days");
				
			}
			
			$params['date_query']['before'] = array(
				'year'   => $_wpucv_date_to->format( 'Y' ),
				'month'  => $_wpucv_date_to->format( 'n' ),
				'day'    => $_wpucv_date_to->format( 'j' ),
			);
		}
		
		// Keyword search
		$_wpucv_keywords = array_key_exists( '_wpucv_keywords', $_POST )? ($_POST['_wpucv_keywords']) : NULL;
		if( !empty( $_wpucv_keywords ) ) {
		}
		// S, name, title
		
		// Post status
		$_wpucv_post_status = array_key_exists( '_wpucv_post_status', $_POST )? ($_POST['_wpucv_post_status']) : NULL;
		if( !empty( $_wpucv_post_status ) ) {
			$params['post_status'] = $_wpucv_post_status;
		}
		
		// Has password
		$_wpucv_has_password = array_key_exists( '_wpucv_has_password', $_POST )? wpucv_sanitizing($_POST['_wpucv_has_password']) : NULL;
		if( !empty( $_wpucv_has_password ) && 'null' != $_wpucv_has_password ) {
			$params['has_password'] = (boolean) $_wpucv_has_password;
		}
		
		// Comments count
		$_wpucv_comments_count = array_key_exists( '_wpucv_comments_count', $_POST )? wpucv_sanitizing($_POST['_wpucv_comments_count']) : NULL;
		$_wpucv_comments_count_oprt = array_key_exists( '_wpucv_comments_count_oprt', $_POST )? wpucv_sanitizing($_POST['_wpucv_comments_count_oprt']) : NULL;
		$_wpucv_comments_count = (integer) $_wpucv_comments_count;
		if( !empty( $_wpucv_comments_count ) && $_wpucv_comments_count > 0 ) {
			$params['comment_count'] = array(
				'value'    => $_wpucv_comments_count,
				'compare'  => $_wpucv_comments_count_oprt,
			);
		}
		
		// Comments count
		$_wpucv_order_by = array_key_exists( '_wpucv_order_by', $_POST )? wpucv_sanitizing($_POST['_wpucv_order_by']) : NULL;
		$_wpucv_order_type = array_key_exists( '_wpucv_order_type', $_POST )? wpucv_sanitizing($_POST['_wpucv_order_type']) : NULL;
		if( !empty( $_wpucv_order_by ) ) {
			$params['orderby'] = $_wpucv_order_by;
			$params['order'] = $_wpucv_order_type;
		}
		
		return $params;
	}
	
	private static function removeEmptyValues( $arr = array() ) {
		$values = array();
		if( is_array( $arr ) ) {
			foreach( $arr as $val ) {
				if( !empty( $val ) ) {
					$values[] = $val;
				}
			}
		}
		
		return $values;
	}
}
}
if (!function_exists('wpucv_list')) {
function wpucv_list( $id ) {
	$list = new WPUCV_List_Renderer( $id );
	return $list->render();
}
}

if (!function_exists('wpucv_get_list_page')) {
function wpucv_get_list_page() {
	global $_POST;
	$list_id = ( array_key_exists( 'list_id', $_POST ) )? wpucv_sanitizing($_POST['list_id'],'int') : NULL;
	
	$wrapper_id = ( array_key_exists( 'wrapper_id', $_POST ) )? wpucv_sanitizing($_POST['wrapper_id']) : NULL;
	$page = ( array_key_exists( 'page', $_POST ) )? wpucv_sanitizing($_POST['page'],'int') : 1;
	
	if( !empty( $list_id ) ) {
		$list = new WPUCV_List_Renderer( $list_id );
		$response = array();
		
		ob_start();
		$list->render_list( $page );
		$response['list'] = ob_get_contents();
		ob_end_clean();
		
		ob_start();
		$list->render_pagination( $wrapper_id, $page );
		$response['pagination'] = ob_get_contents();
		ob_end_clean();
		
		echo json_encode( $response );
	}
	
	exit;
}
}

if (!function_exists('wpucv_handle_preview_request')) {
function wpucv_handle_preview_request(){
	
	global $_GET;
	if( isset( $_GET['wpucv_preview'] ) && isset($_GET['wpucv_preview_id']) ) {
		$real = ( isset( $_GET['real'] ) )? wpucv_sanitizing($_GET['real'],'text') : false;
		
		$list = new WPUCV_List_Renderer( wpucv_sanitizing($_GET['wpucv_preview_id'],'text'), true, $real );
		$list->render_preview(); // esc inside the function
		exit;
	}
}
}
