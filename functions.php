<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
date_default_timezone_set('Asia/Shanghai');
require get_template_directory() . '/inc/inc.php';

   
//登录页面的LOGO链接为首页链接
add_filter('login_headerurl',function() {return get_bloginfo('url');});
//登陆界面logo的title为博客副标题
add_filter('login_headertext',function() {return get_bloginfo( 'description' );});

