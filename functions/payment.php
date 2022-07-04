<?php
class Payment{

public function insert_temp_order($data,$currency='',$method=''){

  global $db;
  global $login_seller_id;

  $o_data = [
    "reference_no"=>$data['reference_no'],
    "buyer_id"=>$login_seller_id,
    "price"=>$data['sub_total'],
    "total"=>$data['total'],
    "type"=>$data['type'],
    "content_id" => $data['content_id'],
  ];

  if(isset($data['qty'])){
    $o_data['qty'] = $data['qty'];
  }else{
    $o_data['qty'] = 1;
  }

  if($data['type'] == "proposal"){

    $o_data['delivery_id'] = $data['delivery_id'];

    if(isset($data['revisions'])){
      $o_data['revisions'] = $data['revisions'];
    }

    if(isset($data['extras'])){
      $o_data['extras'] = $data['extras'];
    }

    if(isset($data['minutes'])){
      $o_data['minutes'] = $data['minutes'];
    }

  }


  if(isset($data['message'])){
    $o_data['message'] = $data['message'];
  }

  if(!empty($currency)){
    $o_data['currency'] = $currency;
  }

  if(!empty($method)){
    $o_data['method'] = $method;
  }

  $insert_order = $db->insert("temp_orders",$o_data);

}

public function execute_payment($reference_no,$method){

  global $db;
  global $site_url;
  global $login_seller_id;
  
  $get_order = $db->query("select * from temp_orders where reference_no=:reference_no AND method=:method AND not type='cart_item' AND not method='coinpayments'",['reference_no'=>$reference_no,'method'=>$method]);
  $data = $get_order->fetch();
  $count_order = $get_order->rowCount();
  if($count_order == 0){
    echo "<script> window.open('$site_url/index','_self'); </script>";
  }

  if($data->type == "proposal"){
    $_SESSION['checkout_seller_id'] = $data->buyer_id;
    $_SESSION['proposal_id'] = $data->content_id;
    $_SESSION['proposal_qty'] = $data->qty;
    $_SESSION['proposal_price'] = $data->price;
    $_SESSION['proposal_delivery'] = $data->delivery_id;
    $_SESSION['proposal_revisions'] = $data->revisions;
    if(!empty($data->extras)){
      $_SESSION['proposal_extras'] = unserialize(base64_decode($data->extras));
    }
    if(!empty($data->minutes)){
      $_SESSION['proposal_minutes'] = $data->minutes;
    }
  }elseif($data->type == "cart"){
    $_SESSION['cart_seller_id'] = $data->buyer_id;
    $_SESSION['reference_no'] = $data->content_id;
  }elseif($data->type == "featured_listing"){
    $_SESSION['featured_listing'] = 1;
    $_SESSION['proposal_id'] = $data->content_id;
  }elseif($data->type == "view_offers"){
    $_SESSION['offer_id'] = $data->offer_id;
    $_SESSION['offer_buyer_id'] = $login_seller_id;
  }elseif($data->type == "message_offer"){ 
    $_SESSION['message_offer_id'] = $data->message_offer_id;
    $_SESSION['message_offer_buyer_id'] = $login_seller_id;
  }

  $_SESSION['method'] = $method;

  $db->delete("temp_orders",array('reference_no'=>$reference_no));

  if($data->type == "featured_listing"){
    echo "<script>window.open('$site_url/proposals/featured_proposal','_self')</script>";
  }elseif($data->type == "orderExtendTime"){
    return true;
  }elseif($data->type == "orderTip"){
    return true;
  }else{
    echo "<script>window.open('$site_url/order','_self')</script>";
  }

}

/// Paypal Payment Code Starts ////
public function paypal_api_setup(){
	global $db;
	global $dir;
	$get_payment_settings = $db->select("payment_settings");
	$row_payment_settings = $get_payment_settings->fetch();
	$paypal_app_client_id = $row_payment_settings->paypal_app_client_id;
	$paypal_app_client_secret = $row_payment_settings->paypal_app_client_secret;
	$paypal_sandbox = $row_payment_settings->paypal_sandbox;
	if($paypal_sandbox == "on"){
    $mode = "sandbox";
	}elseif($paypal_sandbox == "off"){
    $mode = "live";
	}
	require_once "$dir/vendor/autoload.php";
	$api = new PayPal\Rest\ApiContext(
		new PayPal\Auth\OAuthTokenCredential(
			$paypal_app_client_id,
			$paypal_app_client_secret
		)
	);
	$api->setConfig([
    "mode" => $mode
	]);
	return $api;
}

public function paypal($data,$processing_fee){
	global $db;
	global $site_url;
	
  $this->insert_temp_order($data,"","paypal");

  $get_payment_settings = $db->select("payment_settings");
	$row_payment_settings = $get_payment_settings->fetch();
	$paypal_currency_code = $row_payment_settings->paypal_currency_code;

	$api = $this->paypal_api_setup();
	$payer = new PayPal\Api\Payer();
	$item1 = new PayPal\Api\Item();
	$itemList = new PayPal\Api\ItemList();
	$details = new PayPal\Api\Details();
	$amount = new PayPal\Api\Amount();
	$transaction = new PayPal\Api\Transaction();
	$payment = new PayPal\Api\Payment();
	$redirecturls = new PayPal\Api\RedirectUrls();
	//Payer
	$payer->setPaymentMethod("paypal");
	// ### Itemized information
	$item1->setName($data['name'])->setCurrency("$paypal_currency_code")->setQuantity($data['qty'])->setPrice($data['price']);
	$itemList->setItems(array($item1));
	// ### Additional payment details
	$details->setShipping(0)->setTax($processing_fee)->setSubtotal($data['sub_total']);
	//Amount
	$amount->setCurrency("$paypal_currency_code")->setTotal($data['total'])->setDetails($details);
	//Transaction
	$transaction->setAmount($amount)->setItemList($itemList)->setDescription("");
	//Redirect Urls
	$redirecturls->setReturnUrl("{$data['redirect_url']}")->setCancelUrl("{$data['cancel_url']}");
	//Payment
	$payment->setIntent("sale")->setPayer($payer)->setRedirectUrls($redirecturls)->setTransactions([$transaction]);
	try{
		$payment->create($api);
		//Generate Payment-id
		$payment_id = $payment->getId();
		$approvalUrl = $payment->getApprovalLink();
		echo "<script>window.open('$approvalUrl','_self')</script>";
	}catch (Exception $ex){
		echo "there is an error connecting to paypal api.";
	}
}

public function paypal_execute(){
  global $db;
  global $input;
  global $site_url;
  $login_seller_user_name = $_SESSION['seller_user_name'];
  $select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
  $row_login_seller = $select_login_seller->fetch();
  $login_seller_id = $row_login_seller->seller_id;
  // paypal api
  $api = $this->paypal_api_setup();
  //Get The Paypal Payment
  $paymentId = $input->get("paymentId");
  $PayerID = $input->get("PayerID");
  $payment = PayPal\Api\Payment::get($paymentId, $api);
  $execution = new PayPal\Api\PaymentExecution();
  $execution->setPayerId($PayerID);
  try {
    // Execute the payment
    $result = $payment->execute($execution, $api);
    if($result){

      $reference_no = $input->get("reference_no");
      return $this->execute_payment($reference_no,"paypal");

    }
  }catch(Exception $ex){
    exit(1);
  }
}
/// Paypal Payment Code Ends ////

/// Stripe Payment Code Starts ////
public function stripe_api_setup(){
	global $db;
	global $dir;
	require_once "$dir/vendor/autoload.php";
	$get_payment_settings = $db->select("payment_settings");
	$row_payment_settings = $get_payment_settings->fetch();
	$stripe_secret_key = $row_payment_settings->stripe_secret_key;
	$stripe_publishable_key = $row_payment_settings->stripe_publishable_key;
	$stripe_currency_code = $row_payment_settings->stripe_currency_code;
	$stripe = array(
	  "secret_key"      => $stripe_secret_key,
	  "publishable_key" => $stripe_publishable_key,
	  "currency_code"   => $stripe_currency_code
	);
	\Stripe\Stripe::setApiKey($stripe["secret_key"]);
	return $stripe;
}

public function stripe($data){
	global $site_url;
	global $db;
	$login_seller_user_name = $_SESSION['seller_user_name'];
	$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
	$row_login_seller = $select_login_seller->fetch();
	$login_seller_id = $row_login_seller->seller_id;
	$login_seller_email = $row_login_seller->seller_email;
	$stripe = $this->stripe_api_setup();
	$customer = \Stripe\Customer::create(array(
		'email' => $login_seller_email,
		'card'  => $data['stripeToken']
	));
	$charge = \Stripe\Charge::create(array(
		'customer' => $customer->id,
		'amount'   => intval($data['amount']) * 100,
		'currency' => $stripe['currency_code'],
		'description' => $data['desc']
	));
	if($charge){

    // echo "<pre>";
    //   print_r($data);
    // echo "</pre>";

	  if($data['type'] == "proposal"){
   	  $_SESSION['checkout_seller_id'] = $login_seller_id;
   	  $_SESSION['proposal_id'] = $data['proposal_id'];
   	  $_SESSION['proposal_qty'] = $data['proposal_qty'];
   	  $_SESSION['proposal_price'] = $data['amount'];
      $_SESSION['proposal_delivery'] = $data['proposal_delivery'];
      $_SESSION['proposal_revisions'] = $data['proposal_revisions'];
   	  if(isset($data['proposal_extras'])){
   	    $_SESSION['proposal_extras'] = $data['proposal_extras'];
   	  }
   	  if(isset($data['proposal_minutes'])){
        $_SESSION['proposal_minutes'] = $data['proposal_minutes'];
   	  }
	  }elseif ($data['type'] == "cart") {
	     $_SESSION['cart_seller_id'] = $login_seller_id;
       $_SESSION['reference_no'] = $data['reference_no'];
	  }elseif($data['type'] == "featured_listing"){
	     $_SESSION['proposal_id'] = $data['proposal_id'];
	  }elseif($data['type'] == "request_offer"){
   	  $offer_id = $data["offer_id"];
   	  $_SESSION['offer_id'] = $data['offer_id'];
   	  $_SESSION['offer_buyer_id'] = $data['offer_buyer_id'];
	  }elseif($data['type'] == "message_offer"){ 
   	  $_SESSION['message_offer_id'] = $data['message_offer_id'];
   	  $_SESSION['message_offer_buyer_id'] = $data['message_offer_buyer_id'];
	  }
	  $_SESSION['method'] = "stripe";
	  if($data['type'] == "featured_listing"){
      echo "<script>window.open('$site_url/proposals/featured_proposal','_self');</script>";
	  }elseif($data['type'] == "orderExtendTime"){
	  	return true;
	  }elseif($data['type'] == "orderTip"){
      return true;
    }else{
      echo "<script>window.open('$site_url/order','_self');</script>";
	  }

	}
}
/// Stripe Payment Code Ends ////


/// Mercadopago Payment Code Starts ///

   
public function mercadopago($data){
  global $db;
  global $dir;
  global $site_url;

  $this->insert_temp_order($data,"","mercadopago");

  $get_payment_settings = $db->select("payment_settings");
  $row_payment_settings = $get_payment_settings->fetch();
  $enable_mercadopago = $row_payment_settings->enable_mercadopago;
  $mercadopago_access_token = $row_payment_settings->mercadopago_access_token;
  $mercadopago_currency = $row_payment_settings->mercadopago_currency;
  $mercadopago_sandbox = $row_payment_settings->mercadopago_sandbox;

  $login_seller_user_name = $_SESSION['seller_user_name'];
  $select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
  $row_login_seller = $select_login_seller->fetch();
  $login_seller_id = $row_login_seller->seller_id;
  $login_seller_email = $row_login_seller->seller_email;

  if(!isset($data['qty'])){
    $data['qty'] = 1;
  }

  // SDK de Mercado Pago
  require  $dir.'/vendor/autoload.php';

  // Configura credenciais
  MercadoPago\SDK::setAccessToken($mercadopago_access_token);

  // Cria um objeto de preferência
  $preference = new MercadoPago\Preference();

  // Cria um item na preferência
  $item = new MercadoPago\Item();
  $item->title = $data['title'];
  // $item->category_id = "";
  $item->currency_id = $mercadopago_currency;
  if(isset($data['image'])){
    $item->picture_url = "$site_url/proposals/proposal_files/{$data['image']}";
  }
  if(isset($data['description'])){
    $item->description = $data['description'];
  }
  $item->quantity = $data['qty'];
  $item->unit_price = $data['price'];
  $preference->items = array($item);

  // $payer = new MercadoPago\Payer();
  // $date_created = new DateTime();
  // $date_created = $date_created->format(DateTime::ISO8601);
  // $payer->name = $login_seller_user_name;
  // $payer->surname = "";
  // $payer->email = $login_seller_email;
  // $payer->date_created = $date_created;
  // $preference->payer = $payer;

  $url = $data['redirect_url']."&";

  $preference->back_urls = array(
    "success" => $url."success",
    "failure" => $data['cancel_url'],
    "pending" => $url."pending"
  );

  $preference->auto_return = "approved";

  $preference->external_reference = "Ref_".mt_rand();
  $preference->additional_info = "{
    Buyer Username: $login_seller_user_name
    Buyer Email: $login_seller_email
    Payment Date: ".date("F d, Y")."
  }";

