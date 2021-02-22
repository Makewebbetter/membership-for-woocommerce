<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Membership_For_Woocommerce
 * @subpackage Membership_For_Woocommerce/admin/partials
 */

// Exit is accessed directly.
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

global $post;

?>

<!-- Plans creation start. -->
<table class="form-table mwb_membership_plans_creation_setting">
	<tbody>

		<!-- Nonce Field -->
		<?php wp_nonce_field( 'mwb_membership_plans_creation_nonce', 'mwb_membership_plans_nonce' ); ?>	

		<!-- Memberhship plan price start  -->
		<tr valign="top">

			<th scope="row" class="titledesc">
				<label for="mwb_membership_plan_price"><?php esc_html_e( 'Membership Plan Amount', 'membership-for-woocommerce' ); ?></label>
			</th>

			<td class="forminp forminp-text">

				<?php

				$description = esc_html__( 'Provide the amount at which Membership Plan will be available for Users.', 'membership-for-woocommerce' );

				$instance->tool_tip( $description );

				?>

				<input type="text" id="mwb_membership_plan_price" name="mwb_membership_plan_price" value="<?php echo esc_attr( $settings_fields['mwb_membership_plan_price'] ); ?>">
			</td>
		</tr>
		<!-- Membership plan price end. -->

		<!-- Access Type start -->
		<tr valign="top">

			<th scope="row" class="titledesc">
				<label for="mwb_membership_plan_access_type"><?php esc_html_e( 'Access Type', 'membership-for-woocommerce' ); ?></label>
			</th>

			<td class="forminp forminp-text">

				<?php

				$description = esc_html__( 'Provide the Access Type of your Membership Plan', 'membership-for-woocommerce' );

				$instance->tool_tip( $description );

				$mwb_membership_plan_access_type = $settings_fields['mwb_membership_plan_name_access_type'];

				?>

				<select id="mwb_membership_plan_access_type" name="mwb_membership_plan_name_access_type">
					<option <?php echo esc_html( 'lifetime' === $mwb_membership_plan_access_type ? 'selected' : '' ); ?> value="lifetime"><?php esc_html_e( 'Lifetime', 'membership-for-woocommerce' ); ?></option>

					<option <?php echo esc_html( 'limited' === $mwb_membership_plan_access_type ? 'selected' : '' ); ?> value="limited"><?php esc_html_e( 'Limited', 'membership-for-woocommerce' ); ?></option>
				</select>
			</td>
		</tr>
		<!-- Access Type End -->

		<!-- Plan Duration start. -->
		<tr valign="top" id="mwb_membership_duration" style="display: none;">

			<th scope="row" class="titledesc">
				<label for="mwb_membership_plan_duration"><?php esc_html_e( 'Duration', 'membership-for-woocommerce' ); ?></label>
			</th>

			<td class="forminp forminp-text">

				<?php

				$description = esc_html__( 'Provide the number of days the plan will be active', 'membership-for-woocommerce' );

				$instance->tool_tip( $description );

				$mwb_membership_plan_duration_type = $settings_fields['mwb_membership_plan_duration_type'];
				?>

				<input type="number" id="mwb_membership_plan_duration" name="mwb_membership_plan_duration" value="<?php echo esc_attr( $settings_fields['mwb_membership_plan_duration'] ); ?>" min="1" max="31">
				<select name="mwb_membership_plan_duration_type" id="mwb_membership_plan_duration_type">
					<option <?php echo esc_html( 'days' === $mwb_membership_plan_duration_type ? 'selected' : '' ); ?> value="days"><?php esc_html_e( 'Days', 'membership-for-woocommerce' ); ?></option>
					<option <?php echo esc_html( 'weeks' === $mwb_membership_plan_duration_type ? 'selected' : '' ); ?> value="weeks"><?php esc_html_e( 'Weeks', 'membership-for-woocommerce' ); ?></option>
					<option <?php echo esc_html( 'months' === $mwb_membership_plan_duration_type ? 'selected' : '' ); ?> value="months"><?php esc_html_e( 'Months', 'membership-for-woocommerce' ); ?></option>
					<option <?php echo esc_html( 'years' === $mwb_membership_plan_duration_type ? 'selected' : '' ); ?> value="years"><?php esc_html_e( 'Years', 'membership-for-woocommerce' ); ?></option>
				</select>
			</td>
		</tr>
		<!-- Plan Duration End. -->

		<!-- Recurring plan start -->
		<tr id="mwb_membership_recurring_plan" style="display: none" valign="top">

			<th scope="row" class="titledesc">
				<label for="mwb_membership_plan_recurring"><?php esc_html_e( 'Enable Recurring Plan', 'membership-for-woocommerce' ); ?></label>
			</th>

			<td class="forminp forminp-text">

				<?php

				$description = esc_html__( 'This will Enable Recurring membership plan.', 'membership-for-woocommerce' );

				$instance->tool_tip( $description );

				?>

				<input type="checkbox" id="mwb_membership_plan_recurring" name="mwb_membership_plan_recurring" value="yes" <?php checked( 'yes', $settings_fields['mwb_membership_plan_recurring'] ); ?>>
			</td>
		</tr>
		<!-- Recurring plan start -->

	</tbody>
