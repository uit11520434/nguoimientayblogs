<?php
/**
 * Add a "Sidebar" selection metabox.
 */
function mts_add_sidebar_metabox() {
    $screens = array('post', 'page');
    foreach ($screens as $screen) {
        add_meta_box(
            'mts_sidebar_metabox',                  // id
            __('Sidebar', 'video' ),                // title
            'mts_inner_sidebar_metabox',            // callback
            $screen,                                // post_type
            'side',                                 // context (normal, advanced, side)
            'high'                                  // priority (high, core, default, low)
        );
    }
    add_meta_box(
        'mts_layout_metabox',                   // id
        __('Post Layout', 'video'),             // title
        'mts_inner_layout_metabox',             // callback
        'post',                                 // post_type
        'side',                                 // context (normal, advanced, side)
        'high'                                  // priority (high, core, default, low)
    );
}
add_action('add_meta_boxes', 'mts_add_sidebar_metabox');


/**
 * Print the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function mts_inner_sidebar_metabox($post) {
    global $wp_registered_sidebars;
    
    // Add an nonce field so we can check for it later.
    wp_nonce_field('mts_inner_sidebar_metabox', 'mts_inner_sidebar_metabox_nonce');
    
    /*
    * Use get_post_meta() to retrieve an existing value
    * from the database and use the value for the form.
    */
    $custom_sidebar = get_post_meta( $post->ID, '_mts_custom_sidebar', true );
    $sidebar_location = get_post_meta( $post->ID, '_mts_sidebar_location', true );

    // Select custom sidebar from dropdown
    echo '<select name="mts_custom_sidebar" id="mts_custom_sidebar" style="margin-bottom: 10px;">';
    echo '<option value="" '.selected('', $custom_sidebar).'>-- '.__('Default', 'video' ).' --</option>';
    
    // Exclude built-in sidebars
    $hidden_sidebars = array('sidebar', 'footer-bottom', 'footer-bottom-2', 'footer-bottom-3', 'footer-bottom-4', 'widget-header','shop-sidebar', 'product-sidebar');    
    
    foreach ($wp_registered_sidebars as $sidebar) {
        if (!in_array($sidebar['id'], $hidden_sidebars)) {
            echo '<option value="'.esc_attr($sidebar['id']).'" '.selected($sidebar['id'], $custom_sidebar, false).'>'.$sidebar['name'].'</option>';
        }
    }
    echo '<option value="mts_nosidebar" '.selected('mts_nosidebar', $custom_sidebar).'>-- '.__('No sidebar --', 'video' ).'</option>';
    echo '</select><br />';
    
    // Select single layout (left/right sidebar)
    echo '<div class="mts_sidebar_location_fields">';
    echo '<label for="mts_sidebar_location_default" style="display: inline-block; margin-right: 20px;"><input type="radio" name="mts_sidebar_location" id="mts_sidebar_location_default" value=""'.checked('', $sidebar_location, false).'>'.__('Default side', 'video' ).'</label>';
    echo '<label for="mts_sidebar_location_left" style="display: inline-block; margin-right: 20px;"><input type="radio" name="mts_sidebar_location" id="mts_sidebar_location_left" value="left"'.checked('left', $sidebar_location, false).'>'.__('Left', 'video' ).'</label>';
    echo '<label for="mts_sidebar_location_right" style="display: inline-block; margin-right: 20px;"><input type="radio" name="mts_sidebar_location" id="mts_sidebar_location_right" value="right"'.checked('right', $sidebar_location, false).'>'.__('Right', 'video' ).'</label>';
    echo '</div>';
    
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            function mts_toggle_sidebar_location_fields() {
                $('.mts_sidebar_location_fields').toggle(($('#mts_custom_sidebar').val() != 'mts_nosidebar'));
            }
            mts_toggle_sidebar_location_fields();
            $('#mts_custom_sidebar').change(function() {
                mts_toggle_sidebar_location_fields();
            });
        });
    </script>
    <?php
    //debug
    //global $wp_meta_boxes;
}

/**
 * Print the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function mts_inner_layout_metabox($post) {
    global $wp_registered_sidebars;
    
    // Add an nonce field so we can check for it later.
    wp_nonce_field('mts_inner_layout_metabox', 'mts_inner_layout_metabox_nonce');
    
    /*
    * Use get_post_meta() to retrieve an existing value
    * from the database and use the value for the form.
    */
    $post_layout = get_post_meta( $post->ID, '_mts_post_layout', true );

    // Select custom sidebar from dropdown
    echo '<select name="mts_post_layout" id="mts_post_layout">';
    echo '<option value="" '.selected('', $post_layout).'>-- '.__('Default', 'video').' --</option>';
    echo '<option value="crlayout" '.selected('crlayout', $post_layout).'>'.__('Layout 1', 'video').'</option>';
    echo '<option value="rclayout" '.selected('rclayout', $post_layout).'>'.__('Layout 2', 'video').'</option>';
    echo '<option value="cbrlayout" '.selected('cbrlayout', $post_layout).'>'.__('Layout 3', 'video').'</option>';
    echo '<option value="clsrlayout" '.selected('clsrlayout', $post_layout).'>'.__('Layout 4', 'video').'</option>';
      
    echo '</select><br />';
    
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 *
 * @return int
 */
