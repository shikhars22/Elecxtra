<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_dashboard extends CI_Controller {
	public function __construct(){
        parent::__construct();
        if($this->session->has_userdata('admin_id')==FALSE){
        	redirect(base_url('admin'));
        }
        $this->load->model('elecxtra_admin/admin_dashboard_model', 'current_model');
    }
	public function index(){
		$data['session_data']=$this->session->all_userdata();
		$data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
         $data['total_homepage_visitor']=$this->current_model->total_count_visitor('homepage_visitor');
	    $data['total_approved_product']=$this->current_model->total_approved_product();
	    $data['total_hold_product']=$this->current_model->total_hold_product();
	    $data['total_rejected_product']=$this->current_model->total_rejected_product();
	    $data['total_hold_order']=$this->current_model->total_hold_order();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
		$data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
		$data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
		$data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
		$this->load->view('elecxtra_admin/tool/admin_dashboard', $data);
	}
	public function calender(){
		$data['session_data']=$this->session->all_userdata();
		$data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
		$data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
		$data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
		$data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
		$this->load->view('elecxtra_admin/tool/admin_view_calender', $data);
	}
	public function converter(){
		$data['session_data']=$this->session->all_userdata();
		$data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
		$data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
		$data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
		$data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
		$this->load->view('elecxtra_admin/tool/admin_view_converter', $data);
	}
	public function weather(){
		$data['session_data']=$this->session->all_userdata();
		$data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
		$data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
		$data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
		$data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
		$this->load->view('elecxtra_admin/tool/admin_view_weather', $data);
	}
	public function google_map(){
		$data['session_data']=$this->session->all_userdata();
		$data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
		$data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
		$data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
		$data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
		$this->load->view('elecxtra_admin/tool/admin_view_google_map', $data);
	}
}
