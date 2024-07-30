<?php 
/*
 * @Author: iowen
 * @Author URI: https://www.iowen.cn/
 * @Date: 2024-07-30 17:15:18
 * @LastEditors: iowen
 * @LastEditTime: 2024-07-30 19:54:35
 * @FilePath: /WebStack/page.php
 * @Description: 
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>


<?php 
include( 'templates/header-nav.php' );
?>
<div class="main-content page">
<?php include( 'templates/header-banner.php' ); ?>
    <div class="container">
	    <div class="row mt-5 mt-sm-0">
	    	<div class="col-12 mx-auto">
                <div class="panel panel-default">
                    <h1 class="h2"><?php echo get_the_title() ?></h1>
                    <div class="panel-body mt-2">
                        <div class="row">
                            <div class="col-sm-12">
                                <?php while( have_posts() ): the_post(); ?>
	    			            <?php the_content();?>
                                    <?php edit_post_link(__('编辑','i_theme'), '<span class="edit-link">', '</span>' ); ?>
	    		                <?php endwhile; ?>
                            </div> 
                        </div>
                    </div>
                </div>
                    <?php 
                    if ( comments_open() || get_comments_number() ) :
	    				comments_template();
                    endif; 
                    ?>
	    	</div>
	    </div>
	</div>
<?php get_footer(); ?>