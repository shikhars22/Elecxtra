<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Profile extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if($this->session->has_userdata('user_id')==FALSE){
        	$url=base_url('login');
        	redirect($url);
        }
        $this->load->library('form_validation');
        $this->load->model('elecxtra_web/user_model', 'current_model');
        
    }
    public function index(){
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_scripts']=$this->load->view('elecxtra_web_includes/link_script', NULL, TRUE);
        $data['header']=$this->load->view('elecxtra_web_includes/header', NULL, TRUE);
        $data['navigation']=$this->load->view('elecxtra_web_includes/navigation', NULL, TRUE);
        $data['footer']=$this->load->view('elecxtra_web_includes/footer', array('csrfName'=>$data['csrfName'], 'csrfHash'=>$data['csrfHash']), TRUE);
        $data['footer_bottom']=$this->load->view('elecxtra_web_includes/footer_bottom', NULL, TRUE);
        $data['user_data']=$this->current_model->user_data();
		$this->load->view('elecxtra_web/profile', $data);
    }
    public function personal_form_data(){
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_checkUpdateEmail'); 
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|numeric|callback_checkUpdatePhone');
        if ($this->form_validation->run() == FALSE) { 
            exit(json_encode(array('type'=>'warning','text'=>validation_errors())));
        }else{ 
            $data=array(
                'name'=>$this->input->post('name'),
                'phone'=>$this->input->post('phone'),
                'email'=>$this->input->post('email'),
            );
            if($this->current_model->personal_form_data($data)){
                $this->session->set_userdata('user_name',$data['name']);
                $this->session->set_userdata('user_phone',$data['phone']);
                $this->session->set_userdata('user_email',$data['email']);
                exit(json_encode(array('type'=>'success', 'text'=>'Successfully updated.')));
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'something error..!')));
            }
        } 
    }
    public function checkUpdatePhone($phone){
        if($this->current_model->checkUpdatePhone($phone)==true){
            $this->form_validation->set_message('checkUpdatePhone', 'The mobile no. already exists!');
            return FALSE;
        }else{
            return TRUE;
        }
    }
    public function checkUpdateEmail($email){
        if($this->current_model->checkUpdateEmail($email)==true){
            $this->form_validation->set_message('checkUpdateEmail', 'The email is already exists!');
            return FALSE;
        }else{
            return TRUE;
        }
    }
    public function address_form(){ 
        $this->form_validation->set_rules('old_type', 'Old_Type', 'trim|required');
        $this->form_validation->set_rules('type', 'Type', 'trim|required');
        $this->form_validation->set_rules('pin', 'Pin', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('state', 'State', 'trim|required');
        $this->form_validation->set_rules('land_mark', 'Land Mark', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        if ($this->form_validation->run() == FALSE) { 
            exit(json_encode(array('type'=>'warning','text'=>validation_errors())));
        }else{ 
            $data=array(
                'type'=>$this->input->post('type'),
                'pin'=>$this->input->post('pin'),
                'address'=>$this->input->post('address'),
                'city'=>$this->input->post('city'),
                'state'=>$this->input->post('state'),
                'land_mark'=>$this->input->post('land_mark'),
            );
            if($this->current_model->address_form($this->input->post('old_type'), $data)){
                $this->session->set_userdata('user_pin', $data['pin']);
                exit(json_encode(array('type'=>'success', 'text'=>'Successfully updated.')));
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'something error..!')));
            }
        } 
    }
    public function change_pass_form(){ 
        $this->form_validation->set_rules('old_password', 'Password', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('con_password', 'Confirm password', 'trim|required|matches[password]');
        if ($this->form_validation->run() == FALSE) { 
            exit(json_encode(array('type'=>'warning','text'=>validation_errors())));
        }else{ 
            exit(json_encode($this->current_model->change_pass_form($this->input->post('password'),sha1($this->input->post('old_password')))));
        } 
    }
    public function my_order_data(){
        $status=$this->input->post('status');
        $data['order_data']=$this->current_model->my_order_data($status);
        $orderData=$this->load->view('elecxtra_web_includes/load_order', $data, TRUE);
        exit(json_encode(array('type'=>'success', 'data'=>$orderData)));
    }
    public function fetch_order_invoice(){
        $order_id=$this->input->post('order_id');
        $data['order_data']=$this->current_model->get_order_details($order_id);
        $invData=$this->load->view('elecxtra_web_includes/load_invoice', $data, TRUE);
        exit(json_encode(array('type'=>'success', 'data'=>$invData)));
    }
    public function cancel_order(){
        $user_id=$this->session->userdata('user_id');
        $seller_id=$this->input->post('seller_id');
        $product_id=$this->input->post('product_id');
        $order_id=$this->input->post('order_id');
        $qty=$this->input->post('qty');
        $cancel_reason=$this->input->post('cancel_reason');
        $cancel_reason_text=$this->input->post('cancel_reason_text');
        if(empty($order_id) || empty($seller_id) || empty($qty) || empty($cancel_reason)){
            exit(json_encode(array('type'=>'error', 'text'=>"Something went wrong!")));
        }
        if($this->current_model->cancel_order($user_id, $seller_id, $product_id, $order_id, $qty, $cancel_reason, $cancel_reason_text)){
            exit(json_encode(array('type'=>'success', 'text'=>'your order is canceled!')));
        }else{
            exit(json_encode(array('type'=>'error', 'text'=>"Something went wrong!")));
        }
    }
    public function return_order(){
        $user_id=$this->session->userdata('user_id');
        $seller_id=$this->input->post('seller_id');
        $product_id=$this->input->post('product_id');
        $order_id=$this->input->post('order_id');
        $qty=$this->input->post('qty');
        $return_reason=$this->input->post('return_reason');
        $return_reason_text=$this->input->post('return_reason_text');
        if(empty($order_id) || empty($seller_id) || empty($return_reason)){
            exit(json_encode(array('type'=>'error', 'text'=>"Something went wrong!")));
        }
        if($this->current_model->return_order($user_id, $seller_id, $product_id, $order_id, $qty, $return_reason, $return_reason_text)){
            exit(json_encode(array('type'=>'success', 'text'=>'your order is canceled!')));
        }else{
            exit(json_encode(array('type'=>'error', 'text'=>"Something went wrong!")));
        }
    }






    
    
    
}