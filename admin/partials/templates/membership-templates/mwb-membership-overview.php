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

?>
<div class="mwb-overview__wrapper">
	<div class="mwb-overview__banner">
	<img src="<?php echo esc_html( MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL . 'admin/resources/icons/banner.png' ); ?>" alt="banner-image">
	</div>
	<div class="mwb-overview__content">
		<div class="mwb-overview__content-description">
			<h2><?php echo esc_html_e( 'What Is Membership For WooCommerce?', 'membership-for-woocommerce' ); ?></h2>
			<p>
				<?php
				esc_html_e(
					'Membership for WooCommerce allows you to create membership plans for a segment of customers, thereby
					imposing limitations on your certain services or content. Memberships make it easy to create email
					lists where you can offer users special coupons and discount updates.',
					'membership-for-woocommerce'
				);
				?>
			</p>
			<h3><?php esc_html_e( 'With our Membership for WooCommerce plugin, as a store owner you get:', 'membership-for-woocommerce' ); ?></h3>
			<ul class="mwb-overview__features">
				<li><?php esc_html_e( 'Control content access', 'membership-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'See complete customer history', 'membership-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Quick preview section for Membership plans on the plans listing page', 'membership-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'A different status selection like pending, on hold, or completed as per their payment and plan expiry', 'membership-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Manual assignment of membership to a customer', 'membership-for-woocommerce' ); ?></li>
				<?php	do_action( 'mwb_multi_currency_switcher_add_li_to_overview' ); ?>
			</ul>
		</div>
		<h2> <?php esc_html_e( 'The Free Plugin Benefits', 'membership-for-woocommerce' ); ?></h2>
		<div class="mwb-overview__keywords">
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card">
					<div class="mwb-overview__keywords-image">
						<img src="<?php echo esc_html( MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Advanced-report.png' ); ?>" alt="Advanced-report image">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( 'Complete Customer History', 'membership-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description">
							<?php
							esc_html_e( 'Admin gets a quick preview section for Membership plans on the plans listing page. The users too can see their history in the ‘My Account’ section with entire details of their membership plans.', 'membership-for-woocommerce' );
							?>
						</p>
					</div>
				</div>
			</div>
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card">
					<div class="mwb-overview__keywords-image">
						<img src="<?php echo esc_html( MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Workflow.png' ); ?>" alt="Workflow image">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( 'Membership Details', 'membership-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description">
							<?php
							esc_html_e( 'Admin can offer products/categories in a membership plan. Those products and categories can only be accessible to users if they have purchased the plan. Membership Details Tab on My Accounts Page has all the details of the plan.', 'membership-for-woocommerce' );
							?>
						</p>
					</div>
				</div>
			</div>
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card">
					<div class="mwb-overview__keywords-image">
						<img src="<?php echo esc_html( MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Variable-product.png' ); ?>" alt="Variable product image">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( 'Data Export', 'membership-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description">
							<?php
							esc_html_e( 'Admin can effortlessly export all the membership plans along with the user data and settings. He can also import the details of all members as a CSV file.', 'membership-for-woocommerce' );
							?>
						</p>
					</div>
				</div>
			</div>
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card">
					<div class="mwb-overview__keywords-image">
						<img src="<?php echo esc_html( MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Variable-product.png' ); ?>" alt="Variable product image">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( 'Perfectly Neat Shortcodes For Customization', 'membership-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description">
							<?php
							esc_html_e( 'The admin is provided with a neat collection of shortcodes that work not only on the purchase of the default membership plan but also on the custom page. These shortcodes let admin to design their plan page at ease.', 'membership-for-woocommerce' );
							?>
						</p>
					</div>
				</div>
			</div>
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card">
					<div class="mwb-overview__keywords-image">
						<img src="<?php echo esc_html( MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Variable-product.png' ); ?>" alt="Variable product image">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( 'User Cart Total Discount', 'membership-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description">
							<?php
							esc_html_e( "Admin can grant discounts to the customers on total cart value. Free shipping option is also available as per their membership plans. The discount can be a fixed amount or percentage discount based on the admin's choice.", 'membership-for-woocommerce' );
							?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
