<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_view_blog_event_model extends CI_Model{
    /************BLOG****************/
    public function fetch_all_blog(){
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $search = trim(strip_tags($this->input->post("search")['value']));
        $this->db->select('a.*');
        $this->db->from('webina_blog a');
        if($search!=""){
            $this->db->where( "(`a`.`name` LIKE '%$search%' ESCAPE '!' OR `a`.`description` LIKE '%$search%' ESCAPE '!')");
        }
        $data = $this->db->limit($length, $start)->order_by('id', 'desc')->get()->result();
        
        //reord count
        $this->db->select('a.id');
        $this->db->from('webina_blog a');
        if($search!=""){
            $this->db->where( "(`a`.`name` LIKE '%$search%' ESCAPE '!' OR `a`.`description` LIKE '%$search%' ESCAPE '!')");
        }
        $count_rows = $this->db->count_all_results();
        $recordsTotal=$count_rows;
        $recordsFiltered=$count_rows;
        return array('data'=>$data, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=>$recordsFiltered);
    }
    public function add_blog($add_media_data){
        return $this->db->insert('webina_blog', $add_media_data);
    }
    public function update_blog_fetch($id){
        return $this->db->where('id',$id)->get('webina_blog')->row_array();
    }
    public function update_blog($id, $data){
        if (array_key_exists("img", $data)){
            $folder ='./uploads/media/blog/';
            $img=$this->db->select('img')->where('id', $id)->get('webina_blog')->row()->img;
            if(file_exists($folder.$img)){
                unlink($folder.$img);
            }
        }
        return $this->db->where('id', $id)->update('webina_blog', $data);
    }
    public function approved_blog($id){
        if($this->db->where('id',$id)->update('webina_blog',array('status'=>'approved'))){
            exit(json_encode(array('type'=>'success','text'=>'Approved')));
        }else{
            exit(json_encode(array('type'=>'warning','text'=>'Error..!')));
        }
    }
    public function not_approved_blog($id){
        if($this->db->where('id',$id)->update('webina_blog',array('status'=>'hold'))){
            exit(json_encode(array('type'=>'success','text'=>'Approved')));
        }else{
            exit(json_encode(array('type'=>'warning','text'=>'Error..!')));
        }
    }
    public function delete_blog($id){
        if($this->db->where('id',$id)->delete('webina_blog')){
            exit(json_encode(array('type'=>'success','text'=>'Deleted')));
        }else{
            exit(json_encode(array('type'=>'warning','text'=>'Error..!')));
        }
    }




}
