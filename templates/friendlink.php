<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

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