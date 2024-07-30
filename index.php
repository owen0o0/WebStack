<?php 
/*
 * @Author: iowen
 * @Author URI: https://www.iowen.cn/
 * @Date: 2024-07-30 17:15:18
 * @LastEditors: iowen
 * @LastEditTime: 2024-07-30 22:18:04
 * @FilePath: /WebStack/index.php
 * @Description: 
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

include( 'templates/header-nav.php' );
?>
<div class="main-content">

<?php include( 'templates/header-banner.php' ); ?>
 
<?php get_template_part( 'templates/bulletin' ); ?>

<?php
if(io_get_option('is_search')){include('search-tool.php'); }
else{?>
<div class="no-search"></div>
<?php
}
?>

<div class="sites-list" style="margin-bottom: 8.5rem;">
<?php if(!wp_is_mobile() && io_get_option('ad_home_s')) echo '<div class="row"><div class="ad ad-home col-md-6">' . stripslashes( io_get_option('ad_home') ) . '</div><div class="ad ad-home col-md-6 visible-md-block visible-lg-block">' . stripslashes( io_get_option('ad_home') ) . '</div></div>'; ?>        

<?php
foreach($categories as $category) {
  $__visible = io_is_visible(get_term_meta($category->term_id, '_view_user', true));
  if ($__visible === 0) {
      continue;
  }
  if($category->category_parent == 0){
    $children = get_categories(array(
      'taxonomy'   => 'favorites',
      'meta_key'   => '_term_order',
      'orderby'    => 'meta_value_num',
      'order'      => 'desc',
      'child_of'   => $category->term_id,
      'hide_empty' => 0
      )
    );
    if(empty($children)){ 
      fav_con($category, $__visible);
    }else{
      foreach($children as $mid) {
        $__visible = io_is_visible(get_term_meta($mid->term_id, '_view_user', true));
        if ($__visible === 0) {
            continue;
        }
        fav_con($mid, $__visible);
      }
    }
  }
} 
get_template_part( 'templates/friendlink' ); 
?>
</div>
<?php
get_footer();
