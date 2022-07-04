<h5 class="font-weight-normal float-left"><?= $lang['edit_proposal']['instant_delivery']['title']; ?></h5>

<div class="float-right switch-box">
   <span class="text"><?= $lang['edit_proposal']['instant_delivery']['enable']; ?></span>
   <label class="switch">
      <?php if($enable_delivery == 0){ ?>
         <input type="checkbox" name="enable" form="delivery-form" value="1" />
      <?php }else if($enable_delivery == 1){ ?>
         <input type="checkbox" name="enable" form="delivery-form" value="1" checked="">
      <?php } ?>
      <span class="slider"></span>
   </label>
</div>

<div class="clearfix"></div>

<hr class="mt-0">

<div class="alert alert-warning d-none">
  ! Instant Delivery Will Only Work When Some One Buy This Proposal Directly Or Buy Cart.
</div>

<div class="alert alert-info">
  <?= $lang['edit_proposal']['instant_delivery']['alert1']; ?>
</div>

<form action="#" enctype="multipart/form-data" method="post" id="delivery-form"><!--- form Starts -->

  <div class="form-group">
    <p class="mb-2">Message</p>
    <textarea name="message" placeholder="Message" rows="4" class="form-control"><?= $delivery_message; ?></textarea>
  </div>

  <div class="alert alert-info">
    <?= $lang['edit_proposal']['instant_delivery']['alert2']; ?>
  </div>

  <div class="form-group float-left">
    <input type="file" id="deliveryFile" name="file" class="mb-3"/>
    <div id="downloadFile">
    <?php if(!empty($delivery_file)){ ?>
      <a href="download?proposal_id=<?= $proposal_id; ?>" target="_blank">
        <i class="fa fa-download"></i> <?= $delivery_file; ?>
      </a>
    <?php } ?>
    </div>
  </div>

  <?php if(@$enable_watermark == 1){ ?>
  <div class="form-group float-right">
    <label for="">Enable Watermark : </label>
    <input type="checkbox" <?= ($delivery_watermark ==1)?"checked":""; ?> name="enable_watermark" value="1" style="position: relative; top: 2px;">
  </div>
  <?php } ?>

  <div class="clearfix"></div>

  <hr class="mt-0">

  <div class="form-group mb-0"><!--- form-group Starts --->
    <a href="#" class="btn btn-secondary float-left back-to-req"><?= $lang['button']['back']; ?></a>
    <input class="btn btn-success float-right" type="submit" value="<?= $lang['button']['save_continue']; ?>">
  </div><!--- form-group Starts --->

</form><!--- form Ends -->

<script>
$(document).ready(function(){

  $('.back-to-req').click(function(){
    <?php if($d_proposal_status == "draft"){ ?>
      $("input[type='hidden'][name='section']").val("overview");
      $('#overview').addClass('show active');
      $('#instant-delivery').removeClass('show active');
      $('#tabs a[href="#instant-delivery"]').removeClass('active');
    <?php }else{ ?>
      $('.nav a[href="#overview"]').tab('show');
    <?php } ?>
  });

  $('#deliveryFile').bind('change', function() {

    size = this.files[0].size/1024;
    // alert(size);
    if(size > 100000){
      alert("You exceeded our max upload size limit.");
      $(this).val("");
    }

  });

   $("#delivery-form").submit(function(event){

    var file_input = $("#delivery-form input[type='file']")[0].files;
    // alert(length);

    if(file_input.length != 0){
      swal({
       type: 'success',
       text: 'File Is Uploading.',
       onOpen: function(){
         swal.showLoading();
       }
      });
      timeout = 1000;
    }else{
      timeout = 100;
    }

    event.preventDefault();
    var form_data = new FormData(this);
    form_data.append('proposal_id',<?= $proposal_id; ?>);
    // $('#wait').addClass("loader");

    setTimeout(function(){

      $.ajax({
        method: "POST",
        url: "ajax/save_delivery",
        data: form_data,
        async: false,cache: false,contentType: false,processData: false
      }).done(function(data){
        data = $.parseJSON(data);

        if(file_input.length != 0){
          swal.close();
          $("#delivery-form input[type='file']").val('');
        }

         $('#wait').removeClass("loader");
         if(data.status == "error_file"){
            alert("<?= $lang['alert']['extension_not_supported']; ?>");
         }else{

            // alert(data.file);

            if(data.file){
              $("#downloadFile").html("<a href='download?proposal_id=<?= $proposal_id; ?>' target='_blank'> <i class='fa fa-download'></i> "+data.file+" </a>");
            }

            if($("input[name='enable']:checked").length > 0){
              enable_delivery = 1;
            }else{
              enable_delivery = 0;
            }

            if(enable_delivery == 1){
              $('#tabs a[href="#requirements"]').addClass('d-none');
              $('#pricing .float-right.switch-box').hide();
              $('.packages').hide();
              $('.add-attribute').hide();
              $('.proposal-price').show();
              $('.proposal-price input[name="proposal_price"]').attr('min',<?= $min_proposal_price; ?>);
            }else{
              $('#pricing .float-right.switch-box').show();
              $('#tabs a[href="#requirements"]').removeClass('d-none');
            }

            swal({
             type: 'success',
             text: 'Details Saved.',
             timer: 1000,
             onOpen: function(){
               swal.showLoading();
             }
            }).then(function(){
                <?php if($d_proposal_status == "draft"){ ?>
                  $('#instant-delivery').removeClass('show active');
                  $('#pricing').addClass('show active');
                  $('#tabs a[href="#pricing"]').addClass('active');
                <?php }else{ ?> 
                  $('.nav a[href="#pricing"]').tab('show'); 
                <?php } ?>
                $("input[type='hidden'][name='section']").val("pricing");
            });

        }

      });

    },timeout);

   });

});
</script>