<?php
/**
 * Plugin Name: Youtube Auto Post 
 * Plugin URI:  
 * Description: Auto post video by channel youtube, for Video MythemeShop theme.
 * Version: 1.0 
 * Author: trongle
 * Author URI:
 * License: GPLv2 
 */

function register_mysettings() {
        register_setting( 'mfpd-settings-group', 'mfpd_option_name' );
}
 
function mfpd_create_menu() {
        add_menu_page('My First Plugin Settings', 'Auto Post YT', 'administrator', __FILE__, 'mfpd_settings_page',plugins_url('/assets/images/icon.png', __FILE__), 1);
        add_action( 'admin_init', 'register_mysettings' );
}
add_action('admin_menu', 'mfpd_create_menu'); 
 
function mfpd_settings_page() {
?>
<div class="wrap">
<h2>List youtube channel</h2>
<?php if( isset($_GET['settings-updated']) ) { ?>
    <div id="message" class="updated">
        <p><strong><?php _e('Settings saved.') ?></strong></p>
    </div>
<?php } ?>
<form method="post" action="options.php">
    <?php settings_fields( 'mfpd-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Input</th>
        <td><textarea rows="5" cols="80" name="mfpd_option_name" value="<?php echo get_option('mfpd_option_name'); ?>" ></textarea></td>
        </tr>
    </table>
    <?php submit_button(); ?>
</form>
</div>
<?php } ?>