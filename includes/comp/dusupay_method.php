<?php if($dusupay_method != "MOBILE_MONEY"){ ?>
<form method="post" action="<?= $form_action; ?>" id="mobile-money-form">
   <input type="submit" name="dusupay" value="<?= $lang['button']['pay_with_dusupay']; ?>" class="btn btn-lg btn-success btn-block">
</form>
<?php }else{ ?>

<form method="post" action="#" id="mobile-money-form">
   <button type="button" data-toggle="modal" data-target="#mobile-payment-modal" class="btn btn-lg btn-success btn-block">
      <?= $lang['button']['pay_with_dusupay']; ?>
   </button>
</form>

<?php include("mobile_money_modal.php"); ?>

<?php } ?>