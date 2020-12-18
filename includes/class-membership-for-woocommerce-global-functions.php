<?php
/**
 * The admin-public functionality of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Membership_For_Woocommerce
 * @subpackage Membership_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Membership_For_Woocommerce
 * @subpackage Membership_For_Woocommerce/admin
 * @author     Make Web Better <plugins@makewebbetter.com>
 */
class Membership_For_Woocommerce_Global_Functions {

	/**
	 * Instance of the class
	 *
	 * @var object
	 */
	public static $instance;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		self::$instance = $this;
	}

	/**
	 * Returns Instcance of the class
	 */
	public static function get() {

		if ( null == self::$instance ) {

			self::$instance = new self();
		}
		return self::$instance;
	}


	/**
	 * Allowed html for description on admin side
	 *
	 * @param string $description tooltip message.
	 *
	 * @since 1.0.0
	 */
	public function tool_tip( $description = '' ) {

		// Run only if description message is present.
		if ( ! empty( $description ) ) {

			$allowed_html = array(
				'span' => array(
					'class'    => array(),
					'data-tip' => array(),
				),
			);

			echo wp_kses( wc_help_tip( $description ), $allowed_html );
		}
	}

	/**
	 * Returns product name and status.
	 *
	 * @param string $product_id Product id of a particular product.
	 *
	 * @since 1.0.0
	 */
	public function get_product_title( $product_id = '' ) {

		if ( ! empty( $product_id ) ) {

			$result = esc_html__( 'Product not found', 'membership-for-woocommerce' );

			$product = wc_get_product( $product_id );

			if ( ! empty( $product ) ) {

				if ( 'publish' != $product->get_status() ) {

					$result = esc_html__( 'Product unavailable', 'membership-for-woocommerce' );

				} else {

					$result = get_the_title( $product_id );

				}
			}

			return $result;
		}
	}

	/**
	 * Return category name and its existance
	 *
	 * @param string $cat_id Category ID of a particular category.
	 *
	 * @since 1.0.0
	 */
	public function get_category_title( $cat_id = '' ) {

		if ( ! empty( $cat_id ) ) {

			$result = esc_html__( 'Category not found', 'membership-for-woocommerce' );

			$cat_name = get_the_category_by_ID( $cat_id );

			if ( ! empty( $cat_name ) ) {

				$result = $cat_name;

			}

			return $result;
		}
	}

	/**
	 * Membership default global options.
	 *
	 * @since 1.0.0
	 */
	public function default_global_options() {

		$default_global_settings = array(

			'mwb_membership_enable_plugin'              => 'on',
			'mwb_membership_manage_content'             => 'hide_for_non_members',
			'mwb_membership_manage_content_display_msg' => '',
			'mwb_membership_delete_data'                => 'off',
		);

		return $default_global_settings;

	}

	/**
	 * Membership product title for CSV.
	 *
	 * @param array $products An array of product ids.
	 *
	 * @since 1.0.0
	 */
	public function csv_get_prod_title( $products ) {

		if ( ! empty( $products ) && is_array( $products ) ) {

			$product_ids = ! empty( $products ) ? array_map( 'absint', $products ) : null;

			$output = '';

			if ( $product_ids ) {

				foreach ( $product_ids as $single_id ) {

					$single_name = $this->get_product_title( $single_id );
					$output     .= esc_html( $single_name ) . '(#' . esc_html( $single_id ) . '),';

				}
			}

			$output = preg_replace( '/,[^,]*$/', '', $output );
			return $output;
		}

	}

	/**
	 * Membership category title for CSV.
	 *
	 * @param array $categories An array of cataegory ids.
	 *
	 * @since 1.0.0
	 */
	public function csv_get_cat_title( $categories ) {

		if ( ! empty( $categories ) && is_array( $categories ) ) {

			$category_ids = ! empty( $categories ) ? array_map( 'absint', $categories ) : null;

			$output = '';

			if ( $category_ids ) {

				foreach ( $category_ids as $cat_id ) {

					$single_cat = $this->get_category_title( $cat_id );
					$output    .= esc_html( $single_cat ) . '(#' . esc_html( $cat_id ) . '),';
				}
			}

			$output = preg_replace( '/,[^,]*$/', '', $output );
			return $output;
		}
	}

	/**
	 * Membership supported gateways.
	 *
	 * @since 1.0.0
	 */
	public function supported_gateways() {

		$supported_gateways = array(
			'paypal',
			'cod',
			'membership-for-woo-paypal-gateway', // Membership Paypal.
			'membership-for-woo-stripe-gateway', // Membership stripe.
			'membership-adv-bank-transfer', // Mwb Advance abnk transfer.
		);

		return apply_filters( 'mwb_membership_for_woo_supported_gateways', $supported_gateways );
	}

	/**
	 * Available payment gateways.
	 *
	 * @since 1.0.0
	 */
	public function available_gateways() {

		$wc_gateways      = new WC_Payment_Gateways();
		$payment_gateways = $wc_gateways->get_available_payment_gateways();

		$woo_gateways = array();

		if ( ! empty( $payment_gateways ) && is_array( $payment_gateways ) ) {

			// Loop through Woocommerce available payment gateways.
			foreach ( $payment_gateways as $gateway_id ) {

				$woo_gateways[] = $gateway_id->id;
			}
		}

		return $woo_gateways;

	}

	/**
	 * Returns the method title.
	 *
	 * @param string $method_id Id of the payment method.
	 *
	 * @since 1.0.0
	 */
	public function get_payment_method_title( $method_id ) {

		$title = '';

		$wc_gateways      = new WC_Payment_Gateways();
		$payment_gateways = $wc_gateways->get_available_payment_gateways();

		if ( ! empty( $payment_gateways ) && is_array( $payment_gateways ) ) {

			// Loop through Woocommerce available payment gateways.
			foreach ( $payment_gateways as $gateway ) {

				if ( $method_id == $gateway->id ) {

					$title = $gateway->method_title;
				}
			}
		}
		return $title;
	}
	/**
	 * Cart item Ids.
	 *
	 * @since 1.0.0
	 */
	public function cart_item_ids() {

		$cart_items = WC()->cart->get_cart();

		$prod_ids = array();

		if ( ! empty( $cart_items ) && is_array( $cart_items ) ) {

			foreach ( $cart_items as $item ) {

				$prod_ids[] = $item['product_id'];
			}
		}

		return $prod_ids;
	}

	/**
	 * Cart item category Ids.
	 *
	 * @since 1.0.0
	 */
	public function cart_item_cat_ids() {

		$cart_items = WC()->cart->get_cart();

		$cat_ids = array();

		if ( ! empty( $cart_items ) && is_array( $cart_items ) ) {

			foreach ( $cart_items as $cart_item_key => $cart_item ) {

				$cat_ids = array_merge( $cat_ids, $cart_item['data']->get_category_ids() );
			}
		}

		return $cat_ids;
	}

	/**
	 * Get all plans offered products ids.
	 *
	 * @since 1.0.0
	 */
	public function plans_products_ids() {

		$args = array(
			'post_type'   => 'mwb_cpt_membership',
			'post_status' => array( 'publish' ),
			'numberposts' => -1,
		);

		$products = array();

		$ids = array();

		$all_posts = get_posts( $args );

		if ( ! empty( $all_posts ) && is_array( $all_posts ) ) {

			foreach ( $all_posts as $post ) {

				$products = get_post_meta( $post->ID, 'mwb_membership_plan_target_ids', true );

				if ( is_array( $products ) ) {

					foreach ( $products as $id ) {
						$ids[] = $id;
					}
				}
			}
		}

		return $ids;
	}

	/**
	 * Get all plans offered categories ids.
	 *
	 * @since 1.0.0
	 */
	public function plans_cat_ids() {

		$args = array(
			'post_type'   => 'mwb_cpt_membership',
			'post_status' => array( 'publish' ),
			'numberposts' => -1,
		);

		$categories = array();

		$cat_ids = array();

		$all_posts = get_posts( $args );

		if ( ! empty( $all_posts ) && is_array( $all_posts ) ) {

			foreach ( $all_posts as $post ) {

				$categories = get_post_meta( $post->ID, 'mwb_membership_plan_target_categories', true );

				if ( is_array( $categories ) ) {

					foreach ( $categories as $id ) {

						$cat_ids[] = $id;
					}
				}
			}
		}

		return $cat_ids;
	}

	/**
	 * Gutenberg offer plan content.
	 *
	 * @since 1.0.0
	 */
	public function gutenberg_content() {

		$page_content = '<!-- wp:cover {"minHeight":722,"minHeightUnit":"px","customGradient":"linear-gradient(153deg,rgb(6,89,229) 35%,rgb(155,81,224) 80%)","align":"wide"} -->
						<div class="wp-block-cover alignwide has-background-dim has-background-gradient" style="background:linear-gradient(153deg,rgb(6,89,229) 35%,rgb(155,81,224) 80%);min-height:722px"><div class="wp-block-cover__inner-container"><!-- wp:heading {"align":"center","textColor":"white"} -->
						<h2 class="has-text-align-center has-white-color has-text-color"><strong><em>One Membership, Many Benefits</em></strong></h2>
						<!-- /wp:heading -->
						
						<!-- wp:spacer {"height":58} -->
						<div style="height:58px" aria-hidden="true" class="wp-block-spacer"></div>
						<!-- /wp:spacer -->
						
						<!-- wp:html -->
						<div class="mwb_membership_plan_content_title">[mwb_membership_title]</div>
						<!-- /wp:html -->
						
						<!-- wp:html -->
						<div class="mwb_membership_plan_content_price">[mwb_membership_price]</div>
						<!-- /wp:html -->
						
						<!-- wp:html -->
						<div class="mwb_membership_plan_content_desc">[mwb_membership_desc]</div>
						<!-- /wp:html -->
						
						<!-- wp:columns -->
						<div class="wp-block-columns"><!-- wp:column -->
						<div class="wp-block-column"><!-- wp:shortcode -->
						[mwb_membership_yes]
						<!-- /wp:shortcode --></div>
						<!-- /wp:column -->
						
						<!-- wp:column -->
						<div class="wp-block-column"><!-- wp:shortcode -->
						[mwb_membership_no]
						<!-- /wp:shortcode --></div>
						<!-- /wp:column --></div>
						<!-- /wp:columns --></div></div>
						<!-- /wp:cover -->';

		return $page_content;
	}

	/**
	 * Returns Import CSV modal.
	 *
	 * @since 1.0.0
	 */
	public function import_csv_modal_content() {

		?>
		<div class="import_csv_field_wrapper">
			<input type="file" name="csv_to_import" id="csv_file_upload">
			<input type="submit" value="Upload FIle" name="upload_csv_file" id="upload_csv_file" >

			<div class="csv_import_response">
			</div>
		</div>
		<?php

	}


	/**
	 * Returns payment modal content
	 *
	 * @param object $gateway An object of payment gateway.
	 * @return void
	 */
	public function gateway_modal_content( $gateway ) {

		?>
		<li class="wc_payment_method payment_method_<?php echo esc_attr( $gateway->id ); ?>" data-id="<?php echo esc_attr( $gateway->id ); ?>">
			<input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />

			<label for="payment_method_<?php echo esc_attr( $gateway->id ); ?>">
				<?php echo $gateway->get_title(); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?> <?php echo $gateway->get_icon(); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?>
			</label>
			<?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
				<div class="payment_box payment_method_<?php echo esc_attr( $gateway->id ); ?>" 
				<?php
				if ( ! $gateway->chosen ) :
						/* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */
					?>
					style="display:none;"<?php endif; /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>>
					<?php $gateway->payment_fields(); ?>
				</div>
			<?php endif; ?>
		</li>
		<?php
	}

	/**
	 * Returns modal payment div wrapper.
	 *
	 * @since 1.0.0
	 */
	public function payment_gateways_html() {

		$wc_gateways      = new WC_Payment_Gateways();
		$payment_gateways = $wc_gateways->get_available_payment_gateways();

		$supported_gateways = $this->supported_gateways();

		?>
		<div class="mwb_membership_buy_now_modal">
			<!-- Modal payment content start -->
			<div class="mwb_membership_payment_modal" style="float: right;">
				<?php
				foreach ( $payment_gateways as $gateway ) {

					if ( in_array( $gateway->id, $supported_gateways ) ) {

						$this->gateway_modal_content( $gateway );
					}
				}
				?>
			</div>
			<!-- Modal payment content end. -->

			<!-- Modal billing fields -->
			<div class="membership_customer_details" id="memberhsip_customer_details" style="float: left;">
				<div class="membership_billing_fields">
					<h3><?php esc_html_e( 'Billing details', 'membership-for-woocommerce' ); ?></h3>
					<div class="membership_billing_fields_wrapper">
						<p class="form-row validate-required" id="mwb_billing_first_name_field">
							<label for="membership_billing_first_name"><?php esc_html_e( 'First name&nbsp;', 'membership-for-woocommerce' ); ?><abbr class="required" title="required"><?php esc_html_e( '*', 'membership-for-woocommerce' ); ?></abbr></label>
							<span class="membership-input-wrapper">
								<input type="text" class="input-text" name="membership_billing_first_name" id="membership_billing_first_name" value="" placeholder="<?php esc_html_e( 'First name&hellip;', 'membership-for-woocommerce' ); ?>">
							</span>
						</p>
						<p class="form-row validate-required" id="mwb_billing_last_name_field">
							<label for="membership_billing_last_name"><?php esc_html_e( 'Last name&nbsp;', 'membership-for-woocommerce' ); ?><abbr class="required" title="required"><?php esc_html_e( '*', 'membership-for-woocommerce' ); ?></abbr></label>
							<span class="membership-input-wrapper">
								<input type="text" class="input-text" name="membership_billing_last_name" id="membership_billing_last_name" value="" placeholder="<?php esc_html_e( 'Last name&hellip;', 'membership-for-woocommerce' ); ?>">
							</span>
						</p>
						<p class="form-row" id="mwb_billing_company_field">
							<label for="membership_billing_company"><?php esc_html_e( 'Company name&nbsp;', 'membership-for-woocommerce' ); ?><span class="optional"><?php esc_html_e( '(Optional)', 'membership-for-woocommerce' ); ?></span></label>
							<span class="membership-input-wrapper">
								<input type="text" class="input-text" name="membership_billing_company" id="membership_billing_company" value="" placeholder="<?php esc_html_e( 'Company name', 'membership-for-woocommerce' ); ?>">
							</span>
						</p>
						<p class="form-row" id="mwb_billing_country_field">
							<label for="membership_billing_country"><?php esc_html_e( 'Country/Region&nbsp;', 'membership-for-woocommerce' ); ?><abbr class="required" title="required"><?php esc_html_e( '*', 'membership-for-woocommerce' ); ?></abbr></label>
							<span class="membership-input-wrapper">
								<select name="membership_billing_country[]" id="membership_billing_country" class="wc-enhanced-select mwb_country_select">
									<?php
									foreach ( get_country_list() as $code => $name ) {
										?>
										<option value="<?php echo esc_html( $code ); ?>"><?php echo esc_html( $name ); ?></option>
									<?php } ?>
								</select>
							</span>
						</p>
						<p class="form-row validate-required" id="mwb_billing_address_1_field">
							<label for="membership_billing_address_1"><?php esc_html_e( 'Street address&nbsp;', 'membership-for-woocommerce' ); ?><abbr class="required" title="required"><?php esc_html_e( '*', 'membership-for-woocommerce' ); ?></abbr></label>
							<span class="membership-input-wrapper">
								<input type="text" class="input-text" name="membership_billing_address_1" id="membership_billing_address_1" value="" placeholder="<?php esc_html_e( 'House number and street name', 'membership-for-woocommerce' ); ?>">
							</span>
						</p>
						<p class="form-row" id="mwb_billing_address_2_field">	
							<span class="membership-input-wrapper">
								<input type="text" class="input-text" name="membership_billing_address_2" id="membership_billing_address_2" value="" placeholder="<?php esc_html_e( 'Apartment, suit, unit, etc. (Optional)', 'membership-for-woocommerce' ); ?>">
							</span>
						</p>
						<p class="form-row validate-required" id="mwb_billing_city_field">
							<label for="membership_billing_city"><?php esc_html_e( 'Town/City&nbsp;', 'membership-for-woocommerce' ); ?><abbr class="required" title="required"><?php esc_html_e( '*', 'membership-for-woocommerce' ); ?></abbr></label>
							<span class="membership-input-wrapper">
								<input type="text" class="input-text" name="membership_billing_city" id="membership_billing_city" value="" placeholder="<?php esc_html_e( 'Town/City', 'membership-for-woocommerce' ); ?>">
							</span>
						</p>
						<p class="form-row validate-required" id="mwb_billing_state_field">
							<label for="membership_billing_state"><?php esc_html_e( 'State&nbsp;', 'membership-for-woocommerce' ); ?><abbr class="required" title="required"><?php esc_html_e( '*', 'membership-for-woocommerce' ); ?></abbr></label>
							<span class="membership-input-wrapper">
								<select name="membership_billing_state" id="membership_billing_state" class="meb_state_select">
								</select>
							</span>
						</p>
						<p class="form-row validate-required" id="mwb_billing_postcode_field">
							<label for="membership_billing_postcode"><?php esc_html_e( 'Pin code&nbsp;', 'membership-for-woocommerce' ); ?><abbr class="required" title="required"><?php esc_html_e( '*', 'membership-for-woocommerce' ); ?></abbr></label>
							<span class="membership-input-wrapper">
								<input type="text" class="input-text" name="membership_billing_postcode" id="membership_billing_postcode" value="" placeholder="<?php esc_html_e( 'Pin code', 'membership-for-woocommerce' ); ?>">
							</span>
						</p>
						<p class="form-row validate-required" id="mwb_billing_phone_field">
							<label for="membership_billing_phone"><?php esc_html_e( 'Phone&nbsp;', 'membership-for-woocommerce' ); ?><abbr class="required" title="required"><?php esc_html_e( '*', 'membership-for-woocommerce' ); ?></abbr></label>
							<span class="membership-input-wrapper">
								<input type="tel" class="input-text" name="membership_billing_phone" id="membership_billing_phone" value="" placeholder="<?php esc_html_e( 'Phone no.', 'membership-for-woocommerce' ); ?>">
							</span>
						</p>
						<p class="form-row validate-required" id="mwb_billing_email_field">
							<label for="membership_billing_email"><?php esc_html_e( 'E-mail&nbsp;', 'membership-for-woocommerce' ); ?><abbr class="required" title="required"><?php esc_html_e( '*', 'membership-for-woocommerce' ); ?></abbr></label>
							<span class="membership-input-wrapper">
								<input type="email" class="input-text" name="membership_billing_email" id="membership_billing_email" value="" placeholder="<?php esc_html_e( 'Email', 'membership-for-woocommerce' ); ?>">
							</span>
						</p>

						<p class="form-row" id="mwb_proceed_payment">
							<span class="membership-input-wrapper">
								<input type="submit" class="button alt" name="membership_proceed_payment" id="membership_proceed_payment" value="<?php esc_html_e( 'Proceed for Payment', 'membership-for-woocommerce' ); ?>" placeholder="<?php esc_html_e( 'Email', 'membership-for-woocommerce' ); ?>">
							</span>
						</p>
					</div>

				</div>
			</div>
		</div>

		<?php

	}

	/**
	 * Check if any plan exist or not.
	 *
	 * @return bool
	 * @since 1.0.0
	 */
	public function plans_exist_check() {

		$args = array(
			'post_type'   => 'mwb_cpt_membership',
			'post_status' => array( 'publish' ),
			'numberposts' => -1,
		);

		$check = '';

		$all_plans = get_posts( $args );

		if ( ! empty( $all_plans ) && is_array( $all_plans ) ) {

			$check = true;
		} else {

			$check = false;
		}

		return $check;

	}

	/**
	 * Return all memberships in membership free shipping.
	 *
	 * @since 1.0.0
	 */
	public function format_all_membership() {

		$formatted_all_membership = array();

		// Query run for all memberships for free shipping.
		$args = array(
			'post_type'   => 'mwb_cpt_membership',
			'post_status' => array( 'publish' ),
			'numberposts' => -1,
			'fields'      => 'ids',
		);

		$all_membership = get_posts( $args );

		if ( ! empty( $all_membership ) && is_array( $all_membership ) ) {

			foreach ( $all_membership as $key => $id ) {

				$formatted_all_membership[ $id ] = get_the_title( $id );
			}
		}

		return $formatted_all_membership;
	}

	/**
	 * Function to run query.
	 *
	 * @param string $query Is the query.
	 * @return mixed
	 *
	 * @since 1.0.0
	 */
	public function run_query( $query='' ) {

		global $wpdb;

		return ! empty( $wpdb->get_results( $query, ARRAY_A ) ) ? $wpdb->get_results( $query, ARRAY_A ) : false;
	}

	/**
	 * Maps the CSV data.
	 *
	 * @param array $csv_data An array of CSV data.
	 * @return array
	 *
	 * @since 1.0.0
	 */
	public function csv_data_map( $csv_data ) {

		$formatted_data = array();

		if ( ! empty( $csv_data ) && is_array( $csv_data ) ) {

			foreach ( $csv_data as $key => $value ) {

				$formatted_data[] = array(
					'post_id'                              => ! empty( $value[0] ) ? $value[0] : '',
					'post_title'                           => ! empty( $value[1] ) ? $value[1] : '',
					'post_status'                          => ! empty( $value[2] ) ? $value[2] : '',
					'mwb_membership_plan_price'            => ! empty( $value[3] ) ? $value[3] : '',
					'mwb_membership_plan_name_access_type' => ! empty( $value[4] ) ? $value[4] : '',
					'mwb_membership_plan_duration'         => ! empty( $value[5] ) ? $value[5] : '',
					'mwb_membership_plan_duration_type'    => ! empty( $value[6] ) ? $value[6] : '',
					'mwb_membership_plan_start'            => ! empty( $value[7] ) ? $value[7] : '',
					'mwb_membership_plan_end'              => ! empty( $value[8] ) ? $value[8] : '',
					'mwb_membership_plan_user_access'      => ! empty( $value[9] ) ? $value[9] : '',
					'mwb_membership_plan_access_type'      => ! empty( $value[10] ) ? $value[10] : '',
					'mwb_membership_plan_time_duration'    => ! empty( $value[11] ) ? $value[11] : '',
					'mwb_membership_plan_time_duration_type' => ! empty( $value[12] ) ? $value[12] : '',
					'mwb_membership_plan_offer_price_type' => ! empty( $value[13] ) ? $value[13] : '',
					'mwb_memebership_plan_discount_price'  => ! empty( $value[14] ) ? $value[15] : '',
					'mwb_memebership_plan_free_shipping'   => ! empty( $value[15] ) ? $value[15] : '',
					'mwb_membership_plan_target_ids'       => ! empty( $value[16] ) ? $this->import_csv_ids( $value[16] ) : '',
					'mwb_membership_plan_target_categories' => ! empty( $value[17] ) ? $this->import_csv_ids( $value[17] ) : '',
					'post_content'                         => ! empty( $value[18] ) ? $value[18] : '',

				);
			}
		}

		return $formatted_data;

	}

	/**
	 * String to array conversion of pro ids.
	 *
	 * @param string $csv_string A string of CSV Products and Category ids.
	 * @return array
	 *
	 * @since 1.0.0
	 */
	public function import_csv_ids( $csv_string ) {

		$ids = array();

		if ( ! empty( $csv_string ) ) {

			$ids_array = explode( ',', $csv_string );

			foreach ( $ids_array as $key => $id ) {

				$matches = array();

				$check = preg_match( '/(#[0-9][0-9])+/', $id, $matches );

				if ( $check ) {

					$ids[] = str_replace( '#', '', $matches[0] );
				}
			}
		}

		return $ids;
	}

	/**
	 * Returns all Products ids offered from CSV.
	 *
	 * @param array $csv_data An array of CSV data.
	 * @return array
	 * @since 1.0.0
	 */
	public function csv_prod_title( $csv_data ) {

		$csv_prod_title = array();
		$prod_array     = array();

		if ( ! empty( $csv_data ) && is_array( $csv_data ) ) {

			foreach ( $csv_data as $key => $value ) {

				if ( ! empty( $value[16] ) ) {

					$prod_array[] = explode( ',', $value[16] );
				}
			}
		}

		if ( ! empty( $prod_array ) && is_array( $prod_array ) ) {

			foreach ( $prod_array as $key ) {

				foreach ( $key as $index => $title ) {

					$matches = array();

					$check = preg_match( '/[A-Za-z\s\#\-0-9]+/', $title, $matches );

					if ( $check ) {

						$csv_prod_title[] = $matches[0];
					}
				}
			}
		}

		return $csv_prod_title;
	}

	/**
	 * Return all Category ids offered from CSV.
	 *
	 * @param array $csv_data An array of CSV data.
	 * @return array
	 * @since 1.0.0
	 */
	public function csv_cat_title( $csv_data ) {

		$csv_cat_title = array();
		$cat_array     = array();

		if ( ! empty( $csv_data ) && is_array( $csv_data ) ) {

			foreach ( $csv_data as $key => $value ) {

				if ( ! empty( $value[17] ) ) {

					$cat_array[] = explode( ',', $value[17] );
				}
			}
		}

		if ( ! empty( $cat_array ) && is_array( $cat_array ) ) {

			foreach ( $cat_array as $key ) {

				foreach ( $key as $index => $title ) {

					$matches = array();

					$check = preg_match( '/[A-Za-z\s\#\-0-9]+/', $title, $matches );

					if ( $check ) {

						$csv_cat_title[] = $matches[0];
					}
				}
			}
		}
		return $csv_cat_title;
	}

	/**
	 * Returns an aray of all products title available in woocommerce store.
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function all_prod_title() {

		$product_titles = array();

		// Getting all Product ids from woocommerce.
		$all_prod_ids = get_posts(
			array(
				'posts_per_page' => -1,
				'post_type'      => array( 'product', 'product_variation' ),
				'fields'         => 'ids',
			)
		);

		if ( ! empty( $all_prod_ids ) && is_array( $all_prod_ids ) ) {

			foreach ( $all_prod_ids as $id ) {

				$product_titles[] = get_the_title( $id );
			}
		}

		return $product_titles;
	}

	/**
	 * Returns an array of all category title available in woocommerce store.
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function all_cat_title() {

		$cate_titles = array();

		// Getting all Category ids from woocommerce.
		$all_cat_ids = get_terms(
			array(
				'taxonomy' => 'product_cat',
				'fields'   => 'ids',
			)
		);

		if ( ! empty( $all_cat_ids ) && is_array( $all_cat_ids ) ) {

			foreach ( $all_cat_ids as $id ) {

				$term = get_term_by( 'id', $id, 'product_cat' );

				if ( $term ) {

					$cate_titles[] = $term->name;
				}
			}
		}

		return $cate_titles;

	}

}