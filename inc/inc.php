<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
/**
 * 注册菜单
 */
register_nav_menus( array(
	'nav_main' => __( '主菜单' , 'i_owen' ),
));


require_once get_theme_file_path() .'/inc/frame/cs-framework.php';
require_once get_theme_file_path() .'/inc/register.php';
require_once get_theme_file_path() .'/inc/post-type.php';
require_once get_theme_file_path() .'/inc/fav-content.php';
require_once get_theme_file_path() .'/inc/meta-boxes.php';

 
// 禁用版本修订
add_filter( 'wp_revisions_to_keep', 'disable_wp_revisions_to_keep', 10, 2 );
function disable_wp_revisions_to_keep( $num, $post ) {
	return 0;
}

// 禁用自动保存
add_action('admin_print_scripts', function($a){ wp_deregister_script('autosave');});

 

// 替换用户链接
add_filter( 'request', 'my_author' );
function my_author( $query_vars ) {
	if ( array_key_exists( 'author_name', $query_vars ) ) {
		global $wpdb;
		$author_id = $wpdb->get_var( $wpdb->prepare( "SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key='first_name' AND meta_value = %s", $query_vars['author_name'] ) );
		if ( $author_id ) {
			$query_vars['author'] = $author_id;
			unset( $query_vars['author_name'] );
		}
	}
	return $query_vars;
}
add_filter( 'author_link', 'my_author_link', 10, 3 );
function my_author_link( $link, $author_id, $author_nicename ) {
	$my_name = get_user_meta( $author_id, 'first_name', true );
	if ( $my_name ) {
		$link = str_replace( $author_nicename, $my_name, $link );
	}
	return $link;
}

// 屏蔽用户名称类
function remove_comment_body_author_class( $classes ) {
	foreach( $classes as $key => $class ) {
	if(strstr($class, "comment-author-")||strstr($class, "author-")) {
			unset( $classes[$key] );
		}
	}
	return $classes;
}




/**
 * 禁止WordPress自动生成缩略图
 */
function ztmao_remove_image_size($sizes) {
    unset( $sizes['small'] );
    unset( $sizes['medium'] );
    unset( $sizes['large'] );
    return $sizes;
}
add_filter('image_size_names_choose', 'ztmao_remove_image_size');

 
/**
 * 禁用 auto-embeds
 */
remove_filter( 'the_content', array( $GLOBALS['wp_embed'], 'autoembed' ), 8 );

/**
 * 禁止谷歌字体
 */
function remove_open_sans() {
    wp_deregister_style( 'open-sans' );
    wp_register_style( 'open-sans', false );
    wp_enqueue_style('open-sans','');
}
add_action( 'init', 'remove_open_sans' );

/**
 * 禁止代码标点符合转义
 */
remove_filter('the_content', 'wptexturize');

/**
 * 字体增加
 */
function custum_fontfamily($initArray){  
   $initArray['font_formats'] = "微软雅黑='微软雅黑';宋体='宋体';黑体='黑体';仿宋='仿宋';楷体='楷体';隶书='隶书';幼圆='幼圆';";  
   return $initArray;  
}  
add_filter('tiny_mce_before_init', 'custum_fontfamily');

/**
 * 去掉描述P标签
 */
function deletehtml($description) {
    $description = trim($description);
    $description = strip_tags($description,"");
    return ($description);
}
add_filter('category_description', 'deletehtml');


/**
 * 搜索结果排除所有页面
 */
function search_filter_page($query) {
    if ($query->is_search) {
        $query->set('post_type', 'post');
    }
    return $query;
}
add_filter('pre_get_posts','search_filter_page');

/**
 * 去除wordpress前台顶部工具条
 */
show_admin_bar(false);

/**
 * 移除顶部多余信息
 */
