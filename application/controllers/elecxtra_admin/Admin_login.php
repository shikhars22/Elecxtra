<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_login extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('elecxtra_admin/admin_login_model');
        if($this->session->has_userdata('admin_id')==TRUE){
        	redirect(base_url('admin/admin-dashboard'));
        }
    }
	public function index(){
		$data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', NULL, TRUE);
		$data['header']=$this->load->view('elecxtra_admin_includes/admin_header', NULL, TRUE);
		$data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', NULL, TRUE);
		$data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', NULL, TRUE);
		$this->load->view('elecxtra_admin/admin_login', $data);
	}
	public function login_data(){
        $this->form_validation->set_rules('user_id', 'Username', 'trim|required');
        $this->form_validation->set_rules('user_password', 'Password', 'trim|required');
        if ($this->form_validation->run() == FALSE){
            exit(json_encode(array('type'=>'warning','text'=>validation_errors())));
        }
        else{
			$data=$this->admin_login_model->login_valid($this->input->post('user_id'),sha1($this->input->post('user_password')));
			if(empty($data)){
	            exit(json_encode(array('type'=>'warning','text'=>'Wrong Username or Pasword.!')));
			}else{
				$this->session->set_userdata(array( 
					'admin_id'  	=> $data->id,
					'admin_role'  	=> $data->user_role,
					'admin_email'	=> $data->user_email,
					'admin_phone'	=> $data->user_phone,
					'admin_name' 	=> $data->user_name,
					'admin_img'  	=> $data->profile_img,
				));
				exit(json_encode(array('type'=>'success','text'=>'Successfully Login')));
			}
        }
	}
		
}
