<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_product_family_model extends CI_Model{
    /**************category***************/
    public function fetch_category(){
        return $this->db->select('id, name')->where('status',1)->get('webinatech_category')->result();
    }
    public function add_category($data){
    	return $this->db->insert('webinatech_category', $data);
    }
    /**************sub_category***************/
    public function fetch_sub_category($cat_id){
        return $this->db->select('id, name')->where(array('cat_id'=>$cat_id, 'status'=>1))->get('webinatech_sub_category')->result();
    }
    public function add_sub_category($data){
        return $this->db->insert('webinatech_sub_category', $data);
    }
    /**************item***************/
    public function fetch_item($sub_cat_id){
        return $this->db->select('id, name')->where(array('sub_cat_id'=>$sub_cat_id, 'status'=>1))->get('webinatech_item')->result();
    }
    public function add_item($data){
        return $this->db->insert('webinatech_item', $data);
    }
    public function each_save_data($type, $id, $val){
        $temp_arr=explode("-", $this->db->select('title')->where('id', $id)->get('webinatech_'.$type)->row()->title);
        $title_id=end($temp_arr);
        return $this->db->where('id', $id)->update('webinatech_'.$type, array('name'=>$val, 'title'=>strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', ($val.'-'.$title_id))))));
    }
    public function delete_check($id, $type){
        $array=array('category'=>'cat_id', 'sub_category'=>'sub_cat_id', 'item'=>'item_id', 'brand'=>'brand_id');
        return $this->db->select('id')->where($array[$type], $id)->from('webinatech_product')->count_all_results();
    }
    public function delete_permanently_data($id){
        $seller_id=$this->db->select('create_by')->where('id', $id)->get('webinatech_product')->row()->create_by;
        $temp=$this->db->select('other_img')->where('product_id', $id)->get('webinatech_product_media')->row();
        if(!empty($temp->other_img)){
            $all_media=explode("|", $temp->other_img);
            for ($i=0; $i < count($all_media); $i++) { 
                if(file_exists('./uploads/products/'.$all_media[$i])){
                    unlink('./uploads/products/'.$all_media[$i]);
                }
            }
        }
        $this->db->where('id', $id)->delete('webinatech_product');
        $this->db->where('product_id', $id)->delete('webinatech_stock');
        $this->db->where('product_id', $id)->delete('webinatech_product_media');
        $this->db->where('product_id', $id)->delete('webinatech_product_report');
        $this->db->where('product_id', $id)->delete('webinatech_product_attribute');
        $this->db->where('seller_id', $seller_id)->set('total_product', 'total_product - 1', false)->update('webinatech_seller_report');
    }
    public function delete_parmanent($id, $type){
        if($type=="category"){
            $all_sub_cat_id=$this->db->select('id')->where('cat_id', $id)->get('webinatech_sub_category')->result_array();
            foreach ($all_sub_cat_id as $subcat_key => $subcat_value) {
                $all_item_id=$this->db->select('id')->where('sub_cat_id', $subcat_value['id'])->get('webinatech_item')->result_array();
                foreach ($all_item_id as $item_key => $item_value) {
                    $all_prod_id=$this->db->select('id')->where('item_id', $item_value['id'])->get('webinatech_product')->result_array();
                    foreach ($all_prod_id as $prod_key => $prod_value) {
                        $this->delete_permanently_data($prod_value['id']);
                    }
                    $this->db->where('id', $item_value['id'])->delete('webinatech_item');
                }
                $this->db->where('id', $subcat_value['id'])->delete('webinatech_sub_category');
            }
            return $this->db->where('id', $id)->delete('webinatech_category');
        }
        if($type=="sub_category"){
            $all_item_id=$this->db->select('id')->where('sub_cat_id', $id)->get('webinatech_item')->result_array();
            foreach ($all_item_id as $item_key => $item_value) {
                $all_prod_id=$this->db->select('id')->where('item_id', $item_value['id'])->get('webinatech_product')->result_array();
                foreach ($all_prod_id as $prod_key => $prod_value) {
                    $this->delete_permanently_data($prod_value['id']);
                }
                $this->db->where('id', $item_value['id'])->delete('webinatech_item');
            }
            return $this->db->where('id', $id)->delete('webinatech_sub_category');
        }
        if($type=="item"){
            $all_prod_id=$this->db->select('id')->where('item_id', $id)->get('webinatech_product')->result_array();
            foreach ($all_prod_id as $prod_key => $prod_value) {
                $this->delete_permanently_data($prod_value['id']);
            }
            return $this->db->where('id', $id)->delete('webinatech_item');
        }

    }



}