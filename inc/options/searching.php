<div class="panel panel-default" id="searchingOptionsPanel">
	<div class="panel-heading" role="tab" id="searchingOptionsHeading">
		<h4 class="panel-title">
			<a role="button" data-toggle="collapse" href="#searchingOptions" aria-expanded="true" aria-controls="searchingOptions">
			<?php echo esc_html__(  'Query Options', 'ultimate-content-views' ); ?>
			</a>
		</h4>
	</div>
	<div id="searchingOptions" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="searchingOptionsHeading">
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12">
				<?php
					echo static::render_field( array(
						'id'             => '_wpucv_post_types',
						'name'           => '_wpucv_post_types',
						'label'          => esc_html__( 'Post Type(s)', 'ultimate-content-views' ),
						'type'           => 'select',
						'options'        => $post_types,
						'empty_option'   => false,
						'multiple'       => true,
						'select2'        => true,
						'attributes'     => array(
							'onchange' => 'wpucv_show_hide_children_fields([' . implode(',', $post_type_relations) . '], this)',
						),
					), $_wpucv_post_types );
				?>
				
				<?php foreach( $searching_fields as $field ): ?>
				<?php echo static::render_field( $field, $searching_fields_values[ $field['id'] ] ); ?>
				<?php endforeach; ?>
				
				<?php
					echo static::render_field( array(
						'id'                 => '_wpucv_authors',
						'name'               => '_wpucv_authors',
						'label'              => esc_html__( 'Authors', 'ultimate-content-views' ),
						'type'               => 'author',
						'empty_option'       => false,
						'multiple'           => true,
						'select2'            => true,
						'size'               => 3,
						'show_option_all'    => false,
					), $_wpucv_authors );
				?>
				
				<?php
					echo static::render_field( array(
						'id'                 => '_wpucv_date_from',
						'name'               => '_wpucv_date_from',
						'label'              => esc_html__( 'From Date', 'ultimate-content-views' ),
						'type'               => 'pro',
					), $_wpucv_date_from );
				?>
				
				<?php
					echo static::render_field( array(
						'id'                 => '_wpucv_date_to',
						'name'               => '_wpucv_date_to',
						'label'              => esc_html__( 'To Date', 'ultimate-content-views' ),
						'type'               => 'pro',
					), $_wpucv_date_to );
				?>
				
				<?php
					echo static::render_field( array(
						'id'             => '_wpucv_post_status',
						'name'           => '_wpucv_post_status',
						'label'          => esc_html__( 'Post Status(es)', 'ultimate-content-views' ),
						'type'           => 'select',
						'options'        => array(
							'publish'     => esc_html__( 'Publish', 'ultimate-content-views' ),
							'future'      => esc_html__( 'Future', 'ultimate-content-views' ),
							'draft'       => esc_html__( 'Draft', 'ultimate-content-views' ),
							'pending'     => esc_html__( 'Pending', 'ultimate-content-views' ),
							'private'     => esc_html__( 'Private', 'ultimate-content-views' ),
							'trash'       => esc_html__( 'Trash', 'ultimate-content-views' ),
							'auto-draft'  => esc_html__( 'Auto-Draft', 'ultimate-content-views' ),
						),
						'multiple'       => true,
						'select2'        => true,
						'label_note'     => esc_html__( 'For any, don\'t select any option', 'ultimate-content-views' ),
					), $_wpucv_post_status );
				?>
				
				<?php
					echo static::render_field( array(
						'id'             => '_wpucv_has_password',
						'name'           => '_wpucv_has_password',
						'label'          => esc_html__( 'List Protected Posts', 'ultimate-content-views' ),
						'type'           => 'select',
						'options'        => array(
							'null'         => esc_html__( 'With & Without Password', 'ultimate-content-views' ),
							'false'        => esc_html__( 'With Password', 'ultimate-content-views' ),
							'true'         => esc_html__( 'Without Password', 'ultimate-content-views' ),
						),
						'empty_option'   => false,
					), $_wpucv_has_password );
				?>
				</div>
				
				<div class="col-xs-12 col-sm-6">
				<?php
					echo static::render_field( array(
						'id'             => '_wpucv_comments_count_oprt',
						'name'           => '_wpucv_comments_count_oprt',
						'label'          => esc_html__( 'Comments Operator', 'ultimate-content-views' ),
						'type'           => 'select',
						'options'        => array(
							'='        => esc_html__( 'Equal', 'ultimate-content-views' ),
							'!='       => esc_html__( ' Not Equal', 'ultimate-content-views' ),
							'>'        => esc_html__( 'Greater than', 'ultimate-content-views' ),
							'>='       => esc_html__( 'Greater than or equal', 'ultimate-content-views' ),
							'<'        => esc_html__( 'Less', 'ultimate-content-views' ),
							'<='       => esc_html__( 'Less than or equal', 'ultimate-content-views' ),
						),
						'empty_option' => false,
					), $_wpucv_comments_count_oprt );
				?>
				</div>
				
				<div class="col-xs-12 col-sm-6">
				<?php
					echo static::render_field( array(
						'id'                 => '_wpucv_comments_count',
						'name'               => '_wpucv_comments_count',
						'label'              => esc_html__( 'Comments Count', 'ultimate-content-views' ),
						'type'               => 'number',
					), $_wpucv_comments_count );
				?>
				</div>
				
				<div class="col-xs-12 col-sm-7 p-t-10">
				<?php
					echo static::render_field( array(
						'id'             => '_wpucv_ignore_sticky_posts',
						'name'           => '_wpucv_ignore_sticky_posts',
						'label'          => esc_html__( 'Ignore Sticky Posts', 'ultimate-content-views' ),
						'type'           => 'checkbox',
					), $_wpucv_ignore_sticky_posts );
				?>
				</div>
			</div>
		</div>
	</div>
	
</div>
