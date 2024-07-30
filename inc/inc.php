<?php
/*
 * @Theme Name:WebStack
 * @Theme URI:https://www.iotheme.cn/
 * @Author: iowen
 * @Author URI: https://www.iowen.cn/
 * @Date: 2019-02-22 21:26:02
 * @LastEditors: iowen
 * @LastEditTime: 2024-07-30 22:06:04
 * @FilePath: /WebStack/inc/inc.php
 * @Description: 
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
/**
 * 注册菜单
 */
register_nav_menus( array(
	'nav_main' => '侧栏底部菜单',
));


//激活友情链接模块
add_filter( 'pre_option_link_manager_enabled', '__return_true' );

require_once get_theme_file_path() .'/inc/frame/cs-framework.php';
require_once get_theme_file_path() .'/inc/register.php';
require_once get_theme_file_path() .'/inc/post-type.php';
require_once get_theme_file_path() .'/inc/fav-content.php';
require_once get_theme_file_path() .'/inc/ajax.php';


add_action('after_setup_theme', 'my_theme_setup');
function my_theme_setup(){
    load_theme_textdomain( 'i_theme', get_template_directory() . '/languages' );
}

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
//add_filter('pre_get_posts','search_filter_page');

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
add_action('in_admin_header', function(){
        global $current_screen;
        $current_screen->remove_help_tabs();
});
add_filter('admin_footer_text', 'left_admin_footer_text');
function left_admin_footer_text($text) {
    $text = '<span id="footer-thankyou">感谢您使用 <a href="https://www.iotheme.cn/" target="_blank">一为的 WordPress 主题</a></span>';
    return $text;
}

function io_head_favicon(){
    if (io_get_option('favicon','')) {
        echo "<link rel='shortcut icon' href='" . io_get_option('favicon','') . "'>";
    } else {
        echo "<link rel='shortcut icon' href='" . home_url('/favicon.ico') . "'>";
    }
    if (io_get_option('apple_icon','')) {
        echo "<link rel='apple-touch-icon' href='" . io_get_option('apple_icon','') . "'>";
    }
}
add_action('admin_head', 'io_head_favicon');


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
        wp_die('<h1>' . sprintf(__('Feed已经关闭, 请访问网站%s首页%s！', 'i_theme'), '<a href="' . get_bloginfo('url') . '">', '</a>') . '</h1>');
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
function modify_head_js(){
	if (io_get_option("code_head_js",'')) {
		$js = io_get_option("code_head_js");
		echo $js;
	}
}
add_action('wp_head','modify_head_js');

