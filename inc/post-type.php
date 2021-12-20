<?php
/*
 * @Theme Name:WebStack
 * @Theme URI:https://www.iotheme.cn/
 * @Author: iowen
 * @Author URI: https://www.iowen.cn/
 * @Date: 2020-02-22 21:26:05
 * @LastEditors: iowen
 * @LastEditTime: 2021-12-20 23:53:13
 * @FilePath: \WebStack\inc\post-type.php
 * @Description: 
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }


// 网址
add_action( 'init', 'post_type_sites' );
function post_type_sites() {
	$labels = array(
		'name'               => '网址', 'post type general name', 'your-plugin-textdomain',
		'singular_name'      => '网址', 'post type singular name', 'your-plugin-textdomain',
		'menu_name'          => '网址', 'admin menu', 'your-plugin-textdomain',
		'name_admin_bar'     => '网址', 'add new on admin bar', 'your-plugin-textdomain',
		'add_new'            => '添加网址', 'sites', 'your-plugin-textdomain',
		'add_new_item'       => '添加新网址', 'your-plugin-textdomain',
		'new_item'           => '新网址', 'your-plugin-textdomain',
		'edit_item'          => '编辑网址', 'your-plugin-textdomain',
		'view_item'          => '查看网址', 'your-plugin-textdomain',
		'all_items'          => '所有网址', 'your-plugin-textdomain',
		'search_items'       => '搜索网址', 'your-plugin-textdomain',
		'parent_item_colon'  => 'Parent 网址:', 'your-plugin-textdomain',
		'not_found'          => '你还没有发布网址。', 'your-plugin-textdomain',
		'not_found_in_trash' => '回收站中没有网址。', 'your-plugin-textdomain'
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'sites' ),
		'capability_type'    => 'post',
		'menu_icon'          => 'dashicons-admin-site',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 10,
		'supports'           => array( 'title',  'author', 'editor', 'comments', 'custom-fields' )//'editor','excerpt',
	);

	register_post_type( 'sites', $args );
}


// 网址分类
add_action( 'init', 'create_sites_taxonomies', 0 );
function create_sites_taxonomies() {
	$labels = array(
		'name'              => '网址分类目录', 'taxonomy general name',
		'singular_name'     => '网址分类', 'taxonomy singular name',
		'search_items'      => '搜索网址目录',
		'all_items'         => '所有网址目录',
		'parent_item'       => '父级分类目录',
		'parent_item_colon' => '父级分类目录:',
		'edit_item'         => '编辑网址目录',
		'update_item'       => '更新网址目录',
		'add_new_item'      => '添加新网址目录',
		'new_item_name'     => 'New Genre Name',
		'menu_name'         => '网址分类',
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'favorites' ),
	);

	register_taxonomy( 'favorites', array( 'sites' ), $args );
}


// 公告
add_action( 'init', 'post_type_bulletin' );
function post_type_bulletin() {
	$labels = array(
		'name'               => '公告', 'post type general name', 'your-plugin-textdomain',
		'singular_name'      => '公告', 'post type singular name', 'your-plugin-textdomain',
		'menu_name'          => '公告', 'admin menu', 'your-plugin-textdomain',
		'name_admin_bar'     => '公告', 'add new on admin bar', 'your-plugin-textdomain',
		'add_new'            => '发布公告', 'bulletin', 'your-plugin-textdomain',
		'add_new_item'       => '发布新公告', 'your-plugin-textdomain',
		'new_item'           => '新公告', 'your-plugin-textdomain',
		'edit_item'          => '编辑公告', 'your-plugin-textdomain',
		'view_item'          => '查看公告', 'your-plugin-textdomain',
		'all_items'          => '所有公告', 'your-plugin-textdomain',
		'search_items'       => '搜索公告', 'your-plugin-textdomain',
		'parent_item_colon'  => 'Parent 公告:', 'your-plugin-textdomain',
		'not_found'          => '你还没有发布公告。', 'your-plugin-textdomain',
		'not_found_in_trash' => '回收站中没有公告。', 'your-plugin-textdomain'
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'bulletin' ),
		'capability_type'    => 'post',
		'menu_icon'          => 'dashicons-controls-volumeon',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 10,
		'show_in_rest'       => true,
		'supports'           => array( 'title', 'editor', 'author', 'comments', 'custom-fields' )
	);

	register_post_type( 'bulletin', $args );
}

/**
 * 保存排序
 *
 * @param int $term_id
 */
//add_action( 'edited_favorites', 'save_term_order' );
//add_action('created_favorites','save_term_order',10,1);
add_action('edit_favorites','save_term_order',10,1);
function save_term_order( $term_id ) {
	//if (isset($_POST['_term_order'])) {
   		//update_term_meta( $term_id, '_term_order', $_POST[ '_term_order' ] );
	//}
	$ca_menu_id = esc_attr($_POST['ca_ordinal']);
	if ($ca_menu_id)
		update_term_meta( $term_id, '_term_order', $ca_menu_id);
}


