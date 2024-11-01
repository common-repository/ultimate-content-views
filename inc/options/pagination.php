
<div class="panel panel-default" id="paginationOptionsPanel">
	<div class="panel-heading" role="tab" id="paginationOptionsHeading">
		<h4 class="panel-title">
			<a role="button" data-toggle="collapse" href="#paginationOptions" aria-expanded="true" aria-controls="paginationOptions">
			<?php echo esc_html__(  'Pagination', 'ultimate-content-views' ); ?>
			</a>
		</h4>
	</div>
	<div id="paginationOptions" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="paginationOptionsHeading">
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12">
				<?php echo static::render_field( array(
					'id'       => '_wpucv_pagination_note1',
					'name'     => '_wpucv_pagination_note1',
					'type'     => 'note',
					'label'    => esc_html__( 'Note that "Sticky posts" will be added to every page, set "Ignore Sticky Posts" to true for preventing that.', 'ultimate-content-views' ),
				), NULL );
				?>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-6">
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_posts_number',
					'name'         => '_wpucv_posts_number',
					'label'        => esc_html__( 'Number of posts', 'ultimate-content-views' ),
					'type'         => 'number',
				), $_wpucv_posts_number );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_posts_per_page',
					'name'         => '_wpucv_posts_per_page',
					'label'        => esc_html__( 'Number of posts per page', 'ultimate-content-views' ),
					'type'         => 'text',
				), $_wpucv_posts_per_page );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_next_text',
					'name'         => '_wpucv_next_text',
					'label'        => esc_html__( 'Next text', 'ultimate-content-views' ),
					'type'         => 'text',
				), $_wpucv_next_text );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_previous_text',
					'name'         => '_wpucv_previous_text',
					'label'        => esc_html__( 'Previous text', 'ultimate-content-views' ),
					'type'         => 'text',
				), $_wpucv_previous_text );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_first_text',
					'name'         => '_wpucv_first_text',
					'label'        => esc_html__( 'First text', 'ultimate-content-views' ),
					'type'         => 'text',
				), $_wpucv_first_text );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_last_text',
					'name'         => '_wpucv_last_text',
					'label'        => esc_html__( 'Last text', 'ultimate-content-views' ),
					'type'         => 'text',
				), $_wpucv_last_text );
				?>
				</div>
				
				<div class="col-sm-6">
				<?php echo static::render_field( array(
					'id'             => '_wpucv_pagination_type',
					'name'           => '_wpucv_pagination_type',
					'label'          => esc_html__( 'Pagination Type', 'ultimate-content-views' ),
					'type'           => 'select',
					'options'        => array(
						'plain'  => esc_html__( 'Plain text', 'ultimate-content-views' ),
						'square' => esc_html__( 'Square', 'ultimate-content-views' ),
						'circle' => esc_html__( 'Circle', 'ultimate-content-views' ),
					),
				), $_wpucv_pagination_type );
				?>
				
				<?php echo static::render_field( array(
					'id'             => '_wpucv_next_previous_type',
					'name'           => '_wpucv_next_previous_type',
					'label'          => esc_html__( 'Next/Previous Type', 'ultimate-content-views' ),
					'type'           => 'select',
					'options'        => array(
						'text'   => esc_html__( 'Text', 'ultimate-content-views' ),
						'icon'   => esc_html__( 'Icon', 'ultimate-content-views' ),
					),
				), $_wpucv_next_previous_type );
				?>
				
				<?php echo static::render_field( array(
					'id'             => '_wpucv_show_pagination',
					'name'           => '_wpucv_show_pagination',
					'label'          => esc_html__( 'Show Pagination', 'ultimate-content-views' ),
					'type'           => 'checkbox',
				), $_wpucv_show_pagination );
				?>
				
				<?php echo static::render_field( array(
					'id'             => '_wpucv_show_next_previous',
					'name'           => '_wpucv_show_next_previous',
					'label'          => esc_html__( 'Show Next/Prev ', 'ultimate-content-views' ),
					'type'           => 'checkbox',
				), $_wpucv_show_next_previous );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_pagination_c',
					'name'         => '_wpucv_pagination_c',
					'label'        => esc_html__( 'Text color', 'ultimate-content-views' ),
					'type'         => 'color',
				), $_wpucv_pagination_c );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_pagination_h_c',
					'name'         => '_wpucv_pagination_h_c',
					'label'        => esc_html__( 'Text hover color', 'ultimate-content-views' ),
					'type'         => 'color',
				), $_wpucv_pagination_h_c );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_pagination_bg_c',
					'name'         => '_wpucv_pagination_bg_c',
					'label'        => esc_html__( 'Background color', 'ultimate-content-views' ),
					'type'         => 'color',
				), $_wpucv_pagination_bg_c );
				?>
				
				<?php echo static::render_field( array(
					'id'           => '_wpucv_pagination_bg_h_c',
					'name'         => '_wpucv_pagination_bg_h_c',
					'label'        => esc_html__( 'Background hover color', 'ultimate-content-views' ),
					'type'         => 'color',
				), $_wpucv_pagination_bg_h_c );
				?>
				</div>
			</div>
		</div>
	</div>
</div>