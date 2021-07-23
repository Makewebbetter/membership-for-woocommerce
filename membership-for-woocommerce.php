<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link    https://makewebbetter.com/
 * @since   1.0.0
 * @package Membership_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Membership For WooCommerce
 * Plugin URI:        https://makewebbetter.com/product/membership-for-woocommerce/
 * Description:       Membership for WooCommerce plugin provides restrictions on access for any facility with recurring revenue to engage more customers.
 * Version:           1.1.0
 * Author:            MakeWebBetter
 * Author URI:        https://makewebbetter.com/
 * Text Domain:       membership-for-woocommerce
 * Domain Path:       /languages
 *
 * Requires at least: 5.0
 * Tested up to:      5.7.2
 * WC requires at least: 4.0
 * WC tested up to:   5.5.1
 *
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}




/**
 * Function to check for plugin activation.
 *
 * @param string $plugin_slug is the slug of the plugin.
 */
function mwb_membership_is_plugin_active( $plugin_slug = '' ) {
	if ( empty( $plugin_slug ) ) {

		return;
	}

	$active_plugins = (array) get_option( 'active_plugins', array() );

	if ( is_multisite() ) {

		$active_plugins = array_merge( $active_plugins, get_option( 'active_sitewide_plugins', array() ) );
	}

	return in_array( $plugin_slug, $active_plugins, true ) || array_key_exists( $plugin_slug, $active_plugins );
}

/**
 * Checking whether the dependent plugin is active or not.
 */
function mwb_membership_plugin_activation() {
	$activation['status']  = true;
	$activation['message'] = '';

	// If dependent plugin is not active.
	if ( ! mwb_membership_is_plugin_active( 'woocommerce/woocommerce.php' ) ) {

		$activation['status']  = false;
		$activation['message'] = 'woo_inactive';
	}

	return $activation;

}

// The following code runs during the activation of the plugin.
$mwb_membership_plugin_activation = mwb_membership_plugin_activation();

