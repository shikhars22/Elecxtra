<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_login_model extends CI_Model{
	public function login_valid($user_id,$user_password){
		if(is_numeric($user_id)){
            $data=$this->db->where(array('user_phone'=>$user_id, 'user_password'=>$user_password, 'status'=>'approved'))->get('admin_user');
        }else{
    		$data=$this->db->where(array('user_email'=>$user_id, 'user_password'=>$user_password, 'status'=>'approved'))->get('admin_user');
        }
        if($data->num_rows()==1){
			return $data->row();
		}else{
			return false;
		}
		
	}




}
