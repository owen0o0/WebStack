<?php
/*
 * @Theme Name:WebStack
 * @Theme URI:https://www.iotheme.cn/
 * @Author: iowen
 * @Author URI: https://www.iowen.cn/
 * @Date: 2019-02-22 21:26:02
 * @LastEditors: iowen
 * @LastEditTime: 2021-08-22 23:05:46
 * @FilePath: \WebStack\templates\friendlink.php
 * @Description: 
 */
if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

        <?php if( io_get_option('links') ) : ?>
        <h4 class="text-gray mb-4">
            <i class="fa fa-bookmark" id="friendlink" style="margin-right:10px"></i>友情链接
        </h4>
        <div class="friendlink" style="margin-bottom:-40px">
            <div class="panel">
                <?php wp_list_bookmarks('title_li=&before=&after=&categorize=0&show_images=0&orderby=rating&order=DESC&category='.get_option('link_f_cat')); ?>
            </div> 
        </div> 
        <?php endif; ?> 