<?php 
/*
 * @Theme Name:WebStack
 * @Theme URI:https://www.iotheme.cn/
 * @Author: iowen
 * @Author URI: https://www.iowen.cn/
 * @Date: 2019-02-22 21:26:02
 * @LastEditors: iowen
 * @LastEditTime: 2023-04-24 00:37:18
 * @FilePath: \WebStack\inc\frame\config\framework.config.php
 * @Description: 
 */
if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK SETTINGS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$settings           = array(
  'menu_title'      => __('主题设置','io_setting'),
  'menu_type'       => 'menu', // menu, submenu, options, theme, etc.
  'menu_slug'       => 'io_get_option',
  'menu_position'   => 59,
  'menu_icon'       => CS_URI.'/assets/images/setting.png',
  'ajax_save'       => true,
  'show_reset_all'  => false,
  'framework_title' => 'WebStack '.__('主题设置','io_setting').'<style>.cs-framework .cs-body {min-height: 700px;}</style><span style="font-size: 14px;"> - V '.wp_get_theme()->get('Version').'</span> <a href="https://www.iotheme.cn/store/onenav.html" target="_blank">go OneNav</a>',
  //'framework_title' => '主题设置',
);

// 所有分类ID
$cats_id = '';
$categories = get_categories(array('hide_empty' => 0)); 
foreach ($categories as $cat) {
$cats_id .= '<span style="margin-right: 15px;">'.$cat->cat_name.' [ '.$cat->cat_ID.' ]</span>';
}
$blog_name = trim(get_bloginfo('name'));

// ---------------------------------------
// 图标  --------------------------------
// ---------------------------------------
$options[] = array(
    'name' => 'overwiew',
    'title' => '图标设置',
    'icon' => 'fa fa-star',
    'fields' => array(
        array(
            'type'    => 'notice',
            'content' => '---》<a href="https://www.iowen.cn/wordpress-version-webstack/" target="_blank">查看教程</a>《---',
            'class'   => 'info',
        ),
        array(
            'type'    => 'notice',
            'content' => '---》<a href="https://www.iotheme.cn/help" target="_blank">帮助中心</a>《---',
            'class'   => 'info',
        ),
        array(
            'id' => 'logo_normal',
            'type' => 'image',
            'title' => '上传 Logo',
            'add_title' => '上传',
            'after'    => '<p class="cs-text-muted">'.'建议高80px',
            'default'   => get_theme_file_uri('/images/logo@2x.png'),
        ),
        array(
            'id' => 'logo_small',
            'type' => 'image',
            'title' => '方形 Logo',
            'add_title' => '上传',
            'after'    => '<p class="cs-text-muted">'.'建议 80x80',
            'default'   => get_theme_file_uri('/images/logo-collapsed@2x.png'),
        ),
        array(
            'id' => 'favicon',
            'type' => 'image',
            'title' => '上传 Favicon',
            'add_title' => '上传',
            'default'   => get_theme_file_uri('/images/favicon.png'),
        ),
        array(
            'id' => 'apple_icon',
            'type' => 'image',
            'title' => '上传 apple_icon',
            'add_title' => '上传',
            'default'   => get_theme_file_uri('/images/app-ico.png'),
        ),
        array(
            'id'      => 'login_beautify',
            'type'    => 'switcher',
            'title'   => '美化登录页',
            'default' => true,
        ),
        array(
            'id' => 'login_img',
            'type' => 'image',
            'title' => '登录页背景图',
            'add_title' => '上传',
            'default'   => get_theme_file_uri('/images/login.jpg'),
			'dependency' => array( 'login_beautify', '==', true )
        ),
        array(
            'id' => 'login_logo',
            'type' => 'image',
            'title' => '登录页 Logo',
            'add_title' => '上传',
            'after'    => '<p class="cs-text-muted">'.'建议高80px',
            'default'   => get_theme_file_uri('/images/logo_dark@2x.png'),
			'dependency' => array( 'login_beautify', '==', true )
        ),
        array(
            'id' => 'login_color_l',
            'type' => 'color_picker',
            'title' => '登录背景色-左',
            'default'   => '#7d00a0',
			'dependency' => array( 'login_beautify', '==', true )
        ),
        array(
            'id' => 'login_color_r',
            'type' => 'color_picker',
            'title' => '登录背景色-右',
            'default'   => '#c11b8d',
			'dependency' => array( 'login_beautify', '==', true )
        ),
    ),
);