  $preference->payment_methods = array(
    "excluded_payment_types" => array(
      array("id" => "ticket")
    )
  );

  $preference->save();

  if($mercadopago_sandbox == 1){
    echo "<script>window.open('{$preference->sandbox_init_point}','_self')</script>";
  }else{
    echo "<script>window.open('{$preference->init_point}','_self')</script>";
  }

}


public function mercadopago_execute(){

  global $db;
  global $input;
  global $site_url;

  $login_seller_user_name = $_SESSION['seller_user_name'];
  $select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
  $row_login_seller = $select_login_seller->fetch();
  $login_seller_id = $row_login_seller->seller_id;

  $reference_no = $input->get("reference_no");
  return $this->execute_payment($reference_no,"mercadopago");

}

/// Mercadopago Payment Code Ends ///



/// Coinpayments Payment Code Starts ///

public function coinpayments($data,$processing_fee){

  global $db;
  global $input;
  global $site_url;

  $get_payment_settings = $db->select("payment_settings");
  $row_payment_settings = $get_payment_settings->fetch();
  $enable_coinpayments = $row_payment_settings->enable_coinpayments;
  $coinpayments_merchant_id = $row_payment_settings->coinpayments_merchant_id;
  $coinpayments_currency_code = $row_payment_settings->coinpayments_currency_code;

  $this->insert_temp_order($data,$coinpayments_currency_code,"coinpayments");

  if(!isset($data['desc'])){
    $data['desc'] = "";
  }

  $form = "
    <form action='https://www.coinpayments.net/index.php' method='post' id='coinpayments-form'>
      <input type='hidden' name='cmd' value='_pay_simple'>
      <input type='hidden' name='reset' value='1'>
      <input type='hidden' name='merchant' value='$coinpayments_merchant_id'>
      <input type='hidden' name='item_name' value='{$data['name']}'>
      <input type='hidden' name='item_desc' value='{$data['desc']}'>
      <input type='hidden' name='item_number' value='{$data['reference_no']}'>
      <input type='hidden' name='currency' value='$coinpayments_currency_code'>
      <input type='hidden' name='amountf' value='{$data['sub_total']}'>
      <input type='hidden' name='want_shipping' value='0'>
      <input type='hidden' name='taxf' value='$processing_fee'>
      <input type='hidden' name='success_url' value='$site_url/crypto_return'>
      <input type='hidden' name='cancel_url' value='{$data['cancel_url']}'>
    </form>

    <script>
      document.getElementById('coinpayments-form').submit();
    </script>
  ";

  echo $form;

}

