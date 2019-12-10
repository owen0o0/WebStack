<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
// 网址
$new_meta_sites_boxes =
array(
	"visible" => array(
		"name" => "_visible",
		"title" => "仅管理员可见",
		"type"=>"checkbox"),

	"sites_link" => array(
		"name" => "_sites_link",
		"std" => "",
		"title" => "输入网址链接，需包含 http(s)://",
		"type"=>"text"),

	"sites_sescribe" => array(
		"name" => "_sites_sescribe",
		"std" => "",
		"title" => "描叙",
		"type"=>"text"),

	"order" => array(
		"name" => "_sites_order",
		"std" => "0",
		"title" => "网址排序数值越大越靠前",
		"type"=>"text"),

	"thumbnail" => array(
		"name" => "_thumbnail",
		"std" => "",
		"title" => "添加图标地址，调用自定义图标",
		"size" => "",
        'button_text' => '添加图标',
		"type"=>"upload"),

	"wechat_qr" => array(
		"name" => "_wechat_qr",
		"std" => "",
		"title" => "添加公众号二维码",
		"size" => "",
        'button_text' => '添加二维码',
		"type"=>"upload"),
);

// 面板内容
function new_meta_sites_boxes() {
	global $post, $new_meta_sites_boxes;
	//获取保存
	foreach ($new_meta_sites_boxes as $meta_box) {
		$meta_box_value = get_post_meta($post->ID, $meta_box['name'] . '', true);
		if ($meta_box_value != "")
		//将默认值替换为已保存的值
		$meta_box['std'] = $meta_box_value;
		echo '<input type="hidden" name="' . $meta_box['name'] . '_noncename" id="' . $meta_box['name'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
		//选择类型输出不同的html代码
		switch ($meta_box['type']) {
			case 'title':
				echo '<h4>' . $meta_box['title'] . '</h4>';
			break;
			case 'text':
				echo '<h4>' . $meta_box['title'] . '</h4>';
				echo '<span class="form-field"><input type="text" size="40" name="' . $meta_box['name'] . '" value="' . $meta_box['std'] . '" /></span><br />';
			break;
			case 'textarea':
				echo '<h4>' . $meta_box['title'] . '</h4>';
				echo '<textarea id="seo-excerpt" cols="40" rows="2" name="' . $meta_box['name'] . '">' . $meta_box['std'] . '</textarea><br />';
			break;
			case 'radio':
				echo '<h4>' . $meta_box['title'] . '</h4>';
				$counter = 1;
				foreach ($meta_box['buttons'] as $radiobutton) {
					$checked = "";
					if (isset($meta_box['std']) && $meta_box['std'] == $counter) {
						$checked = 'checked = "checked"';
					}
					echo '<input ' . $checked . ' type="radio" class="kcheck" value="' . $counter . '" name="' . $meta_box['name'] . '_value"/>' . $radiobutton;
					$counter++;
				}
			break;
			case 'checkbox':
				if (isset($meta_box['std']) && $meta_box['std'] == 'true') $checked = 'checked = "checked"';
				else $checked = '';
				echo '<br /><label><input type="checkbox" name="' . $meta_box['name'] . '" value="true"  ' . $checked . ' />';
				echo '' . $meta_box['title'] . '</label><br /><br />';
			break;
			case 'upload':
				$button_text = (isset($meta_box['button_text'])) ? $meta_box['button_text'] : 'Upload';
				echo '<h4>' . $meta_box['title'] . '</h4>';
				echo '<input class="damiwp_url_input" style="width: 95%;margin-bottom: 10px;" type="text" id="'.$meta_box['name'].'_input" size="'.$meta_box['size'].'" value="'.$meta_box['std'].'" name="'.$meta_box['name'].'"/><br><a href="#" id="'.$meta_box['name'].'" class="dami_upload_button button">'.$button_text.'</a>';
				//add_script_and_styles();
			break;
			}
		}
}
function create_meta_sites_box() {
	global $theme_name;
	if (function_exists('add_meta_box')) {
		add_meta_box('new-meta-boxes', '网址链接属性', 'new_meta_sites_boxes', 'sites', 'normal', 'high');
	}
}
function save_sites_postdata($post_id) {
	global $post, $new_meta_sites_boxes;
	foreach ($new_meta_sites_boxes as $meta_box) {
		if (!wp_verify_nonce($_POST[$meta_box['name'] . '_noncename'], plugin_basename(__FILE__))) {
			return $post_id;
		}
		if ('page' == $_POST['post_type']) {
			if (!current_user_can('edit_page', $post_id)) return $post_id;
		} else {
			if (!current_user_can('edit_post', $post_id)) return $post_id;
		}
		$data = $_POST[$meta_box['name'] . ''];
		if (get_post_meta($post_id, $meta_box['name'] . '') == "") add_post_meta($post_id, $meta_box['name'] . '', $data, true);
		elseif ($data != get_post_meta($post_id, $meta_box['name'] . '', true)) update_post_meta($post_id, $meta_box['name'] . '', $data);
		elseif ($data == "") delete_post_meta($post_id, $meta_box['name'] . '', get_post_meta($post_id, $meta_box['name'] . '', true));
	}
}
add_action('admin_menu', 'create_meta_sites_box');
add_action('save_post', 'save_sites_postdata');

add_action( 'admin_footer', 'add_script_and_styles' );
function add_script_and_styles() {
	// 增加位置判断
	$current_screen = get_current_screen(); 
    if (!is_object($current_screen) || ($current_screen->id != 'sites') || ($current_screen->post_type != 'sites')) return;
	echo "<script>
	jQuery(document).ready(function(){
	var dami_upload_frame;
	var value_id;
	jQuery('.dami_upload_button').live('click',function(event){
	  value_id =jQuery( this ).attr('id');
	  event.preventDefault();
	  if( dami_upload_frame ){
		dami_upload_frame.open();
		return;
	  }
	  dami_upload_frame = wp.media({
		title: '上传图片',
		button: {
		  text: '确定',
		},
		multiple: false
	  });
	  dami_upload_frame.on('select',function(){
		attachment = dami_upload_frame.state().get('selection').first().toJSON();
		//jQuery('#'+value_id+'_input').val(attachment.url).trigger('change');
		jQuery('input[name='+value_id+']').val(attachment.url).trigger('change');});dami_upload_frame.open();});});
		</script>";
}