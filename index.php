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
  <nav class="navbar user-info-navbar" role="navigation">
    <div class="navbar-content">
      <ul class="user-info-menu left-links list-inline list-unstyled">
        <li class="hidden-xs">
            <a href="#" data-toggle="sidebar">
                <i class="fa-bars"></i>
            </a>
        </li>
        <li>
          <div id="he-plugin-simple"></div>
          <script>WIDGET = {CONFIG: {"modules": "12034","background": 5,"tmpColor": "aaa","tmpSize": 16,"cityColor": "aaa","citySize": 16,"aqiSize": 16,"weatherIconSize": 24,"alertIconSize": 18,"padding": "30px 10px 30px 10px","shadow": "1","language": "auto","borderRadius": 5,"fixed": "false","vertical": "middle","horizontal": "left","key": "a922adf8928b4ac1ae7a31ae7375e191"}}</script>
          <script src="https://widget.heweather.net/simple/static/js/he-simple-common.js?v=1.1"></script>
        </li>
      </ul>
    </div>
    <a href="https://github.com/owen0o0/WebStack" target="_blank"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png" alt="Fork me on GitHub"></a>
  </nav>
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