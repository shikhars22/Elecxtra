<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Seller_model extends CI_Model{
    public function get_seller_details($seller_id){
        return $this->db->where('id', $seller_id)->get('admin_user')->row();
    }
    public function seller_login_data($user_id, $user_password){
        if(is_numeric($user_id)){
            $data=$this->db->where(array('user_phone'=>$user_id, 'user_password'=>$user_password))->get('admin_user');
        }else{
    		$data=$this->db->where(array('user_email'=>$user_id, 'user_password'=>$user_password))->get('admin_user');
        }
        if($data->num_rows()==1){
			return $data->row();
		}else{
			return false;
		}
	}
    public function seller_register_data($data){
        $this->db->trans_begin();
        $this->db->insert('admin_user', $data);
        $seller_id=$this->db->insert_id();
        $this->db->insert('webinatech_seller_report', array('seller_id'=>$seller_id));
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            return true;
        }
    }
    
    public function seller_details_data($seller_id, $data){
        return $this->db->where('id', $seller_id)->update('admin_user', $data);
    }
    public function seller_business_data($seller_id, $data){
        return $this->db->where('id', $seller_id)->update('admin_user', $data);
    }
    public function seller_address_data($seller_id, $data){
        return $this->db->where('id', $seller_id)->update('admin_user', $data);
    }
    public function seller_bank_data($seller_id, $data){
        return $this->db->where('id', $seller_id)->update('admin_user', $data);
    }
    public function seller_pass_change($seller_id, $password, $old_password){
        if($this->db->where('id', $seller_id)->get('admin_user')->row()->user_password==$old_password){
            if($this->db->where('id', $seller_id)->update('admin_user', array('user_password'=>sha1($password)))){
                return array('type'=>'success', 'text'=>'Successfully updated');
            }else{
                return array('type'=>'error', 'text'=>'something error!');
            }
        }else{
            return array('type'=>'warning', 'text'=>'Old password is incorrect!');
        }
    }
    
    public function seller_subscription_change($seller_id, $subscription_plan, $expire_month_count, $expire_date){
        if($this->db->where('id', $seller_id)->update('admin_user', array('subscription_plan'=>$subscription_plan, 'expire_month_count'=>$expire_month_count, 'expire_date'=>$expire_date, 'status'=>'hold'))){
            return array('type'=>'success', 'text'=>'Successfully updated');
        }else{
            return array('type'=>'error', 'text'=>'something error!');
        }
    }
    
    /******start recover password*******/
    public function check_seller_exist($username){
        if(is_numeric($username)){
            if($this->db->where(array('user_phone'=>$username))->get('admin_user')->num_rows()>0){
                return true;
            }else{
                return false;
            }
        }else{
            if($this->db->where(array('user_email'=>$username))->get('admin_user')->num_rows()>0){
                return true;
            }else{
                return false;
            }
        }
    }
    public function seller_recover_pass_account($username, $data){
         if(is_numeric($username)){
            if($this->db->where('user_phone', $username)->update('admin_user', $data)){
                return true;
            }else{
                return false;
            }
        }else{
            if($this->db->where('user_email', $username)->update('admin_user', $data)){
                return true;
            }else{
                return false;
            }
        }
    }
    /******end recover password*******/
    
    
}
