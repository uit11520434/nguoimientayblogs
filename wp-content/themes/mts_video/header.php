<?php
/**
 * The template for displaying the header.
 *
 * Displays everything from the doctype declaration down to the navigation.
 */
?>
<!DOCTYPE html>
<?php $mts_options = get_option(MTS_THEME_NAME); ?>
<html class="no-js" <?php language_attributes(); ?>>
<head itemscope itemtype="http://schema.org/WebSite">
	<meta charset="<?php bloginfo('charset'); ?>">
	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
	<!--[if IE ]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<![endif]-->
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<?php mts_meta(); ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>
<body id="blog" <?php body_class('main'); ?> itemscope itemtype="http://schema.org/WebPage">       
	<div class="main-container">
		<header id="site-header" role="banner" itemscope itemtype="http://schema.org/WPHeader">
			<?php if( $mts_options['mts_sticky_nav'] == '1' ) { ?>
				<div id="catcher" class="clear" style="height: 70px;"></div>
				<div id="header" class="sticky-navigation">
			<?php } else { ?>
				<div id="header">
			<?php } ?>
				<div class="container">
					<div class="logo-wrap">
						<?php if ($mts_options['mts_logo'] != '') { ?>
							<?php
							$logo_id = mts_get_image_id_from_url( $mts_options['mts_logo'] );
							$logo_w_h = '';
							if ( $logo_id ) {
	        					$logo     = wp_get_attachment_image_src( $logo_id, 'full' );
	        					$logo_w_h = ' width="'.$logo[1].'" height="'.$logo[2].'"';
	        				}
        					?>
							<?php if( is_front_page() || is_home() || is_404() ) { ?>
									<h1 id="logo" class="image-logo" itemprop="headline">
										<a href="<?php echo esc_url( home_url() ); ?>"><img src="<?php echo esc_url( $mts_options['mts_logo'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"<?php echo $logo_w_h; ?><?php if (!empty($mts_options['mts_logo2x'])) { echo ' data-at2x="'.esc_attr( $mts_options['mts_logo2x'] ).'"'; } ?>></a>
									</h1><!-- END #logo -->
							<?php } else { ?>
									<h2 id="logo" class="image-logo" itemprop="headline">
										<a href="<?php echo esc_url( home_url() ); ?>"><img src="<?php echo esc_url( $mts_options['mts_logo'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"<?php echo $logo_w_h; ?><?php if (!empty($mts_options['mts_logo2x'])) { echo ' data-at2x="'.esc_attr( $mts_options['mts_logo2x'] ).'"'; } ?>></a>
									</h2><!-- END #logo -->
							<?php } ?>
						<?php } else { ?>
							<?php if( is_front_page() || is_home() || is_404() ) { ?>
									<h1 id="logo" class="text-logo" itemprop="headline">
										<a href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a>
									</h1><!-- END #logo -->
							<?php } else { ?>
								  <h2 id="logo" class="text-logo" itemprop="headline">
										<a href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a>
									</h2><!-- END #logo -->
							<?php } ?>
						<?php } ?>
					</div>
					<?php if ( $mts_options['mts_show_primary_nav'] == '1' ) { ?>
						<div id="secondary-navigation" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
							<a href="#" id="pull" class="toggle-mobile-menu"><?php _e('Menu', 'video' ); ?></a>
							<ul class="nav navbar-nav hidden-xs nav-search-box">
	                            <li class="main-menu-item">
	                            	<?php if ( is_active_sidebar( 'search_sidebar' ) ) : ?>
	                                	<?php dynamic_sidebar( 'search_sidebar' ); ?>
									<?php else: ?>
	                                    <form class="<?php echo $topnav_style=='light'?'light-form':''; ?> dark-form" action="<?php echo home_url() ?>">
	                                        <div class="input-group">
	                                            <input type="text" name="s" class="form-control" placeholder="<?php echo __('Search...','video');?>">
	                                            <span class="input-group-btn">
	                                                <button class="btn btn-default maincolor1 maincolor1hover" type="submit"><i class="fa fa-search"></i></button>
	                                            </span>
	                                        </div>
	                                    </form>
	                                <?php endif; ?>
	                            </li>
                        	</ul>
							<?php if ( has_nav_menu( 'mobile' ) ) { ?>
								<nav class="navigation clearfix">
									<?php if ( has_nav_menu( 'secondary-menu' ) ) { ?>
										<?php wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'menu_class' => 'menu clearfix', 'container' => '', 'walker' => new mts_menu_walker ) ); ?>
									<?php } else { ?>
										<ul class="menu clearfix">
											<?php wp_list_categories('title_li='); ?>
										</ul>
									<?php } ?>
								</nav>
								<nav class="navigation mobile-only clearfix mobile-menu-wrapper">
									<?php wp_nav_menu( array( 'theme_location' => 'mobile', 'menu_class' => 'menu clearfix', 'container' => '', 'walker' => new mts_menu_walker ) ); ?>
								</nav>
							<?php } else { ?>
								<nav class="navigation clearfix mobile-menu-wrapper">
									<?php if ( has_nav_menu( 'secondary-menu' ) ) { ?>
										<?php wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'menu_class' => 'menu clearfix', 'container' => '', 'walker' => new mts_menu_walker ) ); ?>
									<?php } else { ?>
										<ul class="menu clearfix">
											<?php wp_list_categories('title_li='); ?>
										</ul>
									<?php } ?>
								</nav>
							<?php } ?>
						</div><!--#secondary-navigation-->
					<?php } ?>
					<?php if( $mts_options['mts_show_header_url']  == '1' ) { ?>
						<div class="video-header-url">
							<a href="<?php echo isset( $mts_options['mts_header_url_link'] ) ? $mts_options['mts_header_url_link'] : ""; ?>"><?php echo isset( $mts_options['mts_header_url_text'] ) ? $mts_options['mts_header_url_text'] : ""; ?> <i class="fa fa-<?php echo isset( $mts_options['mts_header_url_icon'] ) ? $mts_options['mts_header_url_icon'] : ""; ?>"></i></a>
						</div>
					<?php } ?>
					<?php if (!empty($mts_options['mts_header_buttons'])) { ?>
						<div class="header-signbtn">
							<?php foreach ($mts_options['mts_header_buttons'] as $button) { ?>
								<a href="<?php echo $button['mts_header_button_link']; ?>" <?php if (!empty($button['mts_header_button_color'])) { ?>style="background: <?php echo $button['mts_header_button_color']; ?>;"<?php } ?>>
									<?php if (!empty($button['mts_header_button_icon'])) { ?>
										<i class="fa fa-<?php echo $button['mts_header_button_icon']; ?>"></i>
									<?php } ?>	
								</a>
							<?php } ?> 
						</div> 
					<?php } ?>
					<?php if (!empty($mts_options['mts_cart_links'])) mts_cart(); ?>
				</div><!--.container-->
			</div><!--#header-->  
		</header>
		<?php if (!empty($mts_options['mts_header_adcode'])) { ?>
			<div class="header-ad">
				<?php echo do_shortcode($mts_options['mts_header_adcode']); ?>
			</div>
		<?php } ?>