function mts_save_custom_sidebar( $post_id ) {
    
    /*
    * We need to verify this came from our screen and with proper authorization,
    * because save_post can be triggered at other times.
    */
    
    // Check if our nonce is set.
    if ( ! isset( $_POST['mts_inner_sidebar_metabox_nonce'] ) )
    return $post_id;
    
    $nonce = $_POST['mts_inner_sidebar_metabox_nonce'];
    
    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce, 'mts_inner_sidebar_metabox' ) )
      return $post_id;
    
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;
    
    // Check the user's permissions.
    if ( 'page' == $_POST['post_type'] ) {
    
    if ( ! current_user_can( 'edit_page', $post_id ) )
        return $post_id;
    
    } else {
    
    if ( ! current_user_can( 'edit_post', $post_id ) )
        return $post_id;
    }
    
    /* OK, its safe for us to save the data now. */
    
    // Sanitize user input.
    $sidebar_name = sanitize_text_field( $_POST['mts_custom_sidebar'] );
    $sidebar_location = sanitize_text_field( $_POST['mts_sidebar_location'] );
    
    // Update the meta field in the database.
    update_post_meta( $post_id, '_mts_custom_sidebar', $sidebar_name );
    update_post_meta( $post_id, '_mts_sidebar_location', $sidebar_location );
}
add_action( 'save_post', 'mts_save_custom_sidebar' );

function mts_save_post_layout( $post_id ) {
    
    /*
    * We need to verify this came from our screen and with proper authorization,
    * because save_post can be triggered at other times.
    */
    
    // Check if our nonce is set.
    if ( ! isset( $_POST['mts_inner_layout_metabox_nonce'] ) )
    return $post_id;
    
    $nonce = $_POST['mts_inner_layout_metabox_nonce'];
    
    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce, 'mts_inner_layout_metabox' ) )
      return $post_id;
    
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;
    
    // Check the user's permissions.
    if ( 'page' == $_POST['post_type'] ) {
    
    if ( ! current_user_can( 'edit_page', $post_id ) )
        return $post_id;
    
    } else {
    
    if ( ! current_user_can( 'edit_post', $post_id ) )
        return $post_id;
    }
    
    /* OK, its safe for us to save the data now. */
    
    // Sanitize user input.
    $sidebar_name = sanitize_text_field( $_POST['mts_post_layout'] );
    
    // Update the meta field in the database.
    update_post_meta( $post_id, '_mts_post_layout', $sidebar_name );
}
add_action( 'save_post', 'mts_save_post_layout' );

