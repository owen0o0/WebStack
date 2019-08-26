<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK SETTINGS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$settings           = array(
  'menu_title'      => __('主题设置','io_setting'),
  'menu_type'       => 'theme', // menu, submenu, options, theme, etc.
  'menu_slug'       => 'io_get_option',
  'menu_position'   => 59,
  'menu_icon'       => CS_URI.'/assets/images/setting.png',
  'ajax_save'       => true,
  'show_reset_all'  => true,
  'framework_title' => 'WebStack '.__('主题设置','io_setting').'<style>.cs-framework .cs-body {min-height: 700px;}</style><span style="font-size: 14px;"> - V '.wp_get_theme()->get('Version').'</span>',
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
// 常规  --------------------------------
// ---------------------------------------
$options[] = array(
    'name' => 'overwiew',
    'title' => '常规设置',
    'icon' => 'fa fa-list',
    'fields' => array(
        array(
            'type'    => 'notice',
            'content' => '网站LOGO和Favicon设置',
            'class'   => 'info',
        ),
        array(
            'id' => 'logo_normal',
            'type' => 'image',
            'title' => '上传 Logo',
            'add_title' => '上传',
            'after'    => '<p class="cs-text-muted">'.'建议高80px',
            'default'   => get_stylesheet_directory_uri() . '/images/logo@2x.png',
        ),
        array(
            'id' => 'logo_small',
            'type' => 'image',
            'title' => '方形 Logo',
            'add_title' => '上传',
            'after'    => '<p class="cs-text-muted">'.'建议 80x80',
            'default'   => get_stylesheet_directory_uri() . '/images/logo-collapsed@2x.png',
        ),
        array(
            'id' => 'favicon',
            'type' => 'image',
            'title' => '上传 Favicon',
            'add_title' => '上传',
            'default'   => get_stylesheet_directory_uri() . '/images/favicon.png',
        ),
        array(
            'id' => 'apple_icon',
            'type' => 'image',
            'title' => '上传 apple_icon',
            'add_title' => '上传',
            'default'   => get_stylesheet_directory_uri() . '/images/app-ico.png',
        ),
        array(
            'type'    => 'notice',
            'content' => '其他设置',
            'class'   => 'info',
        ),
        array(
            'id'      => 'icp',
            'type'    => 'text',
            'title'   => '备案号',
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
            'default' => true,
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
            'desc' => '显示在网站头部 &lt;head&gt;',
            'after'    => '<p class="cs-text-muted">'.__('自定义 CSS,自定义美化...<br>如：','io_setting').'body .test{color:#ff0000;}</p>',
            'settings' => array(
              'textarea_rows' => 5,
              'tinymce'       => false,
              'media_buttons' => false,
            )
        ),
        array(
            'id' => 'code_2_footer',
            'type' => 'wysiwyg',
            'title' => 'footer自定义代码',
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
			'content' => '嘿！你好，欢迎使用WebStack主题。<br><br>目前这款主题为免费公开，如使用过程中遇到什么问题，可到博客<a href="https://www.iowen.cn" target="_blank">一为忆</a>反馈<br><br>制作一款WordPress主题实属不易，欢迎各位老板伸出援手，友情赞助！（你们的支持就是我们最大的动力！）',
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
