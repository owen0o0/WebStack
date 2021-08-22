<?php
/*
 * @Theme Name:WebStack
 * @Theme URI:https://www.iotheme.cn/
 * @Author: iowen
 * @Author URI: https://www.iowen.cn/
 * @Date: 2019-02-22 21:26:02
 * @LastEditors: iowen
 * @LastEditTime: 2021-08-22 23:05:35
 * @FilePath: \WebStack\templates\header-banner.php
 * @Description: 
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }  ?>
<nav class="navbar user-info-navbar" role="navigation">
    <div class="navbar-content">
      <ul class="user-info-menu left-links list-inline list-unstyled">
        <li class="hidden-xs">
            <a href="#" data-toggle="sidebar">
                <i class="fa fa-bars"></i>
            </a>
        </li>
        <!-- 天气 -->
        <li>
          <div id="he-plugin-simple"></div>
          <script>WIDGET = {CONFIG: {"modules": "12034","background": 5,"tmpColor": "aaa","tmpSize": 16,"cityColor": "aaa","citySize": 16,"aqiSize": 16,"weatherIconSize": 24,"alertIconSize": 18,"padding": "30px 10px 30px 10px","shadow": "1","language": "auto","borderRadius": 5,"fixed": "false","vertical": "middle","horizontal": "left","key": "a922adf8928b4ac1ae7a31ae7375e191"}}</script>
          <script src="https://widget.heweather.net/simple/static/js/he-simple-common.js?v=1.1"></script>
        </li>
        <!-- 天气 end -->
      </ul>
    </div>
    <a href="https://github.com/owen0o0/WebStack" target="_blank"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png" alt="Fork me on GitHub"></a>
</nav>