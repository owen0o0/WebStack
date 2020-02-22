<?php if ( ! defined( 'ABSPATH' ) ) { exit; }?>
<?php get_header();?>


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
      fav_con($category);
    }else{
      foreach($children as $mid) {
        fav_con($mid);
      }
    }
  }
} 
get_template_part( 'templates/friendlink' ); 
?>
</div>
<?php
get_footer();
