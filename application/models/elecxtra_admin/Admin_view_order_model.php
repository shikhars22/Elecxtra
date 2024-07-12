<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_view_order_model extends CI_Model{
    public function fetch_all_order($status, $start, $length, $search, $order, $filter){
        $orderableColumns=array('a.id', '', 'a.product_name', 'a.subtotal', 'a.order_date', 'c.name', '', 'a.seller_name', '');
        $searchableColumns=array('a.order_id', '', 'a.product_name', 'a.subtotal', 'a.order_date', 'c.name', '', 'a.seller_name', '');
        $this->db->select('a.*, a.product_name, a.group_id, a.cat_name, a.sub_cat_name, a.product_img, c.name as customer_name, c.phone, c.email, a.seller_name');
        $this->db->from('webinatech_customer_order a');
        // $this->db->join('webinatech_product p', 'p.id=a.product_id');
        // $this->db->join("webinatech_category q", "q.id=p.cat_id");
        // $this->db->join("webinatech_sub_category r", "r.id=p.sub_cat_id");
        // $this->db->join("webinatech_brand t", "t.id=p.brand_id", "left");
        // $this->db->join('webinatech_product_media m', 'm.product_id=a.product_id');
        $this->db->join('webinatech_customer c', 'c.id=a.user_id');
        $this->db->join('admin_user s', 's.id=a.seller_id');
        
        $this->db->where(array('a.status'=>$status));
        if($this->session->userdata('admin_role')=="seller"){
            $this->db->where(array('a.seller_id'=>$this->session->userdata('admin_id')));
        }
        if($search!=""){
            if($this->session->userdata('admin_role')=="seller"){
                $this->db->where("(a.order_id LIKE '%$search%' ESCAPE '!' OR a.product_name LIKE '%$search%' ESCAPE '!' OR c.name LIKE '%$search%' ESCAPE '!' OR c.phone LIKE '%$search%' ESCAPE '!' OR c.email LIKE '%$search%' ESCAPE '!')");
            }
            if($this->session->userdata('admin_role')=="superadmin"){
                $this->db->where("(a.order_id LIKE '%$search%' ESCAPE '!' OR a.product_name LIKE '%$search%' ESCAPE '!' OR c.name LIKE '%$search%' ESCAPE '!' OR c.phone LIKE '%$search%' ESCAPE '!' OR c.email LIKE '%$search%' ESCAPE '!' OR a.seller_name LIKE '%$search%' ESCAPE '!')");
            }
        }
        for($i=0; $i<count($filter); $i++){
            if(array_key_exists($filter[$i]['data'], $searchableColumns)){
                $column=$searchableColumns[$filter[$i]['data']];
                $srch=$filter[$i]['search']['value'];
                if(!empty($srch)){
                    $this->db->where("$column LIKE '%$srch%' ESCAPE '!'");
                }
            }
        }
        $data=$this->db->group_by('a.id')->order_by($orderableColumns[$order['column']], $order['dir'])->limit($length, $start)->get()->result();

        // print_r($data);
        // echo $this->db->last_query();
        // die();

        ///record count
        $this->db->select("a.id");
        $this->db->from('webinatech_customer_order a');
        $this->db->join('webinatech_customer c', 'c.id=a.user_id');
        $this->db->where(array('a.status'=>$status));
        if($this->session->userdata('admin_role')=="seller"){
            $this->db->where(array('a.seller_id'=>$this->session->userdata('admin_id')));
        }
        if($search!=""){
            if($this->session->userdata('admin_role')=="seller"){
                $this->db->where("(a.order_id LIKE '%$search%' ESCAPE '!' OR a.product_name LIKE '%$search%' ESCAPE '!' OR c.name LIKE '%$search%' ESCAPE '!' OR c.phone LIKE '%$search%' ESCAPE '!' OR c.email LIKE '%$search%' ESCAPE '!')");
            }
            if($this->session->userdata('admin_role')=="superadmin"){
                $this->db->where("(a.order_id LIKE '%$search%' ESCAPE '!' OR a.product_name LIKE '%$search%' ESCAPE '!' OR c.name LIKE '%$search%' ESCAPE '!' OR c.phone LIKE '%$search%' ESCAPE '!' OR c.email LIKE '%$search%' ESCAPE '!' OR a.seller_name LIKE '%$search%' ESCAPE '!')");
            }
        }
        for($i=0; $i<count($filter); $i++){
            if(array_key_exists($filter[$i]['data'], $searchableColumns)){
                $column=$searchableColumns[$filter[$i]['data']];
                $srch=$filter[$i]['search']['value'];
                if(!empty($srch)){
                    $this->db->where("$column LIKE '%$srch%' ESCAPE '!'");
                }
            }
        }
        $count_rows=$this->db->count_all_results();
        $recordsTotal=$count_rows;
        $recordsFiltered=$count_rows;
        return array('data'=>$data, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=>$recordsFiltered);
    }
    public function order_packaged($order_id){
        if($this->db->select('status')->where('order_id', $order_id)->get('webinatech_customer_order')->row()->status=="hold"){
            return $this->db->where('order_id', $order_id)->update('webinatech_customer_order', array('status'=>'packaged', 'edit_date'=>date('Y-m-d H:i:s')));
        }else{
            return false;
        }
    }
    public function order_pickedup($order_id){
        if($this->db->select('status')->where('order_id', $order_id)->get('webinatech_customer_order')->row()->status=="packaged"){
            return $this->db->where('order_id', $order_id)->update('webinatech_customer_order', array('status'=>'picked', 'edit_date'=>date('Y-m-d H:i:s')));
        }else{
            return false;
        }
    }
    public function order_ready_to_deliver($order_id){
        if($this->db->select('status')->where('order_id', $order_id)->get('webinatech_customer_order')->row()->status=="picked"){
            return $this->db->where('order_id', $order_id)->update('webinatech_customer_order', array('status'=>'ready_order', 'edit_date'=>date('Y-m-d H:i:s')));
        }else{
            return false;
        }
    }
    public function order_out_for_deliver($order_id, $tracking_id){
        if($this->db->select('status')->where('order_id', $order_id)->get('webinatech_customer_order')->row()->status=="ready_order"){
            return $this->db->where('order_id', $order_id)->update('webinatech_customer_order', array('status'=>'out_order', 'tracking_id'=>$tracking_id, 'edit_date'=>date('Y-m-d H:i:s')));
        }else{
            return false;
        }
    }
    public function order_complete_deliver($order_id, $seller_id, $user_id, $qty, $product_id){
        if($this->db->select('status')->where('order_id', $order_id)->get('webinatech_customer_order')->row()->status=="out_order"){
            $this->db->trans_begin();
            $this->db->where('order_id', $order_id)->update('webinatech_customer_order', array('status'=>'completed', 'final_status'=>'delivered', 'edit_date'=>date('Y-m-d H:i:s')));
            $this->db->where('user_id', $user_id)->set('sale_count', 'sale_count + '.$qty, false)->update('webinatech_customer_report');
            $this->db->where('seller_id', $seller_id)->set('sale_count', 'sale_count + '.$qty, false)->update('webinatech_seller_report');
            $this->db->where('product_id', $product_id)->set('sale_count', 'sale_count + '.$qty, false)->update('webinatech_product_report');
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
    public function order_complete_canceled($order_id, $seller_id, $user_id, $qty, $product_id){
        if($this->db->select('status')->where('order_id', $order_id)->get('webinatech_customer_order')->row()->status=="canceled"){
            $this->db->trans_begin();
            $this->db->where('order_id', $order_id)->update('webinatech_customer_order', array('final_status'=>'canceled', 'edit_date'=>date('Y-m-d H:i:s')));
            $this->db->where('product_id', $product_id)->set('stock', 'stock + '.$qty, false)->update('webinatech_stock');
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
    public function order_complete_returned($order_id, $seller_id, $user_id, $qty, $product_id){
        $temp=$this->db->select('final_status, status')->where('order_id', $order_id)->get('webinatech_customer_order')->row();
        if($temp->status=="returned" && $temp->final_status=="delivered"){
            $this->db->trans_begin();
            $this->db->where('order_id', $order_id)->update('webinatech_customer_order', array('final_status'=>'returned', 'edit_date'=>date('Y-m-d H:i:s')));
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
    public function get_order_details($order_id, $user_id){
        $this->db->select('a.ref_id, a.order_id, a.order_date, a.billing_address, a.shipping_address, a.product_id, a.qty, a.price, a.sell_price, a.subtotal, a.seller_id, a.status, a.product_name, a.cat_name, a.sub_cat_name, a.item_name, a.group_id, a.product_img, c.delivery_charge, a.seller_name, s.company_name as seller_company_name, s.company_type as seller_company_type, s.user_state as seller_state, s.user_city as seller_city, s.user_pin as seller_pin, s.user_land_mark as seller_land_mark, s.user_address as seller_address, s.user_gst as seller_gst, p.name, p.name, p.email, p.phone');
        $this->db->where(array('a.user_id'=>$user_id, 'a.order_id'=>$order_id));
        $this->db->from('webinatech_customer_order a');
        $this->db->join('webinatech_customer_order_info c', 'c.ref_id=a.order_id', 'left');
        $this->db->join('webinatech_customer p', 'p.id=a.user_id');
        $this->db->join('admin_user s', 's.id=a.seller_id', 'left');
        $this->db->order_by('a.id', 'desc');
        return $this->db->get()->row();
    }





}
