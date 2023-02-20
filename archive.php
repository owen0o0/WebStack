<?php 
/*
 * @Theme Name:WebStack
 * @Theme URI:https://www.iotheme.cn/
 * @Author: iowen
 * @Author URI: https://www.iowen.cn/
 * @Date: 2020-02-22 21:26:05
 * @LastEditors: iowen
 * @LastEditTime: 2023-02-20 20:52:23
 * @FilePath: \WebStack\archive.php
 * @Description: 
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>


<?php 
$categories= get_categories(array(
  'taxonomy'     => 'favorites',
  'meta_key'     => '_term_order',
  'orderby'      => 'meta_value_num',
  'order'        => 'desc',
  'hide_empty'   => 0,
  )
); 
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
    <div class="row">  
		<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); 
		$link_url = get_post_meta($post->ID, '_sites_link', true); 
        $default_ico = get_theme_file_uri('/images/favicon.png');
		if(current_user_can('level_10') || get_post_meta($post->ID, '_visible', true)==""):
		?>
			<div class="xe-card <?php echo io_get_option('columns') ?> <?php echo get_post_meta($post->ID, '_wechat_qr', true)? 'wechat':''?>">
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

<?php get_footer(); ?>
