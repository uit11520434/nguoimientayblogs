<?php
/**
 * The template for displaying all single posts.
 */
get_header();
$mts_options = get_option(MTS_THEME_NAME);

$mts_video_service = get_post_meta( get_the_ID(), 'video-service', true );
$mts_youtube_select = get_post_meta( get_the_ID(), 'youtube-select', true );
$mts_playlist_id = get_post_meta( get_the_ID(), 'playlist-id', true );
$mts_vimeo_id = get_post_meta( get_the_ID(), 'vimeo-video-id', true );
$mts_dm_id = get_post_meta( get_the_ID(), 'dm-video-id', true );
$mts_facebook_id = get_post_meta( get_the_ID(), 'facebook-video-id', true );
$autoplay = ( isset( $mts_options['mts_autoplay'] ) && '1' === $mts_options['mts_autoplay'] );
$ap = get_post_meta( get_the_ID(), 'autoplay-video', true );
if ( !empty( $ap ) ) {
	$autoplay = ( 'yes' === $ap );
}
$start = get_post_meta( get_the_ID(), 'video-start-time', true );
$start = ( !empty($start) && '0' !== $start && is_numeric($start) ) ? round($start) : false;
$end = get_post_meta( get_the_ID(), 'video-end-time', true );
$end = ( !empty($end) && '0' !== $end && is_numeric($end) ) ? round($end) : false;
$show_related = ( 'yes' === get_post_meta( get_the_ID(), 'show-related', true ) );
?>
<div id="page" class="<?php mts_single_page_class(); ?>">
	<div class="<?php mts_article_class(); if(empty($mts_options['mts_related_posts'])) { echo " no-related-posts"; } ?>">
		<div id="content_box">
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class('g post'); ?>>
			<?php
			// custom single post layout
			global $post;
			$post_layout = get_post_meta( $post->ID, '_mts_post_layout', true );
			if (!empty($post_layout)) $mts_options['mts_single_post_layout'] = $post_layout;
			?>
			<?php if ( 'clsrlayout' === $mts_options['mts_single_post_layout'] ) : ?>
				<div class="main-article-container">
					<article class="single_post">
			<?php endif; ?>
				<div id="popup" class="popup-window">
					<i class="fa fa-times"></i>
					<h3><?php _e('Share','video'); ?></h3>
					<ul class="clearfix">
						<?php if ( ! empty( $mts_options['mts_social_buttons']['enabled'] ) ) mts_social_buttons(); ?>
					</ul>
					<?php if (function_exists('wp_get_shortlink')) { ?>
					<div class="post-shortlink">
						<input type='text' value='<?php echo wp_get_shortlink(get_the_ID()); ?>' onclick='this.focus(); this.select();' />
					</div>
					<?php } ?>
				</div><!--#popup-->
				<?php
				if ( in_array( $mts_video_service, array( 'vimeo', 'dailymotion', 'facebook' ) ) ) {

					if ( 'vimeo' === $mts_video_service && !empty( $mts_vimeo_id ) ) { //Vimeo ?>
						<div class="flex-video single-featured-video flex-video-vimeo">
							<iframe class="vimeo-video" src="https://player.vimeo.com/video/<?php echo trim($mts_vimeo_id); ?>?api=1&player_id=vimeo_video&title=1" width="100%" id="vimeo_video" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
						</div>
						<script type="text/javascript">
							(function( $ ) {
								var iframe = $('#vimeo_video')[0];
								var player = $f(iframe);
								player.addEvent('ready', function() {
									<?php if ($start) { ?>
										player.api('seekTo', <?php echo $start; ?>);
										<?php if ($autoplay) {?>
										player.api('play');
										<?php } ?>
									<?php } else {?>
										<?php if ($autoplay) {?>
											player.api('play');
										<?php } ?>
									<?php } ?>
									<?php if ($end) { ?>
										player.addEvent('playProgress', function(data) {
											if ( Math.round( data.seconds ) >= <?php echo $end; ?>) {
												player.api('unload');
												onVimeoFinish();
											}
										});
									<?php } else { ?>
										player.addEvent('finish', onVimeoFinish);
									<?php } ?>
								});
								function onVimeoFinish() {
									if ( jQuery('#mts_video_share_popup').length ) {
										jQuery('#mts_video_share_popup').bPopup();
									}
								}
								
							})( jQuery );
						</script>
						<?php

					} else if( 'dailymotion' === $mts_video_service &&  !empty( $mts_dm_id ) ) { //Dailymotion
						if ( isset( $mts_options['mts_dm_api_key'] ) && !empty( $mts_options['mts_dm_api_key'] ) ) {
							?>
							<div class="flex-video single-featured-video flex-video-dm">
							<div id="dmplayer"></div>
							</div>
							<script>
								window.dmAsyncInit = function() {
									DM.init({ apiKey: '<?php echo trim( $mts_options['mts_dm_api_key'] ); ?>', status: true, cookie: true });
									var dmplayer = DM.player(document.getElementById('dmplayer'), {
										video: '<?php echo trim($mts_dm_id); ?>',
										width: "100%",
										params: {
											autoplay: '<?php echo $autoplay;?>',
											<?php if ($start) { ?>
											start: <?php echo $start;?>,
											<?php } ?>
											<?php if (!$show_related) { ?>
											endscreen: false,
											<?php } ?>
										}
									});

									dmplayer.addEventListener('video_end', function (e) {
										onDMFinish();
									});

									<?php if ($end) { ?>
									dmplayer.addEventListener('timeupdate', function (e) {
										if ( Math.round( e.target.currentTime ) >= <?php echo $end; ?> ) {
											dmplayer.pause();
											onDMFinish();
										}
									});
									<?php } ?>

									function onDMFinish() {
										if ( jQuery('#mts_video_share_popup').length ) {
											jQuery('#mts_video_share_popup').bPopup();
										}
									}
								};
								(function() {
									var e = document.createElement('script');
									e.async = true;
									e.src = 'https://api.dmcdn.net/all.js';

									var s = document.getElementsByTagName('script')[0];
									s.parentNode.insertBefore(e, s);
								}());
							</script>
						<?php
						}
					} else if( !empty( $mts_facebook_id ) ) { //Facebook
						$fb_app_id = ( isset( $mts_options['mts_facebook_app_id'] ) && !empty( $mts_options['mts_facebook_app_id'] ) ) ? $mts_options['mts_facebook_app_id'] : '550258431816479';
						?>
						<div id="fb-root"></div>
						<script>
							window.fbAsyncInit = function() {
								FB.init({
									appId      : '<?php echo trim($fb_app_id); ?>',
									xfbml      : true,
									version    : 'v2.5',
								});

								// Get Embedded Video Player API Instance
								var my_video_player;
								FB.Event.subscribe('xfbml.ready', function(msg) {
									if (msg.type === 'video') {
										my_video_player = msg.instance;
										<?php if ($autoplay) {?>
										my_video_player.play();
										<?php } ?>
										var fbVideoPopup = my_video_player.subscribe('finishedPlaying', function(e) {
											if ( jQuery('#mts_video_share_popup').length ) {
												jQuery('#mts_video_share_popup').bPopup();
											}
										});
										<?php if ( $start ) { ?>
										var fbVideoStarted = false;
										var fbVideoStart = my_video_player.subscribe('startedPlaying', function(e) {
											if ( !fbVideoStarted ) {
												my_video_player.seek(<?php echo $start;?>);
												fbVideoStarted = true;
											}
										});
										<?php } ?>
									}
								});
							};

							(function(d, s, id){
								var js, fjs = d.getElementsByTagName(s)[0];
								if (d.getElementById(id)) {return;}
								js = d.createElement(s); js.id = id;
								js.src = "//connect.facebook.net/en_US/sdk.js";
								fjs.parentNode.insertBefore(js, fjs);
							}(document, 'script', 'facebook-jssdk'));
						</script>
						<!-- FB embedded video player code -->
						<div class="flex-video single-featured-video flex-video-fb">
							<div class="fb-video"  data-href="https://www.facebook.com/facebook/videos/<?php echo $mts_facebook_id; ?>/" data-allowfullscreen="true"></div>
						</div>
					<?php
					}
				} else if ( !empty( $mts_playlist_id ) ) { // Youtube
					// General Options
					$mts_youtube_api = ( isset( $mts_options['mts_youtube_api'] ) && !empty( $mts_options['mts_youtube_api'] ) ) ? $mts_options['mts_youtube_api'] : 'AIzaSyDcaTYgjaZ1SsJhwLMd5zjTZy8lSAACMnI';
					$mts_youtube_volume = isset( $mts_options['mts_youtube_volume'] ) ? $mts_options['mts_youtube_volume'] : 'auto';
					$volume = ( 'custom' === $mts_youtube_volume ) ? (int) $mts_options['mts_youtube_volume_custom']/100 : ( 'auto' === $mts_youtube_volume ? 'false' : 0 );
					$mts_youtube_force_hd = ( isset( $mts_options['mts_youtube_force_hd'] ) && '1' === $mts_options['mts_youtube_force_hd'] ) ? 'true' : 'false';
					$mts_youtube_play_controls = ( isset( $mts_options['mts_youtube_play_controls'] ) && '1' === $mts_options['mts_youtube_play_controls'] ) ? 'true' : 'false';
					$mts_youtube_full_screen = ( isset( $mts_options['mts_youtube_full_screen'] ) && '0' === $mts_options['mts_youtube_full_screen'] ) ? 'false' : 'true';
					$mts_youtube_logo = ( isset( $mts_options['mts_youtube_logo'] ) && '1' === $mts_options['mts_youtube_logo'] ) ? 'false' : 'true';
					$mts_playlist_annotations = ( isset( $mts_options['mts_youtube_anotations'] ) && '1' === $mts_options['mts_youtube_anotations'] ) ? 'true' : 'false';
					$mts_show_channel_in_title = ( isset( $mts_options['mts_show_channel_in_title'] ) && '1' === $mts_options['mts_show_channel_in_title'] ) ? 'true' : 'false';
					// Paylist
					$mts_playlist_layout = isset( $mts_options['mts_playlist_layout'] ) ? $mts_options['mts_playlist_layout'] : 'vertical';
					$mts_playlist_video_no = ( isset( $mts_options['mts_playlist_video_no'] ) && !empty( $mts_options['mts_playlist_video_no'] ) ) ? (int) $mts_options['mts_playlist_video_no'] : 10;
					$mts_playlist_loadmore = ( isset( $mts_options['mts_playlist_loadmore'] ) && '0' === $mts_options['mts_playlist_loadmore'] ) ? 'false' : 'true';
					$mts_continuouse_play = ( isset( $mts_options['mts_continuouse_play'] ) && '0' === $mts_options['mts_continuouse_play'] ) ? 'false' : 'true';
					$mts_playlist_shuffle = ( isset( $mts_options['mts_playlist_shuffle'] ) && '1' === $mts_options['mts_playlist_shuffle'] ) ? 'true' : 'false';
					$mts_player_color_scheme = isset( $mts_options['mts_player_color_scheme'] ) ? $mts_options['mts_player_color_scheme'] : 'black';
					?>
					<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery('#myList').youtube_video({
								<?php if ( $mts_youtube_select == 'video-id') { ?>
									videos: '<?php echo $mts_playlist_id; ?>',
									show_playlist: false,
									continuous: false,
								<?php } else { ?>
									playlist: '<?php echo $mts_playlist_id; ?>',
									playlist_type:  '<?php echo $mts_playlist_layout; ?>',
									max_results: <?php echo $mts_playlist_video_no; ?>,
									pagination: <?php echo $mts_playlist_loadmore; ?>,
									continuous: <?php echo $mts_continuouse_play; ?>,
									shuffle: <?php echo $mts_playlist_shuffle; ?>,
								<?php } ?>
									show_channel_in_title: <?php echo $mts_show_channel_in_title; ?>,
									share_control: false,
									api_key: '<?php echo $mts_youtube_api; ?>',
									youtube_link_control: false,
									now_playing_text: '<?php echo esc_js(__('Now Playing','video')); ?>',
									load_more_text: '<?php echo esc_js(__('Load More','video')); ?>',
									volume: <?php echo $volume; ?>,
									autoplay: '<?php echo $autoplay; ?>',
									force_hd: <?php echo $mts_youtube_force_hd; ?>,
									show_controls_on_play: <?php echo $mts_youtube_play_controls; ?>,
									fullscreen_control: <?php echo $mts_youtube_full_screen; ?>,
									hide_youtube_logo: <?php echo $mts_youtube_logo; ?>,
									show_annotations: <?php echo $mts_playlist_annotations; ?>,
									colors: <?php mts_youtube_player_colors( $mts_player_color_scheme ); ?>,
									on_state_change: function(state) {
										if ( 0 == state && jQuery('#mts_video_share_popup').length ) {
											jQuery('#mts_video_share_popup').bPopup();
										}
									},
									<?php if ($start) { ?>
									start: <?php echo $start;?>,
									<?php } ?>
									<?php if ($end) { ?>
									end: <?php echo $end;?>,
									<?php } ?>
									showRelated: '<?php echo $show_related; ?>'
							});
						});
					</script>
					<div id="myList"></div>
					<?php if (has_post_thumbnail() && $mts_options['mts_custom_thumbnail'] == '1') {
						$videoimage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
						?>
						<style type="text/css">
							#myList .yesp-autoposter { background-image: url(<?php echo $videoimage[0]; ?>)!important; background-repeat: no-repeat; }
						</style>
					<?php }
				}
				if(has_post_format( 'video' )) { ?>
					<header class="main-post-header">
						<h1 class="title single-title entry-title"><span><?php the_title(); ?></span><?php if ( has_post_format('video') && $mts_youtube_select == 'video-id' && !in_array( $mts_video_service, array( 'vimeo', 'dailymotion', 'facebook' ) ) ) { ?><span class="single-duration"><?php mts_video_duration(0, false); ?></span><?php } ?></h1>
						<div class="single-buttons">
							<ul>
								<li class="single-views"><?php mts_video_views(); ?></li>
								<?php if ( ! empty( $mts_options['mts_social_buttons']['enabled'] ) ) { ?>
									<li class="share-button"><span><i class="fa fa-send"></i><?php _e('Share','video'); ?></span></li>
								<?php } ?>
								<?php if ( !empty($mts_options['mts_like_dislike'])) { 
									mts_like_dislike();
								} ?>
							</ul>
						</div>
					</header><!--.headline_area-->
				<?php } ?>
				
				<?php if ($mts_options['mts_breadcrumb'] == '1') { ?>
					<div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#"><?php mts_the_breadcrumb(); ?></div>
				<?php } ?>
				<?php if ( 'clsrlayout' !== $mts_options['mts_single_post_layout'] ) : ?>
				<div class="main-article-container">
					<article class="single_post">
				<?php endif; ?>
						<div class="post-single-content box mark-links entry-content">
							<?php if(!has_post_format( 'video' )) { ?>
								<header class="main-post-header">
									<h1 class="title single-title entry-title"><span><?php the_title(); ?></span></h1>
								</header>
							<?php } ?>
							<div class="post-top">
								<?php if( !empty( $mts_options["mts_single_headline_meta_info"]['date']) && !empty($mts_options["mts_single_headline_meta"]) ) { ?>
									<div class="publish-date">
										<?php _e('Published on ','video'); the_time(get_option( 'date_format' )); ?>
									</div>
								<?php } ?>
								<?php if(has_post_format( 'video' )) { ?>
									<div class="post-toggle"><i class="fa fa-angle-down"></i></div>
								<?php } ?>
							</div><!--.post-top-->
							<?php if ($mts_options['mts_posttop_adcode'] != '') { ?>
								<?php $toptime = $mts_options['mts_posttop_adcode_time']; if (strcmp( date("Y-m-d", strtotime( "-$toptime day")), get_the_time("Y-m-d") ) >= 0) { ?>
									<div class="topad">
										<?php echo do_shortcode($mts_options['mts_posttop_adcode']); ?>
									</div>
								<?php } ?>
							<?php } ?>
							<div class="togglecontent">
								<div class="thecontent">
									<?php the_content(); ?>
								</div>
								<?php wp_link_pages(array('before' => '<div class="pagination">', 'after' => '</div>', 'link_before'  => '<span class="current"><span class="currenttext">', 'link_after' => '</span></span>', 'next_or_number' => 'next_and_number', 'nextpagelink' => __('Next','video'), 'previouspagelink' => __('Previous','video'), 'pagelink' => '%','echo' => 1 )); ?>

								<?php if(!empty($mts_options["mts_single_headline_meta"])) { ?>
								<div class="post-meta">
									<?php if( !empty( $mts_options["mts_single_headline_meta_info"]['category']) ) { ?>
										<span class="post-cat"><?php _e('Category: ','video'); the_category(', '); ?></span>
									<?php } ?>
									<?php if ( !empty( $mts_options["mts_single_headline_meta_info"]['author']) ) { ?>
										<?php
										$author = '<a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'">'.get_the_author_meta( 'display_name' ).'</a>';
										$meta_author = get_post_meta( get_the_id(), 'submitted-by', true );
										if (!empty($meta_author)) $author = $meta_author;
										?>
										<span class="post-author"><?php _e('Submitted by: ','video'); echo $author; ?></span>
									<?php } ?>
								</div><!--.post-meta-->
								<?php } ?>
							</div><!--.togglecontent-->

							<?php if ($mts_options['mts_postend_adcode'] != '') { ?>
								<?php $endtime = $mts_options['mts_postend_adcode_time']; if (strcmp( date("Y-m-d", strtotime( "-$endtime day")), get_the_time("Y-m-d") ) >= 0) { ?>
									<div class="bottomad">
										<?php echo do_shortcode($mts_options['mts_postend_adcode']); ?>
									</div>
								<?php } ?>
							<?php } ?> 
							
							<?php if($mts_options['mts_tags'] == '1') { ?>
								<div class="tags"><?php mts_the_tags('<span class="tagtext">'.__('Tags','video').':</span>',', ') ?></div>
							<?php } ?>

							<?php if($mts_options['mts_author_box'] == '1') { ?>
								<div class="postauthor">
									<h4><?php _e('About The Author', 'video'); ?></h4>
									<div class="postauthor-box">
										<?php if(function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '70' );  } ?>
										<h5 class="vcard"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="nofollow" class="fn"><?php the_author_meta( 'display_name' ); ?></a></h5>
										<p><?php the_author_meta('description') ?></p>
									</div>
								</div>
							<?php } ?>

							<?php comments_template( '', true ); ?>
							<?php
							if ($mts_options['mts_single_post_layout'] == 'crlayout' || $mts_options['mts_single_post_layout'] == 'clsrlayout' ) {
								mts_related_posts();
							}
							?>
						</div><!--.post-single-content-->
					</article><!--.single_post-->
					<?php
					if ($mts_options['mts_single_post_layout'] == 'crlayout' || $mts_options['mts_single_post_layout'] == 'clsrlayout' ) {
						get_sidebar();
					}
					?>
					<?php
					if ( $mts_options['mts_single_post_layout'] == 'cbrlayout' || $mts_options['mts_single_post_layout'] == 'rclayout' ) {
						mts_related_posts();
					}
					?>
				</div>
			</div><!--.g post-->
		<?php endwhile; /* end loop */ ?>
		</div><!--#content_box-->
	</div>
<?php get_footer(); ?>