if ( is_admin() ) {   
    add_action('admin_init','remove_submenu');  
    function remove_submenu() {   
        remove_submenu_page( 'themes.php', 'theme-editor.php' ); 
    }  
}  
add_action( 'current_screen', 'block_theme_editor_access' );
function block_theme_editor_access() {
    if ( is_admin() ) {
        $screen = get_current_screen();
        if ( 'theme-editor' == $screen->id ) {
            wp_redirect( admin_url() );
            exit;
        }
    }
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
    if( !isset($wp_query->query_vars['custom_page']) )   
        return;  
    $reditect_page =  $wp_query->query_vars['custom_page'];   
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
 
 
add_filter('pre_get_avatar_data', function($args, $id_or_email){
    $gravatar_cdn = io_get_option('gravatar','geekzu');
    if($gravatar_cdn=='gravatar'){
        return $args;
    }
    $email_hash = '';
    $user       = $email = false;
    
    if(is_object($id_or_email) && isset($id_or_email->comment_ID)){
        $id_or_email    = get_comment($id_or_email);
    }

    if(is_numeric($id_or_email)){
        $user    = get_user_by('id', absint($id_or_email));
    }elseif($id_or_email instanceof WP_User){    // User Object
        $user    = $id_or_email;
    }elseif($id_or_email instanceof WP_Post){    // Post Object
        $user    = get_user_by('id', intval($id_or_email->post_author));
    }elseif($id_or_email instanceof WP_Comment){    // Comment Object
        if(!empty($id_or_email->user_id)){
            $user    = get_user_by('id', intval($id_or_email->user_id));
        }elseif(!empty($id_or_email->comment_author_email)){
            $email    = $id_or_email->comment_author_email;
        }
    }elseif(is_string($id_or_email)){
        if(strpos($id_or_email, '@md5.gravatar.com')){
            list($email_hash)    = explode('@', $id_or_email);
        } else {
            $email    = $id_or_email;
        }
    }

    if($user){
        $args    = apply_filters('io_default_avatar_data', $args, $user->ID);
        if($args['found_avatar']){
            return $args;
        }else{
            $email = $user->user_email;
        }
    }
    
    if(!$email_hash){
        if($email){
            $email_hash = md5(strtolower(trim($email)));
        }
    }

    if($email_hash){
        $args['found_avatar']    = true;
    }
    
    switch ($gravatar_cdn){
        case "cravatar":
            $url    = '//cravatar.cn/avatar/'.$email_hash;
            break;
        case "sep":
            $url    = '//cdn.sep.cc/avatar/'.$email_hash;
            break;
        case "loli":
            $url    = '//gravatar.loli.net/avatar/'.$email_hash;
            break;
        case "chinayes":
            $url    = '//gravatar.wp-china-yes.net/avatar/'.$email_hash;
            break;
        case "geekzu":
            $url    = '//sdn.geekzu.org/avatar/'.$email_hash;
            break;
        default:
            $url    = '//sdn.geekzu.org/avatar/'.$email_hash;
    }

    $url_args    = array_filter([
        's'    => $args['size'],
        'd'    => $args['default'],
        'f'    => $args['force_default'] ? 'y' : false,
        'r'    => $args['rating'],
    ]);

    $url            = add_query_arg(rawurlencode_deep($url_args), set_url_scheme($url, $args['scheme']));
    $args['url']    = apply_filters('get_avatar_url', $url, $id_or_email, $args);

    return $args;

}, 10, 2);
function format_url($url){
    if($url == '')
    return;
    if(io_get_option('url_format')){
        $pattern = '@^(?:https?://)?([^/]+)@i';
        $result = preg_match($pattern, $url, $matches);
        return $matches[1];
    }
    else{
        return $url;
    }
}

# 搜索只查询文章和网址。
# --------------------------------------------------------------------
add_filter('pre_get_posts','searchfilter');
function searchfilter($query) {
    //限定对搜索查询和非后台查询设置
    if ($query->is_search && !is_admin() ) {
        $query->set('post_type',array('sites','post'));
    }
    return $query;
}

/**
 * 修改搜索查询的sql代码，将postmeta表左链接进去。
 */
add_filter('posts_join', 'cf_search_join' );
function cf_search_join( $join ) {
    //if(is_admin())
    //    return $join;
    global $wpdb;
    if ( is_search() ) {
      $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }
    return $join;
}

/**
 * 在wordpress查询代码中加入自定义字段值的查询。
 */
add_filter('posts_where', 'cf_search_where');
function cf_search_where( $where ) {
    //if(is_admin())
    //    return $where; 
    global $pagenow, $wpdb;
    if ( is_search() ) {
        $where = preg_replace("/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
        "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
    }
    return $where;
}

/**
 * 去重
 */
add_filter ('posts_distinct', 'cf_search_distinct');
function cf_search_distinct($where) {
    //if(is_admin())
    //    return $where;
    global $wpdb;
    if ( is_search() )  {
      return "DISTINCT";
    }
    return $where;
}

if(io_get_option('ioc_login_language',false)){
    add_filter( 'login_display_language_dropdown', '__return_false' );
}

/**
 * 美化Wordpress登录页 By 一为
 * 原文地址：https://www.iowen.cn/chundaimameihuawordpressmorendengluye/
 */
function io_login_header(){
    echo '<div class="login-container">
    <div class="login-body">
        <div class="login-img shadow-lg position-relative flex-fill">
            <div class="img-bg position-absolute">
                <div class="login-info">
                    <h2>'. get_bloginfo('name') .'</h2>
                    <p>'. get_bloginfo('description') .'</p>
                </div>
            </div>
        </div>';
}

function io_login_footer(){
    echo '</div><!--login-body END-->
    </div><!--login-container END-->
    <div class="footer-copyright position-absolute">
            <span>Copyright © <a href="'. esc_url(home_url()) .'" class="text-white-50" title="'. get_bloginfo('name') .'" rel="home">'. get_bloginfo('name') .'</a>&nbsp;&nbsp;Modify by <a href="https://www.iotheme.cn" target="_blank">一为</a></span> 
    </div>';
}

/**
 * 获取当前用户的等级
 * @return int
 */
function io_get_user_level() {
    // 判断有没有登陆
    if (is_user_logged_in()) {
        // 判断是不是管理员
        if (current_user_can('manage_options')) {
            return 10;
        } else {
            return 2;
        }
    } else {
        return 0;
    }
}
/**
 * 判断是否可见
 * @param $val 0所有人 2登录可见 10管理员可见
 * @return bool
 */
function io_is_visible($val) {
    if (empty($val)) {
        $val = 0;
    }
    if($val == '1'){
        $val = 10;
    }
    $val = intval($val);
    $level = io_get_user_level();
    
    if( $level >= $val){
        return 1;
    }else{
        if($level ===0 && $val === 2){
            return 2;
        }
        return 0;
    }
}


/**
 * 获取简介 
 * @param int $count
 * @param string $meta_key
 * @param string $trimmarker
 * @return string
 */
function io_get_excerpt($count = 90,$meta_key = '_seo_desc', $trimmarker = '...', $post=''){
    if(''===$post){
        global $post;
    }
    $excerpt = '';
    if (!($excerpt = get_post_meta($post->ID, $meta_key, true))) { 
        if (!empty($post->post_excerpt)) {
            $excerpt = $post->post_excerpt;
        } else {
            $excerpt = $post->post_content;
        }
    }
    $excerpt = trim(str_replace(array("\r\n", "\r", "\n", "　", " "), " ", str_replace("\"", "'", strip_tags(strip_shortcodes($excerpt)))));
    $excerpt = mb_strimwidth(strip_tags($excerpt), 0, $count, $trimmarker);
    return $excerpt;
}
/**
 * 获取特色图地址
 */
function io_theme_get_thumb($post = null){
	if( $post === null ){
        global $post;
    }
    $post_thumbnail_src = get_post_meta($post->ID, '_thumbnail', true);
    if(!empty($post_thumbnail_src)){
        return $post_thumbnail_src;
    }
	if( has_post_thumbnail() ){    //如果有特色缩略图，则输出缩略图地址
		$thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
		$post_thumbnail_src = $thumbnail_src [0];
	} else {
		$post_thumbnail_src = '';
		$strResult = io_get_post_first_img(true);
		if(!empty($strResult[1][0])){
			$post_thumbnail_src = $strResult[1][0];   //获取该图片 src
		}
    }
    return $post_thumbnail_src;
}

/**
 * 获取/输出缩略图地址
 */
function io_get_post_first_img($is_array = false){ 
    global $post; 
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $strResult);
    if($is_array)
        return $strResult;
    else{
        if(!empty($strResult[1][0])){
			return $strResult[1][0];  
		}else{	
            return null;
		}
    }
}
/**
 * 美化Wordpress登录页 By 一为
 * 原文地址：https://www.iowen.cn/chundaimameihuawordpressmorendengluye/
 */
function custom_login_style(){
    $login_color_l = io_get_option('login_color_l','#7d00a0');
    $login_color_r = io_get_option('login_color_r','#c11b8d');
    echo '<style type="text/css">
    body{background:'.$login_color_l.';background:-o-linear-gradient(45deg,'.$login_color_l.','.$login_color_r.');background:linear-gradient(45deg,'.$login_color_l.','.$login_color_r.');height:100vh}
    .login h1 a{background-image:url('.io_get_option('login_logo',get_theme_file_uri('/images/logo_dark@2x.png')).');width:180px;background-position:center center;background-size:'.io_get_option('login_logo_size',160).'px}
    .login-container{position:relative;display:flex;align-items:center;justify-content:center;height:100vh}
    .login-body{position:relative;display:flex;margin:0 1.5rem}
    .login-img{display:none}
    .img-bg{color:#fff;padding:2rem;bottom:-2rem;left:0;top:-2rem;right:0;border-radius:10px;background-image:url('.io_get_option('login_img',get_theme_file_uri('/images/login.jpg')).');background-repeat:no-repeat;background-position:center center;background-size:cover}
    .img-bg h2{font-size:2rem;margin-bottom:1.25rem}
    #login{position:relative;background:#fff;border-radius:10px;padding:28px;width:280px;box-shadow:0 1rem 3rem rgba(0,0,0,.175)}
    .flex-fill{flex:1 1 auto}
    .position-relative{position:relative}
    .position-absolute{position:absolute}
    .shadow-lg{box-shadow:0 1rem 3rem rgba(0,0,0,.175)!important}
    .footer-copyright{bottom:0;color:rgba(255,255,255,.6);text-align:center;margin:20px;left:0;right:0}
    .footer-copyright a{color:rgba(255,255,255,.6);text-decoration:none}
    #login form{-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow:none;border-width:0;padding:0}
    #login form .forgetmenot{float:none}
    .login #login_error,.login .message,.login .success{border-left-color:#40b9f1;box-shadow:none;background:#d4eeff;border-radius:6px;color:#2e73b7}
    .login #login_error{border-left-color:#f1404b;background:#ffd4d6;color:#b72e37}
    #login form p.submit{padding:20px 0 0}
    #login form p.submit .button-primary{float:none;background-color:#f1404b;font-weight:bold;color:#fff;width:100%;height:40px;border-width:0;text-shadow:none!important;border-color:none;transition:.5s}
    #login form input{box-shadow:none!important;outline:none!important}
    #login form p.submit .button-primary:hover{background-color:#444}
    .login #backtoblog,.login #nav{padding:0}
    @media screen and (min-width:768px){.login-body{width:1200px}
    .login-img{display:block}
    #login{margin-left:-60px;padding:40px}
    }
</style>';
}
if (io_get_option('login_beautify', true)) {
    add_action('login_header', 'io_login_header');
    add_action('login_footer', 'io_login_footer');

    add_action('login_head', 'custom_login_style');
    
    if(!io_get_option('ioc_login_language',false)){
        add_filter( 'login_display_language_dropdown', '__return_false' );
    }
}