</table>

<div class="mwb_membership_plan_products">
	<h1><?php esc_html_e( 'Membership Plan Offers', 'membership-for-woocommerce' ); ?></h1>
</div>

<!-- Membership product section starts -->
<div class="membership-offers">

	<!-- Offer section html start -->
	<div class="new_created_offers mwb_membership_offers" id="new_created_offers" >

		<h2 class="mwb_membership_offer_title" >
			<?php esc_html_e( 'Offer Section', 'membership-for-woocommerce' ); ?>
		</h2>

		<table>
			<!-- Offer Product section start -->
			<tr>

				<th scope="row" class="titledesc">
					<label for="mwb_membership_offer_product_select"><?php esc_html_e( 'Offered Products', 'membership-for-woocommerce' ); ?></label>
				</th>

				<td class="forminp forminp-text">
					<?php
					$description = esc_html__( 'Select the products you want to offer in Membership Plan.', 'membership-for-woocommerce' );

					$instance->tool_tip( $description );
					?>

					<select id="mwb_membership_plan_target_ids_search" class="wc-membership-product-search" multiple="multiple" name="mwb_membership_plan_target_ids[]" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'membership-for-woocommerce' ); ?>">

						<?php

						if ( ! empty( $settings_fields ) ) {

							$mwb_membership_plan_target_product_ids = is_array( $settings_fields['mwb_membership_plan_target_ids'] ) ? array_map( 'absint', $settings_fields['mwb_membership_plan_target_ids'] ) : array();

							if ( $mwb_membership_plan_target_product_ids ) {

								foreach ( $mwb_membership_plan_target_product_ids as $mwb_membership_plan_single_target_product_ids ) {

									$product_name = $instance->get_product_title( $mwb_membership_plan_single_target_product_ids );
									?>

									<option value="<?php echo esc_html( $mwb_membership_plan_single_target_product_ids ); ?>" <?php echo ( in_array( $mwb_membership_plan_single_target_product_ids, $mwb_membership_plan_target_product_ids, true ) ? 'selected' : '' ); ?>><?php echo( esc_html( $product_name ) . '(#' . esc_html( $mwb_membership_plan_single_target_product_ids ) . ')' ); ?></option>

									<?php
								}
							}
						}

						?>

					</select>

				</td>	

			</tr>
			<!-- Offer product section End -->

			<!-- Offer categories section start -->
			<tr>

				<th scope="row" class="titledesc">
					<label for="mwb_membership_offer_category_select"><?php esc_html_e( 'Offered Categories', 'membership-for-woocommerce' ); ?></label>
				</th>

				<td class="forminp forminp-text">
					<?php
					$description = esc_html__( 'Select the categories you want to offer in Membership Plan.', 'membership-for-woocommerce' );

					$instance->tool_tip( $description );
					?>

					<select id="mwb_membership_plan_target_categories_search" class="wc-membership-product-category-search" multiple="multiple" name="mwb_membership_plan_target_categories[]" data-placeholder="<?php esc_attr_e( 'Search for a category&hellip;', 'membership-for-woocommerce' ); ?>">
						<?php

						if ( ! empty( $settings_fields ) ) {

							$mwb_membership_plan_target_categories = is_array( $settings_fields['mwb_membership_plan_target_categories'] ) ? array_map( 'absint', $settings_fields['mwb_membership_plan_target_categories'] ) : array();

							if ( $mwb_membership_plan_target_categories ) {

								foreach ( $mwb_membership_plan_target_categories as $single_target_category_id ) {

									$category_name = $instance->get_category_title( $single_target_category_id );
									?>

									<option value="<?php echo esc_html( $single_target_category_id ); ?>" selected="selected"><?php echo( esc_html( $category_name ) . '(#' . esc_html( $single_target_category_id ) . ')' ); ?></option>

									<?php
								}
							}
						}

						?>

					</select>

				</td>

			</tr>
			<!-- Offer categories section end. -->

			<!-- Accessibility type start-->
			<tr>
				<th scope="row" class="titledesc">
					<label for="mwb_membership_offer_access_type"><?php esc_html_e( 'Accessibility Type', 'membership-for-woocommerce' ); ?></label>
				</th>

				<td>

				<?php

				$mwb_membership_plan_access_type = $settings_fields['mwb_membership_plan_access_type'];

				$mwb_membership_plan_time_duration = $settings_fields['mwb_membership_plan_time_duration'];

				$mwb_membership_plan_time_duration_type = $settings_fields['mwb_membership_plan_time_duration_type'];

				?>
					<input type="radio" id="mwb_membership_plan_immediate_type" name="mwb_membership_plan_access_type" value="immediate_type" <?php echo esc_html( 'immediate_type' === $mwb_membership_plan_access_type ? 'checked' : '' ); ?>>
					<label for="mwb_membership_plan_immediate_type"><?php esc_html_e( 'Immediately', 'membership-for-woocommerce' ); ?></label>

					<input type="radio" id="mwb_membership_plan_time_type" name="mwb_membership_plan_access_type" value="delay_type" <?php echo esc_html( 'delay_type' === $mwb_membership_plan_access_type ? 'checked' : '' ); ?>>
					<label for="mwb_membership_plan_time_type"><?php esc_html_e( 'Specifiy a time', 'membership-for-woocommerce' ); ?></label>

					<div id="mwb_membership_plan_time_duratin_display" style="display: none;">
					<?php
						$description = esc_html__( 'Select the delay duration in after which plan offers will be accessible.', 'membership-for-woocommerce' );

						$instance->tool_tip( $description );
					?>
						<input type="number" id="mwb_membership_plan_time_duration" name="mwb_membership_plan_time_duration" value="<?php echo esc_attr( $mwb_membership_plan_time_duration ); ?>" min="1" max="31" >
						<select name="mwb_membership_plan_time_duration_type" id="mwb_membership_plan_time_duration_type" >
							<option <?php echo esc_html( 'days' === $mwb_membership_plan_time_duration_type ? 'selected' : '' ); ?> value="days"><?php esc_html_e( 'Days', 'membership-for-woocommerce' ); ?></option>
							<option <?php echo esc_html( 'weeks' === $mwb_membership_plan_time_duration_type ? 'selected' : '' ); ?> value="weeks"><?php esc_html_e( 'Weeks', 'membership-for-woocommerce' ); ?></option>
						</select>
					</div>

				</td>

			</tr>
			<!-- Accessibility type end -->
		</table>

	</div>

	<div class="membership-features">
		<!-- Membership features section start -->
		<div class="new_created_offers mwb_membership_offers">

			<h2 class="mwb_membership_offer_title" >
				<?php esc_html_e( 'Membership Features Section', 'membership-for-woocommerce' ); ?>
			</h2>

			<table>
				<!-- Discount section start -->
				<tr>
					<th scope="row" class="titledesc">
						<label for="mwb_membership_plan_price_type_id"><?php esc_html_e( 'Discount', 'membership-for-woocommerce' ); ?></label>
					</th>

					<td class="forminp forminp-text">

						<?php

						$mwb_membership_plan_offer_price_type = $settings_fields['mwb_membership_plan_offer_price_type'];

						$mwb_membership_plan_discount_price = $settings_fields['mwb_memebership_plan_discount_price'];

						$description = esc_html__( 'Specify discount % applied to orders with this plan.', 'membership-for-woocommerce' );

						$instance->tool_tip( $description );
						?>
						<select name="mwb_membership_plan_offer_price_type" id = 'mwb_membership_plan_offer_price_type_id' >

							<option <?php echo esc_html( '%' === $mwb_membership_plan_offer_price_type ? 'selected' : '' ); ?> value="%"><?php esc_html_e( 'Discount %', 'membership-for-woocommerce' ); ?></option>

							<option <?php echo esc_html( 'fixed' === $mwb_membership_plan_offer_price_type ? 'selected' : '' ); ?> value="fixed"><?php esc_html_e( 'Fixed price', 'membership-for-woocommerce' ); ?></option>

						</select>
						<input type="text" class="mwb_membership plan_offer_input_type" id="mwb_membership_plan_offer_price" name="mwb_memebership_plan_discount_price" value="<?php echo esc_attr( $mwb_membership_plan_discount_price ); ?>">

					</td>
				</tr>
				<!-- Discount section End. -->

				<!-- Fress shipping section start-->
				<tr>
					<th scope="row" class="titledesc">
						<label for="mwb_membership_plan_free_shipping"><?php esc_html_e( 'Allow Free Shipping', 'membership-for-woocommerce' ); ?></label>
					</th>

					<td class="forminp forminp-text">

						<?php

						$mwb_membership_plan_free_shipping = $settings_fields['mwb_memebership_plan_free_shipping'];


						$description = esc_html__( 'Allow Free Shipping to all the members of this membership plan', 'membership-for-woocommerce' );

						$instance->tool_tip( $description );

						?>

						<input type="checkbox"  class="mwb_membership_plan_offer_free_shipping" name="mwb_memebership_plan_free_shipping" value="yes" <?php checked( 'yes', $mwb_membership_plan_free_shipping ); ?> >

						<?php
						if ( 'publish' == $post->post_status ) {
							?>
						<!-- manage free shipping link start. -->
						<div class="mwb_membership_free_shipping_link" style="display: none;">
							<p class="mwb_membership_free_shipping">
								<a class="button" target="_blank" href="<?php echo esc_html( admin_url( 'admin.php' ) . '?page=wc-settings&tab=shipping' ); ?>"><?php esc_html_e( 'Manage Free shipping', 'membership-for-woocommerce' ); ?></a>
							</p>
						</div>
						<!-- Manage free shipping link end. -->
						<?php } ?>
					</td>
				</tr>
				<!-- Free shiping section end. -->

			</table>
		</div>
	</div>
</div>
<!-- Plans creation end. -->