// ---------------------------------------
// 其他  --------------------------------
// ---------------------------------------
$options[] = array(
    'name' => 'other_settings',
    'title' => '常规设置',
    'icon' => 'fa fa-list',
    'fields' => array(
        array(
            'id'      => 'details_page',
            'type'    => 'switcher',
            'title'   => '详情页',
            'desc'    => '显示网址详情页',
            'after'   => '<br><p>关闭状态为网址块直接跳转到目标网址</p>',
            'default' => false,
        ),
        array(
            'id'      => 'po_prompt',
            'type'    => 'radio',
            'title'   => '网址块弹窗提示',
            'desc'    => '网址块默认的弹窗提示内容',
            'default' => 'url',
            'class'   => 'horizontal',
            'options' => array(
                'null'      => '无',
                'url'       => '链接',
                'summary'   => '简介',
                'qr'        => '二维码'
            ),
            'after'   => '如果网址添加了自定义二维码，此设置无效',
        ),
        array(
            'id'      => 'columns',
            'type'    => 'radio',
            'title'   => '网址列数',
            'desc'    => '一行显示个数',
            'default' => 'col-sm-4 col-md-3',
            'class'   => 'horizontal',
            'options' => array(
                'col-sm-6'                    => '2',
                'col-sm-4'                    => '3',
                'col-sm-4 col-md-3'           => '4',
                'col-sm-4 col-md-3 col-lg-2'  => '6'
            ),
        ),
        

        
        array(
            'id'         => 'bulletin',
            'type'       => 'switcher',
            'title'      => '显示公告',
            'desc'      => '在首页顶部显示公告',
            'default'    => true,
        ),
        array(
            'id'         => 'bulletin_n',
            'type'       => 'text',
            'title'      => '公告数量',
            'after'      => '需要显示的公告篇数',
            'default'    => 2,
            'dependency' => array( 'bulletin', '==', 'true' )
        ),
        array(
            'id'         => 'links',
            'type'       => 'switcher',
            'title'      => '友情链接',
            'label'      => '在首页底部添加友情链接',
            'default'    => true,
        ),


        array(
            'type'    => 'notice',
            'content' => '其他设置',
            'class'   => 'info',
        ),
        array(
            'id'      => 'theme_mode',
            'type'    => 'radio',
            'title'   => '颜色主题',
            'default' => 'white',
            'class'   => 'horizontal',
            'options' => array(
                'black'     => '暗色',
                'white'     => '亮色'
            ),
        ),
		array(
			'id'      => 'site_n',
			'type'    => 'number',
			'title'   => '网址数量',
			'default' => '-1',
            'desc'    => '首页分类下显示的网址数量',
            'after'   => '<p>-1 为显示分类下所有网址</p>',
		),
        array(
            'id'      => 'icp',
            'type'    => 'text',
            'title'   => '备案号',
        ),
        array(
            'id'      => 'police_icp',
            'type'    => 'text',
            'title'   => '公安备案号',
        ),
        array(
            'id'      => 'lazyload',
            'type'    => 'switcher',
            'title'   => '图标懒加载',
            'default' => false,
        ),
        array(
            'id'      => 'is_search',
            'type'    => 'switcher',
            'title'   => '搜索',
            'default' => true,
        ),
        array(
            'id'      => 'is_go',
            'type'    => 'switcher',
            'title'   => '内链跳转',
            'default' => false,
        ),
        array(
            'type'    => 'notice',
            'content' => '图标源设置',
            'class'   => 'info',
        ),
        array(
            'id'      => 'ico_url',
            'type'    => 'text',
            'title'   => '图标源',
            'default' => 'https://t3.gstatic.cn/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&size=128&url=',
            'desc'    => 'api 地址',
            'after'   => '默认api地址：https://t3.gstatic.cn/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&size=128&url=<br>如果获取图标失效，请百度搜索‘获取网站图标api’替换能用的就可以了<br>或者自建api服务，源码地址：<a href="https://www.iowen.cn/favicon-api/" target="_blank">https://www.iowen.cn/favicon-api/</a>',
        ),
        array(
            'id'      => 'url_format',
            'type'    => 'switcher',
            'title'   => '不包含 http(s)://',
            'default' => false,
            'desc'    => '根据图标源 api 要求设置，如果api要求不能包含协议名称，请开启此选项',
        ),
        array(
            'id'      => 'ico_png',
            'type'    => 'text',
            'title'   => '图标源api后缀',
            'desc'    => '如：.png ,请根据api格式要求设置，如不需要请留空',
        ),
    ),
);

