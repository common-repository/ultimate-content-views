
<div class="panel panel-default" id="exclusionOptionsPanel">
	<div class="panel-heading" role="tab" id="exclusionOptionsHeading">
		<h4 class="panel-title">
			<a role="button" data-toggle="collapse" href="#exclusionOptions" aria-expanded="true" aria-controls="exclusionOptions">
			<?php echo esc_html__( 'Exclusion', 'ultimate-content-views' ); ?>
			</a>
		</h4>
	</div>
	<div id="exclusionOptions" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="exclusionOptionsHeading">
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12">
				<?php foreach( $excluding_fields as $field ): ?>
				<?php echo static::render_field( $field, $exclude_fields_values[ $field['id'] ] ); ?>
				<?php endforeach; ?>
				
				<?php echo static::render_field( array(
					'id'                 => '_wpucv_exclude_authors',
					'name'               => '_wpucv_exclude_authors',
					'label'              => esc_html__( 'Exclude Authors', 'ultimate-content-views' ),
					'type'               => 'pro',
					'empty_option'       => false,
					'multiple'           => true,
					'select2'            => true,
					'size'               => 3,
					'show_option_all'    => false,
				), $_wpucv_exclude_authors );
				?>
				</div>
			</div>
		</div>
	</div>
</div>