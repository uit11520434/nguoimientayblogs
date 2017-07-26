<?php
/**
 * The template for displaying 404 (Not Found) pages.
 */
?>
<?php get_header(); ?>
<div id="page">
	<article class="article">
		<div id="content_box" >
			<div class="single_page">
				<header>
					<div class="title">
						<h1><?php _e('Error 404 Not Found', 'video' ); ?></h1>
					</div>
				</header>
				<div class="post-content">
					<p><?php _e('Oops! We couldn\'t find this Page.', 'video' ); ?></p>
					<p><?php _e('Please check your URL or use the search form below.', 'video' ); ?></p>
					<?php get_search_form();?>
				</div><!--.post-content--><!--#error404 .post-->
			</div><!--#content-->
			<?php get_sidebar(); ?>
		</div>
	</article>
<?php get_footer(); ?>