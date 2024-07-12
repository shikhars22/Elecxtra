<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_view_profile extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if($this->session->has_userdata('admin_id')==FALSE){
            redirect(base_url('admin'));
        }
        $this->load->library('form_validation');
        $this->load->model('elecxtra_admin/admin_view_profile_model', 'current_model');
    }
    public function index(){
        $data['session_data']=$this->session->all_userdata();
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['profile_data']=$this->current_model->get_profile_data();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
        $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
        $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
        $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
        $this->load->view('elecxtra_admin/admin_view_profile',$data);
    }
    public function update_admin_profile(){
        $this->form_validation->set_rules('user_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
        $this->form_validation->set_rules('company_type', 'Company Type', 'trim|required');
        $this->form_validation->set_rules('user_email', 'Email', 'trim|valid_email|required'); 
        $this->form_validation->set_rules('user_phone', 'Phone', 'trim|required'); 
        $this->form_validation->set_rules('user_gender', 'Gender', 'trim|required'); 
        $this->form_validation->set_rules('user_city', 'City', 'trim|required'); 
        $this->form_validation->set_rules('user_pin', 'Pincode', 'trim|required');
        $this->form_validation->set_rules('user_land_mark', 'Land Mark', 'trim|required'); 
        $this->form_validation->set_rules('user_address', 'Address', 'trim|required'); 
        $this->form_validation->set_rules('user_bank_name', 'Bank Name', 'trim'); 
        $this->form_validation->set_rules('user_bank_branch', 'bank Branch', 'trim'); 
        $this->form_validation->set_rules('user_account_name', 'Acc Holder', 'trim'); 
        $this->form_validation->set_rules('user_account_no', 'Acc No', 'trim'); 
        $this->form_validation->set_rules('user_ifsc_code', 'IFSC code', 'trim'); 
        $this->form_validation->set_rules('user_gst', 'GST', 'trim'); 
        $this->form_validation->set_rules('user_pan', 'PAN', 'trim');
        if ($this->form_validation->run() == FALSE) { 
            exit(json_encode(array('type'=>'warning','text'=>validation_errors())));
        }else{
            //make array for save
            $data=array(
                'user_name'=>$this->input->post('user_name'),
                'profile_img'=>$this->input->post('profile_img'),
                'company_name'=>$this->input->post('company_name'),
                'company_type'=>$this->input->post('company_type'),
                'user_phone'=>$this->input->post('user_phone'),
                'user_email'=>$this->input->post('user_email'),
                'user_gender'=>$this->input->post('user_gender'),
                'user_city'=>$this->input->post('user_city'),
                'user_pin'=>$this->input->post('user_pin'),
                'user_land_mark'=>$this->input->post('user_land_mark'),
                'user_pan'=>$this->input->post('user_pan'),
                'user_account_no'=>$this->input->post('user_account_no'),
                'user_address'=>$this->input->post('user_address'),
                'user_gst'=>$this->input->post('user_gst'),
                'user_account_name'=>$this->input->post('user_account_name'),
                'user_bank_name'=>$this->input->post('user_bank_name'),
                'user_ifsc_code'=>$this->input->post('user_ifsc_code'),
                'user_bank_branch'=>$this->input->post('user_bank_branch'),
                'edit_by'=>$this->session->userdata('admin_id'),
                'edit_date'=>date('Y-m-d H:i:s'),
            );
            exit(json_encode($this->current_model->update_admin_profile($data,$this->session->userdata('admin_id'))));
        }
    }
    public function change_password(){
        $data['session_data']=$this->session->all_userdata();
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
        $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
        $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
        $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
        $this->load->view('elecxtra_admin/admin_view_password',$data);
    }
    public function admin_pass_change_data(){
        $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]');
        if ($this->form_validation->run() == FALSE) { 
            exit(json_encode(array('type'=>'warning','text'=>validation_errors())));
        }else{
            $data=array(
                'old_password'=>$this->input->post('old_password'),
                'password'=>sha1($this->input->post('password'))
            );
            exit(json_encode($this->current_model->admin_pass_change_data($data)));
        }
    }
    
    
}
