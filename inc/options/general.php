<div class="panel panel-default" id="generalOptionsPanel">
	<div class="panel-heading" role="tab" id="generalOptionsHeading">
		<h4 class="panel-title">
			<a role="button" data-toggle="collapse" href="#generalOptions" aria-expanded="true" aria-controls="generalOptions">
			<?php echo esc_html__( 'General Options', 'ultimate-content-views' ); ?>
			</a>
		</h4>
	</div>
	<div id="generalOptions" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="generalOptionsHeading">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-6">
				<?php
					echo static::render_field( array(
						'id'             => '_wpucv_list_name',
						'name'           => '_wpucv_list_name',
						'label'          => esc_html__( 'Title', 'ultimate-content-views' ),
						'type'           => 'text',
					), $_wpucv_list_name );
					
					echo static::render_field( array(
						'id'             => '_wpucv_slug',
						'name'           => '_wpucv_slug',
						'label'          => esc_html__( 'Name', 'ultimate-content-views' ),
						'type'           => 'hidden',
						'attributes'     => array('readonly' => 'readonly'),
					), $_wpucv_slug );
					
					echo static::render_field( array(
						'id'             => '_wpucv_notfound_text',
						'name'           => '_wpucv_notfound_text',
						'label'          => esc_html__( 'Text for not found', 'ultimate-content-views' ),
						'type'           => 'text',
					), $_wpucv_notfound_text );
				?>
					<br /><br />
					<div class="row">
						<div class="col-xs-12">
						<?php
							echo static::render_field( array(
								'type'  => 'label',
								'name'  => 'label_general_1',
								'id'    => 'label_general_1',
								'label' => esc_html__( 'List Title', 'ultimate-content-views' ),
								'underlined_label' => true,
							) );
						?>
						</div>
						
						<div class="col-md-6 p-t-15">
						<?php
							echo static::render_field( array(
								'id'             => '_wpucv_show_list_title',
								'name'           => '_wpucv_show_list_title',
								'label'          => esc_html__( 'Show list title', 'ultimate-content-views' ),
								'type'           => 'checkbox',
								'attributes'     => array(
									'onchange' => 'wpucv_show_hide_children_fields([
										{name: \'_wpucv_list_title_tag\', id: \'_wpucv_list_title_tag\', value: true, multiple: true},
										{name: \'_wpucv_list_title_color\', id: \'_wpucv_list_title_color\', value: true, multiple: true}
									], this)',
								),
							), $_wpucv_show_list_title );
						?>
						</div>
						
						<?php $wrapper_attributes = ($_wpucv_show_list_title)? array() : array('style' => 'display: none;'); ?>
						<?php $attributes = ($_wpucv_show_list_title)? array() : array('disabled' => 'disabled'); ?>
						<div class="col-md-6">
						<?php
							echo static::render_field( array(
								'id'             => '_wpucv_list_title_tag',
								'name'           => '_wpucv_list_title_tag',
								'label'          => esc_html__( 'Used title tag', 'ultimate-content-views' ),
								'type'           => 'select',
								'options'        => array(
									'h2'              => 'h2',
									'h3'              => 'h3',
									'h4'              => 'h4',
									'h5'              => 'h5',
									'h6'              => 'h6',
								),
								'empty_option'   => false,
								'attributes'     => $attributes,
								'wrapper_attributes' => $wrapper_attributes,
							), $_wpucv_list_title_tag );
						?>
						</div>
						
						<div class="col-md-6">
						<?php
							echo static::render_field( array(
								'id'           => '_wpucv_list_title_color',
								'name'         => '_wpucv_list_title_color',
								'label'        => esc_html__( 'Title color', 'ultimate-content-views' ),
								'type'         => 'color',
								'attributes'     => $attributes,
								'wrapper_attributes' => $wrapper_attributes,
							), $_wpucv_list_title_color );
						?>
						</div>
					</div>
					<br /><br />
				</div>
				
				<div class="col-md-6">
					<div class="row">
					    <?php if (!empty($_wpucv_shortcode))
					    {
					    ?>
						<div class="col-md-6">
							<div class="field-wrapper" id="_wpucv_shortcode_wrapper">
								<label class="control-label"><?php echo esc_html__(  'Shortcode', 'ultimate-content-views' ); ?></label>
								<div class="clearfix text-button-wrapper">
									<input type="text" name="_wpucv_shortcode" id="_wpucv_shortcode" value="<?php echo esc_attr($_wpucv_shortcode); ?>" class="form-control"  readonly="readonly" />
									<button type="button" class="btn" onclick="copyToClipboard('_wpucv_shortcode')"><?php echo esc_html__(  'Copy', 'ultimate-content-views' ); ?></button>
									
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="field-wrapper" id="_wpucv_funct_call_wrapper">
								<label class="control-label"><?php echo esc_html__(  'Function Call', 'ultimate-content-views' ); ?></label>
								<div class="clearfix text-button-wrapper">
									<input type="text" name="_wpucv_funct_call" id="_wpucv_funct_call" value="<?php echo esc_attr($_wpucv_funct_call); ?>" class="form-control" readonly="readonly" />
									<button type="button" class="btn" onclick="copyToClipboard('_wpucv_funct_call')"><?php echo esc_html__(  'Copy', 'ultimate-content-views' ); ?></button>
								</div>
							</div>
						</div>
						<?php }?>
						<div class="col-md-6">
							<div class="field-wrapper" id="_wpucv_funct_call_wrapper">
								
								<div class="clearfix text-button-wrapper">
									<input type="hidden" name="_wpucv_funct_call" id="_wpucv_funct_call" value="<?php echo esc_attr($_wpucv_funct_call); ?>" class="form-control" readonly="readonly" />
									
								</div>
							</div>
						</div>
					</div>
					<br /><br />
				<?php
					echo static::render_field( array(
						'id'               => '_wpucv_template',
						'name'             => '_wpucv_template',
						'label'            => esc_html__( 'Choose a Template', 'ultimate-content-views' ),
						'type'             => 'image_select',
						'options'          => array(
							'template01'       => plugins_url( 'images/templates/temp01.png', WPUCV_MAIN_FILE ),
							'template02'       => plugins_url( 'images/templates/temp02.png', WPUCV_MAIN_FILE ),
							'template03'       => plugins_url( 'images/templates/temp03.png', WPUCV_MAIN_FILE ),
							'template04'       => plugins_url( 'images/templates/temp04.png', WPUCV_MAIN_FILE ),
							'template05'       => plugins_url( 'images/templates/temp05.png', WPUCV_MAIN_FILE ),
							'template06'       => plugins_url( 'images/templates/temp06.png', WPUCV_MAIN_FILE ),
							'template07'       => plugins_url( 'images/templates/temp07.png', WPUCV_MAIN_FILE ),
						),
						'underlined_label' => true,
					), $_wpucv_template );
				?>
				</div>
			</div>
		</div>
	</div>
</div>