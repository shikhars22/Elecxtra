<?php defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once(APPPATH."libraries/php_email/vendor/autoload.php");

class Cart extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model("elecxtra_web/Cart_model", 'current_model');
    }
    
    public function send_email($data){
        /*$data=array(
            'smtp_host'=>$smtp_host,
            'smtp_user'=>$smtp_user,
            'smtp_pass'=>$smtp_pass,
            'from'=>$from,
            'from_name'=>$from_name,
            'to'=>$to,
            'to_name'=>$to_name,
            'reply_to'=>$reply_to,
            'reply_to_name'=>$reply_to_name,
            'subject'=>$subject,
            'html'=>$html,
        );*/
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = false;                                   //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $data['smtp_host'];                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $data['smtp_user'];                     //SMTP username
            $mail->Password   = $data['smtp_pass'];                     //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom($data['from'], $data['from_name']);
            $mail->addAddress($data['to'], $data['to_name']);           //Add a recipient
            // $mail->addAddress('ellen@example.com');                  //Name is optional
            $mail->addReplyTo($data['reply_to'], $data['reply_to_name']);
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
        
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');            //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');       //Optional name
        
            //Content
            $mail->isHTML(true);                                        //Set email format to HTML
            $mail->Subject = $data['subject'];
            $mail->Body    = $data['html'];
            $mail->AltBody = '';
        
            $response=$mail->send();
            $mail->clearAddresses();
            $mail->clearAttachments();
            if($response){
                return true;
            }else{
                return false;
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        
    }
    
    public function add_to_cart_hash(){
        exit(json_encode(array('type'=>'success', 'addtocarthash'=>base64_encode(convert_uuencode($this->input->post('hash_id'))))));
    }
    public function load_cart_price(){
        exit(json_encode(array('type'=>'success', 'cart_count'=>$this->cart_count(), 'cart_total'=>$this->cart_total())));
    }
    public function cart_count(){
        if($cart_data=$this->session->tempdata('cart_data')){
            return count($cart_data);
        }else{
            return 0;
        }
    }
    public function cart_total(){
        $total_price=0;
        $price_commission=json_decode(price_commission());
        if($cart_data=$this->session->tempdata('cart_data')){
            $all_product_id=array_column($cart_data, 'product_id');
            $all_product_qty=array_column($cart_data, 'qty', 'product_id');
            $product_price=$this->current_model->get_cart_product_price($all_product_id);
            foreach ($product_price as $key => $value){
                $finalPrice=0;
                foreach ($price_commission as $k => $v){
                    if($value->price<=$v->max_price){
                        $other_charge=2;
                        $comms=$v->commission;
                        $webViewPrice=$value->price+($value->price*$v->commission/100);
                        $finalPrice=number_format((float)($webViewPrice+($webViewPrice*$other_charge/100)), 2, '.', '');
                        break;
                    }
                }
                $total_price+=($finalPrice*$all_product_qty[$value->id]);
            }
            return $total_price;
        }else{
            return $total_price;
        }
    }
    public function load_cart(){
        if($data['cart_data']=$this->session->tempdata('cart_data')){
            $all_product_id=array_column($data['cart_data'], 'product_id');
            $data['product_details']=$this->current_model->get_cart_product_details($all_product_id);
        }else{
            $data['cart_data']=array();
            $data['product_details']=array();
        }
        exit(json_encode(array('type'=>'success', 'data'=>$this->load->view('elecxtra_web_includes/load_cart', $data, true))));
    }
	public function index(){
	    $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
		$data['link_scripts']=$this->load->view("elecxtra_web_includes/link_script", null, true);
		$data['header']=$this->load->view("elecxtra_web_includes/header", null, true);
        $data['navigation']=$this->load->view('elecxtra_web_includes/navigation', NULL, TRUE);
		$data['footer']=$this->load->view('elecxtra_web_includes/footer', array('csrfName'=>$data['csrfName'], 'csrfHash'=>$data['csrfHash']), TRUE);
		$this->load->view('elecxtra_web/cart', $data);
        // $this->load->view('elecxtra_web/order_email_template', $data);
	}
	public function add_to_cart(){
		$qty=$this->input->post('qty');
        $grab=$this->input->post('grab_data');
        if(empty($qty) || empty($grab)){
            exit(json_encode(array("type"=>'error', 'text'=>'grab item & qty not selected')));
        }else{
            $product_id=convert_uudecode(base64_decode($grab));
            $new=true;
            if($cart_data=$this->session->tempdata('cart_data')){
                for ($i=0; $i<count($cart_data); $i++) { 
                    if($cart_data[$i]['product_id']==$product_id){
                        $cart_data[$i]["qty"]=$cart_data[$i]["qty"]+$qty;
                        $new=false;
                    }
                } 
            }
            if($new){
                $cart_data[]=array('product_id'=>$product_id, 'qty'=>$qty);
            }
            $this->session->set_tempdata('cart_data', $cart_data, 2592000);
			exit(json_encode(array("type"=>'success', 'text'=>'Added to cart', 'cart_count'=>count($cart_data))));
        }
	}
    public function update_cart(){
        $qty=$this->input->post('qty');
        $grab=$this->input->post('grab_data');
        if(empty($qty) || empty($grab)){
            exit(json_encode(array("type"=>'error', 'text'=>'grab item & qty not selected')));
        }else{
            $product_id=convert_uudecode(base64_decode($grab));
            if($cart_data=$this->session->tempdata('cart_data')){
                for ($i=0; $i<count($cart_data); $i++) { 
                    if($cart_data[$i]['product_id']==$product_id){
                        $cart_data[$i]["qty"]=$qty;
                    }
                } 
                $this->session->set_tempdata('cart_data', $cart_data, 2592000);
                exit(json_encode(array("type"=>'success', 'text'=>'Updated cart', 'cart_count'=>count($cart_data))));
            }else{
                exit(json_encode(array("type"=>'error', 'text'=>'something went wrong!')));
            }
        }
    }
    public function delete_cart(){
        $grab=$this->input->post('grab_data');
        if(empty($grab)){
            exit(json_encode(array("type"=>'error', 'text'=>'grab item not selected')));
        }else{
            $product_id=convert_uudecode(base64_decode($grab));
            if($cart_data=$this->session->tempdata('cart_data')){
                // print_r($cart_data);
                for ($i=0; $i<count($cart_data); $i++) { 
                    if($cart_data[$i]['product_id']==$product_id){
                        // print_r($cart_data[$i]);
                        unset($cart_data[$i]);
                    }
                } 
                // print_r(array_values($cart_data));
                // die();
                $this->session->set_tempdata('cart_data', array_values($cart_data), 2592000);
                exit(json_encode(array("type"=>'success', 'text'=>'Removed from cart', 'cart_count'=>count($cart_data))));
            }else{
                exit(json_encode(array("type"=>'error', 'text'=>'something went wrong!')));
            }
        }
    }
    public function destroy_cart(){
        $this->session->unset_tempdata('cart_data');
        exit(json_encode(array("type"=>'success', 'text'=>'Cart cleared', 'cart_count'=>0)));
    }




    /***************CHECKOUT*******************/
    public function checkout(){
        if($this->session->has_userdata('user_id')==TRUE){
            if($cart_data=$this->session->tempdata('cart_data')){
                if(count($cart_data)>0){
                    if($data['cart_data']=$this->session->tempdata('cart_data')){
                        $all_product_id=array_column($data['cart_data'], 'product_id');
                        $data['product_details']=$this->current_model->get_cart_product_details($all_product_id);
                        // get user data
                        $data['user_data']=$this->current_model->get_user_details($this->session->userdata('user_id'));
                    }else{
                        $data['cart_data']=array();
                        $data['product_details']=array();
                    }
                    $data['csrfHash']=$this->security->get_csrf_hash();
                    $data['csrfName']=$this->security->get_csrf_token_name();
                    $data['link_script']=$this->load->view("elecxtra_web_includes/link_script", null, true);
                    $data['header']=$this->load->view("elecxtra_web_includes/header", null, true);
                    $data['navigation']=$this->load->view('elecxtra_web_includes/navigation', NULL, TRUE);
                    $data['footer']=$this->load->view('elecxtra_web_includes/footer', array('csrfName'=>$data['csrfName'], 'csrfHash'=>$data['csrfHash']), TRUE);
                    $this->load->view('elecxtra_web/checkout',$data);
                }else{
                    redirect(base_url('cart'));
                }
            }
        }else{
            redirect(base_url('login-first'));
        }
    }
    public function submit_checkout_pincode(){
        exit(json_encode($this->current_model->submit_checkout_pincode($this->session->tempdata('cart_data'), trim($this->input->post('search_pin')))));
    }
    public function place_order(){
        if($this->session->has_userdata('user_id')==TRUE){
            if($cartdata=$this->session->tempdata('cart_data')){
                if(count($cartdata)>0){
                    $user_id=$this->session->userdata('user_id');
                    $cart_data=array_column($cartdata, 'qty', 'product_id');
                    $delivery_data=$this->current_model->checkout_pincode($this->input->post('shipping_pin'));
                    if($delivery_data['type']=='success'){
                        $ref_id="ELXTRA-".time(); $cart_total=0;
                        $shipping_city=$this->input->post('shipping_city');
                        $shipping_state=$this->input->post('shipping_state');
                        $shipping_address=$this->input->post('shipping_address');
                        $shipping_pin=$this->input->post('shipping_pin');
                        $shipping_land_mark=$this->input->post('shipping_land_mark');
                        
                        $order_data=array(); $order_info=array();
                        $product_details=$this->current_model->get_cart_product_min_details(array_column($cartdata, 'product_id'));
                        $price_commission=json_decode(price_commission());
                        foreach ($product_details as $key => $value){
                            $temp_arr=array(); $temp_arr2=array();
                            $temp_arr['order_id']="ELX-".$value->id.time();
                            $temp_arr['product_id']=$value->id;
                            $temp_arr['product_name']=$value->name;
                            $temp_arr['cat_name']=$value->cat_name;
                            $temp_arr['sub_cat_name']=$value->sub_cat_name;
                            $temp_arr['item_name']=$value->item_name;
                            $temp_arr['group_id']=$value->group_id;
                            $temp_arr['product_img']=$value->main_img;
                            $temp_arr['return_day']=$value->return_day;
                            $temp_arr['ref_id']=$ref_id;
                            $temp_arr['qty']=$cart_data[$value->id];
                            $finalPrice=0;
                            foreach ($price_commission as $k => $v){
                                if($value->price<=$v->max_price){
                                    $other_charge=2;
                                    $comms=$v->commission;
                                    $webViewPrice=$value->price+($value->price*$v->commission/100);
                                    $finalPrice=number_format((float)($webViewPrice+($webViewPrice*$other_charge/100)), 2, '.', '');
                                    break;
                                }
                            }
                            $temp_arr['price']=$value->price;
                            $temp_arr['sell_price']=$finalPrice;
                            $temp_arr['seller_id']=$value->create_by;
                            $temp_arr['seller_name']=$value->seller_name;
                            $temp_arr['user_id']=$user_id;
                            $temp_arr['subtotal']=number_format((float)($cart_data[$value->id]*$finalPrice),2,'.','');
                            $cart_total+=$temp_arr['subtotal'];
                            $temp_arr['order_date']=date('Y-m-d H:i:s');
                            $temp_arr['status']='hold';
                            $temp_arr['payment_mode']=$this->input->post('payment_mode');
                            $temp_arr['billing_address']="<span>".$shipping_address."</span><span>".$shipping_pin."</span><span>".$shipping_land_mark."</span><span>".$shipping_city."</span><span>".$shipping_state."</span>";

                            $temp_arr['shipping_address']="<span>".$shipping_address."</span><span>".$shipping_pin."</span><span>".$shipping_land_mark."</span><span>".$shipping_city."</span><span>".$shipping_state."</span>";

                            if($delivery_data['over_total']>$temp_arr['subtotal']){
                                $delivery_charge=$delivery_data['del_charge'];
                            }else{
                                $delivery_charge=0;
                            }

                            $temp_arr2['ref_id']=$temp_arr['order_id'];
                            $temp_arr2['delivery_charge']=$delivery_charge;
                            $temp_arr2['razorpay_order_id']=$this->input->post('razorpay_order_id');
                            $temp_arr2['razorpay_payment_id']=$this->input->post('razorpay_payment_id');
                            $temp_arr2['merchant_order_ref']=$this->input->post('merchant_order_ref');
                            
                            $temp_arr2['billing_city']=$shipping_city;
                            $temp_arr2['billing_state']=$shipping_state;
                            $temp_arr2['billing_address']=$shipping_address;
                            $temp_arr2['billing_pin']=$shipping_pin;
                            $temp_arr2['billing_land_mark']=$shipping_land_mark;

                            $temp_arr2['shipping_city']=$shipping_city;
                            $temp_arr2['shipping_state']=$shipping_state;
                            $temp_arr2['shipping_address']=$shipping_address;
                            $temp_arr2['shipping_pin']=$shipping_pin;
                            $temp_arr2['shipping_land_mark']=$shipping_land_mark;

                            $order_data[]=$temp_arr;
                            $order_info[]=$temp_arr2;

                            $user_send_sms[$temp_arr['order_id']]=array('name'=>$value->name, 'qty'=>$cart_data[$value->id], 'subtotal'=>number_format((float)($cart_data[$value->id]*$finalPrice),2,'.',''), 'delivery_charge'=>$delivery_charge);
                        }                        

                        // echo $cart_total;
                        // print_r($order_data);
                        // print_r($order_info);
                        // print_r($user_send_sms);
                        // die();
                        
                        if($this->current_model->place_order($order_data, $order_info)){
                            $user_details=$this->current_model->get_user_details($user_id);
                            //send user sms that order successfully sublitted
                            if(!empty($user_details->email)){
                                $user_name=$user_details->name;
                                $user_email=$user_details->email;
                                $user_subject="Your order Successfully placed! Order Id ".$ref_id." - ".site_title();
                                $user_message=$this->load->view('elecxtra_web/order_email_template', array('ref_id'=>$ref_id, 'cart_total'=>$cart_total, 'user_details'=>$user_details, 'user_send_sms'=>$user_send_sms, 'billing_address'=>$order_data[0]['billing_address'], 'shipping_address'=>$order_data[0]['shipping_address']), TRUE);
                                $data=array(
                                    'smtp_host'=>get_email_host(),
                                    'smtp_user'=>get_email_name('customer'),
                                    'smtp_pass'=>get_email_pass('customer'),
                                    'from'=>get_email_name('customer'),
                                    'from_name'=>site_title(),
                                    'to'=>$user_email,
                                    'to_name'=>$user_name,
                                    'reply_to'=>get_email_name('info'),
                                    'reply_to_name'=>site_title(),
                                    'subject'=>$user_subject,
                                    'html'=>$user_message,
                                );
                                if($this->send_email($data)){
                                    
                                }
                            }
                            //send user sms that order successfully sublitted
                            $this->session->unset_tempdata('cart_data');
                            exit(json_encode(array('type'=>'success', 'text'=>'Successfully Placed Order!')));
                            
                        }else{
                            exit(json_encode(array('type'=>'error', 'text'=>"some error occure please try again.!")));
                        }
                    }else{
                        exit(json_encode(array('type'=>'error', 'text'=>"shipping pin not available!")));
                    }
                }else{
                    exit(json_encode(array('type'=>'error', 'text'=>"cart not available!")));
                }
            }
        }else{
            // echo "login page with remember came from cart";
            exit(json_encode(array('type'=>'error', 'text'=>"login first!")));
        }
    }
    





}