/**
 * 设置 sites 这种自定义文章类型的固定链接结构为 ID.html 
 * https://www.wpdaxue.com/custom-post-type-permalink-code.html
 */
add_filter('post_type_link', 'custom_sites_link', 1, 3);
function custom_sites_link( $link, $post = 0 ){
    if ( $post->post_type == 'sites' ){
        return home_url( 'sites/' . $post->ID .'.html' );
    } else {
        return $link;
    }
}
add_action( 'init', 'custom_sites_rewrites_init' );
function custom_sites_rewrites_init(){
    add_rewrite_rule(
        'sites/([0-9]+)?.html$',
        'index.php?post_type=sites&p=$matches[1]',
		'top' 
	);
    add_rewrite_rule(
        'sites/([0-9]+)?.html/comment-page-([0-9]{1,})$',
        'index.php?post_type=sites&p=$matches[1]&cpage=$matches[2]',
        'top'
    );
}


//此部分功能是生成分类下拉菜单
add_action('restrict_manage_posts','io_post_type_filter',10,2);
function io_post_type_filter($post_type, $which){
    if('sites' !== $post_type){ //这里为自定义文章类型，需修改
      return; //检查是否是我们需要的文章类型
    }
    $taxonomy_slug     = 'favorites'; //这里为自定义分类法，需修改
    $taxonomy          = get_taxonomy($taxonomy_slug);
    $selected          = '';
    $request_attr      = 'favorites'; //这里为自定义分类法，需修改
    if ( isset($_REQUEST[$request_attr] ) ) {
      $selected = $_REQUEST[$request_attr];
    }
    wp_dropdown_categories(array(
      'show_option_all' =>  __("所有{$taxonomy->label}"),
      'taxonomy'        =>  $taxonomy_slug,
      'name'            =>  $request_attr,
      'orderby'         =>  'name',
      'selected'        =>  $selected,
      'hierarchical'    =>  true,
      'depth'           =>  5,
      'show_count'      =>  true, // Show number of post in parent term
      'hide_empty'      =>  false, // Don't show posts w/o terms
    ));
}
//此部分功能是列出指定分类下的所有文章
add_filter('parse_query','io_work_convert_restrict'); 
function io_work_convert_restrict($query) {  
    global $pagenow;  
    global $typenow;  
    if ($pagenow=='edit.php') {  
        $filters = get_object_taxonomies($typenow);  
        foreach ($filters as $tax_slug) {  
            $var = &$query->query_vars[$tax_slug];  
            if ( isset($var) && $var>0) {  
                $term = get_term_by('id',$var,$tax_slug);  
                $var = $term->slug;  
            }  
        }  
    }  
    return $query;  
} 

/**
 * 文章列表添加自定义字段
 * https://www.iowen.cn/wordpress-quick-edit
 */
add_filter('manage_edit-sites_columns', 'io_ordinal_manage_posts_columns');
add_action('manage_posts_custom_column','io_ordinal_manage_posts_custom_column',10,2);
function io_ordinal_manage_posts_columns($columns){
    $columns['link']       = '链接';
	$columns['ordinal']    = '排序'; 
	$columns['visible']    = '可见性'; 
	return $columns;
}
function io_ordinal_manage_posts_custom_column($column_name,$id){ 
	switch( $column_name ) :
		case 'link': {
			echo get_post_meta($id, '_sites_link', true);
			break;
		}
		case 'ordinal': {
			echo get_post_meta($id, '_sites_order', true);
			break;
		}
		case 'visible': {
			echo get_post_meta($id, '_visible', true)? "管理员" : "所有人";
			break;
		}
	endswitch;
}

//分类列表添加自定义字段
add_filter('manage_edit-favorites_columns', 'io_id_manage_tags_columns');
add_action('manage_favorites_custom_column','io_id_manage_tags_custom_column',10,3);
function io_id_manage_tags_columns($columns){
	$columns['ca_ordinal']    = '菜单排序'; 
	$columns['id']    = 'ID'; 
    return $columns;
}
function io_id_manage_tags_custom_column($null,$column_name,$id){
    if ($column_name == 'ca_ordinal') {
        echo get_term_meta($id, '_term_order', true);
    }
    if ($column_name == 'id') {
        echo $id;
    }
}

/**
 * 文章列表添加自定义字段
 * 
 */
add_action( 'admin_head', 'io_custom_css' );
function io_custom_css(){
	echo '<style>
		#ordinal{
			width:80px;
		} 
	</style>';
}