// ----------------------------------------
// SEO-------------------------------------
// ----------------------------------------
$options[] = array(
    'name' => 'speed',
    'title' => 'SEO设置',
    'icon' => 'fa fa-magic',
    'fields' => array(

        array(
            'id' => 'seo_home_keywords', // this is must be unique
            'type' => 'text',
            'title' => '首页关键词',
        ),

        array(
            'id' => 'seo_home_desc', // this is must be unique
            'type' => 'textarea',
            'title' => '首页描述',
        ),
    ),
);
// ----------------------------------------
// 添加代码-------------------------------
// ----------------------------------------
$options[] = array(
    'name' => 'code',
    'title' => '添加代码',
    'icon' => 'fa fa-code',
    'fields' => array(
        array(
            'id' => 'custom_css',
            'type' => 'wysiwyg',
            'title' => '自定义样式css代码',
            'desc' => '显示在网站头部 &lt;/head&gt; 之前',
            'after'    => '<p class="cs-text-muted">'.__('自定义 CSS,自定义美化...<br>如：','io_setting').'body .test{color:#ff0000;}</p>',
            'settings' => array(
                'textarea_rows' => 5,
                'tinymce'       => false,
                'media_buttons' => false,
            )
        ),
        array(
            'id' => 'code_head_js',
            'type' => 'wysiwyg',
            'title' => 'head自定义 js 代码',
            'desc' => '显示在网站头部 &lt;/head&gt; 之前',
            'after'    => '<p class="cs-text-muted">'.__('出现在网站头部 &lt;/head&gt; 前','io_setting').'</p>',
            'settings' => array(
                'textarea_rows' => 5,
                'tinymce'       => false,
                'media_buttons' => false,
            )
        ),
        array(
            'id' => 'code_2_footer',
            'type' => 'wysiwyg',
            'title' => 'footer自定义 js 代码',
            'desc' => '显示在网站底部',
            'after'    => '<p class="cs-text-muted">'.__('出现在网站底部 body 前，主要用于站长统计代码...</p>','io_setting'),
            'settings' => array(
                'textarea_rows' => 5,
                'tinymce'       => false,
                'media_buttons' => false,
            )
        ),
    )
);
// ----------------------------------------
// 添加广告-------------------------------
// ----------------------------------------
$options[] = array(
    'name' => 'ad',
    'title' => '添加广告',
    'icon' => 'fa fa-google',
    'fields' => array(
        array(
            'id'      => 'ad_home_s',
            'type'    => 'switcher',
            'title'   => '首页顶部广告位',
            'default' => false,
        ),
        array(
            'id'      => 'ad_right_s',
            'type'    => 'switcher',
            'title'   => '详情页右边广告位',
            'default' => true,
        ),
        array(
            'id'      => 'ad_footer_s',
            'type'    => 'switcher',
            'title'   => 'footer广告位',
            'default' => false,
        ),
        array(
            'id'         => 'ad_home',
            'type'       => 'wysiwyg',
            'title'      => '首页顶部广告位内容',
            'default'    => '<a href="https://www.iowen.cn/wordpress-version-webstack/" target="_blank"><img src="' . get_template_directory_uri() . '/screenshot.jpg" alt="广告也精彩" /></a>',
            'settings'   => array(
              'textarea_rows' => 5,
              'tinymce'       => false,
              'media_buttons' => false,
            ),
			'dependency' => array( 'ad_home_s', '==', true )
        ),
        array(
            'id'         => 'ad_right',
            'type'       => 'wysiwyg',
            'title'      => '详情页右边广告位内容',
            'default'    => '<a href="https://www.iowen.cn/wordpress-version-webstack/" target="_blank"><img src="' . get_template_directory_uri() . '/screenshot.jpg" alt="广告也精彩" /></a>',
            'settings'   => array(
              'textarea_rows' => 5,
              'tinymce'       => false,
              'media_buttons' => false,
            ),
			'dependency' => array( 'ad_right_s', '==', true )
        ),
        array(
            'id'         => 'ad_footer',
            'type'       => 'wysiwyg',
            'title'      => 'footer广告位内容',
            'default'    => '<a href="https://www.iowen.cn/wordpress-version-webstack/" target="_blank"><img src="' . get_template_directory_uri() . '/screenshot.jpg" alt="广告也精彩" /></a>',
            'settings'   => array(
              'textarea_rows' => 5,
              'tinymce'       => false,
              'media_buttons' => false,
            ),
			'dependency' => array( 'ad_footer_s', '==', true )
        ),
    )
);

