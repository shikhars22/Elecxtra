<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_dashboard_model extends CI_Model{
    public function total_count_visitor($ref_id){
        return $this->db->select('total_count')->where(array('ref_id'=>$ref_id))->get('webina_total_visitor')->row()->total_count;
    }
    public function total_product(){
        return $this->db->select('id')->from('webinatech_product')->count_all_results();
    }
    public function total_send_email(){
        return $this->db->select('id')->from('webina_email')->count_all_results();
    }
    public function total_approved_product(){
        $this->db->select('id');
        $this->db->from('webinatech_product');
        $this->db->where('approve', '1');
        if($this->session->userdata('admin_role')!="superadmin"){
            $this->db->where('create_by', $this->session->userdata('admin_id'));
        }
        return $this->db->count_all_results();
    }
    public function total_hold_product(){
        $this->db->select('id');
        $this->db->from('webinatech_product');
        $this->db->where('approve', '0');
        if($this->session->userdata('admin_role')!="superadmin"){
            $this->db->where('create_by', $this->session->userdata('admin_id'));
        }
        return $this->db->count_all_results();
    }
    public function total_rejected_product(){
        $this->db->select('id');
        $this->db->from('webinatech_product');
        $this->db->where('reject', '1');
        if($this->session->userdata('admin_role')!="superadmin"){
            $this->db->where('create_by', $this->session->userdata('admin_id'));
        }
        return $this->db->count_all_results();
    }
    public function total_hold_order(){
        $this->db->select('id');
        $this->db->from('webinatech_customer_order');
        $this->db->where('status', 'hold');
        if($this->session->userdata('admin_role')!="superadmin"){
            $this->db->where('seller_id', $this->session->userdata('admin_id'));
        }
        return $this->db->count_all_results();
    }





}