if( io_get_option('ioc_wp_head') ) :
    //remove_action( 'wp_head', 'wp_enqueue_scripts', 1 ); //Javascript的调用
    remove_action( 'wp_head', 'feed_links', 2 ); //移除feed
    remove_action( 'wp_head', 'feed_links_extra', 3 ); //移除feed
    remove_action( 'wp_head', 'rsd_link' ); //移除离线编辑器开放接口
    remove_action( 'wp_head', 'wlwmanifest_link' );  //移除离线编辑器开放接口
    remove_action( 'wp_head', 'index_rel_link' );//去除本页唯一链接信息
    remove_action('wp_head', 'parent_post_rel_link', 10, 0 );//清除前后文信息
    remove_action('wp_head', 'start_post_rel_link', 10, 0 );//清除前后文信息
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
    remove_action( 'wp_head', 'locale_stylesheet' );
    remove_action('publish_future_post','check_and_publish_future_post',10, 1 );
    remove_action( 'wp_head', 'noindex', 1 );
    //remove_action( 'wp_head', 'wp_print_styles', 8 );//载入css
    //remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
    remove_action( 'wp_head', 'wp_generator' ); //移除WordPress版本
    remove_action( 'wp_head', 'rel_canonical' );
    //remove_action( 'wp_footer', 'wp_print_footer_scripts' );
    remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
    remove_action( 'template_redirect', 'wp_shortlink_header', 11, 0 );
    //add_action('widgets_init', 'my_remove_recent_comments_style');
    //function my_remove_recent_comments_style() {
    //global $wp_widget_factory;
    //remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ,'recent_comments_style'));
    //}
    //禁止加载WP自带的jquery.js
    //if ( !is_admin() ) { // 后台不禁止
    //function my_init_method() {
    //wp_deregister_script( 'jquery' ); // 取消原有的 jquery 定义
    //}
    //add_action('init', 'my_init_method'); 
    //}
    //wp_deregister_script( 'l10n' );
endif;

//隐藏帮助选项卡
add_filter( 'contextual_help', 'wpse50723_remove_help', 999, 3 );  
function wpse50723_remove_help($old_help, $screen_id, $screen){  
    $screen->remove_help_tabs();  
    return $old_help;  
}

/**
 * 去除后台标题中的“—— WordPress”
 */
add_filter('admin_title', 'wpdx_custom_admin_title', 10, 2);
function wpdx_custom_admin_title($admin_title, $title){
    return $title.' &lsaquo; '.get_bloginfo('name');
}

/**
 * 禁用REST API、移除wp-json链接
 */
if( io_get_option('ioc_api') ) :
    add_filter('rest_enabled', '_return_false');
    add_filter('rest_jsonp_enabled', '_return_false');
    remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
endif;

/**
 * 禁用 emoji's
 */
function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
 }
 add_action( 'init', 'disable_emojis' );

/**
 * 用于删除tinymce插件的emoji
 */
 function disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
        return array();
    }
 }

 /**
  * 禁止头部加载s.w.org
  */
function remove_dns_prefetch( $hints, $relation_type ) {
    if ( 'dns-prefetch' === $relation_type ) {
        return array_diff( wp_dependencies_unique_hosts(), $hints );
    }
    return $hints;
}
add_filter( 'wp_resource_hints', 'remove_dns_prefetch', 10, 2 );

/**
 * WordPress 关闭 XML-RPC 的 pingback 端口
 */
if( io_get_option('ioc_pingback') ) :
    add_filter( 'xmlrpc_methods', 'remove_xmlrpc_pingback_ping' );
    function remove_xmlrpc_pingback_ping( $methods ) {
	    unset( $methods['pingback.ping'] );
	    return $methods;
    }
endif;

/**
 * 文章自动nofollow
 */
