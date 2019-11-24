<?php  if ( ! defined( 'ABSPATH' ) ) { exit; }
function fav_con($mid) { ?>
        <h4 class="text-gray"><i class="icon-io-tag" style="margin-right: 27px;" id="<?php echo $mid->name; ?>"></i><?php echo $mid->name; ?></h4>
        <div class="row">
        <?php   
          //定义$post为全局变量，这样之后的输出就不会是同一篇文章了
          global $post;
          //下方的posts_per_page设置最为重要
          $args = array(
            'post_type'           => 'sites',        //自定义文章类型，这里为sites
            'ignore_sticky_posts' => 1,              //忽略置顶文章
            'posts_per_page'      => -1,             //显示的文章数量
            'meta_key'            => '_sites_order',
            'orderby'             => 'meta_value_num',
            'tax_query'           => array(
                array(
                    'taxonomy' => 'favorites',       //分类法名称
                    'field'    => 'id',              //根据分类法条款的什么字段查询，这里设置为ID
                    'terms'    => $mid->term_id,     //分类法条款，输入分类的ID，多个ID使用数组：array(1,2)
                )
            ),
          );
          $myposts = new WP_Query( $args );
          if(!$myposts->have_posts()): ?>
          <div class="col-lg-12">
            <div class="nothing">没有内容</div>
          </div>
          <?php
          elseif ($myposts->have_posts()): while ($myposts->have_posts()): $myposts->the_post(); 
            $link_url = get_post_meta($post->ID, '_sites_link', true); 
            $default_ico = get_template_directory_uri() .'/images/favicon.png';
            if(current_user_can('level_10') || get_post_meta($post->ID, '_visible', true)!="true"):
          ?>
            <div class="xe-card <?php echo io_get_option('columns') ?>">
              <a href="<?php echo io_get_option('is_go')? '/go/?url='.base64_encode($link_url) : $link_url ?>" target="_blank" class="xe-widget xe-conversations box2 label-info" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo $link_url ?>">
                <div class="xe-comment-entry">
                  <div class="xe-user-img">
                    <?php if(io_get_option('lazyload')): ?>
                    <img class="img-circle lazy" src="<?php echo $default_ico; ?>" data-src="<?php echo get_post_meta($post->ID, '_thumbnail', true)? get_post_meta($post->ID, '_thumbnail', true): ('//api.iowen.cn/favicon/'.format_url($link_url) . '.png') ?>" onerror="javascript:this.src='<?php echo $default_ico; ?>'" width="40">
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
          <?php endif; endwhile; endif; wp_reset_postdata(); ?>
        </div>   
        <br /> 
<?php } ?>