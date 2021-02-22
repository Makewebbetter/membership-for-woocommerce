<?php
/**
 * Membership plans preview template.
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

$output = '';

if ( ! empty( $post_id ) ) {

	$plan_title       = get_the_title( $post_id );
	$plan_price       = get_post_meta( $post_id, 'mwb_membership_plan_price', true );
	$plan_products    = $instance->csv_get_prod_title( get_post_meta( $post_id, 'mwb_membership_plan_target_ids', true ) );
	$plan_categories  = $instance->csv_get_cat_title( get_post_meta( $post_id, 'mwb_membership_plan_target_categories', true ) );
	$plan_description = get_post_field( 'post_content', $post_id );
	$plan_access_type = get_post_meta( $post_id, 'mwb_membership_plan_name_access_type', true );
	$plan_user_access = get_post_meta( $post_id, 'mwb_membership_plan_access_type', true );
	$currency         = get_woocommerce_currency_symbol();

	// Html for preview mode.
	$output .= '<h2>' . esc_html( $plan_title ) . '</h2>';
	$output .= '<div class="mwb_membership_preview_table">';
	$output .= '<table class="form-table mwb_membership_preview">';
	$output .= '<tbody>';

	// Plan Price section.
	$output .= '<tr>
					<th>
						<label>' . __( 'Plan Price', 'membership-for-woocommerce' ) . ' </label>
					</th>

					<td>' . sprintf( ' %s %s ', esc_html( $currency ), esc_html( $plan_price ) ) . '</td>
				</tr>';

	// Plan access type section.
	$output .= '<tr>
					<th>
						<label>' . __( 'Plan Access Type', 'membership-for-woocommerce' ) . ' </label>
					</th>

					<td>' . esc_html( $plan_access_type ) . '</td>
				</tr>';

	// Plan user access type.
	$output .= '<tr>
					<th>
						<label>' . __( 'Plan User Access Type', 'membership-for-woocommerce' ) . ' </label>
					</th>

					<td>' . esc_html( $plan_user_access ) . '</td>
				</tr>';

	// Plan offered categories.
	$output .= '<tr>
					<th>
						<label>' . __( 'Plan Offered Categories', 'membership-for-woocommerce' ) . ' </label>
					</th>

					<td>' . esc_html( $plan_categories ) . '</td>
				</tr>';

	// Plan offered products.
	$output .= '<tr>
					<th>
						<label>' . __( 'Plan Offered Products', 'membership-for-woocommerce' ) . ' </label>
					</th>

					<td>' . esc_html( $plan_products ) . '</td>
				</tr>';

	// Plan description.
	$output .= '<tr>
					<th>
						<label>' . __( 'Plan Description', 'membership-for-woocommerce' ) . ' </label>
					</th>

					<td>' . esc_html( $plan_description ) . '</td>
				</tr>';

	$output .= '</tbody>
				</table>
				</div>';
}

echo wp_kses_post( wpautop( wptexturize( $output ) ) . PHP_EOL );
