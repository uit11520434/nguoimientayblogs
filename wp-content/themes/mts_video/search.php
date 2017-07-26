<?php
/**
 * The template for displaying search results pages.
 */
?>
<?php $mts_options = get_option(MTS_THEME_NAME); ?>
<?php get_header(); ?>
<div id="page">
	<div class="article">
		<div id="content_box">
			<div class="home-posts home-left <?php echo ($mts_options['mts_archive_sidebar'] == 'sidebar') ? 'home-sidebar' : ''; ?>">
				<h1 class="home-title">
					<span><?php _e("Search Results for:", "video"); ?></span> <?php the_search_query(); ?>
				</h1>
				<?php $j = 0; if (have_posts()) : while (have_posts()) : the_post();
				$mts_youtube_select = get_post_meta( get_the_ID(), 'youtube-select', true ); ?>
					<article class="latestPost excerpt  <?php echo (++$j % 3 == 0) ? 'last' : ''; ?>">
						<?php mts_archive_post(); ?>
					</article><!--.post excerpt-->
				<?php endwhile; else: ?>
					<div class="no-results">
						<h2><?php _e('We apologize for any inconvenience, please hit back on your browser or use the search form below.', 'video'); ?></h2>
						<?php get_search_form(); ?>
					</div><!--noResults-->
				<?php endif; ?>

				<!--Start Pagination-->
	            <?php if (isset($mts_options['mts_pagenavigation_type']) && $mts_options['mts_pagenavigation_type'] == '1' ) { ?>
	                <?php mts_pagination(); ?> 
				<?php } else { ?>
					<div class="pagination pagination-previous-next">
						<ul>
							<li class="nav-previous"><?php next_posts_link( '<i class="fa fa-angle-left"></i> '. __( 'Previous', 'video' ) ); ?></li>
							<li class="nav-next"><?php previous_posts_link( __( 'Next', 'video' ).' <i class="fa fa-angle-right"></i>' ); ?></li>
						</ul>
					</div>
				<?php } ?>
				<!--End Pagination-->
			</div><!--.home-left-->
			<?php if ($mts_options['mts_archive_sidebar'] != 'sidebar') { ?>
				<div class="home-posts home-right">
	                <h2 class="home-title">
	                    <?php if ($mts_options['mts_archive_sidebar'] == 'popular') {
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
	                    } elseif ($mts_options['mts_archive_sidebar'] == 'random') {
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
	                               mts_watch_later_button();
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
			<?php } else {
				get_sidebar();
			} ?>
		</div>
	</div>
<?php get_footer(); ?>