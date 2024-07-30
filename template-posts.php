<?php
/*
Template Name: 文章列表
*/

get_header(); 

include( 'templates/header-nav.php' );

// 获取文章列表

$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
$args = array(
    'ignore_sticky_posts' => 1,
    'paged' => $paged,
);

if(isset($_GET['cat']))
    $args['cat'] = $_GET['cat'];
$args = apply_filters('io_blog_post_query_var_filters', $args);
query_posts( $args );


?>
<div class="main-content page">
<?php include( 'templates/header-banner.php' ); ?>
    <div class="container">
	    <div class="row mt-5 mt-sm-0">
	    	<div class="col-12 mx-auto">
                <div class="panel panel-default">
                    <div class="cat_list">
                    <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post();?>
                    <div class="list-content my-3 pb-4">
                    <h2 class="post-title">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="list-title text-lg overflowClip_2"><?php the_title(); ?></a>
                    </h2>
                    <div class="post-meta d-flex align-items-center text-muted text-xs">
                        <?php
                        $category = get_the_category();
                        if($category[0]){   ?>
                        <span><i class="fa fa-folder mr-1"></i>
                            <a href="<?php echo get_category_link($category[0]->term_id ) ?>"><?php echo $category[0]->cat_name ?></a>
                        </span>
                        <?php } ?>
                        <span class="ml-auto"><i class="fa fa-calendar mr-1"></i>
                            <time class="mx-1"><?php echo get_the_time('Y-m-d G:i') ?></time>
                        </span>
                    </div>
                    <div class="list-desc text-sm text-secondary my-4">
                        <div class="overflowClip_2 "><?php echo io_get_excerpt(150) ?></div>
                    </div>
                    </div> 
                    <?php endwhile; endif;?>
                    </div>
	                <div class="posts-nav">
	                <?php echo paginate_links(array(
	                    'prev_next'          => 0,
	                    'before_page_number' => '',
	                    'mid_size'           => 2,
	                ));?>
	                </div>
                </div>
	    	</div>
	    </div>
    </div>

<?php get_footer(); ?>
