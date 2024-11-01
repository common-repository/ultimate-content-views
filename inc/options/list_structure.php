
<div class="panel panel-default" id="structureOptionsPanel">
	<div class="panel-heading" role="tab" id="structureOptionsHeading">
		<h4 class="panel-title">
			<a role="button" data-toggle="collapse" href="#structureOptions" aria-expanded="true" aria-controls="structureOptions">
			<?php echo esc_html__(  'List Structure', 'ultimate-content-views' ); ?>
			</a>
		</h4>
	</div>
	<div id="structureOptions" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="structureOptionsHeading">
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-6">
				<?php echo static::render_field( array(
					'id'           => '_wpucv_grid_columns_num',
					'name'         => '_wpucv_grid_columns_num',
					'label'        => esc_html__( 'Grid columns number', 'ultimate-content-views' ),
					'type'         => 'select',
					'options'      => array(
						'1'     => esc_html__( '1 column', 'ultimate-content-views' ),
						'2'     => esc_html__( '2 columns', 'ultimate-content-views' ),
						'3'     => esc_html__( '3 columns', 'ultimate-content-views' ),
						'4'     => esc_html__( '4 columns', 'ultimate-content-views' ),
						'6'     => esc_html__( '6 columns', 'ultimate-content-views' ),
					),
					'empty_option' => false,
				), $_wpucv_grid_columns_num );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_grid_columns_spacing',
					'name'         => '_wpucv_grid_columns_spacing',
					'label'        => esc_html__( 'Column spacing', 'ultimate-content-views' ),
					'type'         => 'number',
					'desc'           => esc_html__( 'left & right space of a grid cell', 'ultimate-content-views' ),
				), $_wpucv_grid_columns_spacing );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_grid_rows_spacing',
					'name'         => '_wpucv_grid_rows_spacing',
					'label'        => esc_html__( 'Row spacing', 'ultimate-content-views' ),
					'type'         => 'number',
					'desc'           => esc_html__( 'top & bottom space of a grid cell', 'ultimate-content-views' ),
				), $_wpucv_grid_rows_spacing );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_gallary_row_items',
					'name'         => '_wpucv_gallary_row_items',
					'label'        => esc_html__( 'Items per row', 'ultimate-content-views' ),
					'type'         => 'select',
					'options'      => array(
						'1'     => esc_html__( '1 item', 'ultimate-content-views' ),
						'2'     => esc_html__( '2 items', 'ultimate-content-views' ),
						'3'     => esc_html__( '3 items', 'ultimate-content-views' ),
						'4'     => esc_html__( '4 items', 'ultimate-content-views' ),
						'5'     => esc_html__( '5 items', 'ultimate-content-views' ),
						'6'     => esc_html__( '6 items', 'ultimate-content-views' ),
						'7'     => esc_html__( '7 items', 'ultimate-content-views' ),
						'8'     => esc_html__( '8 items', 'ultimate-content-views' ),
					),
					'empty_option' => false,
				), $_wpucv_gallary_row_items );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_gallary_item_spacing',
					'name'         => '_wpucv_gallary_item_spacing',
					'label'        => esc_html__( 'Item spacing', 'ultimate-content-views' ),
					'type'         => 'number',
				), $_wpucv_gallary_item_spacing );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_title_size',
					'name'         => '_wpucv_title_size',
					'label'        => esc_html__( 'Title font size', 'ultimate-content-views' ),
					'type'         => 'number',
				), $_wpucv_title_size );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_title_lineheight',
					'name'         => '_wpucv_title_lineheight',
					'label'        => esc_html__( 'Title line height', 'ultimate-content-views' ),
					'type'         => 'text',
				), $_wpucv_title_lineheight );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_title_weight',
					'name'         => '_wpucv_title_weight',
					'label'        => esc_html__( 'Title font weight', 'ultimate-content-views' ),
					'type'         => 'text',
				), $_wpucv_title_weight );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_meta_size',
					'name'         => '_wpucv_meta_size',
					'label'        => esc_html__( 'Post meta font size', 'ultimate-content-views' ),
					'type'         => 'number',
				), $_wpucv_meta_size );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_meta_lineheight',
					'name'         => '_wpucv_meta_lineheight',
					'label'        => esc_html__( 'Post meta line height', 'ultimate-content-views' ),
					'type'         => 'text',
				), $_wpucv_meta_lineheight );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_meta_weight',
					'name'         => '_wpucv_meta_weight',
					'label'        => esc_html__( 'Post meta font weight', 'ultimate-content-views' ),
					'type'         => 'text',
				), $_wpucv_meta_weight );
				?>
				
				<?php echo static::render_field( array(
					'id'             => '_wpucv_excerpt_length',
					'name'           => '_wpucv_excerpt_length',
					'label'          => esc_html__( 'Excerpt Length', 'ultimate-content-views' ),
					'type'           => 'number',
					'desc'           => esc_html__( 'Number of words', 'ultimate-content-views' ),
				), $_wpucv_excerpt_length );
				?>
				
				<?php
				$options = array(
					'center'     => 'Center',
				);
				if( is_rtl() ) {
					$options['right'] = 'Right';
				} else{
					$options['left'] = 'Left';
				}
					
				echo static::render_field( array(
					'id'           => '_wpucv_carousel_text_align',
					'name'         => '_wpucv_carousel_text_align',
					'label'        => esc_html__( 'Text align', 'ultimate-content-views' ),
					'type'         => 'select',
					'options'      => $options,
					'empty_option' => false,
				), $_wpucv_carousel_text_align );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_thumbnail_shape',
					'name'         => '_wpucv_thumbnail_shape',
					'label'        => esc_html__( 'Thumbnail shape', 'ultimate-content-views' ),
					'type'         => 'select',
					'options'      => array(
						'rectangle'     => 'Rectangle',
						'circle'     => 'Circle',
					),
					'empty_option' => false,
				), $_wpucv_thumbnail_shape );
				?>
				</div>
				
				<div class="col-sm-6">
				<?php echo static::render_field( array(
					'id'             => '_wpucv_show_author',
					'name'           => '_wpucv_show_author',
					'label'          => esc_html__( 'Show Author ', 'ultimate-content-views' ),
					'type'           => 'checkbox',
				), $_wpucv_show_author );
				?>
				
				<?php echo static::render_field( array(
					'id'             => '_wpucv_show_date',
					'name'           => '_wpucv_show_date',
					'label'          => esc_html__( 'Show Date ', 'ultimate-content-views' ),
					'type'           => 'checkbox',
				), $_wpucv_show_date );
				?>
				
				<?php echo static::render_field( array(
					'id'             => '_wpucv_show_excerpt',
					'name'           => '_wpucv_show_excerpt',
					'label'          => esc_html__( 'Show Excerpt ', 'ultimate-content-views' ),
					'type'           => 'checkbox',
				), $_wpucv_show_excerpt );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_title_color',
					'name'         => '_wpucv_title_color',
					'label'        => esc_html__( 'Title color', 'ultimate-content-views' ),
					'type'         => 'color',
				), $_wpucv_title_color );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_title_h_color',
					'name'         => '_wpucv_title_h_color',
					'label'        => esc_html__( 'Title hover color', 'ultimate-content-views' ),
					'type'         => 'color',
				), $_wpucv_title_h_color );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_meta_color',
					'name'         => '_wpucv_meta_color',
					'label'        => esc_html__( 'Post meta color', 'ultimate-content-views' ),
					'type'         => 'color',
				), $_wpucv_meta_color );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_excerpt_color',
					'name'         => '_wpucv_excerpt_color',
					'label'        => esc_html__( 'Excerpt color', 'ultimate-content-views' ),
					'type'         => 'color',
				), $_wpucv_excerpt_color );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_carousel_dots',
					'name'         => '_wpucv_carousel_dots',
					'label'        => esc_html__( 'Show navigation dots', 'ultimate-content-views' ),
					'type'         => 'checkbox',
				), $_wpucv_carousel_dots );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_carousel_dots_color',
					'name'         => '_wpucv_carousel_dots_color',
					'label'        => esc_html__( 'Dots color', 'ultimate-content-views' ),
					'type'         => 'color',
				), $_wpucv_carousel_dots_color );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_carousel_dots_h_color',
					'name'         => '_wpucv_carousel_dots_h_color',
					'label'        => esc_html__( 'Dots active/hover color', 'ultimate-content-views' ),
					'type'         => 'color',
				), $_wpucv_carousel_dots_h_color );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_excerpt_size',
					'name'         => '_wpucv_excerpt_size',
					'label'        => esc_html__( 'Excerpt font size', 'ultimate-content-views' ),
					'type'         => 'number',
				), $_wpucv_excerpt_size );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_excerpt_lineheight',
					'name'         => '_wpucv_excerpt_lineheight',
					'label'        => esc_html__( 'Excerpt line height', 'ultimate-content-views' ),
					'type'         => 'text',
				), $_wpucv_excerpt_lineheight );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_excerpt_weight',
					'name'         => '_wpucv_excerpt_weight',
					'label'        => esc_html__( 'Excerpt font weight', 'ultimate-content-views' ),
					'type'         => 'text',
				), $_wpucv_excerpt_weight );
				?>
				</div>
				
				<br />
			</div>
			
			
			<div class="row">
				<div class="col-xs-12">
				<?php echo static::render_field( array(
					'type'             => 'label',
					'name'             => 'label_structure_1',
					'id'               => 'label_structure_1',
					'label'            => esc_html__( 'Read More Options', 'ultimate-content-views' ),
					'underlined_label' => true,
				), NULL );
				?>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-6">
				<?php echo static::render_field( array(
					'id'             => '_wpucv_read_more_text',
					'name'           => '_wpucv_read_more_text',
					'label'          => esc_html__( 'Read More Text', 'ultimate-content-views' ),
					'type'           => 'text',
				), $_wpucv_read_more_text );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_read_more_type',
					'name'         => '_wpucv_read_more_type',
					'label'        => esc_html__( 'Type', 'ultimate-content-views' ),
					'type'         => 'select',
					'options'      => array(
						'anchor'     => 'Anchor link',
						'button'     => 'Button',
					),
					'empty_option' => false,
				), $_wpucv_read_more_type );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_read_more_size',
					'name'         => '_wpucv_read_more_size',
					'label'        => esc_html__( 'Font size', 'ultimate-content-views' ),
					'type'         => 'number',
				), $_wpucv_read_more_size );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_read_more_lineheight',
					'name'         => '_wpucv_read_more_lineheight',
					'label'        => esc_html__( 'Line height', 'ultimate-content-views' ),
					'type'         => 'text',
				), $_wpucv_read_more_lineheight );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_read_more_weight',
					'name'         => '_wpucv_read_more_weight',
					'label'        => esc_html__( 'Font weight', 'ultimate-content-views' ),
					'type'         => 'text',
				), $_wpucv_read_more_weight );
				?>
				</div>
				
				<div class="col-sm-6">
				<?php echo static::render_field( array(
					'id'             => '_wpucv_show_read_more',
					'name'           => '_wpucv_show_read_more',
					'label'          => esc_html__( 'Show Read More ', 'ultimate-content-views' ),
					'type'           => 'checkbox',
				), $_wpucv_show_read_more );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_read_more_color',
					'name'         => '_wpucv_read_more_color',
					'label'        => esc_html__( 'Text color', 'ultimate-content-views' ),
					'type'         => 'color',
				), $_wpucv_read_more_color );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_read_more_h_color',
					'name'         => '_wpucv_read_more_h_color',
					'label'        => esc_html__( 'Text hover color', 'ultimate-content-views' ),
					'type'         => 'color',
				), $_wpucv_read_more_h_color );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_read_more_bg_color',
					'name'         => '_wpucv_read_more_bg_color',
					'label'        => esc_html__( 'Background color', 'ultimate-content-views' ),
					'type'         => 'color',
				), $_wpucv_read_more_bg_color );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_read_more_h_bg_color',
					'name'         => '_wpucv_read_more_h_bg_color',
					'label'        => esc_html__( 'Background hover color', 'ultimate-content-views' ),
					'type'         => 'color',
				), $_wpucv_read_more_h_bg_color );
				?>
				</div>
				
				<br />
			</div>
			
			
			<div class="row">
				<div class="col-xs-12">
				<?php echo static::render_field( array(
					'type' => 'label',
					'name' => 'label_structure_2',
					'id' => 'label_structure_2',
					'label' => esc_html__( 'Featured Post Options', 'ultimate-content-views' ),
					'underlined_label' => true,
				), NULL );
				?>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-6">
				<?php echo static::render_field( array(
					'id'           => '_wpucv_feat_title_size',
					'name'         => '_wpucv_feat_title_size',
					'label'        => esc_html__( 'Title font size', 'ultimate-content-views' ),
					'type'         => 'number',
				), $_wpucv_feat_title_size );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_feat_title_lineheight',
					'name'         => '_wpucv_feat_title_lineheight',
					'label'        => esc_html__( 'Title line height', 'ultimate-content-views' ),
					'type'         => 'text',
				), $_wpucv_feat_title_lineheight );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_feat_title_weight',
					'name'         => '_wpucv_feat_title_weight',
					'label'        => esc_html__( 'Title font weight', 'ultimate-content-views' ),
					'type'         => 'text',
				), $_wpucv_feat_title_weight );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_feat_meta_size',
					'name'         => '_wpucv_feat_meta_size',
					'label'        => esc_html__( 'Post meta font size', 'ultimate-content-views' ),
					'type'         => 'number',
				), $_wpucv_feat_meta_size );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_feat_meta_lineheight',
					'name'         => '_wpucv_feat_meta_lineheight',
					'label'        => esc_html__( 'Post meta line height', 'ultimate-content-views' ),
					'type'         => 'text',
				), $_wpucv_feat_meta_lineheight );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_feat_meta_weight',
					'name'         => '_wpucv_feat_meta_weight',
					'label'        => esc_html__( 'Post meta font weight', 'ultimate-content-views' ),
					'type'         => 'text',
				), $_wpucv_feat_meta_weight );
				?>
				
				<?php echo static::render_field( array(
					'id'             => '_wpucv_feat_excerpt_length',
					'name'           => '_wpucv_feat_excerpt_length',
					'label'          => esc_html__( 'Excerpt Length', 'ultimate-content-views' ),
					'type'           => 'number',
					'desc'           => esc_html__( 'Number of words', 'ultimate-content-views' ),
				), $_wpucv_feat_excerpt_length );
				?>
				</div>
				
				<div class="col-sm-6">
				<?php echo static::render_field( array(
					'id'             => '_wpucv_feat_show_author',
					'name'           => '_wpucv_feat_show_author',
					'label'          => esc_html__( 'Show Author ', 'ultimate-content-views' ),
					'type'           => 'checkbox',
				), $_wpucv_feat_show_author );
				?>
				
				<?php echo static::render_field( array(
					'id'             => '_wpucv_feat_show_date',
					'name'           => '_wpucv_feat_show_date',
					'label'          => esc_html__( 'Show Date ', 'ultimate-content-views' ),
					'type'           => 'checkbox',
				), $_wpucv_feat_show_date );
				?>
				
				<?php echo static::render_field( array(
					'id'             => '_wpucv_feat_show_excerpt',
					'name'           => '_wpucv_feat_show_excerpt',
					'label'          => esc_html__( 'Show Excerpt ', 'ultimate-content-views' ),
					'type'           => 'checkbox',
				), $_wpucv_feat_show_excerpt );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_feat_title_color',
					'name'         => '_wpucv_feat_title_color',
					'label'        => esc_html__( 'Title color', 'ultimate-content-views' ),
					'type'         => 'color',
				), $_wpucv_feat_title_color );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_feat_title_h_color',
					'name'         => '_wpucv_feat_title_h_color',
					'label'        => esc_html__( 'Title hover color', 'ultimate-content-views' ),
					'type'         => 'color',
				), $_wpucv_feat_title_h_color );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_feat_meta_color',
					'name'         => '_wpucv_feat_meta_color',
					'label'        => esc_html__( 'Post meta color', 'ultimate-content-views' ),
					'type'         => 'color',
				), $_wpucv_feat_meta_color );
				?>
				
				<?php echo static::render_field( array(
					'id'             => '_wpucv_bottom_border',
					'name'           => '_wpucv_bottom_border',
					'label'          => esc_html__( 'Bottom border', 'ultimate-content-views' ),
					'type'           => 'checkbox',
				), $_wpucv_bottom_border );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_bottom_border_color',
					'name'         => '_wpucv_bottom_border_color',
					'label'        => esc_html__( 'Bottom border color', 'ultimate-content-views' ),
					'type'         => 'color',
				), $_wpucv_bottom_border_color );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_feat_excerpt_color',
					'name'         => '_wpucv_feat_excerpt_color',
					'label'        => esc_html__( 'Excerpt color', 'ultimate-content-views' ),
					'type'         => 'color',
				), $_wpucv_feat_excerpt_color );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_feat_excerpt_size',
					'name'         => '_wpucv_feat_excerpt_size',
					'label'        => esc_html__( 'Excerpt font size', 'ultimate-content-views' ),
					'type'         => 'number',
				), $_wpucv_feat_excerpt_size );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_feat_excerpt_lineheight',
					'name'         => '_wpucv_feat_excerpt_lineheight',
					'label'        => esc_html__( 'Excerpt line height', 'ultimate-content-views' ),
					'type'         => 'text',
				), $_wpucv_feat_excerpt_lineheight );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_feat_excerpt_weight',
					'name'         => '_wpucv_feat_excerpt_weight',
					'label'        => esc_html__( 'Excerpt font weight', 'ultimate-content-views' ),
					'type'         => 'text',
				), $_wpucv_feat_excerpt_weight );
				?>
				</div>
				
				<br />
			</div>
			
			
			<div class="row">
				<div class="col-xs-12">
				<?php echo static::render_field( array(
					'type' => 'label',
					'name' => 'label_structure_3',
					'id' => 'label_structure_3',
					'label' => esc_html__( 'Featured Post Read More Options', 'ultimate-content-views' ),
					'underlined_label' => true,
				), NULL );
				?>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-6">
				<?php echo static::render_field( array(
					'id'             => '_wpucv_feat_read_more_text',
					'name'           => '_wpucv_feat_read_more_text',
					'label'          => esc_html__( 'Read More Text', 'ultimate-content-views' ),
					'type'           => 'text',
				), $_wpucv_feat_read_more_text );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_feat_read_more_size',
					'name'         => '_wpucv_feat_read_more_size',
					'label'        => esc_html__( 'Font size', 'ultimate-content-views' ),
					'type'         => 'number',
				), $_wpucv_feat_read_more_size );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_feat_read_more_lineheight',
					'name'         => '_wpucv_feat_read_more_lineheight',
					'label'        => esc_html__( 'Line height', 'ultimate-content-views' ),
					'type'         => 'text',
				), $_wpucv_feat_read_more_lineheight );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_feat_read_more_weight',
					'name'         => '_wpucv_feat_read_more_weight',
					'label'        => esc_html__( 'Font weight', 'ultimate-content-views' ),
					'type'         => 'text',
				), $_wpucv_feat_read_more_weight );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_feat_read_more_type',
					'name'         => '_wpucv_feat_read_more_type',
					'label'        => esc_html__( 'Type', 'ultimate-content-views' ),
					'type'         => 'select',
					'options'      => array(
						'anchor'     => 'Anchor link',
						'button'     => 'Button',
					),
					'empty_option' => false,
				), $_wpucv_feat_read_more_type );
				?>
				</div>
				
				<div class="col-sm-6">
				<?php echo static::render_field( array(
					'id'             => '_wpucv_feat_show_read_more',
					'name'           => '_wpucv_feat_show_read_more',
					'label'          => esc_html__( 'Show Read More ', 'ultimate-content-views' ),
					'type'           => 'checkbox',
				), $_wpucv_feat_show_read_more );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_feat_read_more_color',
					'name'         => '_wpucv_feat_read_more_color',
					'label'        => esc_html__( 'Text color', 'ultimate-content-views' ),
					'type'         => 'color',
				), $_wpucv_feat_read_more_color );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_feat_read_more_h_c',
					'name'         => '_wpucv_feat_read_more_h_c',
					'label'        => esc_html__( 'Text hover color', 'ultimate-content-views' ),
					'type'         => 'color',
				), $_wpucv_feat_read_more_h_c );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_feat_read_more_bg_c',
					'name'         => '_wpucv_feat_read_more_bg_c',
					'label'        => esc_html__( 'Background color', 'ultimate-content-views' ),
					'type'         => 'color',
				), $_wpucv_feat_read_more_bg_c );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_feat_read_more_h_bgc',
					'name'         => '_wpucv_feat_read_more_h_bgc',
					'label'        => esc_html__( 'Background hover color', 'ultimate-content-views' ),
					'type'         => 'color',
				), $_wpucv_feat_read_more_h_bgc );
				?>
				</div>
			</div>
		</div>
	</div>
</div>