/// Coinpayments Payment Code Ends ///



/// Dusupay Payment Code Starts ////
public function dusupay($data){
	global $db;
  global $site_url;
	
  $login_seller_user_name = $_SESSION['seller_user_name'];
  $select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
  $row_login_seller = $select_login_seller->fetch();
  $login_seller_id = $row_login_seller->seller_id;
  $login_seller_email = $row_login_seller->seller_email;

  $get_payment_settings = $db->select("payment_settings");
  $row_payment_settings = $get_payment_settings->fetch();
  $dusupay_api_key = $row_payment_settings->dusupay_api_key;
  $dusupay_method = $row_payment_settings->dusupay_method;
  $dusupay_provider_id = $row_payment_settings->dusupay_provider_id;
  $dusupay_currency_code = $row_payment_settings->dusupay_currency_code;
  $dusupay_sandbox = $row_payment_settings->dusupay_sandbox;

	$test_mode = ($dusupay_sandbox == "on" ? ',"test_webhook_url": "'.$site_url.'/dusupay_ipn"' : '');

	$url = ($dusupay_sandbox == "on"?'https://dashboard.dusupay.com/api-sandbox/v1/collections':'https://api.dusupay.com/v1/collections');

  if(isset($data['account_number'])){
    $account_number = '"account_number": "'.$data['account_number'].'",';
  }

  if(isset($data['voucher'])){
    $voucher = '"voucher": "'.$data['voucher'].'",';
  }

	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => $url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",    
	  CURLOPT_POSTFIELDS => '{ 
	    "api_key": "'.$dusupay_api_key.'", 
	    "currency": "'.$dusupay_currency_code.'", 
	    "amount": '.$data['amount'].',
	    "method": "'.$dusupay_method.'", 
	    "provider_id": "'.$dusupay_provider_id.'",
      '.@$account_number.'
      '.@$voucher.'
	    "merchant_reference": "'.mt_rand().'",
	    "narration": "'.$data['name'].'",
	    "redirect_url": "'.$site_url.'/dusupay_return",
	    "account_name": "'.$login_seller_user_name.'",
	    "account_email": "'.$login_seller_email.'"
	    '.$test_mode.'
	  }',
	  CURLOPT_HTTPHEADER => array(
	    "cache-control: no-cache",
	    "content-type: application/json"
	  ),
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	if($err){ 
      echo "cURL Error #:" . $err; 
   }else{

      $d_data = json_decode($response, TRUE);
      // echo "<pre>";
      //   print_r($d_data);
      // echo "</pre>";

      if($d_data['status'] != "error"){

        $o_data = [
          "reference_no"=>$d_data['data']['merchant_reference'],
          "buyer_id"=>$login_seller_id,
          "price"=>$data['price'],
          "total"=>$data['amount'],
          "type"=>$data['type'],
          "currency"=>$dusupay_currency_code,
          "content_id" => $data['content_id'],
        ];

        if(isset($data['qty'])){
          $o_data['qty'] = $data['qty'];
        }

        if(isset($data['message'])){
          $o_data['message'] = $data['message'];
        }

        if($data['type'] == "proposal"){

          $o_data['delivery_id'] = $data['delivery_id'];

          if(isset($data['revisions'])){
            $o_data['revisions'] = $data['revisions'];
          }

          if(isset($data['extras'])){
            $o_data['extras'] = $data['extras'];
          }

          if(isset($data['minutes'])){
            $o_data['minutes'] = $data['minutes'];
          }

        }

        $insert_order = $db->insert("dusupay_orders",$o_data);

      }

      if($d_data['status'] == "error"){
        $url = "$site_url/dusupay_return?status={$d_data['status']}&message={$d_data['message']}";
        echo "<script>window.open('$url','_self')</script>";
      }else{
        if($dusupay_method == "CARD" OR $dusupay_method == "BANK"){
           // header('Location: '.$data['data']['payment_url']);
          echo "<script>window.open('".$d_data['data']['payment_url']."','_self')</script>";
        }else{
          echo "<script>window.open('$site_url/dusupay_return?reference={$d_data['data']['merchant_reference']}&status={$d_data['data']['transaction_status']}','_self')</script>";
        }
      }

	}
}
/// Dusupay Payment Code Ends ////

