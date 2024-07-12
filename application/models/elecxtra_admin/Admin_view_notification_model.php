<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_view_notification_model extends CI_Model{
    public function fetch_all_contact(){
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $search = trim(strip_tags($this->input->post("search")['value']));
        $this->db->select('a.*');
        $this->db->from('webina_contact a');
        if($search!=""){
            $this->db->where( "(`a`.`name` LIKE '%$search%' ESCAPE '!' OR `a`.`message` LIKE '%$search%' ESCAPE '!' OR `a`.`email` LIKE '%$search%' ESCAPE '!' OR `a`.`phone` LIKE '%$search%' ESCAPE '!' OR `a`.`address` LIKE '%$search%' ESCAPE '!')");
        }
        $data = $this->db->limit($length, $start)->get()->result();
        
        //reord count
        $this->db->select('a.id');
        $this->db->from('webina_contact a');
        if($search!=""){
            $this->db->where( "(`a`.`name` LIKE '%$search%' ESCAPE '!' OR `a`.`message` LIKE '%$search%' ESCAPE '!' OR `a`.`email` LIKE '%$search%' ESCAPE '!' OR `a`.`phone` LIKE '%$search%' ESCAPE '!' OR `a`.`address` LIKE '%$search%' ESCAPE '!')");
        }
        $count_rows = $this->db->count_all_results();
        $recordsTotal=$count_rows;
        $recordsFiltered=$count_rows;
        return array('data'=>$data, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=>$recordsFiltered);
    }
    public function delete_contact($id){
        if($this->db->where('id',$id)->delete('webina_contact')){
            exit(json_encode(array('type'=>'success','text'=>'Deleted')));
        }else{
            exit(json_encode(array('type'=>'warning','text'=>'Error..!')));
        }
    }
    public function save_send_email($data){
        if($this->db->insert('webina_email', $data)){
            return true;
        }else{
            return false;
        }
    }
    public function delete_send_email($id){
        if($this->db->where('id',  $id)->delete('webina_email')){
            return array('type'=>'success', 'text'=>'Successfully Deleted');
        }else{
            return array('type'=>'error', 'text'=>'something went wrong!');
        }
    }
    public function fetch_all_email(){
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $search = trim(strip_tags($this->input->post("search")['value']));
        $this->db->select('a.*');
        $this->db->from('webina_email a');
        if($search!=""){
            $this->db->where("(`a`.`email_to` LIKE '%$search%' ESCAPE '!' OR `a`.`email_from` LIKE '%$search%' ESCAPE '!' OR `a`.`email_subject` LIKE '%$search%' ESCAPE '!')");
        }
        $data = $this->db->limit($length, $start)->get()->result();
        
        //reord count
        $this->db->select('a.id');
        $this->db->from('webina_email a');
        if($search!=""){
            $this->db->where("(`a`.`email_to` LIKE '%$search%' ESCAPE '!' OR `a`.`email_from` LIKE '%$search%' ESCAPE '!' OR `a`.`email_subject` LIKE '%$search%' ESCAPE '!')");
        }
        $count_rows = $this->db->count_all_results();
        $recordsTotal=$count_rows;
        $recordsFiltered=$count_rows;
        return array('data'=>$data, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=>$recordsFiltered);
    }
    public function get_saved_email_fetch($id){
        return $this->db->where('id',$id)->get('webina_email')->row_array();
    }






}