// ----------------------------------------
// 优化加速-------------------------------
// ----------------------------------------
$options[] = array(
	'name'  => 'optimization',
	'title' => __('优化加速','io_setting'),
	'icon'  => 'fa fa-wordpress',

  	'fields' => array(
		array(
			'id'      => 'ioc_article',
			'type'    => 'switcher',
			'title'   => __('登陆后台跳转到文章列表','io_setting'),
			'desc'    => __('WordPress登陆后一般是显示仪表盘页面，开启这个功能后登陆后台默认显示文章列表（默认开启）','io_setting'),
			'default' => true
		),
		array(
			'id'      => 'ioc_wp_head',
			'type'    => 'switcher',
			'title'   => __('移除顶部多余信息','io_setting'),
			'desc'    => __('移除WordPress Head 中的多余信息，能够有效的提高网站自身安全（默认开启）','io_setting'),
			'default' => true
		),
		array(
			'id'      => 'ioc_api',
			'type'    => 'switcher',
			'title'   => __('禁用REST API','io_setting'),
			'desc'    => __('禁用REST API、移除wp-json链接（默认关闭，如果你的网站没有做小程序或是APP，建议开启这个功能，禁用REST API）','io_setting'),
			'default' => false
		),
		array(
			'id'      => 'ioc_pingback',
			'type'    => 'switcher',
			'title'   => 'XML-RPC',
			'desc'    => __('此功能会关闭 XML-RPC 的 pingback 端口（默认开启，提高网站安全性）','io_setting'),
			'default' => true
		),
		array(
			'id'      => 'ioc_feed',
			'type'    => 'switcher',
			'title'   => 'Feed',
			'desc'    => __('Feed易被利用采集，造成不必要的资源消耗（默认开启）','io_setting'),
			'default' => true
		),
		array(
			'id'      => 'ioc_category',
			'type'    => 'switcher',
			'title'   => __('去除分类标志','io_setting'),
			'desc'    => __('去除链接中的分类category标志，有利于SEO优化，每次开启或关闭此功能，都需要重新保存一下固定链接！（默认关闭）','io_setting'),
			'default' => true
		),
		array(
			'id'      => 'ioc_login_language',
			'type'    => 'switcher',
			'title'   => '去除登录页语言切换',
			'desc'    => __('移除 wp5.9 登录页面中增加的语言切换框，开启登录页美化需关闭此项。','io_setting'),
			'default' => true
		),
        array(
            'id'      => 'gravatar',
            'type'    => 'select',
            'title'   => 'Gravatar加速',
            'default' => 'geekzu',
            'options' => array(
                'gravatar'    => __('使用 Gravatar官方 默认服务器','io_setting'),
                'cravatar'    => __('使用 Cravatar 镜像加速服务','io_setting'),
                'sep'         => __('使用 sep.cc 镜像加速服务','io_setting'),
                'loli'        => __('使用 loli 镜像加速服务','io_setting'),
                'chinayes'    => __('使用 wp-china-yes.cn 镜像加速服务','io_setting'),
                'geekzu'      => __('使用 极客族 提供的加速服务','io_setting'),
            ),
        ),
		
	),
);

// ----------------------------------------
// 友情赞助-------------------------------
// ----------------------------------------
$options[] = array(
	'name'  => 'sponsor',
	'title' => '友情赞助',
	'icon'  => 'fa fa-qrcode',

  	'fields' => array(
	
  		array(
			'type'    => 'subheading',
			'content' => '嘿！你好，欢迎使用WebStack主题。<br><br>目前这款主题为免费公开，如使用过程中遇到什么问题，可到博客<a href="https://www.iowen.cn" target="_blank">一为忆</a>反馈<br><br>制作一款WordPress主题不易，欢迎各位老板伸出援手，友情赞助！（你们的支持就是我最大的动力！）',
		),
	
		array(
			'id'      => 'io_zanzhu',
			'type'    => 'image_select',
			'title'   => '友情赞助',
		    'options' => array(
				'wechat'   => get_stylesheet_directory_uri() . '/images/wechat_qrcode.png',
				'alipay' => get_stylesheet_directory_uri() . '/images/alipay_qrcode.png',
		    ),
		),
	),
);

// ----------------------------------------
// 备份-------------------------------------
// ----------------------------------------
$options[] = array(
    'name' => 'advanced',
    'title' => '备份',
    'icon' => 'fa fa-shield',
    'fields' => array(

        array(
            'type' => 'notice',
            'class' => 'danger',
            'content' => '您可以保存当前的选项，下载一个备份和导入.（此操作会清除网站数据，请谨慎操作）',
        ),

        // 备份
        array(
            'type' => 'backup',
        ),

    )
);
CSFramework::instance( $settings, $options );
