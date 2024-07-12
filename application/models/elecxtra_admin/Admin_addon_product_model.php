<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_addon_product_model extends CI_Model{
	public function fetch_all_addon(){
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $search = trim(strip_tags($this->input->post("search")['value']));
        $this->db->select('a.*');
        $this->db->from('webinatech_product_addon a');
        if($search!=""){
            $this->db->where( "(`a`.`item_id` LIKE '%$search%' ESCAPE '!' OR `a`.`brand_id` LIKE '%$search%' ESCAPE '!' OR `a`.`group_id` LIKE '%$search%' ESCAPE '!')");
        }
        $data = $this->db->limit($length, $start)->get()->result();
        
        //reord count
        $this->db->select('a.id');
        $this->db->from('webinatech_product_addon a');
        if($search!=""){
            $this->db->where( "(`a`.`item_id` LIKE '%$search%' ESCAPE '!' OR `a`.`brand_id` LIKE '%$search%' ESCAPE '!' OR `a`.`group_id` LIKE '%$search%' ESCAPE '!')");
        }
        $count_rows = $this->db->count_all_results();
        $recordsTotal=$count_rows;
        $recordsFiltered=$count_rows;
        return array('data'=>$data, 'recordsTotal'=>$recordsTotal, 'recordsFiltered'=>$recordsFiltered);
    }
	public function fetch_cat(){
		return $this->db->where(array('status'=>1))->get('webinatech_category')->result();
	}
	public function fetch_sub_cat($cat_id){
		return $this->db->select('id,name')->where(array('cat_id'=>$cat_id, 'status'=>1))->get('webinatech_sub_category')->result();
	}
	public function fetch_item($sub_cat_id){
		return $this->db->select('id,name')->where(array('sub_cat_id'=>$sub_cat_id, 'status'=>1))->get('webinatech_item')->result();
	}
	public function fetch_brand($item_id){
		return $this->db->select('id,name')->where(array('item_id'=>$item_id, 'status'=>1))->get('webinatech_brand')->result();
	}
	public function fetch_model_by_item($item_id){
		return $this->db->select('group_id as name')->where(array('item_id'=>$item_id, 'status'=>1))->group_by('group_id')->get('webinatech_product')->result();
	}
	public function fetch_model_by_brand($brand_id){
		return $this->db->select('group_id as name')->where(array('brand_id'=>$brand_id, 'status'=>1))->group_by('group_id')->get('webinatech_product')->result();
	}
	public function fetch_product_by_item($item_id){
		return $this->db->select('a.id, a.title, a.name, a.price, a.sell_price, b.main_img')->from('webinatech_product a')->where(array('item_id'=>$item_id, 'status'=>1))->join('webinatech_product_media b', "b.product_id=a.id")->get()->result();
	}
	public function add_addon_data($addon){
		$temp=$this->db->select('id,addon_product')->where(array('item_id'=>$addon['item_id'], 'brand_id'=>$addon['brand_id'], 'group_id'=>$addon['group_id']))->get('webinatech_product_addon');
		if($temp->num_rows()>0){
			$prevId=$temp->row()->id;
			$addon_product=explode(",", $temp->row()->addon_product);
			$addon_product[]=$addon['addon_product'];
			if($this->db->where('id', $prevId)->update('webinatech_product_addon', array('addon_product'=>implode(",", array_filter(array_unique($addon_product)))))){
				return array(
					'type'=>"success",
					'addon_id'=>$prevId,
				);
			}else{
				return array(
					'type'=>"error",
				); 
			}
		}else{
			if($this->db->insert('webinatech_product_addon', $addon)){
				return array(
					'type'=>"success",
					'addon_id'=>$this->db->insert_id(),
				);
			}else{
				return array(
					'type'=>"error",
				); 
			}
		}
	}
	public function remove_addon_data($id, $prod_id){
		$temp=explode(",", $this->db->where('id', $id)->get('webinatech_product_addon')->row()->addon_product);
		for ($i=0; $i < count($temp); $i++) { 
			if($temp[$i]==$prod_id){
				unset($temp[$i]);
			}
		}
		return $this->db->where('id', $id)->update('webinatech_product_addon', array('addon_product'=>implode(',', array_filter($temp))));
	}
	public function fetch_addon_data($condition){
		$temp=$this->db->where($condition)->get('webinatech_product_addon')->row();
		$arr=explode(",", $temp->addon_product);
		$pro=$this->db->select('a.id, a.title, a.name, a.price, a.sell_price, b.main_img')->from('webinatech_product a')->where_in('a.id', $arr)->join('webinatech_product_media b', "b.product_id=a.id")->get()->result();
		return array('addon_id'=>$temp->id, 'pro'=>$pro);

	}


}