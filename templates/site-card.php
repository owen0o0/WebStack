<?php if ( ! defined( 'ABSPATH' ) ) { exit; }  ?>

              <?php
              $qrurl = $link_url ?: get_permalink($post->ID);
              $is_html = '';
              if(get_post_meta($post->ID, '_wechat_qr', true)){
                $qrurl="<img src='" . get_post_meta(get_the_ID(), '_wechat_qr', true) . "' width='128'>";
                $is_html = 'true';
              } else if($link_url=="") {
                $qrurl = '地址错误！';
              } else if(io_get_option('is_qr')) {
                $qrurl = "<img src='https://my.tv.sohu.com/user/a/wvideo/getQRCode.do?width=128&height=128&text=" . $link_url . "' width='128'>";
                $is_html = 'true';
              }
              
              $url = '';
              $blank = '_blank';
              if(io_get_option('details_page')){ 
                $url=get_permalink();
              }else{ 
                if($link_url==""){
                  $url = 'javascript:';
                  $blank = '';
                }else{
                  if(io_get_option('is_go'))
                    $url = '/go/?url='.base64_encode($link_url) ;
                  else
                    $url = $link_url;
                }
              }
              ?>
              <a href="<?php echo $url ?>" target="<?php echo $blank ?>" class="xe-widget xe-conversations box2 label-info" data-toggle="tooltip" data-placement="bottom" title="" data-html="<?php echo $is_html ?>" data-original-title="<?php echo $qrurl ?>">
                <div class="xe-comment-entry">
                  <div class="xe-user-img">
                    <?php if(io_get_option('lazyload')): ?>
                    <img class="img-circle lazy" src="<?php echo $default_ico; ?>" data-src="<?php echo get_post_meta($post->ID, '_thumbnail', true)? get_post_meta($post->ID, '_thumbnail', true): (io_get_option('ico_url') .format_url($link_url) . io_get_option('ico_png')) ?>" onerror="javascript:this.src='<?php echo $default_ico; ?>'" width="40">
                    <?php else: ?>
                    <img class="img-circle lazy" src="<?php echo get_post_meta($post->ID, '_thumbnail', true)? get_post_meta($post->ID, '_thumbnail', true): (io_get_option('ico_url') .format_url($link_url) . io_get_option('ico_png')) ?>" onerror="javascript:this.src='<?php echo $default_ico; ?>'" width="40">
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
