<?php
/**
 * My Account page layout wrapper.
 *
 * WC template override: woocommerce/templates/myaccount/my-account.php
 *
 * @package alwayshere-child
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="ah-account">
<div class="ah-container">

	<div class="ah-account__layout">

		<aside class="ah-account__sidebar">
			<?php do_action( 'woocommerce_account_navigation' ); ?>
		</aside>

		<main class="ah-account__content">
			<?php
				/**
				 * My Account content — WC routes to the correct endpoint template.
				 */
				do_action( 'woocommerce_account_content' );
			?>
		</main>

	</div>

</div>
</div>