add_filter( 'the_content', 'ioc_seo_wl');
function ioc_seo_wl( $content ) {
    $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>";
    if(preg_match_all("/$regexp/siU", $content, $matches, PREG_SET_ORDER)) {
        if( !empty($matches) ) {
            $srcUrl = get_option('siteurl');
            for ($i=0; $i < count($matches); $i++)
            {
                $tag = $matches[$i][0];
                $tag2 = $matches[$i][0];
                $url = $matches[$i][0];
   
                $noFollow = '';
                $pattern = '/target\s*=\s*"\s*_blank\s*"/';
                preg_match($pattern, $tag2, $match, PREG_OFFSET_CAPTURE);
                if( count($match) < 1 ){
                    $noFollow .= ' target="_blank" ';
                }
                $pattern = '/rel\s*=\s*"\s*[n|d]ofollow\s*"/';
                preg_match($pattern, $tag2, $match, PREG_OFFSET_CAPTURE);
                if( count($match) < 1 ){
                    $noFollow .= ' rel="nofollow" ';
                }
                $pos = strpos($url,$srcUrl);
                if ($pos === false) {
                    $tag = rtrim ($tag,'>');
                    $tag .= $noFollow.'>';
                    $content = str_replace($tag2,$tag,$content);
                }
            }
        }
    }
    $content = str_replace(']]>', ']]>', $content);
    return $content;
}

/**
 * 禁止FEED
 */
if( io_get_option('ioc_feed') ) :
    function digwp_disable_feed() {
        wp_die(sprintf(__('<h1>Feed已经关闭, 请访问网站<a href="%s">首页</a>!</h1>' , 'i_owen'), get_bloginfo('url')));
    }
    add_action('do_feed', 'digwp_disable_feed', 1);
    add_action('do_feed_rdf', 'digwp_disable_feed', 1);
    add_action('do_feed_rss', 'digwp_disable_feed', 1);
    add_action('do_feed_rss2', 'digwp_disable_feed', 1);
    add_action('do_feed_atom', 'digwp_disable_feed', 1);
endif;
  
/**
 * 禁用：wp-embed.min.js
 */
function disable_embeds_init() {  
    /* @var WP $wp */  
    global $wp;  
    // Remove the embed query var.  
    $wp->public_query_vars = array_diff( $wp->public_query_vars, array(  
        'embed',  
    ) );  
    // Remove the REST API endpoint.  
    remove_action( 'rest_api_init', 'wp_oembed_register_route' );  
    // Turn off  
    add_filter( 'embed_oembed_discover', '__return_false' );  
    // Don't filter oEmbed results.  
    remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );  
    // Remove oEmbed discovery links.  
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );  
    // Remove oEmbed-specific JavaScript from the front-end and back-end.  
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );  
    add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );  
    // Remove all embeds rewrite rules.  
    add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );  
}  
add_action( 'init', 'disable_embeds_init', 9999 );  

/** 
 * 删除'wpembed'TinyMCE插件
 */  
function disable_embeds_tiny_mce_plugin( $plugins ) {  
    return array_diff( $plugins, array( 'wpembed' ) );  
}  
/** 
 * 删除与嵌入相关的所有重写规则。 
 */  
function disable_embeds_rewrites( $rules ) {  
    foreach ( $rules as $rule => $rewrite ) {  
        if ( false !== strpos( $rewrite, 'embed=true' ) ) {  
            unset( $rules[ $rule ] );  
        }  
    }  
    return $rules;  
}  
/** 
 * 移除插件激活时的嵌入重写规则。
 */  
function disable_embeds_remove_rewrite_rules() {  
    add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );  
    flush_rewrite_rules();  
}  
register_activation_hook( __FILE__, 'disable_embeds_remove_rewrite_rules' );  
/** 
 * 在插件停用时刷新重写规则。
 */  
function disable_embeds_flush_rewrite_rules() {  
    remove_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );  
    flush_rewrite_rules();  
}   
register_deactivation_hook( __FILE__, 'disable_embeds_flush_rewrite_rules' );  

/**
 * 定制CSS
 */
add_action('wp_head','modify_css');
function modify_css(){
	if (io_get_option("custom_css")) {
		$css = substr(io_get_option("custom_css"), 0);
		echo "<style>" . $css . "</style>";
	}
}

