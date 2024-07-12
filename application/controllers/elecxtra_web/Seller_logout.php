<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Seller_logout extends CI_Controller {
	public function index(){
		// $this->session->sess_destroy();
		$unset_items = array('seller_id');
		$this->session->unset_userdata($unset_items);
		redirect(base_url('seller-register'));
	}

}
