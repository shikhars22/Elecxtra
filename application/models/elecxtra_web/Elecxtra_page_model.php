<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Elecxtra_page_model extends CI_Model{
    public function visitor_count($ref_id, $ip_address, $view_date){
        if($this->db->select('id')->from('webina_count_visitor')->where(array('ref_id'=>$ref_id, 'ip_address'=>$ip_address))->count_all_results()==0){
            $this->db->insert('webina_count_visitor', array('ref_id'=>$ref_id, 'ip_address'=>$ip_address, 'view_date'=>$view_date));
            $this->db->where('ref_id', $ref_id)->set('total_count', 'total_count + 1', false)->update('webina_total_visitor');
        }
        $total_visitor=$this->db->select('total_count')->where(array('ref_id'=>$ref_id))->get('webina_total_visitor')->row()->total_count;
        return array('type'=>'success', 'total_visitor'=>$total_visitor);
    }
    public function get_page_data($name){
        return $this->db->where('name', $name)->get('webina_page_content')->row()->content;
    }
    public function contact_form_data($contact_data){
        if($this->db->insert('webina_contact', $contact_data)){
            return true;
        }else{
            return false;
        }
    }
    public function career_form_data($career_data){
        if($this->db->insert('webina_career', $career_data)){
            return true;
        }else{
            return false;
        }
    }
    /*************blog*******************/
    public function get_total_blog(){
        $this->db->select('id');
        $this->db->from('webina_blog');
        $this->db->where('status', 'approved');
        return $this->db->count_all_results();
    }
    public function get_blog($start, $length){
        return $this->db->where('status', 'approved')->limit($length, $start)->order_by('id', 'desc')->get('webina_blog')->result();
    }
    public function get_blog_details($id){
        $temp=$this->db->where(array('status'=>'approved', 'id'=>$id))->get('webina_blog');
        if($temp->num_rows()>0){
            return $temp->row();
        }else{
            return "";
        }
    }
    /*************news*******************/
    public function get_total_news(){
        $this->db->select('id');
        $this->db->from('webina_news');
        $this->db->where('status', 'approved');
        return $this->db->count_all_results();
    }
    public function get_news($start, $length){
        return $this->db->where('status', 'approved')->limit($length, $start)->order_by('id', 'desc')->get('webina_news')->result();
    }
    public function get_news_details($id){
        $temp=$this->db->where(array('status'=>'approved', 'id'=>$id))->get('webina_news');
        if($temp->num_rows()>0){
            return $temp->row();
        }else{
            return "";
        }
    }
    /*************event*******************/
    public function get_event($today){
        return $this->db->where(array('status'=>'approved'))->where("start_date >=", $today)->get('webina_event')->result();
    }
    public function get_past_event($today){
        return $this->db->where(array('status'=>'approved'))->where("start_date <", $today)->get('webina_event')->result();
    }
    public function get_event_details($id){
        $temp=$this->db->where(array('status'=>'approved', 'id'=>$id))->get('webina_event');
        if($temp->num_rows()>0){
            return $temp->row();
        }else{
            return "";
        }
    }
    /*************notice*******************/
    public function get_total_notice(){
        $this->db->select('id');
        $this->db->from('webina_notice');
        $this->db->where('status', 'approved');
        return $this->db->count_all_results();
    }
    public function get_notice($start, $length){
        return $this->db->where('status', 'approved')->limit($length, $start)->order_by('id', 'desc')->get('webina_notice')->result();
    }
    public function get_notice_details($id){
        $temp=$this->db->where(array('status'=>'approved', 'id'=>$id))->get('webina_notice');
        if($temp->num_rows()>0){
            return $temp->row();
        }else{
            return "";
        }
    }
    /*************comment*******************/
    public function comment_data($comment_data){
        if($this->db->insert('webina_review', $comment_data)){
            return true;
        }else{
            return false;
        }
    }
    public function get_comments($ref_id){
        return $this->db->where(array('status'=>'approved', 'ref_name'=>explode('_', $ref_id)[0], 'ref_id'=>explode('_', $ref_id)[1]))->get('webina_review')->result();
    }
    /********************team********************/
    public function get_team(){
        return $this->db->get('webina_team')->result();
    }
    
    
}
