<?php
/*
 * @Theme Name:WebStack
 * @Theme URI:https://www.iotheme.cn/
 * @Author: iowen
 * @Author URI: https://www.iowen.cn/
 * @Date: 2019-02-22 21:26:02
 * @LastEditors: iowen
 * @LastEditTime: 2024-07-30 17:31:38
 * @FilePath: /WebStack/templates/header-banner.php
 * @Description: 
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }  ?>
<nav class="navbar user-info-navbar" role="navigation">
    <div class="navbar-content">
      <ul class="user-info-menu list-inline list-unstyled">
        <li class="hidden-xs">
            <a href="#" data-toggle="sidebar">
                <i class="fa fa-bars"></i>
            </a>
        </li>
        <!-- 天气 -->
        <li>
          <div id="he-plugin-simple"></div>
          <script>(function(T,h,i,n,k,P,a,g,e){g=function(){P=h.createElement(i);a=h.getElementsByTagName(i)[0];P.src=k;P.charset="utf-8";P.async=1;a.parentNode.insertBefore(P,a)};T["ThinkPageWeatherWidgetObject"]=n;T[n]||(T[n]=function(){(T[n].q=T[n].q||[]).push(arguments)});T[n].l=+new Date();if(T.attachEvent){T.attachEvent("onload",g)}else{T.addEventListener("load",g,false)}}(window,document,"script","tpwidget","//widget.seniverse.com/widget/chameleon.js"))</script>
          <script>tpwidget("init",{"flavor": "slim","location": "WX4FBXXFKE4F","geolocation": "enabled","language": "zh-chs","unit": "c","theme": "chameleon","container": "he-plugin-simple","bubble": "enabled","alarmType": "badge","color": "#999999","uid": "UD5EFC1165","hash": "2ee497836a31c599f67099ec09b0ef62"});tpwidget("show");</script>
        </li>
        <!-- 天气 end -->
      </ul>
      <ul class="user-info-menu list-inline list-unstyled">
        <li class="hidden-sm hidden-xs">
            <a href="https://github.com/owen0o0/WebStack" target="_blank"><i class="fa fa-github"></i> GitHub</a>
        </li>
      </ul>
    </div>
</nav>