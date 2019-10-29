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
    <div style="position: absolute;background: #fff;width: 100%;box-shadow: 0 5px 20px rgba(0,0,0,.05);padding-bottom:1px;">
      <ul class="user-info-menu left-links list-inline list-unstyled">
        <li class="hidden-sm hidden-xs">
            <a href="#" data-toggle="sidebar">
                <i class="fa-bars"></i>
            </a>
        </li>
        <li  >
          <div id="tp-weather-widget" style="padding: 25px 10px;"></div>
          <script>(function(T,h,i,n,k,P,a,g,e){g=function(){P=h.createElement(i);a=h.getElementsByTagName(i)[0];P.src=k;P.charset="utf-8";P.async=1;a.parentNode.insertBefore(P,a)};T["ThinkPageWeatherWidgetObject"]=n;T[n]||(T[n]=function(){(T[n].q=T[n].q||[]).push(arguments)});T[n].l=+new Date();if(T.attachEvent){T.attachEvent("onload",g)}else{T.addEventListener("load",g,false)}}(window,document,"script","tpwidget","//widget.seniverse.com/widget/chameleon.js"))</script>
          <script>tpwidget("init",{"flavor": "slim","location": "WX4FBXXFKE4F","geolocation": "enabled","language": "zh-chs","unit": "c","theme": "white","container": "tp-weather-widget","bubble": "enabled","alarmType": "badge","uid": "UD5EFC1165","hash": "2ee497836a31c599f67099ec09b0ef62"});tpwidget("show");</script>
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