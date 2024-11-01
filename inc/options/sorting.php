<div class="panel panel-default" id="sortingOptionsPanel">
	<div class="panel-heading" role="tab" id="sortingOptionsHeading">
		<h4 class="panel-title">
			<a role="button" data-toggle="collapse" href="#sortingOptions" aria-expanded="true" aria-controls="sortingOptions">
			<?php echo esc_html__(  'Special Sorting', 'ultimate-content-views' ); ?>
			</a>
		</h4>
	</div>
	<div id="sortingOptions" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="sortingOptionsHeading">
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12">
				<?php
					echo static::render_field( array(
						'id'           => '_wpucv_order_by',
						'name'         => '_wpucv_order_by',
						'label'        => esc_html__( 'Order by', 'ultimate-content-views' ),
						'type'         => 'select',
						'options'      => array(
							'ID'              => esc_html__( 'ID', 'ultimate-content-views' ),
							'title'           => esc_html__( 'Title', 'ultimate-content-views' ),
							'name'            => esc_html__( 'Slug', 'ultimate-content-views' ),
							'date_disabled'            => esc_html__( 'Date (Pro)', 'ultimate-content-views' ),
							'modified'        => esc_html__( 'Modification date', 'ultimate-content-views' ),
							'comment_count'   => esc_html__( 'Comments count', 'ultimate-content-views' ),
							'rand_disabled'          => esc_html__( 'Random (Pro)', 'ultimate-content-views' ),
						),
						'empty_option' => true,
					), $_wpucv_order_by );
					
					echo static::render_field( array(
						'id'           => '_wpucv_order_type',
						'name'         => '_wpucv_order_type',
						'label'        => esc_html__( 'Order type', 'ultimate-content-views' ),
						'type'         => 'select',
						'options'      => array(
							'DESC' => esc_html__( 'Descending', 'ultimate-content-views' ),
							'ASC'  => esc_html__( 'Ascending', 'ultimate-content-views' ),
						),
						'empty_option' => false,
					), $_wpucv_order_type );
				?>
				</div>
			</div>
		</div>
	</div>
</div>