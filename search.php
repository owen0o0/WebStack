<?php 
/*
 * @Theme Name:WebStack
 * @Theme URI:https://www.iotheme.cn/
 * @Author: iowen
 * @Author URI: https://www.iowen.cn/
 * @Date: 2020-02-22 21:26:05
 * @LastEditors: iowen
 * @LastEditTime: 2021-08-22 22:26:31
 * @FilePath: \WebStack\search.php
 * @Description: 
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>

<a href="<?php bloginfo('url') ?>" style="position:absolute;margin:30px 0 0 30px;z-index:1000;"><img src="<?php echo io_get_option('logo_normal') ?>" height="40" alt="<?php bloginfo('name') ?>"></a>
<div class="main-content">
	<div id="search" class="s-search">
		<form name="formsearch" method="get" action="<?php bloginfo('url'); ?>?s=" id="super-search-fm">
            <input type="text" id="search-text" name="s" class="search-keyword" placeholder="输入关键字搜索" style="outline:0"/> 
            <button type="submit" οnmοuseοut="this.className='select_class'" οnmοuseοver="this.className='select_over'" ><i class="fa fa-search "></i></button>
        </form>
	</div>

	<div class="row">
		<div class="col-12 col-lg-8 mx-auto">
			<h4 class="text-gray"><i class="fa fa-search" style="margin-right: 27px;"></i>“<?php echo $s; ?>” <?php _e('的搜索结果','i_swallow'); ?></h4>
        	<div class="row">
                 
			<?php if ( !have_posts() ) : ?>
				<div class="col-lg-12">
            		<div class="nothing">没有内容</div>
          		</div>
    		<?php endif; ?>
			
			
    		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post();
			$link_url = get_post_meta($post->ID, '_sites_link', true); 
            $default_ico = get_template_directory_uri() .'/images/favicon.png';
			if(current_user_can('level_10') || get_post_meta($post->ID, '_visible', true)==""):
			?>
				<div class="xe-card col-sm-4 col-md-3 <?php echo get_post_meta($post->ID, '_wechat_qr', true)? 'wechat':''?>">
            	  	
				<?php include( 'templates/site-card.php' ); ?>
            	</div>
    		<?php endif; endwhile; endif;?>
			</div>
			<br /> 
			<div class="posts-nav">
			    <?php echo paginate_links(array(
			        'prev_next'          => 0,
			        'before_page_number' => '',
			        'mid_size'           => 2,
			    ));?>
			</div>
			<div style="text-align:center;margin-top:50px;margin-bottom:30px;">
			<a href="<?php bloginfo('url') ?>" class="but-home ">返回主页</a>
			</div>
		</div>
	</div>
	
<?php
get_footer(); 