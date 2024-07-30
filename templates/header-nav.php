<?php
/*
 * @Theme Name:WebStack
 * @Theme URI:https://www.iotheme.cn/
 * @Author: iowen
 * @Author URI: https://www.iowen.cn/
 * @Date: 2019-02-22 21:26:02
 * @LastEditors: iowen
 * @LastEditTime: 2024-07-30 22:18:36
 * @FilePath: /WebStack/templates/header-nav.php
 * @Description: 
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$categories = get_categories( array(
    'taxonomy'   => 'favorites',
    'parent'     => 0,
    'meta_key'   => '_term_order',
    'orderby'    => 'meta_value_num',
    'order'      => 'desc',
    'hide_empty' => 0,
));
?>
<div class="sidebar-menu toggle-others fixed">
            <div class="sidebar-menu-inner">
                <header class="logo-env">
                    <!-- logo -->
                    <div class="logo">
                        <a href="<?php bloginfo('url') ?>" class="logo-expanded">
                            <img src="<?php echo io_get_option('logo_normal') ?>" height="40" alt="<?php bloginfo('name') ?>" />
                        </a>
                        <a href="<?php bloginfo('url') ?>" class="logo-collapsed">
                            <img src="<?php echo io_get_option('logo_small') ?>" height="40" alt="<?php bloginfo('name') ?>">
                        </a>
                    </div>
                    <div class="mobile-menu-toggle visible-xs">
                        <a href="#" data-toggle="mobile-menu">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                </header>
                <ul id="main-menu" class="main-menu">
                <?php
                foreach($categories as $category) {
                    $_visible = io_is_visible(get_term_meta($category->term_id, '_view_user', true));
                    if ($_visible === 0) {
                        continue;
                    }
                    $children = get_categories(array(
                        'taxonomy'   => 'favorites',
                        'meta_key'   => '_term_order',
                        'orderby'    => 'meta_value_num',
                        'order'      => 'desc',
                        'child_of'   => $category->term_id,
                        'hide_empty' => 0)
                    );
                        if(empty($children)){
                            
                            ?>
                        <li>
                            <a href="<?php if (is_home() || is_front_page()): ?><?php else: echo home_url() ?>/<?php endif; ?>#term-<?php echo $category->term_id;?>" class="smooth">
                                <i class="<?php echo get_term_meta($category->term_id, '_term_ico',true) ?> fa-fw"></i>
                                <span class="title"><?php echo $category->name; ?></span>
                            </a>
                        </li> 
                        <?php }else { ?>
                        <li>
                            <a>
                                <i class="<?php echo get_term_meta($category->term_id, '_term_ico',true) ?> fa-fw"></i>
                                <span class="title"><?php echo $category->name; ?></span>
                            </a>
                            <ul>
                                <?php foreach ($children as $mid) { 
                                    $_visible = io_is_visible(get_term_meta($mid->term_id, '_view_user', true));
                                    if ($_visible === 0) {
                                        continue;
                                    }
                                ?>

                                <li>
                                    <a href="<?php if (is_home() || is_front_page()): ?><?php else: echo home_url() ?>/<?php endif; ?>#term-<?php  echo $mid->term_id ;?>" class="smooth"><?php echo $mid->name; ?></a>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php 
                    }
                }
                ?> 

                    <li class="submit-tag">
                    <?php
                        if(function_exists('wp_nav_menu')) wp_nav_menu( array('container' => false, 'items_wrap' => '%3$s', 'theme_location' => 'nav_main',) ); 
                    ?>
                    </li>
                </ul>
            </div>
        </div>