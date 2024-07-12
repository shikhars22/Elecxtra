<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_seller_model extends CI_Model{
    public function fetch_all_seller($status, $start, $length, $search, $order, $filter){
        $orderableColumns=array('a.id', 'a.user_code', 'a.user_name', 'a.user_phone',  '', '', '', '', 'a.create_date', '');
        $searchableColumns=array('a.id', 'a.user_code', 'a.user_name', 'a.user_phone', '', '', '',  '', 'a.create_date', '');
        $this->db->select('a.*, s.total_product, s.order_count, s.cancel_count, s.return_count, s.sale_count, s.total_revenue');
        $this->db->from("admin_user a");
        $this->db->join("webinatech_seller_report s", "s.seller_id=a.id");
        $this->db->where(array('a.status'=>$status));
        if($search!=""){
            $this->db->where("(a.id LIKE '%$search%' ESCAPE '!' OR a.user_code LIKE '%$search%' ESCAPE '!' OR a.user_name LIKE '%$search%' ESCAPE '!' OR a.user_email LIKE '%$search%' ESCAPE '!' OR a.user_phone LIKE '%$search%' ESCAPE '!')");
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

        // echo $this->db->last_query();
        // die();

        //record count
        $this->db->select("a.id");
        $this->db->from("admin_user a");
        $this->db->join("webinatech_seller_report s", "s.seller_id=a.id");
        $this->db->where(array('a.status'=>$status));
        if($search!=""){
            $this->db->where("(a.id LIKE '%$search%' ESCAPE '!' OR a.user_code LIKE '%$search%' ESCAPE '!' OR a.user_name LIKE '%$search%' ESCAPE '!' OR a.user_email LIKE '%$search%' ESCAPE '!' OR a.user_phone LIKE '%$search%' ESCAPE '!')");
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
    public function delete_permanently_data($id){
        $temp=$this->db->select('other_img')->where('product_id', $id)->get('webinatech_product_media')->row();
        if(!empty($temp->other_img)){
            $all_media=explode("|", $temp->other_img);
            for ($i=0; $i < count($all_media); $i++) { 
                if(file_exists('./uploads/products/'.$all_media[$i])){
                    unlink('./uploads/products/'.$all_media[$i]);
                }
            }
        }
        $this->db->trans_begin();
        $this->db->where('id', $id)->delete('admin_user');
        $this->db->where('seller_id', $id)->delete('webinatech_seller_report');

        /***start product delete****/
        $check_all_pro=$this->db->select('id')->where_in('create_by', $id)->get('webinatech_product')->result();
        if(!empty($check_all_pro)){
            $all_product_id=array_column($check_all_pro, 'id');
            $temp=$this->db->select('other_img')->where_in('product_id', $all_product_id)->get('webinatech_product_media')->result();
            foreach ($temp as $key => $value){
                if(!empty($value->other_img)){
                    $all_media=explode("|", $value->other_img);
                    for ($i=0; $i < count($all_media); $i++) { 
                        if(file_exists('./uploads/products/'.$all_media[$i])){
                            unlink('./uploads/products/'.$all_media[$i]);
                        }
                    }
                }
            }
            $this->db->where_in('id', $all_product_id)->delete('webinatech_product');
            $this->db->where_in('product_id', $all_product_id)->delete('webinatech_stock');
            $this->db->where_in('product_id', $all_product_id)->delete('webinatech_product_media');
            $this->db->where_in('product_id', $all_product_id)->delete('webinatech_product_report');
            $this->db->where_in('product_id', $all_product_id)->delete('webinatech_product_attribute');
        }
        /****end product delete***/

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            return true;
        }
    }
    public function approve_data($id){
        $temp=$this->db->select('user_name, user_phone, user_email')->where('id', $id)->get('admin_user')->row();
        if($this->db->where("id", $id)->update('admin_user', array('status'=>'approved', 'reject_note'=>''))){
            return array('type'=>'success', 'user_name'=>$temp->user_name, 'user_phone'=>$temp->user_phone, 'user_email'=>$temp->user_email);
        }
    }
    public function reject_data($id, $reject_note){
        $temp=$this->db->select('user_name, user_phone, user_email')->where('id', $id)->get('admin_user')->row();
        if($this->db->where("id", $id)->update('admin_user', array('status'=>'rejected', 'reject_note'=>$reject_note))){
            return array('type'=>'success', 'user_name'=>$temp->user_name, 'user_phone'=>$temp->user_phone, 'user_email'=>$temp->user_email);
        }
    }




}
