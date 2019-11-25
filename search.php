<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>

<a href="<?php bloginfo('url') ?>" style="position:absolute;margin:30px 0 0 30px;z-index:1000;"><img src="<?php echo io_get_option('logo_normal') ?>" height="40" alt="<?php bloginfo('name') ?>"></a>
<div class="main-content">
	<?php include('search-tool.php'); ?>
	<div class="row">
		<div class="col-12 col-lg-8 mx-auto">
			<h4 class="text-gray"><i class="fa fa-search" style="margin-right: 27px;"></i>“<?php echo $s; ?>” <?php _e('的搜索结果','i_swallow'); ?></h4>
        	<div class="row">
                 
			<?php if ( !have_posts() ) : ?>
				<div class="col-lg-12">
            		<div class="nothing">没有内容</div>
          		</div>
    		<?php endif; ?>
			
			
    		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post();
			$link_url = get_post_meta($post->ID, '_sites_link', true); 
            $default_ico = get_template_directory_uri() .'/images/favicon.png';
			if(current_user_can('level_10') || get_post_meta($post->ID, '_visible', true)!="true"):
			?>
				<div class="xe-card col-sm-4 col-md-3">
            	  	<a href="<?php echo io_get_option('is_go')? '/go/?url='.base64_encode($link_url) : $link_url ?>" target="_blank" class="xe-widget xe-conversations box2 label-info" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo $link_url ?>">
            	    	<div class="xe-comment-entry">
                  			<div class="xe-user-img">
                  			  	<?php if(io_get_option('lazyload')): ?>
                  			  	<img class="img-circle lazy" src="images/favicon.png" data-src="<?php echo get_post_meta($post->ID, '_thumbnail', true)? get_post_meta($post->ID, '_thumbnail', true): ('//api.iowen.cn/favicon/'.format_url($link_url) . '.png') ?>" onerror="javascript:this.src='<?php echo $default_ico; ?>'" width="40">
                  			  	<?php else: ?>
                  			  	<img class="img-circle lazy" src="<?php echo get_post_meta($post->ID, '_thumbnail', true)? get_post_meta($post->ID, '_thumbnail', true): ('//api.iowen.cn/favicon/'.format_url($link_url) . '.png') ?>" onerror="javascript:this.src='<?php echo $default_ico; ?>'" width="40">
                  			  	<?php endif ?>
                  			</div>
            	    	  	<div class="xe-comment">
            	    	    	<div class="xe-user-name overflowClip_1">
            	    	      		<strong><?php the_title() ?></strong>
            	    	    	</div>
            	    	    	<p class="overflowClip_2"><?php echo get_post_meta($post->ID, '_sites_sescribe', true) ?></p>
            	    	  	</div>
            	    	</div>
            	  	</a>
            	</div>
    		<?php endif; endwhile; endif;?>
			</div> 
			<br /> 
			<div style="text-align:center;margin-top:50px;margin-bottom:30px;">
			<a href="<?php bloginfo('url') ?>" class="but-home ">返回主页</a>
			</div>
		</div>
	</div>
	
<?php
get_footer(); 