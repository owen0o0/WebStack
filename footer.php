<?php 
/*
 * @Theme Name:WebStack
 * @Theme URI:https://www.iotheme.cn/
 * @Author: iowen
 * @Author URI: https://www.iowen.cn/
 * @Date: 2019-02-22 21:26:02
 * @LastEditors: iowen
 * @LastEditTime: 2023-02-20 21:30:14
 * @FilePath: \WebStack\footer.php
 * @Description: 
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }?>
            <footer class="main-footer sticky footer-type-1">
                <div class="go-up">
                    <a href="#" rel="go-top">
                        <i class="fa fa-angle-up"></i>
                    </a>
                </div>
                <div class="footer-inner">
                    <!---请保留版权说明，谢谢---->
                    <div class="footer-text">
                        Copyright © <?php echo date('Y') ?> <?php bloginfo('name'); ?> <?php if(io_get_option('icp')) echo '<a href="https://beian.miit.gov.cn/" target="_blank" rel="link noopener">' . io_get_option('icp') . '</a>'?>
                        &nbsp;&nbsp;Design by <a href="http://webstack.cc" target="_blank"><strong>Webstack</strong></a>&nbsp;&nbsp;Modify by <a href="https://www.iotheme.cn" target="_blank"><strong>一为</strong></a>
                    </div>
                    <!---请保留版权说明，谢谢---->
                </div>
            </footer>
        </div>
    </div>
<?php if (is_home() || is_front_page()): ?>
    <script type="text/javascript">
    $(document).ready(function() {
        setTimeout(function () { 
            if($('a.smooth[href="'+window.location.hash+'"]')[0]){
                $('a.smooth[href="'+window.location.hash+'"]').click();
            } else if(window.location.hash != ''){
                $("html, body").animate({
                    scrollTop: $(window.location.hash).offset().top - 80
                }, {
                    duration: 500,
                    easing: "swing"
                });
            }
        }, 300);
        $(document).on('click', '.has-sub', function(){
            var _this = $(this)
            if(!$(this).hasClass('expanded')) {
               setTimeout(function(){
                    _this.find('ul').attr("style","")
               }, 300);
              
            } else {
                $('.has-sub ul').each(function(id,ele){
                    var _that = $(this)
                    if(_this.find('ul')[0] != ele) {
                        setTimeout(function(){
                            _that.attr("style","")
                        }, 300);
                    }
                })
            }
        })
        $('.user-info-menu .hidden-xs').click(function(){
            if($('.sidebar-menu').hasClass('collapsed')) {
                $('.has-sub.expanded > ul').attr("style","")
            } else {
                $('.has-sub.expanded > ul').show()
            }
        })
        $("#main-menu li ul li").click(function() {
            $(this).siblings('li').removeClass('active'); // 删除其他兄弟元素的样式
            $(this).addClass('active'); // 添加当前元素的样式
        });
        $("a.smooth").click(function(ev) {
            ev.preventDefault();
            if($("#main-menu").hasClass('mobile-is-visible') != true)
                return;
            public_vars.$mainMenu.add(public_vars.$sidebarProfile).toggleClass('mobile-is-visible');
            ps_destroy();
            $("html, body").animate({
                scrollTop: $($(this).attr("href")).offset().top - 80
            }, {
                duration: 500,
                easing: "swing"
            });
        });
        return false;
    });

    var href = "";
    var pos = 0;
    $("a.smooth").click(function(e) {
        e.preventDefault();
        if($("#main-menu").hasClass('mobile-is-visible') === true)
            return;
        $("#main-menu li").each(function() {
            $(this).removeClass("active");
        });
        $(this).parent("li").addClass("active");
        href = $(this).attr("href");
        pos = $(href).position().top - 100;
        $("html,body").animate({
            scrollTop: pos
        }, 500);
    });
    </script>
<?php endif; ?>
<?php wp_footer(); ?>
<!-- 自定义代码 -->
<?php echo io_get_option('code_2_footer');?>
<!-- end 自定义代码 -->
</body>
</html>