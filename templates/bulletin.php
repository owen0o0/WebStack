<?php 
/*
 * @Theme Name:WebStack
 * @Theme URI:https://www.iotheme.cn/
 * @Author: iowen
 * @Author URI: https://www.iowen.cn/
 * @Date: 2019-02-22 21:26:02
 * @LastEditors: iowen
 * @LastEditTime: 2021-08-22 23:05:51
 * @FilePath: \WebStack\templates\bulletin.php
 * @Description: 
 */
if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<?php if( io_get_option('bulletin')) : ?>
<div id="bulletin_box" class="panel">
    <div class="d-flex text-muted">
		<div><i class="fa fa-volume-up" style="line-height:25px"></i></div>
        <div class="bulletin mx-1 mx-md-2">
            <ul class="bulletin-ul">
				<?php 
					$args = array(
						'post_type' => 'bulletin', 
						'posts_per_page' => io_get_option('bulletin_n')
					);
					query_posts($args); while ( have_posts() ) : the_post();
				?>
				<?php the_title( sprintf( '<li class="scrolltext-title overflowClip_1"><a href="%s" rel="bulletin">', esc_url( get_permalink() ) ), '</a> ('. get_the_time('m/d').')</li>' ); ?>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
            </ul>
		</div>
        <a title="关闭" href="javascript:;" rel="external nofollow"  onClick="$('#bulletin_box').slideUp('slow');" style="margin-left:auto"><i class="fa fa-remove" style="line-height:25px"></i></a>
    </div>
</div>
<script> 
$(document).ready(function(){ 
	var ul = $(".bulletin-ul");
	var li = ul.children();
	if(li.length > 1){
		var liHight = $(li[0]).height();
		setInterval('AutoScroll(".bulletin",'+liHight+')',4000);
	}
});
function AutoScroll(obj,hight){ 
    $(obj).find("ul:first").animate({marginTop:"-"+hight+"px"},500,function(){ 
        $(this).css({marginTop:"0px"}).find("li:first").appendTo(this); 
    }); 
} 
</script>
<?php endif; ?> 