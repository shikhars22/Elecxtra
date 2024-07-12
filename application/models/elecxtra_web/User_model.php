<?php defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model{
    public function check_user_exist($username){
        if(is_numeric($username)){
            if($this->db->where(array('phone'=>$username))->get('webinatech_customer')->num_rows()>0){
                return true;
            }else{
                return false;
            }
        }else{
            if($this->db->where(array('email'=>$username))->get('webinatech_customer')->num_rows()>0){
                return true;
            }else{
                return false;
            }
        }
    }
    public function checkUpdatePhone($phone){
        if($this->db->where_not_in('id',$this->session->userdata('user_id'))->where(array('phone'=>$phone))->get('webinatech_customer')->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    public function checkUpdateEmail($email){
        if($this->db->where_not_in('id',$this->session->userdata('user_id'))->where(array('email'=>$email))->get('webinatech_customer')->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    public function login_data($username, $password){
        $query1=$this->db->select('id, name')->where(array('email'=>$username, 'password'=>$password))->get('webinatech_customer');
        if($query1->num_rows()>0){
            $data1=$query1->row();
            return array('login'=>'success', 'user_id'=>$data1->id, 'user_name'=>$data1->name);
        }else{
            $query2=$this->db->select('id, name')->where(array('phone'=>$username, 'password'=>$password))->get('webinatech_customer');
            if($query2->num_rows()>0){
                $data2=$query2->row();
                return array('login'=>'success', 'user_id'=>$data2->id, 'user_name'=>$data2->name);
            }else{
              return array('login'=>'error!');
            }
        }
    }
    public function register_data($data, $reffer_code){
        if(!empty($reffer_code)){
            $temp=$this->db->select('id, name')->where('reffer_code',$reffer_code)->get('admin_user');
            if($temp->num_rows()>0){
                $create_by=$temp->row()->id;
            }else{
                $create_by="";
            }
        }else{
            $create_by="";
        }
        $data['create_by']=$create_by;
        $this->db->trans_begin();
        $this->db->insert('webinatech_customer', $data);
        $user_id=$this->db->insert_id();
        $this->db->insert_batch('webinatech_customer_address', array(array('type'=>'Home', 'user_id'=>$user_id), array('type'=>'Office', 'user_id'=>$user_id)));
        $this->db->insert('webinatech_customer_report', array('user_id'=>$user_id));
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return array('type'=>'error', 'text'=>'something went wrong!');
        }else{
            $this->db->trans_commit();
            return array('type'=>'success', 'text'=>'Successfully Registerd', 'user_id'=>$user_id, 'user_name'=>$data['name']);
        }
    }
    public function user_data(){
        $this->db->select('a.*, GROUP_CONCAT(b.type SEPARATOR "||") as types, GROUP_CONCAT(b.pin SEPARATOR "||") as pins, GROUP_CONCAT(b.city SEPARATOR "||") as cities, GROUP_CONCAT(b.land_mark SEPARATOR "||") as land_marks, GROUP_CONCAT(b.address SEPARATOR "||") as addresses, GROUP_CONCAT(b.state SEPARATOR "||") as states');
        $this->db->from("webinatech_customer a");
        $this->db->where('a.id', $this->session->userdata('user_id'));
        $this->db->join("webinatech_customer_address b", "b.user_id=a.id");
        return $this->db->get()->row();
    }
    public function personal_form_data($data){
        return $this->db->where('id', $this->session->userdata('user_id'))->update('webinatech_customer', $data);
    }
    public function address_form($old_type, $data){
        return $this->db->where(array('type'=>$old_type, 'user_id'=>$this->session->userdata('user_id')))->update('webinatech_customer_address', $data);
    }
    public function change_pass_form($password, $old_password){
        if($this->db->where('id', $this->session->userdata('user_id'))->get('webinatech_customer')->row()->password==$old_password){
            if($this->db->where('id', $this->session->userdata('user_id'))->update('webinatech_customer',array('password'=>sha1($password)))){
                return array('type'=>'success', 'text'=>'Successfully updated');
            }else{
                return array('type'=>'error', 'text'=>'something error!');
            }
        }else{
            return array('type'=>'warning', 'text'=>'Old password is incorrect!');
        }
    }
    public function recover_pass_account($username, $data){
        if(is_numeric($username)){
            if($this->db->where('phone', $username)->update('webinatech_customer', $data)){
                return array('type'=>'success', 'text'=>'Successfully Recovered Password');
            }else{
                return array('type'=>'error', 'text'=>'something error!');
            }
        }else{
            if($this->db->where('email', $username)->update('webinatech_customer', $data)){
                return array('type'=>'success', 'text'=>'Successfully Recovered Password');
            }else{
                return array('type'=>'error', 'text'=>'something error!');
            }
        }
    }
    public function my_order_data($status){
        $this->db->select('a.seller_id, a.ref_id, a.order_id, a.order_date, a.product_id, a.qty, a.price, a.sell_price, a.subtotal, a.status, a.product_name, a.cat_name, a.sub_cat_name, a.item_name, a.group_id, a.product_img, a.return_day, a.edit_date, c.delivery_charge');
        $this->db->where('a.user_id', $this->session->userdata('user_id'));
        $this->db->from('webinatech_customer_order a');
        $this->db->join('webinatech_customer_order_info c', 'c.ref_id=a.order_id', 'left');
        $this->db->order_by('a.id', 'desc');
        return $this->db->get()->result();
    }
    public function get_order_details($order_id){
        $this->db->select('a.seller_id, a.ref_id, a.order_id, a.order_date, a.billing_address, a.shipping_address, a.product_id, a.qty, a.price, a.sell_price, a.subtotal, a.seller_id, a.status, a.product_name, a.cat_name, a.sub_cat_name, a.item_name, a.group_id, a.product_img, a.return_day, a.edit_date, c.delivery_charge, a.seller_name, s.company_name as seller_company_name, s.company_type as seller_company_type, s.user_state as seller_state, s.user_city as seller_city, s.user_pin as seller_pin, s.user_land_mark as seller_land_mark, s.user_address as seller_address, s.user_gst as seller_gst, p.name, p.name, p.email, p.phone');
        $this->db->where(array('a.user_id'=>$this->session->userdata('user_id'), 'a.order_id'=>$order_id));
        $this->db->from('webinatech_customer_order a');
        $this->db->join('webinatech_customer_order_info c', 'c.ref_id=a.order_id', 'left');
        $this->db->join('webinatech_customer p', 'p.id=a.user_id');
        $this->db->join('admin_user s', 's.id=a.seller_id', 'left');
        $this->db->order_by('a.id', 'desc');
        return $this->db->get()->row();
    }
    public function cancel_order($user_id, $seller_id, $product_id, $order_id, $qty, $cancel_reason, $cancel_reason_text){
        $check_status=$this->db->select('status')->where('order_id', $order_id)->get('webinatech_customer_order')->row()->status;
        if($check_status=="hold" || $check_status=="packaged"){
            $this->db->trans_begin();
            $this->db->where('order_id', $order_id)->update('webinatech_customer_order', array('status'=>'canceled', 'note'=>$cancel_reason."_|_".$cancel_reason_text));
            $this->db->where('product_id', $product_id)->set('stock', 'stock + 1', false)->update('webinatech_stock');
            $this->db->where('user_id', $user_id)->set('cancel_count', 'cancel_count + '.$qty, false)->update('webinatech_customer_report');
            $this->db->where('seller_id', $seller_id)->set('cancel_count', 'cancel_count + '.$qty, false)->update('webinatech_seller_report');
            $this->db->where('product_id', $product_id)->set('cancel_count', 'cancel_count + '.$qty, false)->update('webinatech_product_report');
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return false;
            }else{
                $this->db->trans_commit();
                return true;
            }
        }else{
            return false;
        }
    }
    public function return_order($user_id, $seller_id, $product_id, $order_id, $qty, $return_reason, $return_reason_text){
        $temp=$this->db->select('status, return_day, edit_date')->where('order_id', $order_id)->get('webinatech_customer_order')->row();
        $check_status=$temp->status;
        $return_time=date('Y-m-d', strtotime(date('Y-m-d', strtotime($temp->edit_date)). ' + '.$temp->return_day.' days'));

        if($check_status=="completed" && date('Y-m-d')<=$return_time){
            $this->db->trans_begin();
            $this->db->where('order_id', $order_id)->update('webinatech_customer_order', array('status'=>'returned', 'note'=>$return_reason."_|_".$return_reason_text, 'edit_date'=>date('Y-m-d H:i:s')));
            $this->db->where('user_id', $user_id)->set('return_count', 'return_count + '.$qty, false)->update('webinatech_customer_report');
            $this->db->where('seller_id', $seller_id)->set('return_count', 'return_count + '.$qty, false)->update('webinatech_seller_report');
            $this->db->where('product_id', $product_id)->set('return_count', 'return_count + '.$qty, false)->update('webinatech_product_report');
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return false;
            }else{
                $this->db->trans_commit();
                return true;
            }
        }else{
            return false;
        }
    }




    
}
