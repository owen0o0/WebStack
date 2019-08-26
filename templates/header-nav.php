        <div class="sidebar-menu toggle-others fixed">
            <div class="sidebar-menu-inner">
                <header class="logo-env">
                    <!-- logo -->
                    <div class="logo">
                        <a href="<?php bloginfo('url') ?>" class="logo-expanded">
                            <img src="<?php echo io_get_option('logo_normal') ?>" height="40" alt="<?php bloginfo('name') ?>" />
                        </a>
                        <a href="<?php bloginfo('url') ?>" class="logo-collapsed">
                            <img src="<?php echo io_get_option('logo_small') ?>" height="40" alt="<?php bloginfo('name') ?>">
                        </a>
                    </div>
                    <div class="mobile-menu-toggle visible-xs">
                        <a href="#" data-toggle="mobile-menu">
                            <i class="fa-bars"></i>
                        </a>
                    </div>
                </header>
                <ul id="main-menu" class="main-menu">
                <?php
                foreach($categories as $category) {
                    if($category->category_parent == 0){
                        $children = get_categories(array(
                            'taxonomy'   => 'favorites',
                            'meta_key'   => '_term_order',
                            'orderby'    => 'meta_value_num',
                            'order'      => 'desc',
                            'child_of'   => $category->term_id,
                            'hide_empty' => 0)
                        );
                        if(empty($children)){ ?>
                        <li>
                            <a href="<?php if (is_home() || is_front_page()): ?><?php else: ?>/<?php endif; ?>#<?php echo $category->name;?>" class="smooth">
                               <i class="fa <?php echo $category->description ?> fa-fw"></i>
                               <span class="title"><?php echo $category->name; ?></span>
                            </a>
                        </li> 
                        <?php }else { ?>
                        <li>
                            <a>
                               <i class="fa <?php echo $category->description ?> fa-fw"></i>
                               <span class="title"><?php echo $category->name; ?></span>
                            </a>
                            <ul>
                                <?php foreach ($children as $mid) { ?>

                                <li>
                                    <a href="<?php if (is_home() || is_front_page()): ?><?php else: ?>/<?php endif; ?>#<?php  echo $mid->name ;?>" class="smooth"><?php echo $mid->name; ?></a>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php }
                    }
                }
                ?> 

                     <li class="submit-tag">
                     <?php
                        if(function_exists('wp_nav_menu')) wp_nav_menu( array('container' => false, 'items_wrap' => '%3$s', 'theme_location' => 'nav_main',) ); 
                     ?>
                    </li>
                </ul>
            </div>
        </div>