/*-----------------------------------------------------------------------------------*/
/*  YoutTube Playlist Metabox
/*  Shown only when Post Format is Video
/*-----------------------------------------------------------------------------------*/
function mts_custom_meta() {
    add_meta_box( 'mts_meta', __( 'Video Options', 'video' ), 'mts_meta_callback', 'post', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'mts_custom_meta' );

function mts_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'mts_nonce' );
    $mts_stored_meta = get_post_meta( $post->ID );
    if (!isset($mts_stored_meta['youtube-select'])) $mts_stored_meta['youtube-select'] = array('');
    if (!isset($mts_stored_meta['video-service'])) $mts_stored_meta['video-service'] = array('0' => 'youtube');
    ?>

    <p>
        <label for="video-service" class="mts-row-title"><?php _e( 'Service:', 'video' )?></label>
        <select name="video-service" id="video-service">
            <option value="youtube" <?php selected('youtube', $mts_stored_meta['video-service'][0]) ?>><?php _e('YouTube', 'video'); ?></option>
            <option value="vimeo" <?php selected('vimeo', $mts_stored_meta['video-service'][0]) ?>><?php _e('Vimeo', 'video'); ?></option>
            <option value="dailymotion" <?php selected('dailymotion', $mts_stored_meta['video-service'][0]) ?>><?php _e('Dailymotion', 'video'); ?></option>
            <option value="facebook" <?php selected('facebook', $mts_stored_meta['video-service'][0]) ?>><?php _e('Facebook', 'video'); ?></option>
        </select>
    </p>

    <p data-parent-select-id="video-service" data-parent-select-value="youtube">
        <label for="video-select" class="mts-row-title"><input name="youtube-select" id="video-select" type="radio" value="video-id" <?php checked( $mts_stored_meta['youtube-select'][0], 'video-id' ); ?>><?php _e( 'Video', 'video' )?></label>&nbsp;&nbsp;
        <label for="playlist-select" class="mts-row-title"><input name="youtube-select" id="playlist-select" type="radio" value="playlist-id" <?php checked( $mts_stored_meta['youtube-select'][0], 'playlist-id' ); ?>><?php _e( 'Playlist', 'video' )?></label>
    </p>
 
    <p data-parent-select-id="video-service" data-parent-select-value="youtube">
        <label for="playlist-id" class="mts-row-title"><?php _e( 'YouTube Playlist/Video ID', 'video' )?></label>
        <input type="text" name="playlist-id" id="playlist-id" value="<?php if ( isset ( $mts_stored_meta['playlist-id'] ) ) echo $mts_stored_meta['playlist-id'][0]; ?>" style="width:100%;"/>
    </p>

    <p data-parent-select-id="video-service" data-parent-select-value="vimeo">
        <label for="vimeo-video-id" class="mts-row-title"><?php _e( 'Vimeo Video ID', 'video' )?></label>
        <input type="text" name="vimeo-video-id" id="vimeo-video-id" value="<?php if ( isset ( $mts_stored_meta['vimeo-video-id'] ) ) echo $mts_stored_meta['vimeo-video-id'][0]; ?>" style="width:100%;"/>
    </p>

    <p data-parent-select-id="video-service" data-parent-select-value="dailymotion">
        <label for="dm-video-id" class="mts-row-title"><?php _e( 'Dailymotion ID [Short URL ID]', 'video' )?></label><br />
        <label for="dm-video-id" class="mts-row-description" style="font-style:italic"><?php _e( 'Make sure API key is set in Options Panel', 'video' )?></label><br />
        <input type="text" name="dm-video-id" id="dm-video-id" value="<?php if ( isset ( $mts_stored_meta['dm-video-id'] ) ) echo $mts_stored_meta['dm-video-id'][0]; ?>" style="width:100%;"/>
    </p>

    <p data-parent-select-id="video-service" data-parent-select-value="facebook">
        <label for="facebook-video-id" class="mts-row-title"><?php _e( 'Facebook Video ID', 'video' )?></label>
        <input type="text" name="facebook-video-id" id="facebook-video-id" value="<?php if ( isset ( $mts_stored_meta['facebook-video-id'] ) ) echo $mts_stored_meta['facebook-video-id'][0]; ?>" style="width:100%;"/>
    </p>

    <p>
        <?php $autoplay = isset ( $mts_stored_meta['autoplay-video'] ) ? $mts_stored_meta['autoplay-video'][0] : ''; ?>
        <label for="autoplay-video" class="mts-row-title"><?php _e( 'Autoplay:', 'video' )?></label>
        <select name="autoplay-video" id="autoplay-video">
            <option value="" <?php selected('', $autoplay) ?>><?php _e('Default', 'video'); ?></option>
            <option value="yes" <?php selected('yes', $autoplay) ?>><?php _e('On', 'video'); ?></option>
            <option value="no" <?php selected('no', $autoplay) ?>><?php _e('Off', 'video'); ?></option>
        </select>
    </p>

    <p data-parent-select-id="video-service" data-parent-select-value="youtube,vimeo,dailymotion,facebook" style="width:50%; float: left; margin-top:0;">
        <?php $start = isset ( $mts_stored_meta['video-start-time'] ) ? $mts_stored_meta['video-start-time'][0] : ''; ?>
        <label for="video-start-time" class="mts-row-title"><?php _e( 'Start Time (seconds)', 'video' )?></label>
        <input type="text" name="video-start-time" id="video-start-time" value="<?php echo $start; ?>" style="max-width: 100%;"/>
    </p>

    <p data-parent-select-id="video-service" data-parent-select-value="youtube,vimeo,dailymotion" style="width:47%; float: right; margin-top: 0;">
        <?php $end = isset ( $mts_stored_meta['video-end-time'] ) ? $mts_stored_meta['video-end-time'][0] : ''; ?>
        <label for="video-end-time" class="mts-row-title"><?php _e( 'End Time (seconds)', 'video' )?></label>
        <input type="text" name="video-end-time" id="video-end-time" value="<?php echo $end; ?>" style="max-width: 100%;"/>
    </p>
    <em data-parent-select-id="video-service" data-parent-select-value="youtube,vimeo,dailymotion" class="clear"><?php _e( 'Leave empty if you want video to play to its Start or End', 'video' )?></em>
    <p class="clear">
        <label for="submitted-by" class="mts-row-title"><?php _e( 'Submitted by', 'video' )?></label>
        <input type="text" name="submitted-by" id="submitted-by" value="<?php if ( isset ( $mts_stored_meta['submitted-by'] ) ) echo $mts_stored_meta['submitted-by'][0]; ?>" style="width: 100%"/>
    </p>
    <p data-parent-select-id="video-service" data-parent-select-value="youtube,dailymotion">
        <?php $related = isset ( $mts_stored_meta['show-related'] ) ? $mts_stored_meta['show-related'][0] : 'no'; ?>
        <label for="show-related" class="mts-row-title">
            <input type="checkbox" name="show-related" id="show-related" value="1" <?php checked( $related, 'yes' ); ?> />
            <?php _e( 'Show Related Videos', 'video' ); ?>
        </label>
    </p>
    
    <?php
}

