<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_view_media_model extends CI_Model{
    /************banner****************/
    public function add_banner($data){
        return $this->db->insert('webina_banner', $data);
    }
    public function banner_status_data($id, $status){
        return $this->db->where("id", $id)->update('webina_banner', array('status'=>$status));
    }
    public function fetch_all_banner(){
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $search = trim(strip_tags($this->input->post("search")['value']));
        $this->db->select('a.*');
        $this->db->from('webina_banner a');
        if($search!=""){
            $this->db->where( "(`a`.`title` LIKE '%$search%' ESCAPE '!' OR `a`.`name` LIKE '%$search%' ESCAPE '!' OR `a`.`description` LIKE '%$search%' ESCAPE '!' OR `a`.`page` LIKE '%$search%' ESCAPE '!')");
        }
        $data = $this->db->order_by('a.id', 'desc')->limit($length, $start)->get()->result();
        
        //reord count
        $this->db->select('a.id');
        $this->db->from('webina_banner a');
        if($search!=""){
            $this->db->where( "(`a`.`title` LIKE '%$search%' ESCAPE '!' OR `a`.`name` LIKE '%$search%' ESCAPE '!' OR `a`.`description` LIKE '%$search%' ESCAPE '!' OR `a`.`page` LIKE '%$search%' ESCAPE '!')");
        }
        $count_rows = $this->db->count_all_results();
        $recordsTotal=$count_rows;
        $recordsFiltered=$count_rows;
        return array('data'=>$data, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=>$recordsFiltered);
    }
    public function update_banner_fetch($id){
        return $this->db->where('id',$id)->get('webina_banner')->row_array();
    }
    public function update_banner($id, $data){
        $temp_media=$this->db->select('img,vdo')->where('id', $id)->get('webina_banner')->row();
        if(array_key_exists('img', $data)){
            if(!empty($temp_media->img)){
                if(file_exists('./uploads/media/'.$temp_media->img)){
                    unlink('./uploads/media/'.$temp_media->img);
                }
            }
        }
        if($temp_media->vdo!=$data['vdo']){
            if(!empty($temp_media->vdo)){
                if(file_exists('./uploads/uploader/'.$temp_media->vdo)){
                    unlink('./uploads/uploader/'.$temp_media->vdo);
                }
            }
        }
        if($this->db->where('id', $id)->update('webina_banner', $data)){
            return true;
        }else{
            return false;
        }
    }
    public function delete_banner($id){
        $temp_media=$this->db->select('img,vdo')->where('id', $id)->get('webina_banner')->row();
        if(!empty($temp_media)){
            if(!empty($temp_media->img)){
                if(file_exists('./uploads/media/'.$temp_media->img)){
                    unlink('./uploads/media/'.$temp_media->img);
                }
            }
            if(!empty($temp_media->vdo)){
                if(file_exists('./uploads/uploader/'.$temp_media->vdo)){
                    unlink('./uploads/uploader/'.$temp_media->vdo);
                }
            }
        }

        if($this->db->where('id',$id)->delete('webina_banner')){
            exit(json_encode(array('type'=>'success','text'=>'Deleted')));
        }else{
            exit(json_encode(array('type'=>'warning','text'=>'Error..!')));
        }
    }

    






}
?>