/// Paystack Payment Code Starts ////
public function paystack_api_setup(){
	global $db;
	global $dir;
	require_once "$dir/vendor/autoload.php";
	$get_payment_settings = $db->select("payment_settings");
	$row_payment_settings = $get_payment_settings->fetch();
	$enable_paystack = $row_payment_settings->enable_paystack;
	$paystack_public_key = $row_payment_settings->paystack_public_key;
	$paystack_secret_key = $row_payment_settings->paystack_secret_key;
	$paystack = new Yabacon\Paystack($paystack_secret_key);
	return $paystack;
}

public function paystack($data){
	global $db;

  $this->insert_temp_order($data,"","paystack");

	$login_seller_user_name = $_SESSION['seller_user_name'];
	$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
	$row_login_seller = $select_login_seller->fetch();
	$login_seller_id = $row_login_seller->seller_id;
	$login_seller_email = $row_login_seller->seller_email;
	$paystack = $this->paystack_api_setup();
	try{
		$tranx = $paystack->transaction->initialize([
      'amount'=>$data['total']*100, /* 20 naira */
      'email'=> $login_seller_email,
      'reference'=> mt_rand(),
      'callback_url'=>$data['redirect_url'],
		]);
	}catch(\Yabacon\Paystack\Exception\ApiException $e){
		print_r($e->getResponseObject());
		die($e->getMessage());
	}
	header('Location: '.$tranx->data->authorization_url);
}

function paystack_execute(){
   global $input;
   global $site_url;
   global $db;

   $login_seller_user_name = $_SESSION['seller_user_name'];
   $select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
   $row_login_seller = $select_login_seller->fetch();
   $login_seller_id = $row_login_seller->seller_id;

   $paystack = $this->paystack_api_setup();
   $reference = isset($_GET['reference']) ? $input->get('reference') : '';
   try{
    // verify using the library
    $tranx = $paystack->transaction->verify([
      'reference'=>$reference, // unique to transactions
    ]);
   } catch(\Yabacon\Paystack\Exception\ApiException $e){
    print_r($e->getResponseObject());
    die($e->getMessage());
   }
   if('success' === $tranx->data->status){

      // transaction was successful...
      // please check other things like whether you already gave value for this ref
      // if the email matches the customer who owns the product etc
      // Give value
      $reference_no = $input->get("reference_no");
      return $this->execute_payment($reference_no,"paystack");

   }
}
/// Paystack Payment Code Ends ////

}