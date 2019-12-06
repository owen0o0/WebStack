<?php
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
		'rewrite'            => array( 'slug' => 'site' ),
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

/**
 * 分类项目排序字段
 *
 * @param        Term Object $term
 * @param string $taxonomy
 */
add_action('favorites_add_form_fields','io_add_fav_field');
function io_add_fav_field(){
	echo '
	<table class="form-table">
		<tbody>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="_term_order">'.__('排序','i_owen').'</label></th>
				<td>
				<input name="_term_order" id="_term_order" type="text" value="0" size="30">
				<p class="description">'.__( '数字越大越靠前' ).'</p>
				</td>
			</tr>
		</tbody>
	</table>
	<h2 style="color: red;">'.__('注意，最多2级，且父级不应有内容','i_owen').'</h2>';
}

add_action( 'favorites_edit_form_fields', 'term_order_field', 10, 2 );
function term_order_field( $term, $taxonomy ) {
   ?>

   <table class="form-table">
      <tbody>
      <tr class="form-field">
         <th scope="row" valign="top">
            <label for="meta-order"><?php _e( '排序' ); ?></label>
         </th>
         <td>
            <input type="text" name="_term_order" size="3" style="width:10%;" value="<?= get_term_meta( $term->term_id, '_term_order', true ); ?>"/>
			<p class="description"><?php _e( '数字越大越靠前' ); ?></p>
         </td>
      </tr>
      </tbody>
   </table>
   <h2 style="color: red;"><?php _e('注意，最多2级，且父级不应有内容','i_owen'); ?></h2>
   <?php
}

/**
 * 保存排序
 *
 * @param int $term_id
 */
//add_action( 'edited_favorites', 'save_term_order' );
add_action('created_favorites','save_term_order',10,1);
add_action('edit_favorites','save_term_order',10,1);
function save_term_order( $term_id ) {
   update_term_meta( $term_id, '_term_order', $_POST[ '_term_order' ] );
}


/**
 * 设置 sites 这种自定义文章类型的固定链接结构为 ID.html 
 * https://www.wpdaxue.com/custom-post-type-permalink-code.html
 */
add_filter('post_type_link', 'custom_sites_link', 1, 3);
function custom_sites_link( $link, $post = 0 ){
    if ( $post->post_type == 'site' ){
        return home_url( 'site/' . $post->ID .'.html' );
    } else {
        return $link;
    }
}
add_action( 'init', 'custom_sites_rewrites_init' );
function custom_sites_rewrites_init(){
    add_rewrite_rule(
        'site/([0-9]+)?.html$',
        'index.php?post_type=site&p=$matches[1]',
        'top' );
    add_rewrite_rule(
        'site/([0-9]+)?.html/comment-page-([0-9]{1,})$',
        'index.php?post_type=site&p=$matches[1]&cpage=$matches[2]',
        'top'
        );
}