if ( true === $mwb_membership_plugin_activation['status'] ) {


	/**
	 * Define plugin constants.
	 *
	 * @since 1.0.0
	 */
	function define_membership_for_woocommerce_constants() {
		membership_for_woocommerce_constants( 'MEMBERSHIP_FOR_WOOCOMMERCE_VERSION', '1.0.0' );
		membership_for_woocommerce_constants( 'MEMBERSHIP_FOR_WOOCOMMERCE_DIR_PATH', plugin_dir_path( __FILE__ ) );
		membership_for_woocommerce_constants( 'MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL', plugin_dir_url( __FILE__ ) );
		membership_for_woocommerce_constants( 'MEMBERSHIP_FOR_WOOCOMMERCE_SERVER_URL', 'https://makewebbetter.com' );
		membership_for_woocommerce_constants( 'MEMBERSHIP_FOR_WOOCOMMERCE_ITEM_REFERENCE', 'Membership For WooCommerce' );
	}

	/**
	 * Define mwb-site update feature.
	 *
	 * @since 1.0.0
	 */
	function auto_update_membership_for_woocommerce() {
		 $mwb_mfw_license_key = get_option( 'mwb_mfw_license_key', '' );
		if ( ! defined( 'MEMBERSHIP_FOR_WOOCOMMERCE_SPECIAL_SECRET_KEY' ) ) {
			define( 'MEMBERSHIP_FOR_WOOCOMMERCE_SPECIAL_SECRET_KEY', '59f32ad2f20102.74284991' );
		}

		if ( ! defined( 'MEMBERSHIP_FOR_WOOCOMMERCE_LICENSE_SERVER_URL' ) ) {
			define( 'MEMBERSHIP_FOR_WOOCOMMERCE_LICENSE_SERVER_URL', 'https://makewebbetter.com' );
		}

		if ( ! defined( 'MEMBERSHIP_FOR_WOOCOMMERCE_ITEM_REFERENCE' ) ) {
			define( 'MEMBERSHIP_FOR_WOOCOMMERCE_ITEM_REFERENCE', 'Membership For WooCommerce' );
		}
		membership_for_woocommerce_constants( 'MEMBERSHIP_FOR_WOOCOMMERCE_BASE_FILE', __FILE__ );
		membership_for_woocommerce_constants( 'MEMBERSHIP_FOR_WOOCOMMERCE_LICENSE_KEY', $mwb_mfw_license_key );

	}

	/**
	 * Callable function for defining plugin constants.
	 *
	 * @param String $key   Key for contant.
	 * @param String $value value for contant.
	 * @since 1.0.0
	 */
	function membership_for_woocommerce_constants( $key, $value ) {
		if ( ! defined( $key ) ) {

			define( $key, $value );
		}
	}

	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-membership-for-woocommerce-activator.php
	 */
	function activate_membership_for_woocommerce() {
		
		include_once plugin_dir_path( __FILE__ ) . 'includes/class-membership-for-woocommerce-activator.php';
		Membership_For_Woocommerce_Activator::activate();
		Membership_For_Woocommerce_Activator::membership_for_woocommerce_activate();
		$mwb_mfw_active_plugin = get_option( 'mwb_all_plugins_active', false );
		if ( is_array( $mwb_mfw_active_plugin ) && ! empty( $mwb_mfw_active_plugin ) ) {
			$mwb_mfw_active_plugin['membership-for-woocommerce'] = array(
				'plugin_name' => __( 'Membership For WooCommerce', 'membership-for-woocommerce' ),
				'active' => '1',
			);
		} else {
			$mwb_mfw_active_plugin = array();
			$mwb_mfw_active_plugin['membership-for-woocommerce'] = array(
				'plugin_name' => __( 'Membership For WooCommerce', 'membership-for-woocommerce' ),
				'active' => '1',
			);
		}
		update_option( 'mwb_all_plugins_active', $mwb_mfw_active_plugin );
	}

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-membership-for-woocommerce-deactivator.php
	 */
	function deactivate_membership_for_woocommerce() {
		include_once plugin_dir_path( __FILE__ ) . 'includes/class-membership-for-woocommerce-deactivator.php';
		Membership_For_Woocommerce_Deactivator::membership_for_woocommerce_deactivate();
		$mwb_mfw_deactive_plugin = get_option( 'mwb_all_plugins_active', false );
		if ( is_array( $mwb_mfw_deactive_plugin ) && ! empty( $mwb_mfw_deactive_plugin ) ) {
			foreach ( $mwb_mfw_deactive_plugin as $mwb_mfw_deactive_key => $mwb_mfw_deactive ) {
				if ( 'membership-for-woocommerce' === $mwb_mfw_deactive_key ) {
					$mwb_mfw_deactive_plugin[ $mwb_mfw_deactive_key ]['active'] = '0';
				}
			}
		}
		update_option( 'mwb_all_plugins_active', $mwb_mfw_deactive_plugin );
	}

	register_activation_hook( __FILE__, 'activate_membership_for_woocommerce' );
	register_deactivation_hook( __FILE__, 'deactivate_membership_for_woocommerce' );

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-membership-for-woocommerce.php';


	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since 1.0.0
	 */
	function run_membership_for_woocommerce() {
		 define_membership_for_woocommerce_constants();
		auto_update_membership_for_woocommerce();
		$mfw_plugin_standard = new Membership_For_Woocommerce();
		$mfw_plugin_standard->mfw_run();
		$GLOBALS['mfw_mwb_mfw_obj'] = $mfw_plugin_standard;

	}
	run_membership_for_woocommerce();


	// Add settings link on plugin page.
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'membership_for_woocommerce_settings_link' );

	/**
	 * Settings link.
	 *
	 * @since 1.0.0
	 * @param Array $links Settings link array.
	 */
	function membership_for_woocommerce_settings_link( $links ) {
		$my_link = array(
			'<a href="' . admin_url( 'admin.php?page=membership_for_woocommerce_menu' ) . '">' . __( 'Settings', 'membership-for-woocommerce' ) . '</a>',
		);
		return array_merge( $my_link, $links );
	}

	/**
	 * Adding custom setting links at the plugin activation list.
	 *
	 * @param  array  $links_array      array containing the links to plugin.
	 * @param  string $plugin_file_name plugin file name.
	 * @return array
	 */
	function membership_for_woocommerce_custom_settings_at_plugin_tab( $links_array, $plugin_file_name ) {
		if ( strpos( $plugin_file_name, basename( __FILE__ ) ) ) {
			$links_array[] = '<a href="https://demo.makewebbetter.com/membership-for-woocommerce/?utm_source=MWB-membership-backend&utm_medium=MWB-ORG-Page&utm_campaign=MWB-demo" target="_blank"><img src="' . esc_html( MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL ) . 'admin/image/Demo.svg" class="mwb-info-img" alt="Demo image">' . __( 'Demo', 'membership-for-woocommerce' ) . '</a>';
			$links_array[] = '<a href="https://docs.makewebbetter.com/membership-for-woocommerce/?utm_source=MWB-membership-backend&utm_medium=MWB-ORG-Page&utm_campaign=MWB-doc" target="_blank"><img src="' . esc_html( MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL ) . 'admin/image/Documentation.svg" class="mwb-info-img" alt="documentation image">' . __( 'Documentation', 'membership-for-woocommerce' ) . '</a>';
			$links_array[] = '<a href="https://support.makewebbetter.com/wordpress-plugins-knowledge-base/category/membership-for-woocommerce/?utm_source=MWB-membership-backend&utm_medium=MWB-ORG-Page&utm_campaign=MWB-support" target="_blank"><img src="' . esc_html( MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL ) . 'admin/image/Support.svg" class="mwb-info-img" alt="support image">' . __( 'Support', 'membership-for-woocommerce' ) . '</a>';
		}
		return $links_array;
	}
	add_filter( 'plugin_row_meta', 'membership_for_woocommerce_custom_settings_at_plugin_tab', 10, 2 );


} else {

	// Deactivate the plugin if Woocommerce not active.
	add_action( 'admin_init', 'mwb_membership_plugin_activation_failure' );

	/**
	 * Deactivate the plugin.
	 */
	function mwb_membership_plugin_activation_failure() {

		deactivate_plugins( plugin_basename( __FILE__ ) );
	}

	// Add admin error notice.
	add_action( 'admin_notices', 'mwb_membership_plugin_activation_notice' );

	/**
	 * This function displays plugin activation error notices.
	 */
	function mwb_membership_plugin_activation_notice() {

		global $mwb_membership_plugin_activation;

		// To hide Plugin activated notice.
		unset( $_GET['activate'] );

		?>

		<?php if ( 'woo_inactive' === $mwb_membership_plugin_activation['message'] ) { ?>

			<div class="notice notice-error is-dismissible">
				<p><strong><?php esc_html_e( 'WooCommerce', 'membership-for-woocommerce-pro' ); ?></strong><?php esc_html_e( ' is not activated, Please activate WooCommerce first to activate ', 'membership-for-woocommerce-pro' ); ?><strong><?php esc_html_e( 'Membership For WooCommerce', 'membership-for-woocommerce-pro' ); ?></strong><?php esc_html_e( '.', 'membership-for-woocommerce-pro' ); ?></p>
			</div>

			<?php
		}
	}
}



