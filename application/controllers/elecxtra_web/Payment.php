<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH."libraries/razorpay/razorpay-php/Razorpay.php");
use Razorpay\Api\Api as RazorpayApi;
use Razorpay\Api\Errors\SignatureVerificationError as RazorpayApiSignErr;

class Payment extends CI_Controller{

    // public $keyId='rzp_test_yaWOPIKDFLEI3f';
    // public $keySecret='TELdCze83ALnWcRwqFg4lrL7';
    
    public $keyId='rzp_live_UlHpsYhJYH0e9H';
    public $keySecret='Sjkksw9ipYfO6rRyj0drJ1IB';
    
    public function __construct(){
        parent::__construct();
        $this->load->model("elecxtra_web/Cart_model", 'current_model');
    }

    public function verify_payment(){   
        if(empty($_POST['razorpay_payment_id']) === false){
            $success = true;
            $error = "Payment Failed";

            $api = new RazorpayApi($this->keyId, $this->keySecret);
            $razorpay_order_id=$_SESSION['razorpay_order_id'];
            $merchant_order_ref=$_POST['merchant_order_ref'];
            $razorpay_payment_id=$_POST['razorpay_payment_id'];
            try{
                // Please note that the razorpay order ID must
                // come from a trusted source (session here, but
                // could be database or something else)
                $attributes = array(
                    'razorpay_order_id' => $razorpay_order_id,
                    'razorpay_payment_id' => $razorpay_payment_id,
                    'razorpay_signature' => $_POST['razorpay_signature']
                );
                $api->utility->verifyPaymentSignature($attributes);
            }
            catch(RazorpayApiSignErr $e){
                $success = false;
                $error = 'Razorpay Error : '.$e->getMessage();
            }
            if ($success === true){
                //save $razorpay_payment_id, $razorpay_order_id in database and redirect to success page
                $pay_amt = $api->payment->fetch($razorpay_payment_id);
                if($pay_amt['status']=='captured'){
                    exit(json_encode(array('type'=>'success', 'razorpay_order_id'=>$razorpay_order_id, 'merchant_order_ref'=>$merchant_order_ref, 'razorpay_payment_id'=>$razorpay_payment_id, 'text'=>'your payment successfully captured')));
                }else{
                    // $html = "<p>Your payment failed</p><p>{$error}</p>";
                    exit(json_encode(array('type'=>'error', 'text'=>'your payment failed!')));
                }
            }else{
                // $html = "<p>Your payment failed</p><p>{$error}</p>";
                exit(json_encode(array('type'=>'error', 'text'=>'your payment failed!')));
            }
        }else{
            exit(json_encode(array('type'=>'error', 'text'=>'your payment failed!')));
        }
    }
    public function order_pay_now(){
        $name=$this->input->post('name');
        $phone=$this->input->post('phone');
        $email=$this->input->post('email');
        $shipping_city=$this->input->post('shipping_city');
        $shipping_state=$this->input->post('shipping_state');
        $shipping_address=$this->input->post('shipping_address');
        $shipping_pin=$this->input->post('shipping_pin');
        $shipping_land_mark=$this->input->post('shipping_land_mark');
        if( empty($name) || empty($email) || empty($phone) || empty($shipping_city) || empty($shipping_state) || empty($shipping_address) || empty($shipping_pin) || empty($shipping_land_mark) ){
            exit(json_encode(array('type'=>'error', 'text'=>'Something went wrong!')));
        }else{
            $billing_address=$shipping_address.", Pin: ".$shipping_pin.", Land Mark: ".$shipping_land_mark.", City: ".$shipping_city.", State: ".$shipping_state;
            $product_output=$this->current_model->submit_checkout_pincode($this->session->tempdata('cart_data'), $shipping_pin);
            if($product_output['type']=='success'){
                $amount=$product_output['total'];
                $unique_id=time();
                $orderData = [
                    'receipt'         => $unique_id,
                    'amount'          => $amount * 100, // rupees in paise
                    'currency'        => 'INR',
                    'payment_capture' => 1 // auto capture
                ];
                $displayCurrency = 'INR';
                $api = new RazorpayApi($this->keyId, $this->keySecret);
                $razorpayOrder = $api->order->create($orderData);
                $razorpayOrderId = $razorpayOrder['id'];
                $razorpayMarchantOrderId = $unique_id;
                $_SESSION['razorpay_order_id'] = $razorpayOrderId;
                $displayAmount = $amount = $orderData['amount'];
                if($displayCurrency !== 'INR'){
                    $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
                    $exchange = json_decode(file_get_contents($url), true);
                    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
                }
                $data = 
                    [
                        "key"               => $this->keyId,
                        "amount"            => $amount,
                        "name"              => site_title(),
                        "description"       => "Total Payable Amount",
                        "image"             => base_url('viewer_assets/images/logo.png'),
                        "prefill"           => [
                            "name"              => $name,
                            "email"             => $email,
                            "contact"           => $phone,
                        ],
                    "notes"                 => [
                        "address"           => $billing_address,
                        "merchant_order_id" => $razorpayMarchantOrderId,
                    ],
                    "theme"                 => [
                        // "color"             => "#F37254"
                    ],
                    "order_id"          => $razorpayOrderId,
                ];

                if($displayCurrency !== 'INR'){
                    $data['display_currency']  = $displayCurrency;
                    $data['display_amount']    = $displayAmount;
                }
                $data['json']=json_encode($data);
                $data['merchant_order_ref']=$razorpayMarchantOrderId;
                $data['csrfHash']=$this->security->get_csrf_hash();
                $data['csrfName']=$this->security->get_csrf_token_name();
                exit(json_encode(array('type'=>'success', 'payment_ui'=>$this->load->view('elecxtra_web/payment_ui', $data, TRUE))));
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'service not available at your address')));
            }
        }
    }

    public function subscription_pay_now(){
        $price_amount=$this->input->post('price_amount');
        $user_name=$this->input->post('user_name');
        $user_phone=$this->input->post('user_phone');
        $user_email=$this->input->post('user_email');
        if( empty($user_name) || empty($user_email) || empty($user_phone) || empty($price_amount) ){
            exit(json_encode(array('type'=>'error', 'text'=>'something went wrong!')));
        }else{
            $unique_id=time();
            $orderData = [
                'receipt'         => $unique_id,
                'amount'          => $price_amount * 100, // rupees in paise
                'currency'        => 'INR',
                'payment_capture' => 1 // auto capture
            ];
            $displayCurrency = 'INR';
            $api = new RazorpayApi($this->keyId, $this->keySecret);
            $razorpayOrder = $api->order->create($orderData);
            $razorpayOrderId = $razorpayOrder['id'];
            $razorpayMarchantOrderId = $unique_id;
            $_SESSION['razorpay_order_id'] = $razorpayOrderId;
            $displayAmount = $amount = $orderData['amount'];
            if($displayCurrency !== 'INR'){
                $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
                $exchange = json_decode(file_get_contents($url), true);
                $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
            }
            $data = 
                [
                    "key"               => $this->keyId,
                    "amount"            => $amount,
                    "name"              => site_title(),
                    "description"       => "Total Payable Amount",
                    "image"             => base_url('viewer_assets/images/logo.png'),
                    "prefill"           => [
                        "name"              => $user_name,
                        "email"             => $user_email,
                        "contact"           => $user_phone,
                    ],
                "notes"                 => [
                    "address"           => "",
                    "merchant_order_id" => $razorpayMarchantOrderId,
                ],
                "theme"                 => [
                    // "color"             => "#F37254"
                ],
                "order_id"          => $razorpayOrderId,
            ];

            if($displayCurrency !== 'INR'){
                $data['display_currency']  = $displayCurrency;
                $data['display_amount']    = $displayAmount;
            }
            $data['json']=json_encode($data);
            $data['merchant_order_ref']=$razorpayMarchantOrderId;
            $data['csrfHash']=$this->security->get_csrf_hash();
            $data['csrfName']=$this->security->get_csrf_token_name();
            exit(json_encode(array('type'=>'success', 'payment_ui'=>$this->load->view('elecxtra_web/payment_ui', $data, TRUE))));
        }
    }
    




}