/**
 * Saves the custom youtube input
 */
function mts_meta_save( $post_id ) {
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'mts_nonce' ] ) && wp_verify_nonce( $_POST[ 'mts_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    
    if ( !empty($_POST[ 'submitted-by' ]) ) update_post_meta( $post_id, 'submitted-by', sanitize_text_field( $_POST[ 'submitted-by' ] ) );

    // Checks for input and sanitizes/saves if needed
    if ( isset( $_POST[ 'playlist-id' ] ) ) {
        $video_id = $_POST[ 'playlist-id' ];
        if (substr($video_id, 0, 4) == 'http') {
            if( !empty( $_POST[ 'youtube-select' ] ) && $_POST[ 'youtube-select' ] == 'video-id' ) {
                if (preg_match('/v=([a-z0-9_-]+)/i', $video_id, $matches))
                    $video_id = $matches[1];
            } else {
                if (preg_match('/list=([a-z0-9_-]+)/i', $video_id, $matches))
                    $video_id = $matches[1];
            }
        }

        if ( get_post_meta( $post_id, 'playlist-id', true ) != $video_id ) {
            update_post_meta( $post_id, 'playlist-id', sanitize_text_field( $video_id ) );
            update_post_meta( $post_id, 'video-length', '' );
            update_post_meta( $post_id, 'video-views', '' );
        }
    }

    // Checks for input and saves if needed
    if ( isset( $_POST[ 'youtube-select' ] ) ) {
        update_post_meta( $post_id, 'youtube-select', $_POST[ 'youtube-select' ] );
    }

    if ( isset( $_POST[ 'vimeo-video-id' ] ) ) {
        $vimeo_id = $_POST[ 'vimeo-video-id' ];

        if ( get_post_meta( $post_id, 'vimeo-video-id', true ) != $vimeo_id ) {
            update_post_meta( $post_id, 'vimeo-video-id', sanitize_text_field( $vimeo_id ) );
            update_post_meta( $post_id, 'video-views', '' );
        }
    }

    if ( isset( $_POST[ 'dm-video-id' ] ) ) {
        $dm_id = $_POST[ 'dm-video-id' ];

        if ( get_post_meta( $post_id, 'dm-video-id', true ) != $dm_id ) {
            update_post_meta( $post_id, 'dm-video-id', sanitize_text_field( $dm_id ) );
            update_post_meta( $post_id, 'video-views', '' );
        }
    }

    if ( isset( $_POST[ 'facebook-video-id' ] ) ) {
        $facebook_id = $_POST[ 'facebook-video-id' ];

        if ( get_post_meta( $post_id, 'facebook-video-id', true ) != $facebook_id ) {
            update_post_meta( $post_id, 'facebook-video-id', sanitize_text_field( $facebook_id ) );
            update_post_meta( $post_id, 'video-views', '' );
        }
    }

    if ( isset( $_POST[ 'video-service' ] ) ) {
        $service = $_POST[ 'video-service' ];

        if ( get_post_meta( $post_id, 'video-service', true ) != $service ) {
            update_post_meta( $post_id, 'video-service', sanitize_text_field( $service ) );
            update_post_meta( $post_id, 'video-views', '' );
        }
    }

    if ( isset( $_POST['autoplay-video'] ) ) {
        update_post_meta( $post_id, 'autoplay-video', $_POST['autoplay-video'] );
    }

    if ( isset( $_POST['show-related'] ) ) {
        $related = 'yes';
    } else {
        $related = 'no';
    }
    update_post_meta( $post_id, 'show-related', $related );

    $start = isset( $_POST['video-start-time'] ) ? $_POST['video-start-time'] : '';
    update_post_meta( $post_id, 'video-start-time', $start );

    $end = isset( $_POST['video-end-time'] ) ? $_POST['video-end-time'] : '';
    update_post_meta( $post_id, 'video-end-time', $end );
 
}
add_action( 'save_post', 'mts_meta_save' );

function mts_custom_meta_enqueue( $hook_suffix ) {
    if( 'post.php' == $hook_suffix || 'post-new.php' == $hook_suffix ) {
        wp_enqueue_script( 'video_theme_metabox', get_template_directory_uri() . '/js/admin.js', array( 'jquery' ));
    }
}
add_action( 'admin_enqueue_scripts', 'mts_custom_meta_enqueue' );