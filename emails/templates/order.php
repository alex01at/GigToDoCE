<style>
  
.o_px-xs {
    padding-left: 8px;
    padding-right: 8px;
}

.o_bg-light {
    background-color: #e8f2e8;
}

.o_block {
    max-width: 632px;
    margin: 0 auto;
}

.o_bg-white {
    background-color: #ffffff;
}
.o_text {
    font-size: 16px;
    line-height: 24px;
}
.o_sans, 
.o_heading, 
p, li {
    margin-top: 0px;
    margin-bottom: 0px;
}

.o_body .o_mb-xs {
    margin-bottom: 8px;
}
h4.o_heading {
    font-size: 18px;
    line-height: 23px;
}
.o_heading, strong, b {
    font-weight: 700 !important;
}
.o_sans, .o_heading {
    font-family: "Roboto", sans-serif !important;
}

.o_px-md {
    padding-left: 24px;
    padding-right: 24px;
}

.o_py {
    padding-top: 16px;
    padding-bottom: 16px;
}

.o_body .o_mb-md {
    margin-bottom: 24px;
}

.o_text-secondary, a.o_text-secondary span, 
a.o_text-secondary strong, 
.o_text-secondary.o_link a {
    color: #424651;
}

.o_bg-success {
    background-color: #0ec06e;
}

.o_br {
    border-radius: 4px;
}

.o_btn a {
    display: block;
    padding: 12px 24px;
    mso-text-raise: 3px;
}
.o_text-white, a.o_text-white span, a.o_text-white strong, .o_text-white.o_link a {
    color: #ffffff;
}

.o_bb-light {
    border-bottom: 1px solid #d3dce0;
}

.o_text-dark, a.o_text-dark span, a.o_text-dark strong, .o_text-dark.o_link a {
    color: #242b3d;
}

.o_text-light, a.o_text-light span, a.o_text-light strong, .o_text-light.o_link a {
    color: #82899a;
}

.o_body .o_mb-xs {
    margin-bottom: 8px;
}
.o_text-xs {
    font-size: 14px;
    line-height: 21px;
}

</style>

<div class="box" align="center">
  <div class="container">
    <div class="row bg-green o_sans">
      
      <div class="icon-container">
        <div class="icon bg-white" align="center" style="">
          <img src="<?= img_url("check.png"); ?>" width="48" height="48">
        </div>
      </div>

      <h2 class="o_heading o_mb-xxs">Congratulations!</h2>

      <p class="o_mb-md">You just made a new sale</p>
    </div>
  </div>
</div>


<div class="o_bg-light o_px-xs" align="center">
  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
    <tbody>
      <tr>
        <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center">
          <h4 class="o_heading o_text-dark o_mb-xs"></h4><h4 class="o_heading o_text-dark o_mb-xs selected-element" data-color="Dark" data-size="Heading 4" data-min="10" data-max="26">Hello, <?= $data['user_name']; ?></h4>
          <p class="o_mb-md">You just received an order from <?= $data['buyer_user_name']; ?>. Deliver as soon as possible to release your payment.</p>
          <table align="center" cellspacing="0" cellpadding="0" border="0" role="presentation">
            <tbody>
              <tr>
                <td width="300" class="o_btn o_bg-success o_br o_heading o_text" align="center"><a label="Button" class="o_text-white" href='<?= $site_url; ?>/order_details?order_id=<?= $data['order_id']; ?>'>View Order Details</a></td>
              </tr>
            </tbody>
          </table>
          
        </td>
      </tr>
    </tbody>
  </table>
</div>


<div class="o_bg-light o_px-xs" align="center">
  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
    <tbody>
      <tr>
        <td class="o_bg-white o_sans o_text-xs o_text-light o_px-md o_pt-xs" align="center">
          <p><br data-mce-bogus="1"></p><h4 class="o_heading o_text-dark selected-element" data-color="Dark" data-size="Heading 4" data-min="10" data-max="26">Order Summary</h4><p></p>
          <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
            <tbody>
              <tr>
                <td class="o_re o_bb-light" style="font-size: 8px; line-height: 8px; height: 8px;">&nbsp; </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
</div>


<div class="o_bg-light o_px-xs" align="center">
  <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
    <tbody>
      <tr>
        <td class="o_re o_bg-white o_px o_pt" align="center">

          <div class="o_col o_col-3 o_col-full" style="margin-top:25px; margin-bottom: 25px;">
            <div class="o_px-xs o_sans o_text o_text-light o_left o_xs-center">
              <h4 class="o_heading o_text-dark"><strong><?= $data['proposal_title']; ?></strong></h4>

              <p class="o_text-xs o_mb-xs">
                Quantity: <?= $data['qty']; ?><br>
                Duration: <?= $data['duration']; ?><br>
                Buyer: <?= $data['buyer_user_name']; ?><br>
                <strong class="selected-element">Amount: </strong><?= showPrice($data['amount']); ?>
                <br>
              </p>

            </div>
          </div>

        </td>
      </tr>
    </tbody>
  </table>
</div>