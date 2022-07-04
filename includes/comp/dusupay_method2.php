<?php if($dusupay_method != "MOBILE_MONEY"){ ?>
   <form method="post" action="<?= $form_action; ?>" id="mobile-money-form">
      <input type="submit" name="dusupay" value="<?= $lang['button']['pay_with_dusupay']; ?>" class="btn btn-success">
   </form>
<?php }else{ ?>

   <form method="post" action="#" id="mobile-money-form">
      <button type="button" class="btn btn-success open-modal">
         <?= $lang['button']['pay_with_dusupay']; ?>
      </button>
   </form>

   <script>

   $(document).ready(function(){

      $(".open-modal").click(function(event) {
         $("#<?= $main_modal; ?>").modal("hide");
         $("#mobile-payment-modal").modal("show");
      });

   });

   </script>

<?php } ?>