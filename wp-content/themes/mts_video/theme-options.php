<?php

defined('ABSPATH') or die;

/*
 * 
 * Require the framework class before doing anything else, so we can use the defined urls and dirs
 *
 */
require_once( dirname( __FILE__ ) . '/options/options.php' );
/*
 * 
 * Custom function for filtering the sections array given by theme, good for child themes to override or add to the sections.
 * Simply include this function in the child themes functions.php file.
 *
 * NOTE: the defined constants for urls, and dir will NOT be available at this point in a child theme, so you must use
 * get_template_directory_uri() if you want to use any of the built in icons
 *
 */
function add_another_section($sections){
	
	//$sections = array();
	$sections[] = array(
				'title' => __('A Section added by hook', 'video' ),
				'desc' => '<p class="description">' . __('This is a section created by adding a filter to the sections array, great to allow child themes, to add/remove sections from the options.', 'video' ) . '</p>',
				//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
				//You don't have to though, leave it blank for default.
				'icon' => trailingslashit(get_template_directory_uri()).'options/img/glyphicons/glyphicons_062_attach.png',
				//Lets leave this as a blank section, no options just some intro text set above.
				'fields' => array()
				);
	
	return $sections;
	
}//function
//add_filter('nhp-opts-sections-twenty_eleven', 'add_another_section');


/*
 * 
 * Custom function for filtering the args array given by theme, good for child themes to override or add to the args array.
 *
 */
function change_framework_args($args){
	
	//$args['dev_mode'] = false;
	
	return $args;
	
}//function
//add_filter('nhp-opts-args-twenty_eleven', 'change_framework_args');

/*
 * This is the meat of creating the options page
 *
 * Override some of the default values, uncomment the args and change the values
 * - no $args are required, but they're there to be overridden if needed.
 *
 *
 */