//文章列表添加排序规则
add_filter('manage_edit-sites_sortable_columns', 'sort_sites_order_column');
//add_filter('manage_edit-favorites_sortable_columns', 'sort_favorites_order_column');
add_action('pre_get_posts', 'sort_sites_order');
function sort_sites_order_column($defaults)
{
    $defaults['ordinal'] = 'ordinal';
    return $defaults;
}
function sort_favorites_order_column($defaults)
{
    $defaults['ca_ordinal'] = 'ca_ordinal';
    return $defaults;
}
function sort_sites_order($query) {
    if(!is_admin())
		return;
    $orderby = $query->get('orderby');
    if('ordinal' == $orderby) {
        $query->set('meta_key', '_sites_order');
        $query->set('orderby', 'meta_value_num');
    }
    if('ca_ordinal' == $orderby) {
        $query->set('meta_key', '_term_order');
        $query->set('orderby', 'meta_value_num');
    }
}


add_action('quick_edit_custom_box',  'io_add_quick_edit', 10, 2);
function io_add_quick_edit($column_name, $post_type) {
	if ($column_name == 'ordinal') {
		//请注意：<fieldset>类可以是：
		//inline-edit-col-left，inline-edit-col-center，inline-edit-col-right
		//所有列均为float：left，
		//因此，如果要在左列，请使用clear：both元素
		echo '
		<fieldset class="inline-edit-col-left" style="clear: both;">
			<div class="inline-edit-col"> 
				<label class="alignleft">
					<span class="title">排序</span>
					<span class="input-text-wrap"><input type="number" name="ordinal" class="ptitle" value=""></span>
				</label> 
				<em class="alignleft inline-edit-or"> 越大越靠前</em>
			</div>
		</fieldset>';
	}
	if ($column_name == 'ca_ordinal') {  
	  	echo '
	  	<fieldset>
		  	<div class="inline-edit-col"> 
			  	<label class="alignleft">
				  	<span class="title">排序</span>
				  	<span class="input-text-wrap"><input type="number" name="ca_ordinal" class="ptitle" value=""></span>
			  	</label> 
			  	<em class="alignleft inline-edit-or"> 越大越靠前</em>
		  	</div>
	  	</fieldset>';
	}
}


//保存和更新数据
add_action('save_post', 'io_save_quick_edit_data');
function io_save_quick_edit_data($post_id) {
    //如果是自动保存日志，并非我们所提交数据，那就不处理
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;
    // 验证权限，'sites' 为文章类型，默认为 'post' ,这里为我自定义的文章类型'sites'
    if (isset($_POST['post_type']) && 'sites' ==  $_POST['post_type'] ) {
        if ( !current_user_can( 'edit_page', $post_id ) )
            return $post_id;
    } 
	$post = get_post($post_id); 
	// 'ordinal' 与前方代码对应
    if (isset($_POST['ordinal']) && ($post->post_type != 'revision')) {
        $left_menu_id = esc_attr($_POST['ordinal']);
        if ($left_menu_id)
			update_post_meta( $post_id, '_sites_order', $left_menu_id);// ‘_sites_order’为自定义字段
    } 
}

//输出js
add_action('admin_footer', 'ashuwp_quick_edit_javascript');
function ashuwp_quick_edit_javascript() {
	$current_screen = get_current_screen(); 
    if (!is_object($current_screen) || ($current_screen->post_type != 'sites'))return;
	if($current_screen->id == 'edit-sites'){
 	echo"
    <script type='text/javascript'>
    jQuery(function($){
		var wp_inline_edit_function = inlineEditPost.edit;
		inlineEditPost.edit = function( post_id ) {
			wp_inline_edit_function.apply( this, arguments );
			var id = 0;
			if ( typeof( post_id ) == 'object' ) {
				id = parseInt( this.getId( post_id ) );
			}
			if ( id > 0 ) {
				var specific_post_edit_row = $( '#edit-' + id ),
						specific_post_row = $( '#post-' + id ),
						product_price = $( '.column-ordinal', specific_post_row ).text(); 

				$('input[name=\"ordinal\"]', specific_post_edit_row ).val( product_price ); 
			}
		}
	});
    </script>";
	} 
	if($current_screen->id == 'edit-favorites'){
 	echo"
    <script type='text/javascript'>
    jQuery(function($){
		var wp_inline_edit_function = inlineEditTax.edit;
		inlineEditTax.edit = function( post_id ) {
			wp_inline_edit_function.apply( this, arguments );
			var id = 0;
			if ( typeof( post_id ) == 'object' ) {
				id = parseInt( this.getId( post_id ) );
			}
		console.log('调试区'+id);
			if ( id > 0 ) {
				var specific_post_edit_row = $( '#edit-' + id ),
						specific_post_row = $( '#tag-' + id ),
						product_price = $( '.column-ca_ordinal', specific_post_row ).text(); 

				$('input[name=\"ca_ordinal\"]', specific_post_edit_row ).val( product_price ); 
			}
		}
	});
    </script>";
	} 
}

