"use strict";
function wpucv_ini(){
	"use strict";
	if(jQuery('[name="_wpucv_template"]').length > 0){
		"use strict";
		wpucv_template_changed(jQuery('[name="_wpucv_template"]:checked').val());
		jQuery('[name="_wpucv_template"]').parent('li').on("click",function(){
			
			"use strict";
			var val = jQuery(this).find('input[type="radio"]').val();
			if(val != 'template03' && val != 'template04')
			{
				wpucv_template_changed(val);
				wpucv_change_pagination_options(val);		
			}
			
		});
	}
	
	if(jQuery('#wpucv_preview_modal_close').length > 0){
		jQuery('#wpucv_preview_modal_close').on('click', function(){
			"use strict";
			wpucv_hide_modal();
		});
	}
	
	if(jQuery('#wpucv_mobile_screen').length > 0){
		jQuery('#wpucv_mobile_screen').on('click', function(){
			"use strict";
			jQuery('#wpucv_preview_modal_body iframe').css('max-width', '375px');
		});
		
		jQuery('#wpucv_tablet_screen').on('click', function(){
			"use strict";
			jQuery('#wpucv_preview_modal_body iframe').css('max-width', '768px');
		});
		
		jQuery('#wpucv_labtop_screen').on('click', function(){
			"use strict";
			jQuery('#wpucv_preview_modal_body iframe').css('max-width', '1199px');
		});
		
		jQuery('#wpucv_desktop_screen').on('click', function(){
			"use strict";
			jQuery('#wpucv_preview_modal_body iframe').css('max-width', '1439px');
		});
	}
	
	if(jQuery('#wpucv_for_dummy_preview').length > 0){
		jQuery('#wpucv_for_dummy_preview').on('click', function(){
			"use strict";
			jQuery('#iframe_real_preview').addClass('hidden');
			jQuery('#iframe_dummy_preview').removeClass('hidden');
		});
		
		jQuery('#wpucv_for_real_preview').on('click', function(){
			"use strict";
			jQuery('#iframe_dummy_preview').addClass('hidden');
			jQuery('#iframe_real_preview').removeClass('hidden');
		});
	}
	
	if(jQuery('#wpucv_preview_modal').length > 0){
		jQuery(document).keyup(function(evnt){
			"use strict";
			var key = evnt.which || evnt.keyCode;
			
			if(27 == key && !jQuery('#wpucv_preview_modal').hasClass('hidden')){
				jQuery('#wpucv_preview_modal_close').trigger('click');
			}
		});
	}
}
//-------------------------------------
function wpucv_is_empty(value){
	"use strict";
	if(typeof value == 'undefined' || value == null || value == '' || value == '0' || value == 0){
		return true;
	}
	else if(value instanceof Array && value.length == 0){
		return true;
	}
	else if(value instanceof Object){
		
		if(value.length == 0){
			return true;
		}
		for(var i in value){
			return false;
		}
		return true;
	}
	return false;
}
//-------------------------------------
function wpucv_select_media(callback, params){
	"use strict";
	var frame;
	if(frame){
		frame.open();
		return;
	}
	frame = wp.media();
	frame.on("select", function(){
		"use strict";
		var attachment = frame.state().get("selection").first();
		var url = attachment.attributes.url;
		
		window[callback](url, params);
		frame.close();
	});
	frame.open();
}
//-------------------------------------
function wpucv_set_selected_image(url, parms){
	"use strict";
	var img = '<img src="' + url + '" width="100%" height="100%" />';
	jQuery('#' + parms[1]).html(img);
	jQuery.ajax({
		url: wpucv_admin_url,
		method: 'POST',
		dataType: 'json',
		data: {
			action: 'wpucv_img_id_from_url',
			url: url,
		},
		success: function(data){
			"use strict";
			if(data.id){
				jQuery('#' + parms[0]).val(data.id);
			}
		}
	});
}
//-------------------------------------
function wpucv_remove_image(field, container){
	"use strict";
	jQuery('#' + field).val('');
	jQuery('#' + container).html('');
}
//-------------------------------------
function wpucv_show_hide_children_fields(children, parent){
	"use strict";
	parent = jQuery(parent);
	var value = null;
	if(parent.prop('tagName') == 'INPUT' && parent.attr("type") == 'checkbox'){
		value = (parent.prop('checked'))? 1 : 0;
	} else {
		if(parent.hasClass('select2')){
			value = wpucv_get_select2_data(parent.select2('data'));
		} else {
			value = parent.val();
		}
	}
	
	for(var i = 0; i < children.length; i++){
		if((value instanceof Array && value.includes(children[i].value)) || (!(value instanceof Array) && children[i].value == value)){
			var disabled = false;
			var display = 'block';
		} else{
			var disabled = true;
			var display = 'none';
		}
		
		var name = children[i].name;
		name += (children[i].multiple)? '[]' : '';
		var element = jQuery("[name='" + name + "']");
		if(element.prop('tagName') != 'LABEL'){
			if(element.hasClass('select2')){
				element.select2({
					disabled: disabled
				});
			} else{
				element.prop('disabled', disabled)
			}
		}
		
		jQuery('#' + children[i].id + '_wrapper').css('display', display);
	}
}
//-------------------------------------
function wpucv_delete_repeatable_row(btn, name, key){
	"use strict";
	name = (typeof name != 'undefined')? name : null;
	key = (typeof key != 'undefined')? key : null;
	if(!wpucv_is_empty(name) && key != ''){
		var field = '<input type="hidden" name="' + name + '_deleted[]" value="' + key + '" >';
		jQuery('#deleted_' + name).append(field);
	}
	jQuery(btn).parent('td').parent('tr').remove();
}
//-------------------------------------
function wpucv_add_repeatable_row(name){
	"use strict";
	var key = (new Date()).getTime();
	var template = jQuery('#template_' + name).text();
	template = template.replace(/\%\%KEY\%\%/g, key);
	jQuery('#table_' + name + ' tbody').append(template);
}
//-------------------------------------
function wpucv_image_select_changed(elm){
	
	
	if(jQuery(elm).find('> input[type="radio"]').prop('id') == '_wpucv_template_2' || jQuery(elm).find('> input[type="radio"]').prop('id') == '_wpucv_template_3')
	{
		alert('Please upgrade to Pro version to unlock this template');
	}else{
		
	"use strict";
	jQuery(elm).siblings().removeClass('wpucv-selected');
	jQuery(elm).addClass('wpucv-selected');
	jQuery(elm).find('> input[type="radio"]').prop('checked', true);
	jQuery(elm).find('> input[type="radio"]').trigger('change');
	}
}
//-------------------------------------
function wpucv_template_changed(temp){
	"use strict";
	var options_fields = [{
			name: "label_structure_2",
			type: "label",
			multiple: false
		},{
			name: "_wpucv_feat_show_author",
			type: "checkbox",
			multiple: false
		},{
			name: "_wpucv_feat_show_date",
			type: "checkbox",
			multiple: false
		},{
			name: "_wpucv_feat_title_size",
			type: "number",
			multiple: false
		},{
			name: "_wpucv_feat_title_lineheight",
			type: "text",
			multiple: false
		},{
			name: "_wpucv_feat_title_weight",
			type: "text",
			multiple: false
		},{
			name: "_wpucv_feat_title_color",
			type: "color",
			multiple: false
		},{
			name: "_wpucv_feat_title_h_color",
			type: "color",
			multiple: false
		},{
			name: "_wpucv_feat_meta_size",
			type: "number",
			multiple: false
		},{
			name: "_wpucv_feat_meta_lineheight",
			type: "text",
			multiple: false
		},{
			name: "_wpucv_feat_meta_weight",
			type: "text",
			multiple: false
		},{
			name: "_wpucv_feat_meta_color",
			type: "color",
			multiple: false
		},{
			name: "_wpucv_feat_show_excerpt",
			type: "checkbox",
			multiple: false
		},{
			name: "_wpucv_feat_show_read_more",
			type: "checkbox",
			multiple: false
		},{
			name: "_wpucv_feat_excerpt_length",
			type: "number",
			multiple: false
		},{
			name: "_wpucv_feat_excerpt_size",
			type: "number",
			multiple: false
		},{
			name: "_wpucv_feat_excerpt_lineheight",
			type: "text",
			multiple: false
		},{
			name: "_wpucv_feat_excerpt_weight",
			type: "text",
			multiple: false
		},{
			name: "_wpucv_feat_excerpt_color",
			type: "color",
			multiple: false
		},{
			name: "label_structure_3",
			type: "label",
			multiple: false
		},{
			name: "_wpucv_feat_read_more_text",
			type: "text",
			multiple: false
		},{
			name: "_wpucv_feat_read_more_type",
			type: "select",
			multiple: false
		},{
			name: "_wpucv_feat_read_more_color",
			type: "color",
			multiple: false
		},{
			name: "_wpucv_feat_read_more_h_c",
			type: "color",
			multiple: false
		},{
			name: "_wpucv_feat_read_more_bg_c",
			type: "color",
			multiple: false
		},{
			name: "_wpucv_feat_read_more_h_bgc",
			type: "color",
			multiple: false
		},{
			name: "_wpucv_feat_read_more_size",
			type: "number",
			multiple: false
		},{
			name: "_wpucv_feat_read_more_lineheight",
			type: "text",
			multiple: false
		},{
			name: "_wpucv_feat_read_more_weight",
			type: "text",
			multiple: false
		},{
			name: "_wpucv_show_author",
			type: "checkbox",
			multiple: false
		},{
			name: "_wpucv_show_date",
			type: "checkbox",
			multiple: false
		},{
			name: "_wpucv_show_excerpt",
			type: "checkbox",
			multiple: false
		},{
			name: "_wpucv_excerpt_length",
			type: "number",
			multiple: false
		},{
			name: "_wpucv_title_size",
			type: "number",
			multiple: false
		},{
			name: "_wpucv_title_lineheight",
			type: "text",
			multiple: false
		},{
			name: "_wpucv_title_weight",
			type: "text",
			multiple: false
		},{
			name: "_wpucv_title_color",
			type: "color",
			multiple: false
		},{
			name: "_wpucv_title_h_color",
			type: "color",
			multiple: false
		},{
			name: "_wpucv_meta_size",
			type: "number",
			multiple: false
		},{
			name: "_wpucv_meta_lineheight",
			type: "text",
			multiple: false
		},{
			name: "_wpucv_meta_weight",
			type: "text",
			multiple: false
		},{
			name: "_wpucv_meta_color",
			type: "color",
			multiple: false
		},{
			name: "_wpucv_excerpt_size",
			type: "number",
			multiple: false
		},{
			name: "_wpucv_excerpt_lineheight",
			type: "text",
			multiple: false
		},{
			name: "_wpucv_excerpt_weight",
			type: "text",
			multiple: false
		},{
			name: "_wpucv_excerpt_color",
			type: "color",
			multiple: false
		},{
			name: "_wpucv_show_read_more",
			type: "checkbox",
			multiple: false
		},{
			name: "label_structure_1",
			type: "label",
			multiple: false
		},{
			name: "_wpucv_read_more_text",
			type: "text",
			multiple: false
		},{
			name: "_wpucv_read_more_type",
			type: "select",
			multiple: false
		},{
			name: "_wpucv_read_more_color",
			type: "color",
			multiple: false
		},{
			name: "_wpucv_read_more_h_color",
			type: "color",
			multiple: false
		},{
			name: "_wpucv_read_more_bg_color",
			type: "color",
			multiple: false
		},{
			name: "_wpucv_read_more_h_bg_color",
			type: "color",
			multiple: false
		},{
			name: "_wpucv_read_more_size",
			type: "number",
			multiple: false
		},{
			name: "_wpucv_read_more_lineheight",
			type: "text",
			multiple: false
		},{
			name: "_wpucv_read_more_weight",
			type: "text",
			multiple: false
		},{
			name: "_wpucv_carousel_dots",
			type: "checkbox",
			multiple: false
		},{
			name: "_wpucv_carousel_dots_color",
			type: "color",
			multiple: false
		},{
			name: "_wpucv_carousel_dots_h_color",
			type: "color",
			multiple: false
		},{
			name: "_wpucv_carousel_text_align",
			type: "select",
			multiple: false
		},{
			name: "_wpucv_bottom_border",
			type: "checkbox",
			multiple: false
		},{
			name: "_wpucv_bottom_border_color",
			type: "color",
			multiple: false
		},{
			name: "_wpucv_thumbnail_shape",
			type: "select",
			multiple: false
		},{
			name: "_wpucv_posts_per_page",
			type: "number",
			multiple: false
		},{
			name: "_wpucv_next_text",
			type: "text",
			multiple: false
		},{
			name: "_wpucv_previous_text",
			type: "text",
			multiple: false
		},{
			name: "_wpucv_first_text",
			type: "text",
			multiple: false
		},{
			name: "_wpucv_last_text",
			type: "text",
			multiple: false
		},{
			name: "_wpucv_pagination_type",
			type: "select",
			multiple: false
		},{
			name: "_wpucv_next_previous_type",
			type: "select",
			multiple: false
		},{
			name: "_wpucv_show_next_previous",
			type: "text",
			multiple: false
		},{
			name: "_wpucv_pagination_c",
			type: "color",
			multiple: false
		},{
			name: "_wpucv_pagination_h_c",
			type: "color",
			multiple: false
		},{
			name: "_wpucv_grid_columns_num",
			type: "select",
			multiple: false
		},{
			name: "_wpucv_grid_columns_spacing",
			type: "number",
			multiple: false
		},{
			name: "_wpucv_grid_rows_spacing",
			type: "number",
			multiple: false
		},{
			name: "_wpucv_gallary_row_items",
			type: "select",
			multiple: false
		},{
			name: "_wpucv_gallary_item_spacing",
			type: "number",
			multiple: false
	}];
	
	switch(temp){
		case 'template01':
		var enabled = ['_wpucv_show_author', '_wpucv_show_date', '_wpucv_show_excerpt', '_wpucv_excerpt_length', '_wpucv_title_size', '_wpucv_title_lineheight',
						'_wpucv_title_weight', '_wpucv_title_color', '_wpucv_title_h_color', '_wpucv_meta_size', '_wpucv_meta_lineheight', '_wpucv_meta_weight',
						'_wpucv_meta_color', '_wpucv_excerpt_size', '_wpucv_excerpt_lineheight', '_wpucv_excerpt_weight', '_wpucv_excerpt_color',
						'_wpucv_show_read_more', 'label_structure_1', '_wpucv_read_more_text', '_wpucv_read_more_type', '_wpucv_read_more_color',
						'_wpucv_read_more_h_color', '_wpucv_read_more_bg_color', '_wpucv_read_more_h_bg_color', '_wpucv_read_more_size',
						'_wpucv_read_more_lineheight', '_wpucv_read_more_weight', '_wpucv_posts_per_page', '_wpucv_next_text', '_wpucv_previous_text',
						'_wpucv_first_text', '_wpucv_last_text', '_wpucv_pagination_type', '_wpucv_next_previous_type', '_wpucv_show_next_previous',
						'_wpucv_pagination_c', '_wpucv_pagination_h_c'];
		break;
		
		case 'template02':
		var enabled = ['_wpucv_show_author', '_wpucv_show_date', '_wpucv_show_excerpt', '_wpucv_excerpt_length', '_wpucv_title_size', '_wpucv_title_lineheight',
						'_wpucv_title_weight', '_wpucv_title_color', '_wpucv_title_h_color', '_wpucv_meta_size', '_wpucv_meta_lineheight', '_wpucv_meta_weight',
						'_wpucv_meta_color', '_wpucv_excerpt_size', '_wpucv_excerpt_lineheight', '_wpucv_excerpt_weight', '_wpucv_excerpt_color',
						'_wpucv_show_read_more', 'label_structure_1', '_wpucv_read_more_text', '_wpucv_read_more_type', '_wpucv_read_more_color',
						'_wpucv_read_more_h_color', '_wpucv_read_more_bg_color', '_wpucv_read_more_h_bg_color', '_wpucv_read_more_size',
						'_wpucv_read_more_lineheight', '_wpucv_read_more_weight', '_wpucv_posts_per_page', '_wpucv_next_text', '_wpucv_previous_text',
						'_wpucv_first_text', '_wpucv_last_text', '_wpucv_pagination_type', '_wpucv_next_previous_type', '_wpucv_show_next_previous',
						'_wpucv_pagination_c', '_wpucv_pagination_h_c', '_wpucv_grid_columns_num', '_wpucv_grid_columns_spacing', '_wpucv_grid_rows_spacing'];
		break;
		
		case 'template03':
		var enabled = ['label_structure_2', '_wpucv_feat_show_author', '_wpucv_feat_show_date', '_wpucv_feat_title_size', '_wpucv_feat_title_lineheight',
						'_wpucv_feat_title_weight', '_wpucv_feat_title_color', '_wpucv_feat_meta_size', '_wpucv_feat_meta_lineheight', '_wpucv_feat_meta_weight',
						'_wpucv_feat_meta_color', '_wpucv_feat_show_excerpt', '_wpucv_feat_show_read_more', '_wpucv_feat_excerpt_length',
						'_wpucv_feat_excerpt_size', '_wpucv_feat_excerpt_lineheight', '_wpucv_feat_excerpt_weight', '_wpucv_feat_excerpt_color', 'label_structure_3',
						'_wpucv_feat_read_more_text', '_wpucv_feat_read_more_type', '_wpucv_feat_read_more_color', '_wpucv_feat_read_more_h_c',
						'_wpucv_feat_read_more_bg_c', '_wpucv_feat_read_more_h_bgc', '_wpucv_feat_read_more_size', '_wpucv_feat_read_more_lineheight',
						'_wpucv_feat_read_more_weight', '_wpucv_show_author', '_wpucv_show_date', '_wpucv_title_size', '_wpucv_title_lineheight',
						'_wpucv_title_weight', '_wpucv_title_color', '_wpucv_title_h_color', '_wpucv_meta_size', '_wpucv_meta_lineheight', '_wpucv_meta_weight',
						'_wpucv_meta_color', '_wpucv_feat_title_h_color', '_wpucv_posts_per_page', '_wpucv_next_text', '_wpucv_previous_text', '_wpucv_first_text',
						'_wpucv_last_text', '_wpucv_pagination_type', '_wpucv_next_previous_type', '_wpucv_show_next_previous', '_wpucv_pagination_c',
						'_wpucv_pagination_h_c'];
		break;
		
		case 'template04':
		var enabled = ['label_structure_2', '_wpucv_feat_show_author', '_wpucv_feat_show_date', '_wpucv_feat_title_size', '_wpucv_feat_title_lineheight',
						'_wpucv_feat_title_weight', '_wpucv_feat_title_color', '_wpucv_feat_meta_size', '_wpucv_feat_meta_lineheight', '_wpucv_feat_meta_weight',
						'_wpucv_feat_meta_color', '_wpucv_feat_show_excerpt', '_wpucv_feat_show_read_more', '_wpucv_feat_excerpt_length',
						'_wpucv_feat_excerpt_size', '_wpucv_feat_excerpt_lineheight', '_wpucv_feat_excerpt_weight', '_wpucv_feat_excerpt_color',
						'label_structure_3', '_wpucv_feat_read_more_text', '_wpucv_feat_read_more_type', '_wpucv_feat_read_more_color', '_wpucv_feat_read_more_h_c',
						'_wpucv_feat_read_more_bg_c', '_wpucv_feat_read_more_h_bgc', '_wpucv_feat_read_more_size', '_wpucv_feat_read_more_lineheight',
						'_wpucv_feat_read_more_weight', '_wpucv_show_author', '_wpucv_show_date', '_wpucv_title_size', '_wpucv_title_lineheight',
						'_wpucv_title_weight', '_wpucv_title_color', '_wpucv_title_h_color', '_wpucv_meta_size', '_wpucv_meta_lineheight', '_wpucv_meta_weight',
						'_wpucv_meta_color', '_wpucv_feat_title_h_color', '_wpucv_posts_per_page', '_wpucv_next_text', '_wpucv_previous_text', '_wpucv_first_text',
						'_wpucv_last_text', '_wpucv_pagination_type', '_wpucv_next_previous_type', '_wpucv_show_next_previous', '_wpucv_pagination_c',
						'_wpucv_pagination_h_c'];
		break;
		
		case 'template05':
		var enabled = ['_wpucv_posts_per_page', '_wpucv_next_text', '_wpucv_previous_text', '_wpucv_first_text', '_wpucv_last_text', '_wpucv_pagination_type',
						'_wpucv_next_previous_type', '_wpucv_show_next_previous', '_wpucv_pagination_c', '_wpucv_pagination_h_c',
						'_wpucv_gallary_row_items', '_wpucv_gallary_item_spacing'];
		break;
		
		case 'template06':
		var enabled = ['_wpucv_show_author', '_wpucv_show_date', '_wpucv_title_size', '_wpucv_title_lineheight', '_wpucv_title_weight', '_wpucv_title_color',
						'_wpucv_title_h_color', '_wpucv_meta_size', '_wpucv_meta_lineheight', '_wpucv_meta_weight', '_wpucv_meta_color', '_wpucv_show_read_more',
						'label_structure_1', '_wpucv_read_more_text', '_wpucv_read_more_type', '_wpucv_read_more_color', '_wpucv_read_more_h_color',
						'_wpucv_read_more_bg_color', '_wpucv_read_more_h_bg_color', '_wpucv_read_more_size', '_wpucv_read_more_lineheight',
						'_wpucv_read_more_weight', '_wpucv_carousel_dots', '_wpucv_carousel_dots_color', '_wpucv_carousel_dots_h_color', 
						'_wpucv_thumbnail_shape', '_wpucv_carousel_text_align'];
		break;
		
		case 'template07':
		var enabled = ['_wpucv_show_author', '_wpucv_show_date', '_wpucv_title_size', '_wpucv_title_lineheight', '_wpucv_title_weight', '_wpucv_title_color',
						'_wpucv_title_h_color', '_wpucv_meta_color', '_wpucv_meta_size', '_wpucv_meta_lineheight', '_wpucv_meta_weight', '_wpucv_bottom_border',
						'_wpucv_bottom_border_color', '_wpucv_posts_per_page', '_wpucv_next_text', '_wpucv_previous_text', '_wpucv_first_text', '_wpucv_last_text',
						'_wpucv_pagination_type', '_wpucv_next_previous_type', '_wpucv_show_next_previous', '_wpucv_pagination_c', '_wpucv_pagination_h_c'];
		break;
	}
	
	for(var i = 0; i < options_fields.length; i++){
		if(jQuery.inArray(options_fields[i].name, enabled) >= 0){
			var disabled = false;
			var display = 'block';
		} else{
			var disabled = true;
			var display = 'none';
		}
		
		var name = options_fields[i].name.replace(/\[|\]/g, "\\$1");
		var nameProp = (options_fields[i].multiple)? name + '\[\]' : name;
		jQuery('#' + name + '_wrapper').css('display', display);
	}
}
//-------------------------------------
function copyToClipboard(elmId){
	"use strict";
	var elm = document.getElementById(elmId);
	elm.select();
	document.execCommand('copy');
}
//-------------------------------------
function wpucv_get_select2_data(data){
	"use strict";
	var arr = [];
	for(var i = 0; i < data.length; i++){
		arr[arr.length] = data[i].id;
	}
	
	return arr;
}
//-------------------------------------
function wpucv_list_edit_page(){
	"use strict";
	jQuery.ajax({
		url: wpucv_admin_url,
		method: 'POST',
		dataType: 'html',
		data: {
			action: 'wpucv_list_edit_page',
			post_id: jQuery('#wpucv_post_id').val(),
			new_post: jQuery('#wpucv_new_post').val()
		},
		success: function(data){
			"use strict";
			jQuery('#poststuff').html(data);
			wpucv_ini();
		},
		error: function(){
			
		}
	});
}