function setup_framework_options(){
$args = array();

//Set it to dev mode to view the class settings/info in the form - default is false
$args['dev_mode'] = false;
//Remove the default stylesheet? make sure you enqueue another one all the page will look whack!
//$args['stylesheet_override'] = true;

//Add HTML before the form
//$args['intro_text'] = __('<p>This is the HTML which can be displayed before the form, it isnt required, but more info is always better. Anything goes in terms of markup here, any HTML.</p>', 'video' );

if ( ! MTS_THEME_WHITE_LABEL ) {
	//Setup custom links in the footer for share icons
	$args['share_icons']['twitter'] = array(
		'link' => 'http://twitter.com/mythemeshopteam',
		'title' => __( 'Follow Us on Twitter', 'video' ),
		'img' => 'fa fa-twitter-square'
	);
	$args['share_icons']['facebook'] = array(
		'link' => 'http://www.facebook.com/mythemeshop',
		'title' => __( 'Like us on Facebook', 'video' ),
		'img' => 'fa fa-facebook-square'
	);
}

//Choose to disable the import/export feature
//$args['show_import_export'] = false;

//Choose a custom option name for your theme options, the default is the theme name in lowercase with spaces replaced by underscores
$args['opt_name'] = MTS_THEME_NAME;

//Custom menu icon
//$args['menu_icon'] = '';

//Custom menu title for options page - default is "Options"
$args['menu_title'] = __('Theme Options', 'video' );

//Custom Page Title for options page - default is "Options"
$args['page_title'] = __('Theme Options', 'video' );

//Custom page slug for options page (wp-admin/themes.php?page=***) - default is "nhp_theme_options"
$args['page_slug'] = 'theme_options';

//Custom page capability - default is set to "manage_options"
//$args['page_cap'] = 'manage_options';

//page type - "menu" (adds a top menu section) or "submenu" (adds a submenu) - default is set to "menu"
//$args['page_type'] = 'submenu';

//parent menu - default is set to "themes.php" (Appearance)
//the list of available parent menus is available here: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
//$args['page_parent'] = 'themes.php';

//custom page location - default 100 - must be unique or will override other items
$args['page_position'] = 62;

//Custom page icon class (used to override the page icon next to heading)
//$args['page_icon'] = 'icon-themes';

if ( ! MTS_THEME_WHITE_LABEL ) {
	//Set ANY custom page help tabs - displayed using the new help tab API, show in order of definition
	$args['help_tabs'][] = array(
		'id' => 'nhp-opts-1',
		'title' => __('Support', 'video' ),
		'content' => '<p>' . sprintf( __('If you are facing any problem with our theme or theme option panel, head over to our %s.', 'video' ), '<a href="http://community.mythemeshop.com/">'. __( 'Support Forums', 'video' ) . '</a>' ) . '</p>'
	);
	$args['help_tabs'][] = array(
		'id' => 'nhp-opts-2',
		'title' => __('Earn Money', 'video' ),
		'content' => '<p>' . sprintf( __('Earn 70%% commision on every sale by refering your friends and readers. Join our %s.', 'video' ), '<a href="http://mythemeshop.com/affiliate-program/">' . __( 'Affiliate Program', 'video' ) . '</a>' ) . '</p>'
	);
}

//Set the Help Sidebar for the options page - no sidebar by default										
//$args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'video' );

$mts_patterns = array(
	'nobg' => array('img' => NHP_OPTIONS_URL.'img/patterns/nobg.png'),
	'pattern0' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern0.png'),
	'pattern1' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern1.png'),
	'pattern2' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern2.png'),
	'pattern3' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern3.png'),
	'pattern4' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern4.png'),
	'pattern5' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern5.png'),
	'pattern6' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern6.png'),
	'pattern7' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern7.png'),
	'pattern8' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern8.png'),
	'pattern9' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern9.png'),
	'pattern10' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern10.png'),
	'pattern11' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern11.png'),
	'pattern12' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern12.png'),
	'pattern13' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern13.png'),
	'pattern14' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern14.png'),
	'pattern15' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern15.png'),
	'pattern16' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern16.png'),
	'pattern17' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern17.png'),
	'pattern18' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern18.png'),
	'pattern19' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern19.png'),
	'pattern20' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern20.png'),
	'pattern21' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern21.png'),
	'pattern22' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern22.png'),
	'pattern23' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern23.png'),
	'pattern24' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern24.png'),
	'pattern25' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern25.png'),
	'pattern26' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern26.png'),
	'pattern27' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern27.png'),
	'pattern28' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern28.png'),
	'pattern29' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern29.png'),
	'pattern30' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern30.png'),
	'pattern31' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern31.png'),
	'pattern32' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern32.png'),
	'pattern33' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern33.png'),
	'pattern34' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern34.png'),
	'pattern35' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern35.png'),
	'pattern36' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern36.png'),
	'pattern37' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern37.png'),
	'hbg' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg.png'),
	'hbg2' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg2.png'),
	'hbg3' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg3.png'),
	'hbg4' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg4.png'),
	'hbg5' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg5.png'),
	'hbg6' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg6.png'),
	'hbg7' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg7.png'),
	'hbg8' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg8.png'),
	'hbg9' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg9.png'),
	'hbg10' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg10.png'),
	'hbg11' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg11.png'),
	'hbg12' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg12.png'),
	'hbg13' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg13.png'),
	'hbg14' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg14.png'),
	'hbg15' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg15.png'),
	'hbg16' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg16.png'),
	'hbg17' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg17.png'),
	'hbg18' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg18.png'),
	'hbg19' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg19.png'),
	'hbg20' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg20.png'),
	'hbg21' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg21.png'),
	'hbg22' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg22.png'),
	'hbg23' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg23.png'),
	'hbg24' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg24.png'),
	'hbg25' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg25.png')
);

$sections = array();

$sections[] = array(
				'icon' => 'fa fa-cogs',
				'title' => __('General Settings', 'video' ),
				'desc' => '<p class="description">' . __('This tab contains common setting options which will be applied to the whole theme.', 'video' ) . '</p>',
				'fields' => array(
					array(
						'id' => 'mts_logo',
						'type' => 'upload',
						'title' => __('Logo Image', 'video' ),
						'sub_desc' => __('Upload your logo using the Upload Button or insert image URL.', 'video' )
						),
					array(
						'id' => 'mts_favicon',
						'type' => 'upload',
						'title' => __('Favicon', 'video' ),
						'sub_desc' => sprintf( __('Upload a %s image that will represent your website\'s favicon.', 'video' ), '<strong>32 x 32 px</strong>' )
						),
					array(
						'id' => 'mts_touch_icon',
						'type' => 'upload',
						'title' => __('Touch icon', 'video' ),
						'sub_desc' => sprintf( __('Upload a %s image that will represent your website\'s touch icon for iOS 2.0+ and Android 2.1+ devices.', 'video' ), '<strong>152 x 152 px</strong>' )
						),
					array(
						'id' => 'mts_metro_icon',
						'type' => 'upload',
						'title' => __('Metro icon', 'video' ),
						'sub_desc' => sprintf( __('Upload a %s image that will represent your website\'s IE 10 Metro tile icon.', 'video' ), '<strong>144 x 144 px</strong>' )
						),
					array(
						'id' => 'mts_mail_to',
						'type' => 'text',
						'title' => __('Contact Form Recipient', 'video' ),
						'sub_desc' => __('Enter contact form recipient email address. When empty, the Admin Email ID will be used', 'video' ),
						),
					array(
						'id' => 'mts_twitter_username',
						'type' => 'text',
						'title' => __('Twitter Username', 'video' ),
						'sub_desc' => __('Enter your Username here.', 'video' ),
						),
					array(
						'id' => 'mts_feedburner',
						'type' => 'text',
						'title' => __('FeedBurner URL', 'video' ),
						'sub_desc' => sprintf( __('Enter your FeedBurner\'s URL here, ex: %s and your main feed (http://example.com/feed) will get redirected to the FeedBurner ID entered here.)', 'video' ), '<strong>http://feeds.feedburner.com/mythemeshop</strong>' ),
						'validate' => 'url'
						),
					array(
						'id' => 'mts_header_code',
						'type' => 'textarea',
						'title' => __('Header Code', 'video' ),
						'sub_desc' => wp_kses( __('Enter the code which you need to place <strong>before closing &lt;/head&gt; tag</strong>. (ex: Google Webmaster Tools verification, Bing Webmaster Center, BuySellAds Script, Alexa verification etc.)', 'video' ), array( 'strong' => '' ) )
						),
					array(
						'id' => 'mts_analytics_code',
						'type' => 'textarea',
						'title' => __('Footer Code', 'video' ),
						'sub_desc' => wp_kses( __('Enter the codes which you need to place in your footer. <strong>(ex: Google Analytics, Clicky, STATCOUNTER, Woopra, Histats, etc.)</strong>.', 'video' ), array( 'strong' => '' ) )
						),
					array(
                        'id' => 'mts_pagenavigation_type',
                        'type' => 'radio',
                        'title' => __('Pagination Type', 'video' ),
                        'sub_desc' => __('Select pagination type.', 'video' ),
                        'options' => array(
                                        '0'=> __('Default (Next / Previous)', 'video' ),
                                        '1' => __('Numbered (1 2 3 4...)', 'video' ),
                                        '2' => __( 'AJAX (Load More Button)', 'video' ),
                                        '3' => __( 'AJAX (Auto Infinite Scroll)', 'video' ) ),
                        'std' => '1'
                        ),
                    array(
                        'id' => 'mts_ajax_search',
                        'type' => 'button_set',
                        'title' => __('AJAX Quick search', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Enable or disable search results appearing instantly below the search form', 'video' ),
						'std' => '0'
                        ),
					array(
						'id' => 'mts_responsive',
						'type' => 'button_set',
						'title' => __('Responsiveness', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('MyThemeShop themes are responsive, which means they adapt to tablet and mobile devices, ensuring that your content is always displayed beautifully no matter what device visitors are using. Enable or disable responsiveness using this option.', 'video' ),
						'std' => '1'
						),
					array(
						'id' => 'mts_rtl',
						'type' => 'button_set',
						'title' => __('Right To Left Language Support', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Enable this option for right-to-left sites.', 'video' ),
						'std' => '0'
						),
					array(
						'id' => 'mts_watch_later',
						'type' => 'button_set', 
						'title' => __('Watch Later', 'video'), 
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Use this button to enable Watch Later feature for video posts.', 'video'),
						'std' => '1'
						),
                    array(
						'id' => 'mts_views_counter',
						'type' => 'button_set',
						'title' => __('View Counter', 'video'), 
						'options' => array('none' => 'Off', 'local' => 'Local', 'youtube' => 'Youtube'),
						'sub_desc' => __('Show local view count or Youtube views.', 'video'),
						'std' => 'youtube'
						),
					array(
						'id' => 'mts_shop_products',
						'type' => 'text',
						'title' => __('No. of Products', 'video' ),
						'sub_desc' => __('Enter the total number of products which you want to show on shop page (WooCommerce plugin must be enabled).', 'video' ),
						'validate' => 'numeric',
						'std' => '9',
						'class' => 'small-text',
						'reset_at_version' => '2.0'
						),
					)
				);
$sections[] = array(
				'icon' => 'fa fa-bolt',
				'title' => __('Performance', 'video' ),
				'desc' => '<p class="description">' . __('This tab contains performance-related options which can help speed up your website.', 'video' ) . '</p>',
				'fields' => array(
					array(
						'id' => 'mts_prefetching',
						'type' => 'button_set',
						'title' => __('Prefetching', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Enable or disable prefetching. If user is on homepage, then single page will load faster and if user is on single page, homepage will load faster in modern browsers.', 'video' ),
						'std' => '0'
						),
					array(
						'id' => 'mts_lazy_load',
						'type' => 'button_set_hide_below',
						'title' => __('Lazy Load', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Delay loading of images outside of viewport, until user scrolls to them.', 'video' ),
						'std' => '0',
						'args' => array('hide' => 2),
						'reset_at_version' => '2.0'
						),
					array(
						'id' => 'mts_lazy_load_thumbs',
						'type' => 'button_set',
						'title' => __('Lazy load featured images', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Enable or disable Lazy load of featured images across site.', 'video' ),
						'std' => '0',
						'reset_at_version' => '2.0'
						),
					array(
						'id' => 'mts_lazy_load_content',
						'type' => 'button_set',
						'title' => __('Lazy load post content images', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Enable or disable Lazy load of images inside post/page content.', 'video' ),
						'std' => '0',
						'reset_at_version' => '2.0'
						),
					array(
						'id' => 'mts_async_js',
						'type' => 'button_set',
						'title' => __('Async JavaScript', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => sprintf( __('Add %s attribute to script tags to improve page download speed.', 'video' ), '<code>async</code>' ),
						'std' => '1',
						'reset_at_version' => '2.0'
						),
					array(
						'id' => 'mts_remove_ver_params',
						'type' => 'button_set',
						'title' => __('Remove ver parameters', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => sprintf( __('Remove %s parameter from CSS and JS file calls. It may improve speed in some browsers which do not cache files having the parameter.', 'video' ), '<code>ver</code>' ),
						'std' => '1',
						'reset_at_version' => '2.0'
						),
					array(
						'id' => 'mts_optimize_wc',
						'type' => 'button_set',
						'title' => __('Optimize WooCommerce scripts', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Load WooCommerce scripts and styles only on WooCommerce pages (WooCommerce plugin must be enabled).', 'video' ),
						'std' => '1',
						'reset_at_version' => '2.0'
						),
					'cache_message' => array(
						'id' => 'mts_cache_message',
						'type' => 'info',
						'title' => __('Use Cache', 'video' ),
						'desc' => sprintf(
							__('A cache plugin can increase page download speed dramatically. We recommend using %1$s or %2$s.', 'video' ),
							'<a href="'.admin_url( 'plugin-install.php?tab=plugin-information&plugin=w3-total-cache&TB_iframe=true&width=772&height=574' ).'" class="thickbox" title="W3 Total Cache">W3 Total Cache</a>',
							'<a href="'.admin_url( 'plugin-install.php?tab=plugin-information&plugin=wp-super-cache&TB_iframe=true&width=772&height=574' ).'" class="thickbox" title="WP Super Cache">WP Super Cache</a>'
						),
					),
				)
			);

// Hide cache message on multisite or if a chache plugin is active already
if ( is_multisite() || strstr( join( ';', get_option( 'active_plugins' ) ), 'cache' ) ) {
	unset( $sections[1]['fields']['cache_message'] );
}

$sections[] = array(
				'icon' => 'fa fa-adjust',
				'title' => __('Styling Options', 'video' ),
				'desc' => '<p class="description">' . __('Control the visual appearance of your theme, such as colors, layout and patterns, from here.', 'video' ) . '</p>',
				'fields' => array(
					array(
						'id' => 'mts_color_scheme',
						'type' => 'color',
						'title' => __('Color Scheme', 'video' ),
						'sub_desc' => __('The theme comes with unlimited color schemes for your theme\'s styling.', 'video' ),
						'std' => '#e82f34'
						),
					array(
						'id' => 'mts_layout',
						'type' => 'radio_img',
						'title' => __('Layout Style', 'video' ),
						'sub_desc' => wp_kses_post( __('Choose the <strong>default sidebar position</strong> for your site. The position of the sidebar for individual posts can be set in the post editor.', 'video' ) ),
						'options' => array(
								'cslayout' => array('img' => NHP_OPTIONS_URL.'img/layouts/cs.png'),
								'sclayout' => array('img' => NHP_OPTIONS_URL.'img/layouts/sc.png')
									),
						'std' => 'cslayout'
						),
					array(
						'id' => 'mts_background',
						'type' => 'background',
						'title' => __('Site Background', 'video' ),
						'sub_desc' => __('Set background color, pattern and image from here.', 'video' ),
						'options' => array(
							'color'         => '',            // false to disable, not needed otherwise
							'image_pattern' => $mts_patterns, // false to disable, array of options otherwise ( required !!! )
							'image_upload'  => '',            // false to disable, not needed otherwise
							'repeat'        => array(),       // false to disable, array of options to override default ( optional )
							'attachment'    => array(),       // false to disable, array of options to override default ( optional )
							'position'      => array(),       // false to disable, array of options to override default ( optional )
							'size'          => array(),       // false to disable, array of options to override default ( optional )
							'gradient'      => '',            // false to disable, not needed otherwise
							'parallax'      => array(),       // false to disable, array of options to override default ( optional )
						),
						'std' => array(
							'color'         => '#ffffff',
							'use'           => 'pattern',
							'image_pattern' => 'nobg',
							'image_upload'  => '',
							'repeat'        => 'repeat',
							'attachment'    => 'scroll',
							'position'      => 'left top',
							'size'          => 'cover',
							'gradient'      => array('from' => '#ffffff', 'to' => '#000000', 'direction' => 'horizontal' ),
							'parallax'      => '0',
						),
						'reset_at_version' => '2.0'
					),
					array(
						'id' => 'mts_custom_css',
						'type' => 'textarea',
						'title' => __('Custom CSS', 'video' ),
						'sub_desc' => __('You can enter custom CSS code here to further customize your theme. This will override the default CSS used on your site.', 'video' )
						),
					array(
						'id' => 'mts_lightbox',
						'type' => 'button_set',
						'title' => __('Lightbox', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('A lightbox is a stylized pop-up that allows your visitors to view larger versions of images without leaving the current page. You can enable or disable the lightbox here.', 'video' ),
						'std' => '0'
						),
					)
				);
$sections[] = array(
				'icon' => 'fa fa-credit-card',
				'title' => __('Header', 'video' ),
				'desc' => '<p class="description">' . __('From here, you can control the elements of header section.', 'video' ) . '</p>',
				'fields' => array(
					array(
						'id' => 'mts_header_bg_color',
						'type' => 'color',
						'title' => __('Header Background Color', 'video'), 
						'sub_desc' => __('Pick a color for the Header background color.', 'video'),
						'std' => '#000000'
						),
					array(
						'id' => 'mts_sticky_nav',
						'type' => 'button_set',
						'title' => __('Floating Navigation Menu', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => sprintf( __('Use this button to enable %s.', 'video' ), '<strong>' . __('Floating Navigation Menu', 'video' ) . '</strong>' ),
						'std' => '0'
						),
                    array(
						'id' => 'mts_show_primary_nav',
						'type' => 'button_set',
						'title' => __('Show Primary Menu', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => sprintf( __('Use this button to enable %s.', 'video' ), '<strong>' . __( 'Primary Navigation Menu', 'video' ) . '</strong>' ),
						'std' => '1'
						),
                    array(
                        'id'        => 'mts_header_buttons',
                        'type'      => 'group', //doesn't need to be called for callback fields
                        'title'     => __('Header Buttons', 'video'), 
                        'sub_desc'  => __('Add custom links to the right side of the header.', 'video'),
                        'groupname' => __('Button', 'video'), // Group name
                        'subfields' => 
                            array(
                                array(
                                    'id' => 'mts_header_button_icon',
            						'type' => 'icon_select',
            						'title' => __('Icon', 'video'),
            						'sub_desc' => __('Optional', 'video')
            						),
                                array(
                                    'id' => 'mts_header_button_color',
            						'type' => 'color',
            						'title' => __('Color', 'video'),
            						'sub_desc' => __('Optional', 'video')
            						),
                                array(
                                    'id' => 'mts_header_button_link',
            						'type' => 'text',
            						'title' => __('Link URL', 'video'),
            						'std' => '#'
            						),
                            ),
						'std' => array(
							'1' => array(
								'group_title' => '',
								'group_sort' => '1',
								'mts_header_button_icon' => 'facebook',
								'mts_header_button_color' => '#3a5795',
								'mts_header_button_link' => '#'
							),
							'2' => array(
								'group_title' => '',
								'group_sort' => '1',
								'mts_header_button_icon' => 'twitter',
								'mts_header_button_color' => '#55acee',
								'mts_header_button_link' => '#'
							),
							'3' => array(
								'group_title' => '',
								'group_sort' => '1',
								'mts_header_button_icon' => 'google-plus',
								'mts_header_button_color' => '#dd4b39',
								'mts_header_button_link' => '#'
							),
						)
                    ),
					array(
						'id' => 'mts_show_header_url',
						'type' => 'button_set_hide_below',
						'title' => __('Show Submit Video Button', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => sprintf( __('Use this button to enable Submit Video Button on right side', 'video' ) . '</strong>' ),
						'std' => '1',
						'args' => array('hide' => 3)
						),
					array(
                        'id' => 'mts_header_url_icon',
						'type' => 'icon_select',
						'title' => __('Icon', 'video'),
						'sub_desc' => __('Select Icon for Submit Button', 'video'),
						'std' => 'plus'
						),
					array(
                        'id' => 'mts_header_url_text',
						'type' => 'text',
						'title' => __('Button Text', 'video'),
						'sub_desc' => __('Set Button text from here', 'video'),
						'std' => __('Submit Video', 'video'),
						),
                    array(
                        'id' => 'mts_header_url_link',
						'type' => 'text',
						'title' => __('Button URL', 'video'),
						'sub_desc' => __('Set Button URL From here', 'video'),
						'std' => esc_url( home_url() ).'/submit-video/',
						),
					array(
						'id' => 'mts_header_section2',
						'type' => 'button_set',
						'title' => __('Show Logo', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => wp_kses( __('Use this button to Show or Hide the <strong>Logo</strong> completely.', 'video' ), array( 'strong' => '' ) ),
						'std' => '1'
						),
					array(
						'id' => 'mts_cart_links',
						'type' => 'button_set',
						'title' => __('WooCommerce Account + Cart Link', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => wp_kses( __('Use this button to Show or Hide the Account & Cart Link. <strong>NOTE:</strong> This option only works if WooCommerce Plugin is enabled.', 'video' ), array( 'strong' => '' ) ),
						'std' => '1',
						'reset_at_version' => '2.0'
					),
				)
			);
$sections[] = array(
				'icon' => 'fa fa-table',
				'title' => __('Footer', 'video' ),
				'desc' => '<p class="description">' . __('From here, you can control the elements of Footer section.', 'video' ) . '</p>',
				'fields' => array(
					array(
						'id' => 'mts_bottom_footer',
						'type' => 'button_set_hide_below',
						'title' => __('Footer Widgets', 'video'), 
						'sub_desc' => __('Enable or disable footer widgets with this option.', 'video' ),
						'options' => array(
								'0' => __( 'Off', 'video' ),
								'1' => __( 'On', 'video' )
							),
						'std' => '0'
						),
                    array(
						'id' => 'mts_footer_bg_color',
						'type' => 'color',
						'title' => __('Footer Background Color', 'video'), 
						'sub_desc' => __('Pick a color for the footer background color.', 'video'),
						'std' => '#111111'
						),
					array(
						'id' => 'mts_copyright_bg_color',
						'type' => 'color',
						'title' => __('Copyright Background Color', 'video'), 
						'sub_desc' => __('Pick a color for the Copyright background color.', 'video'),
						'std' => '#000000'
						),
					array(
						'id' => 'mts_show_footer_nav',
						'type' => 'button_set',
						'title' => __('Show Footer menu', 'video'), 
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Use this button to enable <strong>Footer Navigation Menu</strong>.', 'video'),
						'std' => '1'
						),
					array(
						'id' => 'mts_copyrights',
						'type' => 'textarea',
						'title' => __('Copyrights Text', 'video' ),
						'sub_desc' => __( 'You can change or remove our link from footer and use your own custom text.', 'video' ) . ( MTS_THEME_WHITE_LABEL ? '' : wp_kses( __('(You can also use your affiliate link to <strong>earn 70% of sales</strong>. Ex: <a href="https://mythemeshop.com/go/aff/aff" target="_blank">https://mythemeshop.com/?ref=username</a>)', 'video' ), array( 'strong' => '', 'a' => array( 'href' => array(), 'target' => array() ) ) ) ),
						'std' => MTS_THEME_WHITE_LABEL ? null : sprintf( __( 'Theme by %s', 'video' ), '<a href="http://mythemeshop.com/" rel="nofollow">MyThemeShop</a>' )
						),
					)
				);
$sections[] = array(
				'icon' => 'fa fa-home',
				'title' => __('Homepage', 'video' ),
				'desc' => '<p class="description">' . __('From here, you can control the elements of the homepage.', 'video' ) . '</p>',
				'fields' => array(
					array(
						'id' => 'mts_featured_slider',
						'type' => 'button_set_hide_below',
						'title' => __('Featured Posts', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => wp_kses( __('<strong>Enable or Disable</strong> homepage slider with this button. The slider will show recent articles from the selected categories.', 'video' ), array( 'strong' => '' ) ),
						'std' => '0',
                        'args' => array('hide' => 1)
						),
						array(
						'id' => 'mts_featured_slider_cat',
						'type' => 'cats_multi_select',
						'title' => __('Featured Posts Category(s)', 'video' ),
						'sub_desc' => wp_kses( __('Select a category from the drop-down menu, latest articles from this category will be shown <strong>in the slider</strong>.', 'video' ), array( 'strong' => '' ) ),
						),
					array(
						'id' => 'mts_home_sidebar',
						'type' => 'button_set',
						'title' => __('Homepage Right Column', 'video'), 
						'class' => 'green',
						'options' => array('sidebar' => __('Sidebar', 'video'),'popular' => __('Popular', 'video'),'random' => __('Random', 'video')),
						'sub_desc' => __('Show most popular or random posts on right side of homepage.', 'video'),
						'std' => 'popular'
						),
					array(
						'id' => 'mts_archive_sidebar',
						'type' => 'button_set',
						'title' => __('Archive Right Column', 'video'),
						'class' => 'green', 
						'options' => array('sidebar' => __('Sidebar', 'video'), 'popular' => __('Popular', 'video'), 'random' => __('Random', 'video')),
						'sub_desc' => __('Show most popular or random posts on right side of post archives & search results.', 'video'),
						'std' => 'random'
						),
    				array(
        				'id' => 'mts_popular_days',
        				'type' => 'text',
        				'class' => 'small-text',
        				'title' => __('Popular posts day limit', 'video') ,
        				'sub_desc' => __('Show popular posts from last X days. <br />0 = Unlimited.', 'video') ,
        				'std' => '0',
        				'args' => array(
        					'type' => 'number'
        					)
        				),
					)
				);	
$sections[] = array(
				'icon' => 'fa fa-file-text',
				'title' => __('Single Content', 'video' ),
				'desc' => '<p class="description">' . __('From here, you can control the appearance and functionality of your single posts page.', 'video' ) . '</p>',
				'fields' => array(
					array(
						'id' => 'mts_single_post_layout',
						'type' => 'radio_img',
						'title' => __('Single Posts Layout', 'video'), 
						'sub_desc' => __('Choose how you want the single posts to appear.', 'video'),
						'options' => array(
								'crlayout' => array('img' => NHP_OPTIONS_URL.'img/layouts/cr.png'),
								'rclayout' => array('img' => NHP_OPTIONS_URL.'img/layouts/rc.png'),
								'cbrlayout' => array('img' => NHP_OPTIONS_URL.'img/layouts/cbr.png'),
								'clsrlayout' => array('img' => NHP_OPTIONS_URL.'img/layouts/clsr.png'),
							),
						'std' => 'crlayout'
						),
					array(
						'id' => 'mts_custom_thumbnail',
						'type' => 'button_set',
						'title' => __('Featured Image as Player Thumbnail', 'video'), 
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Use this button to Show Featured Image as thumbnail in single Video Players.', 'video'),
						'std' => '1'
						),
					array(
						'id' => 'mts_grab_thumbnail',
						'type' => 'button_set',
						'title' => __('Download Video Thumbnails', 'video'), 
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Download YouTube video thumbnails and set as featured image when there is no featured image is set.', 'video'),
						'std' => '1'
						),
					array(
						'id' => 'mts_breadcrumb',
						'type' => 'button_set',
						'title' => __('Breadcrumbs', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Breadcrumbs are a great way to make your site more user-friendly. You can enable them by checking this box.', 'video' ),
						'std' => '0'
						),
					array(
						'id' => 'mts_like_dislike',
						'type' => 'button_set',
						'title' => __('Like/Dislike', 'video'), 
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Use this button to enable Like &amp; Dislike features for posts.', 'video'),
						'std' => '1'
						),
					array(
						'id' => 'mts_show_share_popup',
						'type' => 'button_set',
						'title' => __('Intelligent Social Popup', 'video'), 
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Show Popup with share buttons when video ends.', 'video'),
						'std' => '1'
						),
					array(
						'id' => 'mts_show_share_meta',
						'type' => 'button_set',
						'title' => __('Social Meta Tags', 'video'),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Enable or disable Open Graph and Twitter Cards meta tags in single posts head tag.', 'video'),
						'std' => '1',
						'reset_at_version' => '2.0.6'
						),
					array(
						'id' => 'mts_autoplay',
						'type' => 'button_set',						
						'title' => __('Autoplay Videos', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Autoplay videos when the page loads. This option does not work on mobile devices.', 'video' ),
						'std' => '0'
						),
					array(
						'id' => 'mts_single_headline_meta',
						'type' => 'button_set_hide_below',
						'title' => __('Post Meta Info.', 'video'), 
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Use this button to Show or Hide Post Meta Info <strong>Author name and Categories</strong>.', 'video'),
						'std' => '1'
						),
					array(
 						'id' => 'mts_single_headline_meta_info',
 						'type' => 'multi_checkbox',
 						'title' => __('Meta Info to Show', 'video'),
 						'sub_desc' => __('Choose What Meta Info to Show.', 'video'),
 						'options' => array('date' => __('Date','video'),'category' => __('Categories','video'),'author' => __('Author Name','video')),
 						'std' => array('author' => '1', 'date' => '1', 'category' => '1')
 						),
					array(
						'id' => 'mts_tags',
						'type' => 'button_set',
						'title' => __('Tag Links', 'video'), 
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Use this button if you want to show a tag cloud below the related posts.', 'video'),
						'std' => '0'
						),
					array(
						'id' => 'mts_author_box',
						'type' => 'button_set',
						'title' => __('Author Box', 'video'), 
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Use this button if you want to display author information below the article.', 'video'),
						'std' => '0'
						),
					array(
                        'id'       => 'mts_comments',
                        'type'     => 'layout2',
                        'title'    => __('Comments', 'video'),
                        'sub_desc' => __('Show standard comments, Facebook comments, or both, in tabs layout.', 'video'),
                        'options'  => array(
                            'enabled'  => array(
                                'comments'   => array(
                                	'label' 	=> __('Comments','video'),
                                	'subfields'	=> array(
                                		// none
                                	)
                                ),
                            ),
                            'disabled' => array(
                                'fb_comments'   => array(
                                	'label' 	=> __('Facebook Comments','video'),
                                	'subfields'	=> array(
					        			array(
					        				'id' => 'mts_fb_app_id',
					        				'type' => 'text',
					        				'title' => __('Facebook App ID', 'video'),
											'sub_desc' => __('Enter your Facebook app ID here. You can create Facebook App id <a href="https://developers.facebook.com/apps" target="_blank">here</a>', 'video'),
					        				'class' => 'small'
					        			),
                                	)
                                ),
                            )
                        )
                    ),
					array(
						'id' => 'mts_author_comment',
						'type' => 'button_set',
						'title' => __('Highlight Author Comment', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Use this button to highlight author comments.', 'video' ),
						'std' => '1'
						),
					array(
        				'id' => 'mts_related_posts',
        				'type' => 'button_set',
        				'title' => __('Related Posts', 'video') ,
        				'options' => array(
        					'0' => 'Off',
        					'1' => 'On'
        				) ,
        				'sub_desc' => __('Use this button to show related posts with thumbnails below the content area in a post.', 'video') ,
        				'std' => '1',
        				'args' => array(
        					'hide' => 2
        				)
        			),
        			array(
        				'id' => 'mts_related_posts_taxonomy',
        				'type' => 'button_set',
        				'title' => __('Related Posts Taxonomy', 'video') ,
        				'options' => array(
        					'tags' => 'Tags',
        					'categories' => 'Categories'
        				) ,
        				'class' => 'green',
        				'sub_desc' => __('Related Posts based on tags or categories.', 'video') ,
        				'std' => 'categories'
        			),
        			array(
        				'id' => 'mts_related_postsnum',
        				'type' => 'text',
        				'class' => 'small-text',
        				'title' => __('Number of related posts', 'video') ,
        				'sub_desc' => __('Enter the number of posts to show in the related posts section.', 'video') ,
        				'std' => '3',
        				'args' => array(
        					'type' => 'number'
        				)
        			),
					array(
						'id' => 'mts_comment_date',
						'type' => 'button_set',
						'title' => __('Date in Comments', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Use this button to show the date for comments.', 'video' ),
						'std' => '1'
						),
					)
				);
$sections[] = array(
				'icon' => 'fa fa-caret-right',
				'title' => __('General', 'video' ),
				'desc' => '<p class="description">' . __('From here, you can control the appearance and functionality of your YouTube Player.', 'video' ) . '</p>',
				'fields' => array(
					array(
						'id' => 'mts_youtube_api',
						'type' => 'text',
						'title' => __('YouTube Data V3 API Key', 'video' ),
						'sub_desc' => sprintf( __('API key necessary for retrieving data from YouTube. When empty, the default API key will be used which is limited. %s.', 'video' ), '<a href="https://www.youtube.com/watch?v=qXhIpThTMlk" target="_blank"><b>' . __( 'Register your key for free.', 'video' ) . '</b></a>' ),
						),
					array(
						'id' => 'mts_dm_api_key',
						'type' => 'text',
						'title' => __('Dailymotion API Key', 'video' ),
						'sub_desc' => sprintf( __('API key necessary for retrieving data from DailyMotion. Videos will not work if this field is empty. %s.', 'video' ), '<a href="https://developer.dailymotion.com/api#register" target="_blank"><b>' . __( 'Register your key for free.', 'video' ) . '</b></a>' ),
						),
					array(
						'id' => 'mts_facebook_app_id',
						'type' => 'text',
						'title' => __('Facebook App ID', 'video' ),
						'sub_desc' => sprintf( __('API key necessary for retrieving data from Facebook. When empty, the default API key will be used which is limited. %s.', 'video' ), '<a href="https://developers.facebook.com/docs/apps/register" target="_blank"><b>' . __( 'Register your key for free.', 'video' ) . '</b></a>' ),
						),
					array(
                        'id' => 'mts_youtube_volume',
                        'type' => 'radio',
                        'title' => __('Default Volume', 'video' ),
                        'sub_desc' => __('Set the default video volume', 'video' ),
                        'options' => array(
                            'auto'=> __('Default Volume', 'video' ),
                            'mute' => __('Mute', 'video' ),
                            'custom' => __( 'Enter Custom Percentage', 'video' ),
                            ),
                        'std' => 'auto'
                        ),
					array(
						'id' => 'mts_youtube_volume_custom',
						'type' => 'text',
						'title' => __('Custom Default Volume', 'video' ),
						'sub_desc' => __('Enter Percentage. Ex: 30 (without %)', 'video' ),
						),
					array(
						'id' => 'mts_youtube_force_hd',
						'type' => 'button_set',						
						'title' => __('Force HD', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Force the player to show HD (720p/1080p) content.', 'video' ),
						'std' => '0'
						),
					array(
						'id' => 'mts_youtube_play_controls',
						'type' => 'button_set',						
						'title' => __('Show Controls on Play', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Show or Hide YouTube controls while video is playing', 'video' ),
						'std' => '1'
						),
					array(
						'id' => 'mts_youtube_anotations',
						'type' => 'button_set',						
						'title' => __('Show Annotations', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Show or hide the interactive annotations in the YouTube video.', 'video' ),
						'std' => '0'
						),
					array(
						'id' => 'mts_youtube_full_screen',
						'type' => 'button_set',						
						'title' => __('Show Full Screen Control', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Display a button in the controls bar to view the video in fullscreen. Note: not all browsers support fullscreen. On these browsers the button will always be hidden.', 'video' ),
						'std' => '1'
						),
					array(
						'id' => 'mts_youtube_logo',
						'type' => 'button_set',						
						'title' => __('YouTube Logo', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Show or Hide YouTube logo in the player', 'video' ),
						'std' => '0'
						),
					array(
						'id' => 'mts_show_channel_in_title',
						'type' => 'button_set',						
						'title' => __('Channel in Title', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Show or Hide channel in the player title', 'video' ),
						'std' => '0'
						),
					)
				);
$sections[] = array(
				'icon' => 'fa fa-caret-right',
				'title' => __('Playlist', 'video' ),
				'desc' => '<p class="description">' . __('From here, you can control the functionality of your YouTube Player with Playlist.', 'video' ) . '</p>',
				'fields' => array(
                    array(
                        'id' => 'mts_playlist_layout',
                        'type' => 'radio',
                        'title' => __('Playlist Layout', 'video' ),
                        'sub_desc' => __('Set the default video volume', 'video' ),
                        'options' => array(
                            'vertical'=> __('Vertically (playlist on the right)', 'video' ),
                            'horizontal' => __('Horizontally (playlist at the bottom)', 'video' ),
                            ),
                        'std' => 'vertical'
                        ),
					array(
						'id' => 'mts_playlist_video_no',
						'type' => 'text',
						'title' => __('No. of Videos', 'video' ),
						'sub_desc' => __('Number of videos to load. The maximum of this option is 50 due to YouTube\'s API limitations, but with Pagination enabled you can retrieve up to 50 video\'s each time.', 'video' ),
						'std' => '10'
						),
					array(
						'id' => 'mts_playlist_loadmore',
						'type' => 'button_set',						
						'title' => __('Load More Button', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('A button "Load More" will appear once the Max Video Results limit is reached.', 'video' ),
						'std' => '1'
						),
					array(
						'id' => 'mts_continuouse_play',
						'type' => 'button_set',						
						'title' => __('Continuous Play', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Play the next video in the playlist when the current one has finished.', 'video' ),
						'std' => '1'
						),
					array(
						'id' => 'mts_playlist_shuffle',
						'type' => 'button_set',						
						'title' => __('Shuffle', 'video' ),
						'options' => array( '0' => __( 'Off', 'video' ), '1' => __( 'On', 'video' ) ),
						'sub_desc' => __('Shuffle the playlist upon loading.', 'video' ),
						'std' => '0'
						),	
					)
				);
$sections[] = array(
				'icon' => 'fa fa-caret-right',
				'title' => __('Colors', 'video' ),
				'desc' => '<p class="description">' . __('From here, you can control the colors of your YouTube Player.', 'video' ) . '</p>',
				'fields' => array(
						array(
	                        'id' => 'mts_player_color_scheme',
	                        'type' => 'radio_img',
	                        'title' => __('YouTube Player Color', 'video' ),
	                        'sub_desc' => __('Select video player color scheme', 'video' ),
	                        'options' => array(
	                            'black'=> array('img' => NHP_OPTIONS_URL.'img/player/black.jpg'),
	                            'red' => array('img' => NHP_OPTIONS_URL.'img/player/red.jpg'),
	                            'white' => array('img' => NHP_OPTIONS_URL.'img/player/white.jpg'),
	                            'blue' => array('img' => NHP_OPTIONS_URL.'img/player/blue.jpg'),
	                            'brown' => array('img' => NHP_OPTIONS_URL.'img/player/brown.jpg'),
	                            'green' => array('img' => NHP_OPTIONS_URL.'img/player/green.jpg'),
	                            ),
	                        'std' => 'black'
                        ),
					)
				);
$sections[] = array(
				'icon' => 'fa fa-group',
				'title' => __('Social Buttons', 'video' ),
				'desc' => '<p class="description">' . __('Enable or disable social sharing buttons on single posts using these buttons.', 'video' ) . '</p>',
				'fields' => array(
					array(
                        'id'       => 'mts_social_buttons',
                        'type'     => 'layout',
                        'title'    => __('Social Media Buttons', 'video' ),
                        'sub_desc' => __('Organize how you want the social sharing buttons to appear on single posts', 'video' ),
                        'options'  => array(
                            'enabled'  => array(
                            	'facebook'  => __('Facebook Like', 'video' ),
                            	'facebookshare'   => __('Facebook Share', 'video' ),
                                'twitter'   => __('Twitter', 'video' ),
                                'gplus'     => __('Google Plus', 'video' ),
                                'pinterest' => __('Pinterest', 'video' ),
                            	'linkedin'  => __('LinkedIn', 'video' ),
                                'stumble'   => __('StumbleUpon', 'video' ),
                            ),
                            'disabled' => array(
                            )
                        ),
                        'std'  => array(
                            'enabled'  => array(
                            	'facebook'  => __('Facebook Like', 'video' ),
                            	'facebookshare'   => __('Facebook Share', 'video' ),
                                'twitter'   => __('Twitter', 'video' ),
                                'gplus'     => __('Google Plus', 'video' ),
                                'pinterest' => __('Pinterest', 'video' ),
                            	'linkedin'  => __('LinkedIn', 'video' ),
                                'stumble'   => __('StumbleUpon', 'video' ),
                            ),
                            'disabled' => array(
                            )
                        )
                    ),
				)
			);
$sections[] = array(
				'icon' => 'fa fa-bar-chart-o',
				'title' => __('Ad Management', 'video' ),
				'desc' => '<p class="description">' . __('Now, ad management is easy with our options panel. You can control everything from here, without using separate plugins.', 'video' ) . '</p>',
				'fields' => array(
					array(
						'id' => 'mts_header_adcode',
						'type' => 'textarea',
						'title' => __('Header Ad', 'video'), 
						'sub_desc' => __('Paste your Adsense, BSA or other ad code here to show ads below Header area.', 'video')
						),
					array(
						'id' => 'mts_posttop_adcode',
						'type' => 'textarea',
						'title' => __('Below Post Title', 'video' ),
						'sub_desc' => __('Paste your Adsense, BSA or other ad code here to show ads below your article title on single posts.', 'video' )
						),
					array(
						'id' => 'mts_posttop_adcode_time',
						'type' => 'text',
						'title' => __('Show After X Days', 'video' ),
						'sub_desc' => __('Enter the number of days after which you want to show the Below Post Title Ad. Enter 0 to disable this feature.', 'video' ),
						'validate' => 'numeric',
						'std' => '0',
						'class' => 'small-text',
                        'args' => array('type' => 'number')
						),
					array(
						'id' => 'mts_postend_adcode',
						'type' => 'textarea',
						'title' => __('Below Post Content', 'video' ),
						'sub_desc' => __('Paste your Adsense, BSA or other ad code here to show ads below the post content on single posts.', 'video' )
						),
					array(
						'id' => 'mts_postend_adcode_time',
						'type' => 'text',
						'title' => __('Show After X Days', 'video' ),
						'sub_desc' => __('Enter the number of days after which you want to show the Below Post Title Ad. Enter 0 to disable this feature.', 'video' ),
						'validate' => 'numeric',
						'std' => '0',
						'class' => 'small-text',
                        'args' => array('type' => 'number')
						),
					)
				);
$sections[] = array(
				'icon' => 'fa fa-columns',
				'title' => __('Sidebars', 'video' ),
				'desc' => '<p class="description">' . __('Now you have full control over the sidebars. Here you can manage sidebars and select one for each section of your site, or select a custom sidebar on a per-post basis in the post editor.', 'video' ) . '<br></p>',
                'fields' => array(
                    array(
                        'id'        => 'mts_custom_sidebars',
                        'type'      => 'group', //doesn't need to be called for callback fields
                        'title'     => __('Custom Sidebars', 'video' ),
                        'sub_desc'  => wp_kses_post( __('Add custom sidebars. <strong style="font-weight: 800;">You need to save the changes to use the sidebars in the dropdowns below.</strong><br />You can add content to the sidebars in Appearance &gt; Widgets.', 'video' ) ),
                        'groupname' => __('Sidebar', 'video' ), // Group name
                        'subfields' => 
                            array(
                                array(
                                    'id' => 'mts_custom_sidebar_name',
            						'type' => 'text',
            						'title' => __('Name', 'video' ),
            						'sub_desc' => __('Example: Homepage Sidebar', 'video' )
            						),	
                                array(
                                    'id' => 'mts_custom_sidebar_id',
            						'type' => 'text',
            						'title' => __('ID', 'video' ),
            						'sub_desc' => __('Enter a unique ID for the sidebar. Use only alphanumeric characters, underscores (_) and dashes (-), eg. "sidebar-home"', 'video' ),
            						'std' => 'sidebar-'
            						),
                            ),
                        ),
                    array(
						'id' => 'mts_sidebar_for_home',
						'type' => 'sidebars_select',
						'title' => __('Homepage', 'video' ),
						'sub_desc' => __('Select a sidebar for the homepage.', 'video' ),
                        'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4', 'widget-header','shop-sidebar', 'product-sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_post',
						'type' => 'sidebars_select',
						'title' => __('Single Post', 'video' ),
						'sub_desc' => __('Select a sidebar for the single posts. If a post has a custom sidebar set, it will override this.', 'video' ),
                        'args' => array('exclude' => array('sidebar', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4', 'widget-header','shop-sidebar', 'product-sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_page',
						'type' => 'sidebars_select',
						'title' => __('Single Page', 'video' ),
						'sub_desc' => __('Select a sidebar for the single pages. If a page has a custom sidebar set, it will override this.', 'video' ),
                        'args' => array('exclude' => array('sidebar', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4', 'widget-header','shop-sidebar', 'product-sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_archive',
						'type' => 'sidebars_select',
						'title' => __('Archive', 'video' ),
						'sub_desc' => __('Select a sidebar for the archives. Specific archive sidebars will override this setting (see below).', 'video' ),
                        'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4', 'widget-header','shop-sidebar', 'product-sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_category',
						'type' => 'sidebars_select',
						'title' => __('Category Archive', 'video' ),
						'sub_desc' => __('Select a sidebar for the category archives.', 'video' ),
                        'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4', 'widget-header','shop-sidebar', 'product-sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_tag',
						'type' => 'sidebars_select',
						'title' => __('Tag Archive', 'video' ),
						'sub_desc' => __('Select a sidebar for the tag archives.', 'video' ),
                        'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4', 'widget-header','shop-sidebar', 'product-sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_date',
						'type' => 'sidebars_select',
						'title' => __('Date Archive', 'video' ),
						'sub_desc' => __('Select a sidebar for the date archives.', 'video' ),
                        'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4', 'widget-header','shop-sidebar', 'product-sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_author',
						'type' => 'sidebars_select',
						'title' => __('Author Archive', 'video' ),
						'sub_desc' => __('Select a sidebar for the author archives.', 'video' ),
                        'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4', 'widget-header','shop-sidebar', 'product-sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_search',
						'type' => 'sidebars_select',
						'title' => __('Search', 'video' ),
						'sub_desc' => __('Select a sidebar for the search results.', 'video' ),
                        'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4', 'widget-header','shop-sidebar', 'product-sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_notfound',
						'type' => 'sidebars_select',
						'title' => __('404 Error', 'video' ),
						'sub_desc' => __('Select a sidebar for the 404 Not found pages.', 'video' ),
                        'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4', 'widget-header','shop-sidebar', 'product-sidebar')),
                        'std' => ''
						),
                    
                    array(
						'id' => 'mts_sidebar_for_shop',
						'type' => 'sidebars_select',
						'title' => __('Shop Pages', 'video' ),
						'sub_desc' => wp_kses( __('Select a sidebar for Shop main page and product archive pages (WooCommerce plugin must be enabled). Default is <strong>Shop Page Sidebar</strong>.', 'video' ), array( 'strong' => '' ) ),
                        'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4', 'widget-header','shop-sidebar', 'product-sidebar')),
                        'std' => 'shop-sidebar'
						),
                    array(
						'id' => 'mts_sidebar_for_product',
						'type' => 'sidebars_select',
						'title' => __('Single Product', 'video' ),
						'sub_desc' => wp_kses( __('Select a sidebar for single products (WooCommerce plugin must be enabled). Default is <strong>Single Product Sidebar</strong>.', 'video' ), array( 'strong' => '' ) ),
                        'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4', 'widget-header','shop-sidebar', 'product-sidebar')),
                        'std' => 'product-sidebar'
						),
                    ),
				);
//$sections[] = array(
//				'icon' => NHP_OPTIONS_URL.'img/glyphicons/fontsetting.png',
//				'title' => __('Fonts', 'video' ),
//				'desc' => __('<p class="description"><div class="controls">You can find theme font options under the Appearance Section named <a href="themes.php?page=typography"><b>Theme Typography</b></a>, which will allow you to configure the typography used on your site.<br></div></p>', 'video' ),
//				);
$sections[] = array(
	'icon' => 'fa fa-list-alt',
	'title' => __('Navigation', 'video' ),
	'desc' => '<p class="description"><div class="controls">' . sprintf( __('Navigation settings can now be modified from the %s.', 'video' ), '<a href="nav-menus.php"><b>' . __( 'Menus Section', 'video' ) . '</b></a>' ) . '<br></div></p>'
);
				
	$tabs = array();
    
    $args['presets'] = array();
	$args['show_translate'] = false;
    include('theme-presets.php');
    
	global $NHP_Options;
	$NHP_Options = new NHP_Options($sections, $args, $tabs);

}//function
add_action('init', 'setup_framework_options', 0);

/*
 * 
 * Custom function for the callback referenced above
 *
 */
function my_custom_field($field, $value){
	print_r($field);
	print_r($value);

}//function

/*
 * 
 * Custom function for the callback validation referenced above
 *
 */
function validate_callback_function($field, $value, $existing_value){
	
	$error = false;
	$value =  'just testing';
	/*
	do your validation
	
	if(something){
		$value = $value;
	}elseif(somthing else){
		$error = true;
		$value = $existing_value;
		$field['msg'] = 'your custom error message';
	}
	*/
	$return['value'] = $value;
	if($error == true){
		$return['error'] = $field;
	}
	return $return;
	
}//function

/*--------------------------------------------------------------------
 * 
 * Default Font Settings
 *
 --------------------------------------------------------------------*/
if(function_exists('mts_register_typography')) { 
	mts_register_typography(array(
		'logo_font' => array(
			'preview_text' => __('Logo','video'),
			'preview_color' => 'dark',
			'font_family' => 'Roboto',
			'font_variant' => '700',
			'font_size' => '36px',
			'font_color' => '#ffffff',
			'css_selectors' => '#logo a',
			'additional_css' => 'text-transform:uppercase;'
		),
		'navigation_font' => array(
			'preview_text' => __('Navigation Font','video'),
			'preview_color' => 'dark',
			'font_family' => 'Roboto',
			'font_variant' => '700',
			'font_size' => '13px',
			'font_color' => '#ffffff',
			'css_selectors' => '.menu li, .menu li a, .mts-cart a, .video-header-url a',
			'additional_css' => 'text-transform:uppercase;'
		),
		'home_title_font' => array(
			'preview_text' => __('Home Article Title','video'),
			'preview_color' => 'light',
			'font_family' => 'Roboto',
			'font_size' => '15px',
			  'font_variant' => '700',
			'font_color' => '#000',
			'css_selectors' => '.home-post-title a'
		),
		'single_title_font' => array(
			'preview_text' => __('Single Article Title','video'),
			'preview_color' => 'light',
			'font_family' => 'Roboto',
			'font_size' => '20px',
			  'font_variant' => '700',
			'font_color' => '#000',
			'css_selectors' => '.single-title, .page h1.title'
		),
		'content_font' => array(
			'preview_text' => __('Content Font','video'),
			'preview_color' => 'light',
			'font_family' => 'Roboto',
			'font_size' => '14px',
			  'font_variant' => 'normal',
			'font_color' => '#000000',
			'css_selectors' => 'body'
		),
		'sidebar_font' => array(
			'preview_text' => __('Sidebar Font','video'),
			'preview_color' => 'light',
			'font_family' => 'Roboto',
			'font_variant' => 'normal',
			'font_size' => '14px',
			'font_color' => '#444444',
			'css_selectors' => '#sidebars .widget'
		),
		'footer_font' => array(
			'preview_text' => __('Footer Font','video'),
			'preview_color' => 'light',
			'font_family' => 'Roboto',
			'font_variant' => 'normal',
			'font_size' => '14px',
			'font_color' => '#6F6F6F',
			'css_selectors' => '#site-footer, footer .menu li a'
		),
		'h1_headline' => array(
			'preview_text' => __('Content H1','video'),
			'preview_color' => 'light',
			'font_family' => 'Roboto',
			'font_variant' => '700',
			'font_size' => '28px',
			'font_color' => '#000',
			'css_selectors' => 'h1'
		),
		'h2_headline' => array(
			'preview_text' => __('Content H2','video'),
			'preview_color' => 'light',
			'font_family' => 'Roboto',
			'font_variant' => '700',
			'font_size' => '24px',
			'font_color' => '#000',
			'css_selectors' => 'h2'
		),
		'h3_headline' => array(
			'preview_text' => __('Content H3','video'),
			'preview_color' => 'light',
			'font_family' => 'Roboto',
			'font_variant' => '700',
			'font_size' => '22px',
			'font_color' => '#000',
			'css_selectors' => 'h3'
		),
		'h4_headline' => array(
			'preview_text' => __('Content H4','video'),
			'preview_color' => 'light',
			'font_family' => 'Roboto',
			'font_variant' => '700',
			'font_size' => '20px',
			'font_color' => '#000',
			'css_selectors' => 'h4'
		),
		'h5_headline' => array(
			'preview_text' => __('Content H5','video'),
			'preview_color' => 'light',
			'font_family' => 'Roboto',
			'font_variant' => '700',
			'font_size' => '18px',
			'font_color' => '#000',
			'css_selectors' => 'h5'
		),
		'h6_headline' => array(
			'preview_text' => __('Content H6','video'),
			'preview_color' => 'light',
			'font_family' => 'Roboto',
			'font_variant' => '700',
			'font_size' => '16px',
			'font_color' => '#000',
			'css_selectors' => 'h6'
		)
	));
} ?>