<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Logout extends CI_Controller {
	public function index(){
		// $this->session->sess_destroy();
		$unset_items = array('user_id', 'user_name');
		$this->session->unset_userdata($unset_items);
		redirect(base_url('login'));
	}

}