function wpucv_loading_spiner(){
	jQuery('#loading_spiner').toggleClass('hidden');
}
jQuery("#save_content_data").on("click", function(){
  jQuery('#loading_spiner').removeClass('hidden');
});
jQuery( "#post" ).submit(function( event ) {
  jQuery('#loading_spiner').removeClass('hidden');
  return true;
});
//-------------------------------------
function wpucv_reset_list_options(){
	"use strict";
	if(window.confirm('Are you sure?')){
		wpucv_loading_spiner();
		wpucv_list_edit_page();
	}
}
//-------------------------------------
function wpucv_loading_spiner(){
	"use strict";
	jQuery('#loading_spiner').toggleClass('hidden');
}
//-------------------------------------
function wpucv_preview(){
	"use strict";
	var form = jQuery('#post');
	var data = form.serialize();
	data += '&action=wpucv_prepare_for_preview';
	
	wpucv_loading_spiner();
	
	jQuery.ajax({
		url: wpucv_admin_url,
		method: 'POST',
		dataType: 'html',
		data: data,
		success: function(data){
			"use strict";
			wpucv_preview_list(data);
		},
		error: function(){
			
		}
	});
}
//-------------------------------------
function wpucv_preview_list(preview_id){
	"use strict";
	jQuery('#wpucv_preview_modal .wpucv-modal').css('height', '100%');
	var src = wpucv_home_url + '?wpucv_preview=true&wpucv_preview_id=' + preview_id + '&t=' + (new Date()).getTime();
	jQuery('#iframe_dummy_preview').attr('src', src);
	src += '&real=true';
	jQuery('#iframe_real_preview').attr('src', src);
	
	setTimeout(function(){
		"use strict";
		wpucv_loading_spiner();
		wpucv_show_modal();
	}, 1000);
	
	setTimeout(function(){
		"use strict";
		jQuery.ajax({
			url: wpucv_admin_url,
			method: 'POST',
			dataType: 'html',
			data: {
				action: 'wpucv_destroy_preview_session',
				preview_id: preview_id
			},
			success: function(data){
			},
			error: function(){
			}
		});
	}, 10000);
}
//-------------------------------------
function wpucv_show_modal(){
	"use strict";
	jQuery('#wpucv_modal_overly').removeClass('hidden');
	jQuery('#wpucv_preview_modal').removeClass('hidden');
	setTimeout(function(){
		"use strict";
		jQuery('#wpucv_preview_modal').addClass('wpucv-showen');
	}, 500);
}
//-------------------------------------
function wpucv_hide_modal(){
	jQuery('#wpucv_preview_modal').removeClass('wpucv-showen');
	setTimeout(function(){
		"use strict";
		jQuery('#wpucv_modal_overly').addClass('hidden');
		jQuery('#wpucv_preview_modal').addClass('hidden');
	}, 1000);
}
//-------------------------------------
function wpucv_change_pagination_options(template){
	var posts, page;
	
	switch(template){
		case 'template01':
		posts = 18;
		page = 6;
		break;
		
		case 'template02':
		posts = 27;
		page = 9;
		break;
		
		case 'template03':
		posts = 21;
		page = 7;
		break;
		
		case 'template04':
		posts = 18;
		page = 6;
		break;
		
		case 'template05':
		posts = 63;
		page = 21;
		break;
		
		case 'template06':
		posts = 9;
		page = 3;
		break;
		
		case 'template07':
		posts = 18;
		page = 6;
		break;
	}
	
	jQuery('#_wpucv_posts_number').val(posts);
	jQuery('#_wpucv_posts_per_page').val(page);
}
//-------------------------------------

