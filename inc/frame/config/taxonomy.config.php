<?php
/*
 * @Theme Name:WebStack
 * @Theme URI:https://www.iotheme.cn/
 * @Author: iowen
 * @Author URI: https://www.iowen.cn/
 * @Date: 2021-08-22 19:00:30
 * @LastEditors: iowen
 * @LastEditTime: 2023-02-20 19:24:47
 * @FilePath: \WebStack\inc\frame\config\taxonomy.config.php
 * @Description: 
 */
if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

$options[] = array(
    'id' => 'favorites_meta',
    'title' => '图标设置',
    'taxonomy' => 'favorites',
    'data_type' => 'unserialize',
    'fields' => array(
        array(
            'type'    => 'notice',
            'content' => '<h2 style="color: red;">'.__('注意，最多2级，且父级不应有内容','i_theme').'</h2>',
            'class'   => 'info',
        ),
        array(
            'id' => '_term_ico',
            'type' => 'icon',
            'title' => '选择菜单图标',
            'default' => 'fa fa-chrome'
        ),
        array(
            'id' => '_term_order',
            'type' => 'text',
            'title' => '排序',
            'after' =>'数字越大越靠前',
            'default'   => '0',
        ),
        array(
            'type'    => 'notice',
            'content' => '<b><span style="color:red">注意：</span>如果添加新的分类后首页没有显示，请检测“排序”字段有没有值，如果没有，请设置一个值，默认为 0。</b>',
            'class'   => 'info',
        ),
    ),
);
CSFramework_Taxonomy::instance( $options );