function remove_submenu() {   
    remove_submenu_page( 'themes.php', 'theme-editor.php' );   
}    
if ( is_admin() ) {   
    add_action('admin_init','remove_submenu');   
}  
add_action('generate_rewrite_rules', 'io_rewrite_rules' );   
/**********重写规则************/  
function io_rewrite_rules( $wp_rewrite ){   
    $new_rules = array(    
        'go/?$'          => 'index.php?custom_page=go',
    ); //添加翻译规则   
    $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;   
    //php数组相加   
}  
/*******添加query_var变量***************/  
add_action('query_vars', 'io_add_query_vars');   
function io_add_query_vars($public_query_vars){     
    $public_query_vars[] = 'custom_page'; //往数组中添加添加custom_page   
       
    return $public_query_vars;     
}  
//模板载入规则   
add_action("template_redirect", 'io_template_redirect');   
function io_template_redirect(){   
    global $wp;   
    global $wp_query, $wp_rewrite;   
       
    //查询custom_page变量   
    @$reditect_page =  $wp_query->query_vars['custom_page'];   
    //如果custom_page等于go，则载入go.php页面   
    //注意 my-account/被翻译成index.php?custom_page=hello_page了。    
    if($reditect_page=='go'){
        include(TEMPLATEPATH.'/go.php');   
        die(); 
    }
}
/**
 * 激活主题更新重写规则
 */
add_action( 'load-themes.php', 'io_flush_rewrite_rules' );   
function io_flush_rewrite_rules() {   
    global $pagenow, $wp_rewrite;   
    if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) )   
        $wp_rewrite->flush_rules();   
}  


// 自定义图标
class iconfont {
	function __construct(){
		add_filter( 'nav_menu_css_class', array( $this, 'nav_menu_css_class' ) );
		add_filter( 'walker_nav_menu_start_el', array( $this, 'walker_nav_menu_start_el' ), 10, 4 );
	}
	function nav_menu_css_class( $classes ){
		if( is_array( $classes ) ){
			$tmp_classes = preg_grep( '/^(fa)(-\S+)?$/i', $classes );
			if( !empty( $tmp_classes ) ){
				$classes = array_values( array_diff( $classes, $tmp_classes ) );
			}
		}
		return $classes;
	}

	protected function replace_item( $item_output, $classes ){
		if( !in_array( 'fa', $classes ) ){
			array_unshift( $classes, 'fa' );
		}
		$before = true;
        $icon = '
        <i class="' . implode( ' ', $classes ) . ' fa-fw"></i>';
		preg_match( '/(<a.+>)(.+)(<\/a>)/i', $item_output, $matches );
		if( 4 === count( $matches ) ){
			$item_output = $matches[1];
			if( $before ){
                $item_output .= $icon . '
                <span class="smooth">' . $matches[2] . '</span>
                <span class="label label-Primary pull-right hidden-collapsed">♥</span>';
			} else {
                $item_output .= '
                <span class="smooth">' . $matches[2] . '</span>
                ' . $icon;
			}
			$item_output .= $matches[3];
		}
		return $item_output;
	}

	function walker_nav_menu_start_el( $item_output, $item, $depth, $args ){
		if( is_array( $item->classes ) ){
			$classes = preg_grep( '/^(fa)(-\S+)?$/i', $item->classes );
			if( !empty( $classes ) ){
				$item_output = $this->replace_item( $item_output, $classes );
			}
		}
		return $item_output;
	}
}
new iconfont();

function include_post_types_in_search($query) {
	if(is_search()) {
		$post_types = get_post_types(array('public' => true, 'exclude_from_search' => false), 'objects');
		$searchable_types = array();
		if($post_types) {
			foreach( $post_types as $type) {
				$searchable_types[] = $type->name;
			}
		}
		$query->set('post_type', $searchable_types);
	}
	return $query;
}
add_action('pre_get_posts', 'include_post_types_in_search');

function format_url($url){
    $pattern = '@^(?:https?://)?([^/]+)@i';
    $result = preg_match($pattern, $url, $matches);
    return $matches[1];
}