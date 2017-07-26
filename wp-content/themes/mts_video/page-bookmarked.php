<?php
/**
 * Template Name: Bookmarked Videos
 */
?>
<?php $mts_options = get_option(MTS_THEME_NAME); ?>
<?php get_header(); ?>
<div id="page">
	<div id="content_box">
		<div class="home-posts home-left">
			<h1 class="home-title">
				<span><?php _e("Bookmarked Videos", "video"); ?></span>
			</h1>
			<?php
				$bookmarked_videos = !empty($_COOKIE['bookmarked']) ? explode(',', $_COOKIE['bookmarked']) : array();
				if (!empty($bookmarked_videos)) {
				if (get_query_var('page') > 1) {
                    $paged = get_query_var('page');
                } elseif (get_query_var('paged')) {
                    $paged = get_query_var('paged');
                } else {
                    $paged = 1;
                }
				$my_query = new WP_Query(array('post__in' => $bookmarked_videos, 'ignore_sticky_posts' => 1, 'posts_per_page' => 10, 'paged' => $paged));
				$j = 0; if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post(); ?>
					<article class="latestPost excerpt  <?php echo (++$j % 3 == 0) ? 'last' : ''; ?>" itemscope itemtype="http://schema.org/BlogPosting">
						<div class="home-thumb">
	                        <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" class="featured-thumbnail">
	    					   <?php the_post_thumbnail('featured',array('title' => '')); ?>
	    					   <?php if ( has_post_format('video') ) { ?>
	    					   		<span class="duration"><?php mts_video_duration(); ?></span>
	    					   <?php } ?>
	                        </a>
	    				</div>
	    				<h2 class="home-post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
	    				<div class="home-content">
	    					<?php echo mts_excerpt(17); ?>
	    					<div class="views"><?php mts_video_views(); ?></div>
	    				</div>
					</article><!--.post excerpt-->
				<?php endwhile; ?>
				<!--Start Pagination-->
	            <?php if (isset($mts_options['mts_pagenavigation_type']) && $mts_options['mts_pagenavigation_type'] == '1' ) { ?>
	                <?php mts_pagination('', 3, $my_query); ?> 
				<?php } else { ?>
					<div class="pagination pagination-previous-next">
						<ul>
							<li class="nav-previous"><?php next_posts_link( '<i class="fa fa-angle-left"></i> '. __( 'Previous', 'video' ) ); ?></li>
							<li class="nav-next"><?php previous_posts_link( __( 'Next', 'video' ).' <i class="fa fa-angle-right"></i>' ); ?></li>
						</ul>
					</div>
				<?php } ?>
				<!--End Pagination-->
				<?php endif; ?>
			<?php } else { ?>
				<p class="no-bookmarked"><?php _e("No bookmarked videos. Use the Watch Later button to bookmark videos!", "video"); ?></p>
			<?php } ?>
		</div><!--.home-left-->
		<div class="home-posts home-right">
			<h2 class="home-title"><?php _e('Random Posts','video'); ?></h2>
			<?php
				$my_query = new WP_Query('orderby=rand&ignore_sticky_posts=1');
    			while ($my_query->have_posts()) : $my_query->the_post(); ?>
				<article class="latestPost excerpt  <?php echo (++$j % 3 == 0) ? 'last' : ''; ?>" itemscope itemtype="http://schema.org/BlogPosting">
					<div class="home-thumb">
                        <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" class="featured-thumbnail">
    					   <?php the_post_thumbnail('featured',array('title' => '')); ?>
    					   <?php if ( has_post_format('video') ) { ?>
    					   		<?php mts_watch_later_button(); ?>
    					   		<span class="duration"><?php mts_video_duration(); ?></span>
    					   <?php } ?>
                        </a>
    				</div>
    				<h2 class="home-post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
    				<div class="home-content">
    					<?php echo mts_excerpt(17); ?>
    					<div class="views"><?php mts_video_views(); ?></div>
    				</div>
				</article><!--.post excerpt-->
    		<?php endwhile; ?>
    		<?php wp_reset_query(); ?>
		</div><!--.home-right-->
	</div>
	<?php get_footer(); ?>