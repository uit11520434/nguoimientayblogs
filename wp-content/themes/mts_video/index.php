<?php
/**
 * The main template file.
 *
 * Used to display the homepage when home.php doesn't exist.
 */
?>
<?php $mts_options = get_option(MTS_THEME_NAME); ?>
<?php get_header(); ?>
<div id="page">
    <?php if($mts_options['mts_featured_slider'] == '1') { ?>
        <?php if (is_home() || is_front_page()) { ?>
            <?php if (!is_paged()) { ?>
                <div class="featured-posts">
                    <?php // prevent implode error
                        if (empty($mts_options['mts_featured_slider_cat']) || !is_array($mts_options['mts_featured_slider_cat'])) {
                            $mts_options['mts_featured_slider_cat'] = array('0');
                        }
                        $slider_cat = implode(",", $mts_options['mts_featured_slider_cat']);
                        $count = 1;
                        $featured_query = new WP_Query("cat=".$slider_cat."&orderby=date&order=DESC&showposts=7&ignore_sticky_posts=1");

                    if ($featured_query->have_posts()) : while ($featured_query->have_posts()) : $featured_query->the_post();
                        $mts_youtube_select = get_post_meta( get_the_ID(), 'youtube-select', true );
                        if($count == 1){ ?> 
                            <div class="featured-first">
                                <div class="featured-post featured-post-<?php echo $count; ?>">
                                    <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" class="featured-thumbnail">
                                        <?php the_post_thumbnail('video-slider-big',array('title' => ''));
                                        if ( has_post_format('video') ) {
                                            mts_watch_later_button();
                                        } 
                                        if ( has_post_format('video') ) { ?>
                                            <span class="play-btn">
                                                <i class="fa fa-play"></i>
                                            </span>
                                       <?php } ?>
                                        <header>
                                           <div class="header-featured">
                                                <h2 class="title">
                                                    <?php the_title(); ?>
                                                </h2>
                                                <?php if ( has_post_format('video') && $mts_youtube_select == 'video-id' ) { ?>
                                                    <span class="duration"><?php mts_video_duration(); ?></span>
                                                <?php } ?>
                                           </div>
                                        </header><!--.header-->
                                    </a>
                                </div><!--.post -->
                            </div>
                        <div class="featured-small">
                        <?php } else { ?>
                            <div class="featured-post featured-post-<?php echo $count; ?>">
                                <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" class="featured-thumbnail">
                                    <?php the_post_thumbnail('video-slider-small', array('title' => ''));
                                    if ( has_post_format('video') ) {
                                        mts_watch_later_button();
                                    }
                                    if ( has_post_format('video') ) { ?>
                                        <span class="play-btn">
                                            <i class="fa fa-play"></i>
                                        </span>
                                   <?php } ?>
                                    <header>
                                        <div class="header-featured">
                                            <h2 class="title">
                                                <?php the_title(); ?>
                                            </h2>
                                            <?php if ( has_post_format('video') && $mts_youtube_select == 'video-id' ) { ?>
                                                <span class="duration"><?php mts_video_duration(); ?></span>
                                            <?php } ?>
                                       </div>
                                    </header><!--.header-->
                                </a>
                            </div><!--.smallpost-->
                        <?php } $count++; endwhile; ?>
                        </div><!--.featured-small-->
                    <?php endif; wp_reset_query(); ?>
                </div><!-- .featured-posts -->
            <?php 
            }
        }
    } ?>
	<div class="home-posts-wrap">
        <div class="home-posts home-left <?php echo ($mts_options['mts_home_sidebar'] == 'sidebar') ? 'home-sidebar' : ''; ?>">
            <h2 class="home-title"><?php _e('New Videos','video'); ?></h2>
            <?php $j = 0; if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article class="latestPost excerpt" id="post-<?php the_ID(); ?>">
                    <?php mts_archive_post(); ?>
                </article>
            <?php endwhile; endif; ?>

            <!--Start Pagination-->
            <?php if (isset($mts_options['mts_pagenavigation_type']) && $mts_options['mts_pagenavigation_type'] == '1' ) {
                mts_pagination();
            } else { ?>
                <div class="pagination pagination-previous-next">
                    <ul>
                        <li class="nav-previous num-prev"><?php next_posts_link( '<i class="fa fa-angle-left"></i> ' ); ?></li>
                        <li class="nav-next num-next"><?php previous_posts_link( '<i class="fa fa-angle-right"></i>' ); ?></li>
                    </ul>
                </div>
            <?php } ?>
            <!--End Pagination-->
        </div><!--.home-posts-left-->
        <?php if ( $mts_options['mts_home_sidebar'] != 'sidebar' ) { ?>
            <div class="home-posts home-right">
                <h2 class="home-title">
                    <?php if ($mts_options['mts_home_sidebar'] == 'popular') {
                        _e('Most Popular','video'); 
                        $query_params = array(
                            'meta_key' => '_mts_view_count',
                            'orderby' => 'meta_value_num',
                            'order' => 'DESC',
                            'ignore_sticky_posts' => '1'
                        );
                        if (!empty($mts_options['mts_popular_days'])) {
                            $popular_days = (int) $mts_options['mts_popular_days'];
                            $query_params['date_query'] = array(
                                array(
                                    'after'     => "$popular_days days ago",
                                    'inclusive' => true,
                                ),
                            ); 
                        }
                        $my_query = new WP_Query($query_params);
                    } elseif ($mts_options['mts_home_sidebar'] == 'random') {
                        _e('Random Posts','video');
                        $my_query = new WP_Query('orderby=rand&ignore_sticky_posts=1');
                    } ?>
                </h2>
                <?php while ($my_query->have_posts()) : $my_query->the_post(); 
                $mts_youtube_select = get_post_meta( get_the_ID(), 'youtube-select', true ); ?>
                    <article class="latestPost excerpt">
                        <div class="home-thumb">
                            <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" class="featured-thumbnail">
                               <?php the_post_thumbnail('video-featured',array('title' => ''));
                               if ( has_post_format('video') ) mts_watch_later_button();
                               if ( has_post_format('video') && $mts_youtube_select == 'video-id' ) { ?>
                                    <span class="duration"><?php mts_video_duration(); ?></span>
                               <?php } ?>
                            </a>
                        </div>
                        <h2 class="home-post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                        <div class="home-content">
                            <?php echo mts_excerpt(14); ?>
                            <div class="views"><?php mts_video_views(); ?></div>
                        </div>
                    </article><!--.post excerpt-->
                <?php endwhile; wp_reset_query(); ?>
            </div><!--.home-posts-right-->
        <?php } else { get_sidebar(); } ?>
    </div><!--.home-posts-wrap-->
<?php get_footer(); ?>