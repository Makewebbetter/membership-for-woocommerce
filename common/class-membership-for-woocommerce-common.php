<?php
/**
 * The common functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Membership_For_Woocommerce
 * @subpackage Membership_For_Woocommerce/common
 */

/**
 * The common functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the common stylesheet and JavaScript.
 * namespace membership_for_woocommerce_common.
 *
 * @package    Membership_For_Woocommerce
 * @subpackage Membership_For_Woocommerce/common
 */
class Membership_For_Woocommerce_Common {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Creating Instance of the global functions class.
	 *
	 * @var object
	 */
	public $global_class;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->global_class = Membership_For_Woocommerce_Global_Functions::get();
	}

	/**
	 * Register the stylesheets for the common side of the site.
	 *
	 * @since    1.0.0
	 */
	public function mfw_common_enqueue_styles() {
		wp_enqueue_style( $this->plugin_name . 'common', MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL . 'common/css/membership-for-woocommerce-common.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the common side of the site.
	 *
	 * @since    1.0.0
	 */
	public function mfw_common_enqueue_scripts() {
		wp_register_script( $this->plugin_name . 'common', MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL . 'common/js/membership-for-woocommerce-common.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name . 'common', 'mfw_common_param', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script( $this->plugin_name . 'common' );
	}

	/**
	 * Ajax function for membership checkout.
	 *
	 * @return void
	 */
	public function mwb_membership_checkout() {

		check_ajax_referer( 'auth_adv_nonce', 'nonce' );
		$plan_id    = isset( $_POST['plan_id'] ) ? sanitize_text_field( wp_unslash( $_POST['plan_id'] ) ) : '';
		$plan_price = isset( $_POST['plan_price'] ) ? sanitize_text_field( wp_unslash( $_POST['plan_price'] ) ) : '';
		$plan_title = isset( $_POST['plan_title'] ) ? sanitize_text_field( wp_unslash( $_POST['plan_title'] ) ) : '';

		$mwb_membership_default_product = get_option( 'mwb_membership_default_product', '' );

		global $wp_session;

		$wp_session['plan_price'] = $plan_price;
		$wp_session['plan_title'] = $plan_title;
		$wp_session['plan_id']    = $plan_id;
		WC()->session->set( 'plan_id', $plan_id );
		WC()->session->set( 'plan_title', $plan_title );
		WC()->session->set( 'plan_price', $plan_price );
		WC()->session->set( 'product_id', $mwb_membership_default_product );

		$cart_item_data = add_filter( 'woocommerce_add_cart_item_data', array( $this, 'add_membership_product_price_to_cart_item_data' ), 10, 2 );

		$redirect_url = wc_get_cart_url();
		echo wp_json_encode( $redirect_url );

		wp_die();
	}


	/**
	 * WooCommerce add cart item data.
	 *
	 * @param array $cart_item_data cart item data.
	 * @param int   $product_id product id.
	 * @return array
	 */
	public function add_membership_product_price_to_cart_item_data( $cart_item_data, $product_id ) {
		$product = wc_get_product( $product_id );

		global $wp_session;

		if ( $product ) {
			$cart_item_data['plan_price'] = $wp_session['plan_price'];
			$cart_item_data['plan_title'] = $wp_session['plan_title'];
		}
		$cart_item_data = apply_filters( 'add_membership_product_price_to_cart_item_data', $cart_item_data );
		$mwb_membership_default_product = get_option( 'mwb_membership_default_product', '' );
		return $cart_item_data;
	}



	/**
	 * Callback function for file Upload and import.
	 */
	public function mwb_membership_csv_file_upload() {

		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-membership-activity-helper.php';

		// Handling file upload using activity helper class..
		$activity_class = new Membership_Activity_Helper( 'csv-uploads', 'uploads' );
		// phpcs:disable
		$csv_file    = ! empty( $_FILES['file'] ) ? map_deep( wp_unslash( $_FILES['file'] ), 'sanitize_text_field' ) : ''; // phpcs:ignore

		// phpcs:enable
		$upload_file = $activity_class->do_upload( $csv_file, array( 'csv' ) );

		if ( ! current_user_can( 'edit_posts' ) ) {
			exit;
		}

		if ( $upload_file && ( true === $upload_file['result'] ) ) {

			$file_url = $upload_file['url'];
			$csv      = array_map( 'str_getcsv', file( $file_url ) );

			unset( $csv[0] ); // Removing first key after CSV data is converted to array.

			// Getting a formatted CSV data.
			$formatted_csv_data = $this->global_class->csv_data_map( $csv );

			// Getting all Product titles from woocommerce store.
			$all_prod_title = $this->global_class->all_prod_title();

			// Getting all Category titles from woocommerce store.
			$all_cat_title = $this->global_class->all_cat_title();

			$prd_check = '';
			$cat_check = '';

			$csv_prod_title = $this->global_class->csv_prod_title( $csv ); // Getting all product titles from csv.
			$csv_cate_title = $this->global_class->csv_cat_title( $csv ); // Getting all category titles from csv.

			if ( is_array( $csv_prod_title ) && is_array( $csv_cate_title ) ) {

				foreach ( $csv_prod_title as $key => $value ) {

					if ( in_array( $value, $all_prod_title, true ) ) {

						$prd_check = true;
					}
				}

				foreach ( $csv_cate_title as $key => $value ) {

					if ( in_array( $value, $all_cat_title, true ) ) {

						$cat_check = true;
					}
				}
			}

			$args = array(
				'post_type'   => 'mwb_cpt_membership',
				'post_status' => array( 'publish' ),
				'numberposts' => -1,
			);

			$check = '';
			$all_plan_array = array();
			$all_plans = get_posts( $args );
			foreach ( $all_plans as $single_plan ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited */

				array_push( $all_plan_array, $single_plan->post_title );
			}

			// If product ids and category ids from csv match from those of woocommerce, then only import the file.
			if ( true === $prd_check || true === $cat_check ) {
				foreach ( $formatted_csv_data as $key => $value ) {
					if ( in_array( $value['post_title'], (array) $all_plan_array ) ) {
						$value['post_title'] = $value['post_title'] . '-copied';
					}
					if ( ! empty( $value['post_title'] ) ) {
						$plan_id = wp_insert_post(
							array(
								'post_type'    => 'mwb_cpt_membership',
								'post_title'   => $value['post_title'],
								'post_status'  => $value['post_status'],
								'post_content' => $value['post_content'],
							),
							true
						);

						update_post_meta( $plan_id, 'mwb_membership_plan_price', $value['mwb_membership_plan_price'] );
						update_post_meta( $plan_id, 'mwb_membership_plan_name_access_type', $value['mwb_membership_plan_name_access_type'] );
						update_post_meta( $plan_id, 'mwb_membership_plan_duration', $value['mwb_membership_plan_duration'] );
						update_post_meta( $plan_id, 'mwb_membership_plan_duration_type', $value['mwb_membership_plan_duration_type'] );
						update_post_meta( $plan_id, 'mwb_membership_plan_recurring', $value['mwb_membership_plan_recurring'] );
						update_post_meta( $plan_id, 'mwb_membership_plan_access_type', $value['mwb_membership_plan_access_type'] );
						update_post_meta( $plan_id, 'mwb_membership_plan_time_duration', $value['mwb_membership_plan_time_duration'] );
						update_post_meta( $plan_id, 'mwb_membership_plan_time_duration_type', $value['mwb_membership_plan_time_duration_type'] );
						update_post_meta( $plan_id, 'mwb_membership_plan_offer_price_type', $value['mwb_membership_plan_offer_price_type'] );
						update_post_meta( $plan_id, 'mwb_memebership_plan_discount_price', $value['mwb_memebership_plan_discount_price'] );
						update_post_meta( $plan_id, 'mwb_memebership_plan_free_shipping', $value['mwb_memebership_plan_free_shipping'] );
						update_post_meta( $plan_id, 'mwb_membership_plan_target_ids', $value['mwb_membership_plan_target_ids'] );
						update_post_meta( $plan_id, 'mwb_membership_plan_target_categories', $value['mwb_membership_plan_target_categories'] );
					}
				}

				echo wp_json_encode(
					array(
						'status'   => 'success',
						'message'  => 'File Imported Successfully',
						'redirect' => admin_url( 'edit.php?post_type=mwb_cpt_membership' ),
					)
				);

			} else {

				echo wp_json_encode(
					array(
						'status'   => 'failed',
						'message'  => 'Something Went Wrong. Either Products or Categories are not available!',
						'redirect' => admin_url( 'edit.php?post_type=mwb_cpt_membership' ),
					)
				);
			}
		}

		wp_die();
	}



	/**
	 * Membership status update according to subscription renewal.
	 *
	 * @param mixed $mwb_new_order new order id.
	 * @param mixed $subscription_id subscription id.
	 * @param mixed $payment_method is the method for payment of subscription.
	 * @return array
	 */
	public function mwb_membership_subscription_renewal( $mwb_new_order, $subscription_id, $payment_method ) {
		$expiry_date = '';
		$next_payment_date = get_post_meta( $subscription_id, 'mwb_next_payment_date', true );
		$end_payment_date =	get_post_meta( $subscription_id, 'mwb_susbcription_end' );
		if ( ! empty( $next_payment_date ) ) {
			$expiry_date = $next_payment_date;
		} elseif ( ! empty( $end_payment_date ) ) {
			$expiry_date = $end_payment_date;
		}
		$subscription = get_post( $subscription_id );
		$parent_order_id  = $subscription->mwb_parent_order;
	
		$order_status  = $mwb_new_order->get_status();
		if ( 'processing' == $order_status || 'complete' == $order_status ) {

			$order = wc_get_order( $parent_order_id );
			$member_id = '';
			foreach ( $order->get_items() as $item_id => $item ) {
	
				if ( ! empty( $item->get_meta( '_member_id' ) ) ) {
					$member_id = $item->get_meta( '_member_id' );
				}
			}

			if ( ! empty( $member_id ) ) {
				update_post_meta( $member_id, 'member_status', 'complete' );
				update_post_meta( $member_id, 'member_expiry', $expiry_date  );
			}
		}
	}



	/**
	 * Update the option for settings from the multistep form.
	 * 
	 * @name mwb_standard_save_settings_filter
	 * @since 1.0.0
	*/
	public function mwb_standard_save_settings_filter() {
		check_ajax_referer( 'ajax-nonce', 'nonce' );

		$term_accpted = ! empty( $_POST['consetCheck'] ) ? sanitize_text_field( wp_unslash( $_POST['consetCheck'] ) ) : ' ';
		if ( ! empty( $term_accpted ) && 'yes' == $term_accpted ) {
			update_option( 'mfw_enable_tracking', 'on' );
		}
		//settings fields.
		$first_name = ! empty( $_POST['firstName'] ) ? sanitize_text_field( wp_unslash( $_POST['firstName'] ) ) : '';
		update_option( 'firstname', $first_name );

		$email = ! empty( $_POST['email'] ) ? sanitize_text_field( wp_unslash( $_POST['email'] ) ) : '';
		update_option( 'email', $email );

		$desc = ! empty( $_POST['desc'] ) ? sanitize_text_field( wp_unslash( $_POST['desc'] ) ) : '';
		update_option( 'desc', $desc );

		$age = ! empty( $_POST['age'] ) ? sanitize_text_field( wp_unslash( $_POST['age'] ) ) : '';
		update_option( 'age', $age );

		$first_checkbox = ! empty( $_POST['FirstCheckbox'] ) ? sanitize_text_field( wp_unslash( $_POST['FirstCheckbox'] ) ) : '';
		update_option( 'first_checkbox', $first_checkbox );

		$checked_first_switch = ! empty( $_POST['checkedA'] ) ? sanitize_text_field( wp_unslash( $_POST['checkedA'] ) ) : '';
		if ( ! empty( $checked_first_switch ) && $checked_first_switch ) {
			update_option( 'mwb_membership_enable_plugin', 'on' );
		}

		$MemPlanAmount = ! empty( $_POST['memPlanAmount'] ) ? sanitize_text_field( wp_unslash( $_POST['memPlanAmount'] ) ) : '';
		update_option( 'Mem_Plan_Amount', $MemPlanAmount );

		$MemPlanTitle = ! empty( $_POST['memPlanTitle'] ) ? sanitize_text_field( wp_unslash( $_POST['memPlanTitle'] ) ) : '';
		update_option( 'Mem_Plan_Title', $MemPlanTitle );

		$MemPlanProduct = ! empty( $_POST['memPlanProduct'] ) ? sanitize_text_field( wp_unslash( $_POST['memPlanProduct'] ) ) : '';
		update_option( 'Mem_Plan_Product', $MemPlanProduct );


		$post_id = wp_insert_post(array (
		'post_type' => 'mwb_cpt_membership',
		'post_title' => $MemPlanTitle,
		'post_content' => '',
		'post_status' => 'publish',
		'comment_status' => 'closed',   // if you prefer
		'ping_status' => 'closed',      // if you prefer
		'meta_input' => array(
			'mwb_membership_plan_price' => $MemPlanAmount,
			// and so on ;)
		)
	));

	$product_array = array();
	array_push( $product_array, $MemPlanProduct );
	update_post_meta( $post_id , 'mwb_membership_plan_target_ids_search', $MemPlanProduct );
	
	

		update_option( 'mfw_mfw_plugin_standard_multistep_done', 'yes' );

	
		wp_send_json( 'yes' );
	}

	
}
