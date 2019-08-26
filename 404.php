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
include( 'header-nav.php' );
?>

<style type="text/css">
.data-null {text-align: center;padding:100px 0}
.data-null h1 {font-size: 6rem;padding: 0;}
.data-null .btn-home {color: #fff;position: relative;top: 0;padding: 10px 75px;background: #f1404b;font-weight: 600;border-radius: 900px;transition: .2s;box-shadow: 0px 5px 20px -3px rgba(249, 100, 90, .6);}
.data-null .btn-home:hover {top:2px;background:#333;box-shadow:none;transition:.2s}
.single-content input {height: 37px;line-height: 37px;font: 14px "Microsoft YaHei",Helvetica;padding: 2px 10px;background: #ebebeb;border: 1px solid #ebebeb;border-radius: 20px 0 0 20px;-webkit-appearance: none;}
.single-content #searchsubmit {overflow: visible;position: relative;border: 0;cursor: pointer;height: 37px;color: #fff;background: #f1404b;border-radius: 0 20px 20px 0;transition: .2s;}
.single-content #searchsubmit:hover {background: #333;}
.screen-reader-text{display: none;}
</style>

<div class="main-content">
			<div class="row">
				<div class="col-12 col-lg-12">
					<section class="data-null">
			            <h1 class="font-theme">404</h1>
			            <p><?php _e('抱歉，没有你要找的内容...','i_owen') ?></p>
                      	<div class="single-content">
							<?php get_search_form(); ?>
						</div> 
                      	<div style="margin-top: 30px">
							<a class="btn-home" href="<?php bloginfo('url'); ?>"><?php _e('返回首页','i_owen') ?></a>
                        </div>
			        </section>
				</div>
			</div>
<?php get_footer(); ?>