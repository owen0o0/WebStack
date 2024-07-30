<?php
/*
 * @Theme Name:One Nav
 * @Theme URI:https://www.iotheme.cn/
 * @Author: iowen
 * @Author URI: https://www.iowen.cn/
 * @Date: 2021-06-03 08:56:01
 * @LastEditors: iowen
 * @LastEditTime: 2024-07-30 22:08:25
 * @FilePath: /WebStack/taxonomy-favorites.php
 * @Description: 网站分类页
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$__visible = io_is_visible(get_term_meta(get_queried_object_id(), '_view_user', true));
if ($__visible === 0) {
    wp_safe_redirect( home_url() );
}

get_header();

include( 'templates/header-nav.php' );
?>
<div class="main-content">
    
<?php include( 'templates/header-banner.php' ); ?>

    <?php
    if(io_get_option('is_search')){include('search-tool.php'); }
    else{?>
    <div class="no-search"></div>
    <?php } ?>
    <h4 class="text-gray"><i class="icon-io-tag" style="margin-right: 27px;" id="<?php single_cat_title() ?>"></i><?php single_cat_title() ?></h4>
	<?php
    if($__visible == 2){
        echo '<div class="login-notice">'.__('此分类需登陆后查看','i_theme').'</div>';
	} else {
	?>
    <div class="row">  
		<?php
		if (have_posts()):
			while (have_posts()):
				the_post();
				$link_url    = get_post_meta($post->ID, '_sites_link', true);
				$default_ico = get_theme_file_uri('/images/favicon.png');
				if (io_is_visible(get_post_meta($post->ID, '_visible', true))):
					?>
			<div class="xe-card <?php echo io_get_option('columns') ?> <?php echo get_post_meta($post->ID, '_wechat_qr', true) ? 'wechat' : '' ?>">
            <?php include ('templates/site-card.php'); ?>
        	</div>
    	<?php endif; endwhile; endif; ?>
    </div> 
    <br /> 

	<div class="posts-nav">
	    <?php echo paginate_links(
			array(
				'prev_next'          => 0,
				'before_page_number' => '',
				'mid_size'           => 2,
			)
		); ?>
	</div>
	<?php } ?>
<?php get_footer(); ?>