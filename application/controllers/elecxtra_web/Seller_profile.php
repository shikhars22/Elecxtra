<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Seller_profile extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if($this->session->has_userdata('seller_id')==FALSE){
            $url=base_url('seller-register');
            redirect($url);
        }
        $this->load->library('form_validation');
        $this->load->model('elecxtra_web/seller_model', 'current_model');
    }

    //////////////////////Seller Profile///////////////
    public function index(){
        $data['seller_details']=$this->current_model->get_seller_details($this->session->userdata('seller_id'));
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_scripts']=$this->load->view('elecxtra_web_includes/link_script', NULL, TRUE);
        $data['header']=$this->load->view('elecxtra_web_includes/header', NULL, TRUE);
        $data['navigation']=$this->load->view('elecxtra_web_includes/navigation', NULL, TRUE);
        $data['footer']=$this->load->view('elecxtra_web_includes/footer', array('csrfName'=>$data['csrfName'], 'csrfHash'=>$data['csrfHash']), TRUE);
        $data['footer_bottom']=$this->load->view('elecxtra_web_includes/footer_bottom', NULL, TRUE);
        $this->load->view('elecxtra_web/seller_profile', $data);
    }
    
    
    
    public function seller_details_data(){
        $this->form_validation->set_rules('user_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('user_phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('user_email', 'Email', 'trim|required');
        if ($this->form_validation->run() == FALSE) { 
            exit(json_encode(array('type'=>'warning','text'=>validation_errors())));
        }else{
            $data=array(
                'user_name'=>$this->input->post('user_name'),
                'user_phone'=>$this->input->post('user_phone'),
                'user_email'=>$this->input->post('user_email'),
            );

            if($this->current_model->seller_details_data($this->session->userdata('seller_id'), $data)){
                exit(json_encode(array('type'=>'success', 'text'=>'Successfully Updated!')));
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'Wrong OTP Entered!')));
            }
        }
    }
    public function seller_address_data(){
        $this->form_validation->set_rules('user_city', 'City', 'trim|required');
        $this->form_validation->set_rules('user_state', 'State', 'trim|required');
        $this->form_validation->set_rules('user_land_mark', 'land Mark', 'trim|required');
        $this->form_validation->set_rules('user_pin', 'Pincode', 'trim|required');
        $this->form_validation->set_rules('user_address', 'Address', 'trim|required');
        if ($this->form_validation->run() == FALSE) { 
            exit(json_encode(array('type'=>'warning','text'=>validation_errors())));
        }else{
            $data=array(
                'user_city'=>$this->input->post('user_city'),
                'user_state'=>$this->input->post('user_state'),
                'user_land_mark'=>$this->input->post('user_land_mark'),
                'user_pin'=>$this->input->post('user_pin'),
                'user_address'=>$this->input->post('user_address'),
            );
            
            if($this->current_model->seller_address_data($this->session->userdata('seller_id'), $data)){
                exit(json_encode(array('type'=>'success', 'text'=>'Successfully Updated!')));
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'Wrong OTP Entered!')));
            }
        }
    }
    public function seller_bank_data(){
        $this->form_validation->set_rules('user_bank_name', 'Bank Name', 'trim|required');
        $this->form_validation->set_rules('user_bank_branch', 'bank Branch', 'trim|required');
        $this->form_validation->set_rules('user_account_name', 'Account Holder', 'trim|required');
        $this->form_validation->set_rules('user_account_no', 'Account Number', 'trim|required');
        $this->form_validation->set_rules('user_ifsc_code', 'IFSC Code', 'trim|required');
        if ($this->form_validation->run() == FALSE) { 
            exit(json_encode(array('type'=>'warning','text'=>validation_errors())));
        }else{
            $data=array(
                'user_bank_name'=>$this->input->post('user_bank_name'),
                'user_bank_branch'=>$this->input->post('user_bank_branch'),
                'user_account_name'=>$this->input->post('user_account_name'),
                'user_account_no'=>$this->input->post('user_account_no'),
                'user_ifsc_code'=>$this->input->post('user_ifsc_code'),
            );
            
            if($this->current_model->seller_bank_data($this->session->userdata('seller_id'), $data)){
                exit(json_encode(array('type'=>'success', 'text'=>'Successfully Updated!')));
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'Wrong OTP Entered!')));
            }
        }
    }
    public function seller_business_data(){
        $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
        $this->form_validation->set_rules('company_type', 'Company Type', 'trim|required');
        $this->form_validation->set_rules('user_pan', 'PAN', 'trim|required');
        $this->form_validation->set_rules('user_gst', 'GST', 'trim|required');
        if ($this->form_validation->run() == FALSE) { 
            exit(json_encode(array('type'=>'warning','text'=>validation_errors())));
        }else{
            $data=array(
                'company_name'=>$this->input->post('company_name'),
                'company_type'=>$this->input->post('company_type'),
                'user_pan'=>$this->input->post('user_pan'),
                'user_gst'=>$this->input->post('user_gst'),
            );

            $attach_files=array();
            $countfiles = count($_FILES['attachments']['name']);
            for($i=0;$i<$countfiles;$i++){
                $filename = time().'_'.$_FILES['attachments']['name'][$i];
                if(in_array(strtolower(pathinfo($filename, PATHINFO_EXTENSION)), array('pdf'))){
                    $attach_folder='./uploads/seller/attachments/';
                    if(!is_dir($attach_folder)){ mkdir($attach_folder, 0755, true); }
                    move_uploaded_file($_FILES['attachments']['tmp_name'][$i], $attach_folder.$filename);
                    $attach_files[]=$filename;
                }
            }
            if(!empty($attach_files)){
                $data['user_attachment']=implode("|", $attach_files);
            }

            if($this->current_model->seller_business_data($this->session->userdata('seller_id'), $data)){
                exit(json_encode(array('type'=>'success', 'text'=>'Successfully Updated!')));
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'Wrong OTP Entered!')));
            }
        }
    }
    public function seller_pass_change(){
        $this->form_validation->set_rules('old_password', 'Password', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('con_password', 'Confirm password', 'trim|required|matches[password]');
        if ($this->form_validation->run() == FALSE) { 
            exit(json_encode(array('type'=>'warning','text'=>validation_errors())));
        }else{ 
            exit(json_encode($this->current_model->seller_pass_change($this->session->userdata('seller_id'), $this->input->post('password'),sha1($this->input->post('old_password')))));
        } 
    }
    
    
    
    public function seller_subscription_change(){
        $this->form_validation->set_rules('subscription_plan', 'Subscription Plan Name', 'trim|required');
        $this->form_validation->set_rules('expire_month_count', 'Expire Month Count', 'trim|required');
        if ($this->form_validation->run() == FALSE) { 
            exit(json_encode(array('type'=>'warning','text'=>validation_errors())));
        }else{
            $expire_date=date('Y-m-d', strtotime("+30 day", strtotime(date('Y-m-d'))));
            exit(json_encode($this->current_model->seller_subscription_change($this->session->userdata('seller_id'), $this->input->post('subscription_plan'), $this->input->post('expire_month_count'), $expire_date)));
        } 
    }
    
    
}
