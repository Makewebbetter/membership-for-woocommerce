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
?>

<!-- Heading start -->
<div class="mfw_overview_wrapper">
	<div class="mfw_overview-contact">
		<a href="<?php echo esc_url( 'https://makewebbetter.com/contact-us/' ); ?>" target="__blank"><span class="mfw_overview-dial-text"><?php esc_html_e( 'Contact Us', 'membership-for-woocommerce' ); ?></span><img src="<?php echo esc_html( MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL . 'admin/resources/icons/dial.svg' ); ?>" alt="banner-image" class="mfw_overview-dial"></a>
		<a href="<?php echo esc_url( 'https://docs.makewebbetter.com/membership-for-woocommerce/' ); ?>" target="__blank"><span class="mfw_overview-doc-text"><?php esc_html_e( 'Document', 'membership-for-woocommerce' ); ?></span><img src="<?php echo esc_html( MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL . 'admin/resources/icons/doc.svg' ); ?>" alt="banner-image" class="mfw_overview-doc"></a>
		<!-- <a href="<?php echo esc_url( 'https://makewebbetter.com/contact-us/' ); ?>" target="__blank"><span class="mfw_overview-skype-text"><?php esc_html_e( 'Connect', 'membership-for-woocommerce' ); ?></span><img src="<?php echo esc_html( MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Support.png' ); ?>" alt="icon" class="mfw_overview-skype"></a> -->
	</div>
	<div class="mfw_overview_banner">
		<img src="<?php echo esc_html( MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/banner.png' ); ?>" alt="banner-image">
	</div>
	<div class="mfw_overview_content">
		<div class="mfw_overview_content-entry_text">
			<h2><?php esc_html_e( 'What is Membership for WooCommerce?', 'membership-for-woocommerce' ); ?></h2>
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
			<h3>
				<?php esc_html_e( 'With our Membership for WooCommerce plugin, as a store owner you get:', 'membership-for-woocommerce' ); ?>
			</h3>
			<div class="mfw_overview-intro">
			<ul>
				<li>
					<span>&#9900;</span>
					<p><?php esc_html_e( 'Control access to your content and see complete customer history', 'membership-for-woocommerce' ); ?></p>
				</li>
				<li>
					<span>&#9900;</span>
					<p><?php esc_html_e( 'Quick preview section for Membership plans on the plans listing page', 'membership-for-woocommerce' ); ?></p>
				</li>
				<li>
					<span>&#9900;</span>
					<p><?php esc_html_e( 'A different status selection like pending, on hold, or completed as per their payment and plan expiry', 'membership-for-woocommerce' ); ?></p>
				</li>
				<li>
					<span>&#9900;</span>
					<p><?php esc_html_e( 'Manual assignment of membership to a customer', 'membership-for-woocommerce' ); ?></p>
				</li>
				
			</ul>
			<iframe width="100%" height="auto" src="https://www.youtube.com/embed/Yf0pa_Fgn5s" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" poster="" allowfullscreen class="mfw_overview-video"></iframe>
			</div>
		</div>
		<ul>
			<li class="mfw_overview_heading">
				<h2><?php esc_html_e( 'The Freemium Benefits', 'membership-for-woocommerce' ); ?></h2>
			</li>
			<li>
				<img src="<?php echo esc_html( MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL . 'admin/resources/icons/3.jpeg' ); ?>" alt="logo-left">
				<div>
					<h3><?php esc_html_e( 'Complete Customer History', 'membership-for-woocommerce' ); ?></h3>
					<p>
					<?php
						esc_html_e(
							'You get a quick preview section for Membership plans on the plans listing page. Your users too
							can see their history in the ‘My Account’ section with entire details of their membership plans.',
							'membership-for-wooocommerce'
						);
						?>
					</p>
				</div>
			</li>
			<li>
				<div>
					<h3><?php esc_html_e( 'Membership Details', 'membership-for-woocommerce' ); ?></h3>
					<p>
					<?php
					esc_html_e(
						'You can offer products/categories in a membership plan. Those products and categories can only be
						accessible to users if they have purchased the plan. Membership Details Tab on My Accounts Page
						has all the details of the plan.',
						'membership-for-woocommerce'
					);
					?>
					</p>
				</div>
				<img src="<?php echo esc_html( MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL . 'admin/resources/icons/audit1.png' ); ?>" alt="logo-right">
			</li>
			<li>
				<img src="<?php echo esc_html( MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL . 'admin/resources/icons/mfw20.png' ); ?>" alt="logo-left">
				<div>
					<h3><?php esc_html_e( 'Data Export', 'membership-for-woocommerce' ); ?></h3>
					<p>
					<?php
					esc_html_e(
						'You can effortlessly export all the membership plans along with the user data and settings. You
						can also import the details of all members as a CSV file.',
						'membertship-for-woocommerce'
					);
					?>
						</p>
				</div>
			</li>
			<li>
				<div>
					<h3><?php esc_html_e( 'Email PDF Invoice With Out-And-Out Modification Options', 'membership-for-woocommerce' ); ?></h3>
					<p>
					<?php
					esc_html_e(
						'You can attach a PDF invoice to the customer’s email after a successful purchase. You can modify
						the email address, phone number, and the logo of the sender in the pdf invoice. You also have
						options to manipulate the subject or add extra static content to the email.',
						'membership-for-woocommerce'
					);
					?>
					</p>
				</div>
				<img src="<?php echo esc_html( MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL . 'admin/resources/icons/mfw17.png' ); ?>" alt="logo-right">
			</li>

			<li class="mfw_overview_heading">
				<h2><?php esc_html_e( 'Elite Features of Premium Version - Coming Soon', 'membership-for-woocommerce' ); ?> </h2>
			</li>

			<li>
				<img src="<?php echo esc_html( MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL . 'admin/resources/icons/mfw2.png' ); ?>" alt="logo-left">
				<div>
					<h3><?php esc_html_e( 'Recurring membership Feature', 'membership-for-woocommerce' ); ?></h3>
					<p>
					<?php
						esc_html_e(
							'Get a steady and fix revenue with the recurring feature of our pro version. Recurring
							subscriptions will provide memberships on a monthly basis and get regular payments for your
							services.',
							'membership-for-woocommerce'
						);
						?>
				</p>
				</div>
			</li>
			<li>
				<div>
					<h3><?php esc_html_e( 'Drip content feature', 'membership-for-woocommerce' ); ?></h3>
					<p>
						<?php
						esc_html_e(
							'Get the powerful drip content feature to increase the stickiness and value of your membership.
							Release content drip by drip to your site users to avoid overwhelming them at once and have
							complete access to your full library. You may drip particular items, menus, or posts so that
							users can view them in a certain order.',
							'membership-for-woocommerce'
						);
						?>
							</p>
				</div>
				<img src="<?php echo esc_html( MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL . 'admin/resources/icons/mfw20.png' ); ?>" alt="logo-right">
			</li>
			<li>
				<div>
					<h3><?php esc_html_e( 'Create Multiple Membership Levels or Products', 'membership-for-woocommerce' ); ?></h3>
					<p>
					<?php
					esc_html_e(
						'In case you want to offer more than one membership plan to your users, Membership for
						WooCommerce Pro, is for you. Your users may find their new requirements.',
						'membership-for-woocommerce'
					);
					?>
						</p>
				</div>
				<img src="<?php echo esc_html( MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL . 'admin/resources/icons/mfw9.png' ); ?>" alt="logo-right">
			</li>
			<li>
				<img src="<?php echo esc_html( MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL . 'admin/resources/icons/mfw3.png' ); ?>" alt="logo-left">
				<div>
					<h3><?php esc_html_e( 'Min/Max Discount Implementation on the Cart', 'membership-for-woocommerce' ); ?></h3>
					<p>
						<?php
						esc_html_e(
							'You can grant discounts to your customers on cart value and even offer them free shipping as per
							their membership plans. You can implement minimum and maximum discount implementation if
							multiple memberships are purchased by your user.',
							'membership-for-woocommerce'
						);
						?>
						</p>
				</div>
			</li>
			<li>
				<div>
					<h3><?php esc_html_e( 'Purchase Other Plans Related to Product', 'membership-for-woocommerce' ); ?></h3>
					<p>
						<?php
						esc_html_e(
							'Display plans related to particular products in different membership with purchasing options for
							the same.',
							'membership-for-woocommerce'
						);
						?>
						</p>
				</div>
				<img src="<?php echo esc_html( MEMBERSHIP_FOR_WOOCOMMERCE_DIR_URL . 'admin/resources/icons/mfw13.png' ); ?>" alt="logo-right">
			</li>
		</ul>
	</div>
</div>
