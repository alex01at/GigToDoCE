
<?php if($current_balance >= $sub_total){ ?>
<form action="shopping_balance" method="post" id="shopping-balance-form">
<button class="btn btn-lg btn-success btn-block" type="submit" name="checkout_submit_order" onclick="return confirm('Are you sure you want to pay for this with your shopping balance?')">
	<?= $lang['button']['pay_with_shopping']; ?>
</button>
</form>
<?php } ?>

<?php if($enable_paypal == "yes"){ ?>
<form action="paypal_charge" method="post" id="paypal-form"><!--- paypal-form Starts --->
 <button type="submit" name="paypal" class="btn btn-lg btn-success btn-block"><?= $lang['button']['pay_with_paypal']; ?></button>
</form>
<?php } ?>

<?php 
if($enable_stripe == "yes"){
require_once("stripe_config.php");
$stripe_total_amount = $total * 100;
?>
<form action="checkout_charge" method="post" id="credit-card-form"><!--- credit-card-form Starts --->
<input
type="submit"
class="btn btn-lg btn-success btn-block stripe-submit"
value="<?= $lang['button']['pay_with_stripe']; ?>"
data-key="<?= $stripe['publishable_key']; ?>"
data-amount="<?= $stripe_total_amount; ?>"
data-currency="<?= $stripe['currency_code']; ?>"
data-email="<?= $login_seller_email; ?>"
data-name="<?= $site_name; ?>"
data-image="<?= $site_logo_image; ?>"
data-description="<?= $proposal_title; ?>"
data-allow-remember-me="false">
<script>
$(document).ready(function() {
	$('.stripe-submit').on('click', function(event) {
		event.preventDefault();
		var $button = $(this),
		$form = $button.parents('form');
		var opts = $.extend({},$button.data(),{
			token: function(result) {
				$form.append($('<input>').attr({ type: 'hidden', name: 'stripeToken', value: result.id })).submit();
			}
		});
		StripeCheckout.open(opts);
	});
});
</script>
</form>
<?php } ?>


<?php if($enable_2checkout == "yes"){ ?>
<form action='plugins/paymentGateway/2checkout_charge' id="2checkout-form" method='post'>
  <input name='2Checkout' type='submit' class="btn btn-lg btn-success btn-block" value='<?= $lang['button']['pay_with_2checkout']; ?>'/>
</form>
<?php } ?>


<?php if($enable_mercadopago == "1"){ ?>
<form action="mercadopago_charge" method="post" id="mercadopago-form">
	<input type="submit" name="mercadopago" class="btn btn-lg btn-success btn-block" value="<?= $lang['button']['pay_with_mercadopago']; ?>">
</form>
<?php } ?>

<?php if($enable_coinpayments == "yes"){ ?>
<form action="https://www.coinpayments.net/index.php" method="post" id="coinpayments-form">
<input type="hidden" name="cmd" value="_pay_simple">
<input type="hidden" name="reset" value="1">
<input type="hidden" name="merchant" value="<?= $coinpayments_merchant_id; ?>">
<input type="hidden" name="item_name" value="<?= $proposal_title; ?>">
<input type="hidden" name="item_desc" value="Proposal Payment">
<input type="hidden" name="item_number" value="1">
<input type="hidden" name="currency" value="<?= $coinpayments_currency_code; ?>">
<input type="hidden" name="amountf" value="<?= $sub_total; ?>">
<input type="hidden" name="want_shipping" value="0">
<input type="hidden" name="taxf" value="<?= $processing_fee; ?>">
<input type="hidden" name="success_url" value="<?= $site_url; ?>/crypto_order?checkout_seller_id=<?= $login_seller_id; ?>&proposal_id=<?= $proposal_id; ?>&proposal_qty=<?= $proposal_qty; ?>&proposal_price=<?= $sub_total; ?>&proposal_delivery=<?= $delivery_id; ?>&proposal_revisions=<?= $revisions; ?><?= (isset($_SESSION['c_proposal_extras']))?'&proposal_extras='.base64_encode(serialize(@$proposal_extras)):''; ?><?= (isset($_SESSION['c_proposal_minutes']))?'&proposal_minutes='.$proposal_minutes:''; ?>">
<input type="hidden" name="cancel_url" value="<?= $site_url; ?>/proposals/<?= $proposal_seller_user_name; ?>/<?= $proposal_url; ?>">
<input type="submit" class="btn btn-lg btn-success btn-block" value="<?= $lang['button']['pay_with_coinpayments']; ?>">
</form>
<?php } ?>

<?php if($enable_paystack == "yes"){ ?>
<form action="paystack_charge" method="post" id="paystack-form"><!--- paypal-form Starts --->
 <button type="submit" name="paystack" class="btn btn-lg btn-success btn-block"><?= $lang['button']['pay_with_paystack']; ?></button>
</form>
<?php } ?>

<?php if($enable_dusupay == "yes"){ ?>
<form method="post" action="dusupay_charge" id="mobile-money-form">
<input type="submit" name="dusupay" value="<?= $lang['button']['pay_with_dusupay']; ?>" class="btn btn-lg btn-success btn-block">
</form>
<?php } ?>