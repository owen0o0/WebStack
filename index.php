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

<?php
if(io_get_option('is_search')){include('search-tool.php'); }
else{?>
<div class="no-search"></div>
<?php
}


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


get_footer();