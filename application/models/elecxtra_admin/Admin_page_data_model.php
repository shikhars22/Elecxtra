<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_page_data_model extends CI_Model{
	public function get_page_data($name){
		return $this->db->where('name', $name)->get('webina_page_content')->row()->content;
	}
	public function update_page_data($name, $data){
		if($this->db->where('name', $name)->update('webina_page_content', $data)){
			return true;
		}else{
			return false;
		}
	}



}
