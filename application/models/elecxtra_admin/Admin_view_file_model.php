<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_view_file_model extends CI_Model{
    public function add_file($add_file_data){
        if($this->db->insert('webina_file', $add_file_data)){
            return true;
        }else{
            return false;
        }
    }
    public function fetch_all_file($show_file, $type){
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $search = trim(strip_tags($this->input->post("search")['value']));
        $this->db->select('a.*');
        $this->db->from('webina_file a');
        if($type=="all"){
            $this->db->where(array('a.status'=>$show_file));
        }else{
            $this->db->where(array('a.type'=>$type, 'a.status'=>$show_file));
        }
        if($search!=""){
            $this->db->where( "(`a`.`name` LIKE '%$search%' ESCAPE '!' OR `a`.`description` LIKE '%$search%' ESCAPE '!')");
        }
        $data = $this->db->order_by('a.id', 'desc')->limit($length, $start)->get()->result();
        //reord count
        $this->db->select('a.id');
        $this->db->from('webina_file a');
        if($type=="all"){
            $this->db->where(array('a.status'=>$show_file));
        }else{
            $this->db->where(array('a.type'=>$type, 'a.status'=>$show_file));
        }
        if($search!=""){
            $this->db->where( "(`a`.`name` LIKE '%$search%' ESCAPE '!' OR `a`.`description` LIKE '%$search%' ESCAPE '!')");
        }
        $count_rows = $this->db->count_all_results();
        $recordsTotal=$count_rows;
        $recordsFiltered=$count_rows;
        return array('data'=>$data, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=>$recordsFiltered);
    }
    public function update_file_fetch($id){
        return $this->db->where('id',$id)->get('webina_file')->row_array();
    }
    public function update_file($id, $update_file_data){
        if($this->db->where('id', $id)->update('webina_file', $update_file_data)){
            return true;
        }else{
            return false;
        }
    }
    public function delete_file($id){
        $temp=$this->db->where('id',$id)->get('webina_file')->row();
        switch ($temp->type) {
            case "doc_file":
                $folder ='./uploads/doc/';
                break;
            case "excel_file":
                $folder ='./uploads/excel/';
                break;
            case "pdf_file":
                $folder ='./uploads/pdf/';
                break;
            case "ppt_file":
                $folder ='./uploads/ppt/';
                break;
        }
        $file=$temp->file;
        if($this->db->where('id',$id)->delete('webina_file') && unlink($folder.$file)){
            exit(json_encode(array('type'=>'success','text'=>'Deleted')));
        }else{
            exit(json_encode(array('type'=>'warning','text'=>'Error..!')));
        }
    }






}
?>