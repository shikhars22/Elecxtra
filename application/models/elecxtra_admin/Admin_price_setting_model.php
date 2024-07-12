<?php defined('BASEPATH') OR exit('No direct script access allowed');
class admin_price_setting_model extends CI_Model{
    /************commission****************/
    public function add_commission($data){
        return $this->db->insert('webinatech_price_commission', $data);
    }
    public function commission_status_data($id, $status){
        return $this->db->where("id", $id)->update('webinatech_price_commission', array('status'=>$status));
    }
    public function fetch_all_commission(){
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $search = trim(strip_tags($this->input->post("search")['value']));
        $this->db->select('a.*');
        $this->db->from('webinatech_price_commission a');
        if($search!=""){
            $this->db->where( "(`a`.`title` LIKE '%$search%' ESCAPE '!' OR `a`.`name` LIKE '%$search%' ESCAPE '!' OR `a`.`description` LIKE '%$search%' ESCAPE '!')");
        }
        $data = $this->db->order_by('a.id', 'desc')->limit($length, $start)->get()->result();
        
        //reord count
        $this->db->select('a.id');
        $this->db->from('webinatech_price_commission a');
        if($search!=""){
            $this->db->where( "(`a`.`title` LIKE '%$search%' ESCAPE '!' OR `a`.`name` LIKE '%$search%' ESCAPE '!' OR `a`.`description` LIKE '%$search%' ESCAPE '!')");
        }
        $count_rows = $this->db->count_all_results();
        $recordsTotal=$count_rows;
        $recordsFiltered=$count_rows;
        return array('data'=>$data, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=>$recordsFiltered);
    }
    public function update_commission_fetch($id){
        return $this->db->where('id',$id)->get('webinatech_price_commission')->row_array();
    }
    public function update_commission($id, $data){
        if($this->db->where('id', $id)->update('webinatech_price_commission', $data)){
            return true;
        }else{
            return false;
        }
    }
    public function delete_commission($id){
        if($this->db->where('id',$id)->delete('webinatech_price_commission')){
            exit(json_encode(array('type'=>'success','text'=>'Deleted')));
        }else{
            exit(json_encode(array('type'=>'warning','text'=>'Error..!')));
        }
    }
    
    
    /************subscription****************/
    public function add_subscription($data){
        return $this->db->insert('webina_subscription', $data);
    }
    public function subscription_status_data($id, $status){
        return $this->db->where("id", $id)->update('webina_subscription', array('status'=>$status));
    }
    public function fetch_all_subscription(){
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $search = trim(strip_tags($this->input->post("search")['value']));
        $this->db->select('a.*');
        $this->db->from('webina_subscription a');
        if($search!=""){
            $this->db->where( "(`a`.`plan_name` LIKE '%$search%' ESCAPE '!' OR `a`.`plan_price` LIKE '%$search%' ESCAPE '!' OR `a`.`plan_description` LIKE '%$search%' ESCAPE '!')");
        }
        $data = $this->db->order_by('a.id', 'desc')->limit($length, $start)->get()->result();
        
        //reord count
        $this->db->select('a.id');
        $this->db->from('webina_subscription a');
        if($search!=""){
            $this->db->where( "(`a`.`plan_name` LIKE '%$search%' ESCAPE '!' OR `a`.`plan_price` LIKE '%$search%' ESCAPE '!' OR `a`.`plan_description` LIKE '%$search%' ESCAPE '!')");
        }
        $count_rows = $this->db->count_all_results();
        $recordsTotal=$count_rows;
        $recordsFiltered=$count_rows;
        return array('data'=>$data, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=>$recordsFiltered);
    }
    public function update_subscription_fetch($id){
        return $this->db->where('id',$id)->get('webina_subscription')->row_array();
    }
    public function update_subscription($id, $data){
        if($this->db->where('id', $id)->update('webina_subscription', $data)){
            return true;
        }else{
            return false;
        }
    }
    public function delete_subscription($id){
        if($this->db->where('id',$id)->delete('webina_subscription')){
            exit(json_encode(array('type'=>'success','text'=>'Deleted')));
        }else{
            exit(json_encode(array('type'=>'warning','text'=>'Error..!')));
        }
    }

    






}
?>