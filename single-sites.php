<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>


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
<div class="main-content page">
    
<?php include( 'templates/header-banner.php' ); ?>

    <div class="container">
	    <div class="row mt-5 mt-sm-0">
	    	<div class="col-12 mx-auto">
                <div class="panel panel-default"> 
                    <div class="panel-body my-4 ">
                    <?php while( have_posts() ): the_post();?>
                        <div class="row">
	    					<div class="col-12 col-sm-4 col-lg-3">
                                <?php 
                                $m_link_url = get_post_meta($post->ID, '_sites_link', true); 
                                if($m_link_url == '')
                                    $imgurl = get_template_directory_uri() .'/images/favicon.png';
                                else
                                    $imgurl = get_post_meta(get_the_ID(), '_thumbnail', true)? get_post_meta(get_the_ID(), '_thumbnail', true): (io_get_option('ico_url') .format_url($m_link_url) . io_get_option('ico_png'));
                                $sitetitle = get_the_title();
                                ?>
                                <div class="siteico">
                                    <div class="blur blur-layer" style="background: transparent url(<?php echo $imgurl ?>) no-repeat center center;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;animation: rotate 30s linear infinite;"></div>
                                    <img class="img-cover" src="<?php echo $imgurl ?>" alt="<?php echo $sitetitle ?>" title="<?php echo $sitetitle ?>">
                                </div>
	    					</div>
	    					<div class="col-12 col-sm-8 col-lg-9 mt-4 mt-md-0">
	    						<div class="site-body p-xl-4">
                                    <?php 
                                    $terms = get_the_terms( get_the_ID(), 'favorites' );
                                    if( !empty( $terms ) ){
                                    	foreach( $terms as $term ){
                                            $name = $term->name;
                                            $link = esc_url( get_term_link( $term, 'res_category' ) );
                                            echo " <a class='btn-cat' href='$link'>".$name."</a>";
                                        }
                                    }  
                                    ?>
                                    <div class="site-name h3"><?php echo $sitetitle ?></div>
                                    <div class="mt-2">
                                
	    									<p><?php echo get_post_meta(get_the_ID(), '_sites_sescribe', true) ?></p>
                                         <?php 
                                         $qrurl="https://my.tv.sohu.com/user/a/wvideo/getQRCode.do?width=150&height=150&text=". $m_link_url;
                                         $qrname = "手机查看";
                                         if(get_post_meta(get_the_ID(), '_wechat_qr', true)){
                                            $qrurl=get_post_meta(get_the_ID(), '_wechat_qr', true);
                                            $qrname = "公众号";
                                         } 
                                         ?>
	    								<div class="site-go mt-3">
                                        <?php if($m_link_url!=""): ?>
	    								<a style="margin-right: 10px;" href="<?php echo io_get_option('is_go')? '/go/?url='.base64_encode($m_link_url) : $m_link_url ?>" title="<?php echo $sitetitle ?>" target="_blank" class="btn btn-arrow"><span>链接直达<i class="fa fa-angle-right"></i></span></a>
                                        <?php endif; ?>
                                        <a href="javascript:" class="btn btn-arrow"  data-toggle="tooltip" data-placement="bottom" title="" data-html="true" data-original-title="<img src='<?php echo $qrurl ?>' width='150'>"><span><?php echo $qrname ?><i class="fa fa-qrcode"></i></span></a>
	    								</div>
	    							</div>

	    						</div>
	    					</div>
                        </div>
                        <div class="mt-4 pt-4 border-top">
                            <?php  
                            $contentinfo = get_the_content();
                            if( $contentinfo ){
                                the_content();   
                            }else{
                                echo "暂无介绍内容，请编辑添加";
                            }
                            ?>

                        </div>
                    <?php endwhile; ?>
                    </div>
                        <?php edit_post_link(__('编辑','i_owen'), '<span class="edit-link">', '</span>' ); ?>
                </div>

                <h4 class="text-gray mt-4"><i class="icon-io-tag" style="margin-right: 27px;" id="相关导航"></i>相关导航</h4>
                <div class="row mb-5"> 
                    <?php
                    $post_num = 6;
                    $i = 0;
                    if ($i < $post_num) {
                        $custom_taxterms = wp_get_object_terms( $post->ID,'favorites', array('fields' => 'ids') );
                        $args = array(
                        'post_type' => 'sites',// 文章类型
                        'post_status' => 'publish',
                        'posts_per_page' => 6, // 文章数量
                        'orderby' => 'rand', // 随机排序
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'favorites', // 分类法
                                'field' => 'id',
                                'terms' => $custom_taxterms
                            )
                        ),
                        'post__not_in' => array ($post->ID), // 排除当前文章
                        );
                        $related_items = new WP_Query( $args ); 
                        if ($related_items->have_posts()) :
                            while ( $related_items->have_posts() ) : $related_items->the_post();
                            $link_url = get_post_meta($post->ID, '_sites_link', true); 
                            $default_ico = get_template_directory_uri() .'/images/favicon.png';
                            if(current_user_can('level_10') || get_post_meta($post->ID, '_visible', true)!="true"):
                            ?>
                                <div class="xe-card col-sm-6 col-md-4 <?php echo get_post_meta($post->ID, '_wechat_qr', true)? 'wechat':''?>">
                                <?php include( 'templates/site-card.php' ); ?>
                                </div>
                            <?php endif; $i++; endwhile; endif; wp_reset_postdata();
                    }
                    if ($i == 0) echo '<div class="col-lg-12"><div class="nothing">没有相关内容!</div></div>';
                    ?>
                </div>
                <br /> 

	    	</div>
        </div>
    </div>
<?php get_footer(); ?>