<?php defined('BASEPATH') OR exit('No direct script access allowed');
class admin_view_profile_model extends CI_Model{
    public function get_profile_data(){
        return $this->db->where('id', $this->session->userdata('admin_id'))->get('admin_user')->row();
    }
    public function update_admin_profile($data,$id){
        if($this->db->where('user_phone',$data['user_phone'])->where_not_in('id',$id)->get('admin_user')->num_rows()>0){
            return array('type'=>'warning', 'text'=>'Phone Number is already available. Please check Phone Number!');   
        }elseif($this->db->where('user_email',$data['user_email'])->where_not_in('id',$id)->get('admin_user')->num_rows()>0){
            return array('type'=>'warning', 'text'=>'Email is already available. Please check Email!');   
        }elseif($this->db->where('user_ifsc_code',$data['user_ifsc_code'])->where_not_in('id',$id)->get('admin_user')->num_rows()>0){
            return array('type'=>'warning', 'text'=>'IFSC code is already available. Please check IFSC code!');   
        }elseif($this->db->where('user_account_no',$data['user_account_no'])->where_not_in('id',$id)->get('admin_user')->num_rows()>0){
            return array('type'=>'warning', 'text'=>'Account Number is already available. Please check Account Number');   
        }elseif($data['user_pan']!="" && $this->db->where('user_pan',$data['user_pan'])->where_not_in('id',$id)->get('admin_user')->num_rows()>0){
            return array('type'=>'warning', 'text'=>'PAN Number is already available. Please check PAN!');
        }elseif($data['user_gst']!="" && $this->db->where('user_gst',$data['user_gst'])->where_not_in('id',$id)->get('admin_user')->num_rows()>0){
            return array('type'=>'warning', 'text'=>'GST Number is already available. Please check GST Number!');   
        }else{
            if($this->db->where('id',$id)->update('admin_user', $data)){
                return array('type'=>'success', 'text'=>'Successfully Updated');
            }else{
                return array('type'=>'error', 'text'=>'server error.!');
            }
        }
    }
    public function admin_pass_change_data($data){
        if(sha1($data['old_password'])==$this->db->select('user_password')->where('id',$this->session->userdata('admin_id'))->get('admin_user')->row()->user_password){
            if($this->db->where('id',$this->session->userdata('admin_id'))->update('admin_user',array('user_password'=>$data['password']))){
                return array('type'=>'success','text'=>'Successfully Updated Password. Please Login');
            }else{
                return array('type'=>'error','text'=>'Error.!');
            }
        }else{
            return array('type'=>'error','text'=>'Old password is wrong.!');
        }
    }


}
