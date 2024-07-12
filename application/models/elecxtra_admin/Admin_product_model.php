<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_product_model extends CI_Model{
	public function fetch_all_product($approve, $reject, $trash, $start, $length, $search, $order, $filter){
		$orderableColumns=array('a.id', '', 'a.name', 'a.manufacturer', 'f.stock', 'a.price', 'a.create_date', 'a.update_date', 's.user_name', '', '');
		$searchableColumns=array('a.id', '', 'a.name', 'a.manufacturer', 'f.stock', 'a.price', 'a.create_date', 'a.update_date', 's.user_name', '', '');
		$this->db->select('a.*, b.name as cat_name, c.name as sub_cat_name, d.main_img, d.attachment, i.name as item_name, f.stock, s.user_name, s.user_phone, s.user_email, s.company_name');
        $this->db->from("webinatech_product a");
        $this->db->join("webinatech_category b", "b.id=a.cat_id");
        $this->db->join("webinatech_sub_category c", "c.id=a.sub_cat_id");
        $this->db->join("webinatech_item i", "i.id=a.item_id");
        $this->db->join("webinatech_product_media d", "d.product_id=a.id", "left");
        $this->db->join("webinatech_stock f", "f.product_id=a.id");
        $this->db->join("admin_user s", "s.id=a.create_by");
        if($this->session->userdata('admin_role')=="seller"){
        	$this->db->where(array('a.create_by'=>$this->session->userdata('admin_id')));
        	$this->db->where_in('a.trash', explode(',', $trash));
        	$this->db->where_in('a.reject', explode(',', $reject));
        	$this->db->where_in('a.approve', explode(',', $approve));
        }
        if($this->session->userdata('admin_role')=="superadmin"){
    		$this->db->where_in('a.trash', explode(',', $trash));
        	$this->db->where_in('a.reject', explode(',', $reject));
        	$this->db->where_in('a.approve', explode(',', $approve));
        }
        if($search!=""){
        	if($this->session->userdata('admin_role')=="seller"){
            	$this->db->where("(a.id LIKE '%$search%' ESCAPE '!' OR a.name LIKE '%$search%' ESCAPE '!' OR a.manufacturer LIKE '%$search%' ESCAPE '!' OR b.name LIKE '%$search%' ESCAPE '!' OR c.name LIKE '%$search%' ESCAPE '!' OR i.name LIKE '%$search%' ESCAPE '!')");
	        }
	        if($this->session->userdata('admin_role')=="admin"){
            	$this->db->where("(a.id LIKE '%$search%' ESCAPE '!' OR a.name LIKE '%$search%' ESCAPE '!' OR a.manufacturer LIKE '%$search%' ESCAPE '!' OR b.name LIKE '%$search%' ESCAPE '!' OR c.name LIKE '%$search%' ESCAPE '!' OR i.name LIKE '%$search%' ESCAPE '!' OR s.user_name LIKE '%$search%' ESCAPE '!' OR s.user_phone LIKE '%$search%' ESCAPE '!' OR s.user_email LIKE '%$search%' ESCAPE '!' OR s.company_name LIKE '%$search%' ESCAPE '!')");
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

        // echo $this->db->last_query();
        // die();

        //record count
        $this->db->select("a.id");
        $this->db->from("webinatech_product a");
        $this->db->join("webinatech_category b", "b.id=a.cat_id");
        $this->db->join("webinatech_sub_category c", "c.id=a.sub_cat_id");
        $this->db->join("webinatech_item i", "i.id=a.item_id");
        $this->db->join("admin_user s", "s.id=a.create_by");
        if($this->session->userdata('admin_role')=="seller"){
        	$this->db->where(array('a.create_by'=>$this->session->userdata('admin_id')));
        	$this->db->where_in('a.trash', explode(',', $trash));
        	$this->db->where_in('a.reject', explode(',', $reject));
        	$this->db->where_in('a.approve', explode(',', $approve));
        }
        if($this->session->userdata('admin_role')=="superadmin"){
    		$this->db->where_in('a.trash', explode(',', $trash));
        	$this->db->where_in('a.reject', explode(',', $reject));
        	$this->db->where_in('a.approve', explode(',', $approve));
        }
        if($search!=""){
        	if($this->session->userdata('admin_role')=="seller"){
            	$this->db->where("(a.id LIKE '%$search%' ESCAPE '!' OR a.name LIKE '%$search%' ESCAPE '!' OR a.manufacturer LIKE '%$search%' ESCAPE '!' OR b.name LIKE '%$search%' ESCAPE '!' OR c.name LIKE '%$search%' ESCAPE '!' OR i.name LIKE '%$search%' ESCAPE '!')");
	        }
	        if($this->session->userdata('admin_role')=="admin"){
            	$this->db->where("(a.id LIKE '%$search%' ESCAPE '!' OR a.name LIKE '%$search%' ESCAPE '!' OR a.manufacturer LIKE '%$search%' ESCAPE '!' OR b.name LIKE '%$search%' ESCAPE '!' OR c.name LIKE '%$search%' ESCAPE '!' OR i.name LIKE '%$search%' ESCAPE '!' OR s.user_name LIKE '%$search%' ESCAPE '!' OR s.user_phone LIKE '%$search%' ESCAPE '!' OR s.user_email LIKE '%$search%' ESCAPE '!' OR s.company_name LIKE '%$search%' ESCAPE '!')");
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
	public function seller_report_data($table, $field, $what, $seller_id=0){
		if(empty($seller_id)){
			$seller_id=$this->session->userdata('admin_id');
		}
		$this->db->where('seller_id', $seller_id)->set($field, $what, false)->update($table);
	}
	public function update_stock($id, $stock){
		return $this->db->where("product_id", $id)->update('webinatech_stock', array('stock'=>$stock));
	}
	public function status_data($id, $status){
		return $this->db->where("id", $id)->update('webinatech_product', array('status'=>$status));
	}
	public function feature_data($id, $feature){
		return $this->db->where("id", $id)->update('webinatech_product', array('feature'=>$feature));
	}
	public function deal_data($id, $deal){
		return $this->db->where("id", $id)->update('webinatech_product', array('deal'=>$deal));
	}
	public function delete_data($id){
		$temp=$this->db->select('status,approve,reject,trash')->where('id', $id)->get('webinatech_product')->row();
		if($temp->approve==1 && $temp->reject==0){
			$this->seller_report_data('webinatech_seller_report', 'total_product', 'total_product - 1');
		}
		if($temp->approve==0 && $temp->reject==0){
			$this->seller_report_data('webinatech_seller_report', 'pending_product', 'pending_product - 1');
		}
		return $this->db->where("id", $id)->update('webinatech_product', array('trash'=>1));
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
		$this->db->where('id', $id)->delete('webinatech_product');
		$this->db->where('product_id', $id)->delete('webinatech_stock');
		$this->db->where('product_id', $id)->delete('webinatech_product_media');
		$this->db->where('product_id', $id)->delete('webinatech_product_report');
		$this->db->where('product_id', $id)->delete('webinatech_product_attribute');
		$this->seller_report_data('webinatech_seller_report', 'total_product', 'total_product - 1');
		if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            return true;
        }
	}
	public function restore_data($id){
		$temp=$this->db->select('status,approve,reject,trash')->where('id', $id)->get('webinatech_product')->row();
		if($temp->approve==1 && $temp->reject==0){
			$this->seller_report_data('webinatech_seller_report', 'total_product', 'total_product + 1');
		}
		if($temp->approve==0 && $temp->reject==0){
			$this->seller_report_data('webinatech_seller_report', 'pending_product', 'pending_product + 1');
		}
		return $this->db->where("id", $id)->update('webinatech_product', array('trash'=>0));
	}
	public function approve_data($seller_id, $id){
		$this->seller_report_data('webinatech_seller_report', 'total_product', 'total_product + 1', $seller_id);
		$this->seller_report_data('webinatech_seller_report', 'pending_product', 'pending_product - 1', $seller_id);
		return $this->db->where("id", $id)->update('webinatech_product', array('approve'=>1, 'reject'=>0, 'reject_note'=>''));
	}
	public function reject_data($seller_id, $id, $reject_note){
		$this->seller_report_data('webinatech_seller_report', 'pending_product', 'pending_product - 1', $seller_id);
		return $this->db->where("id", $id)->update('webinatech_product', array('reject'=>1, 'reject_note'=>$reject_note));
	}
	public function get_prod_data($id){
		return $this->db->where(array('id'=>$id, 'create_by'=>$this->session->userdata('admin_id')))->get('webinatech_product')->row();
	}
    public function fetch_product_details($id, $item_id, $group_id){
		$this->db->select('a.*, b.name as cat_name, c.name as sub_cat_name, i.name as item_name, d.main_img, d.attachment, d.other_img, f.stock');
		$this->db->from('webinatech_product a');
		$this->db->join("webinatech_category b", "b.id=a.cat_id");
        $this->db->join("webinatech_sub_category c", "c.id=a.sub_cat_id");
        $this->db->join("webinatech_item i", "i.id=a.item_id");
		$this->db->join("webinatech_product_media d", "d.product_id=a.id", "left");
        $this->db->join("webinatech_stock f", "f.product_id=a.id");
		$this->db->where(array('a.id'=>$id, 'a.create_by'=>$this->session->userdata('admin_id')));
		$product_details=$this->db->get()->row();
		return array('type'=>'success', 'product_details'=>$product_details);
	}
    public function fetch_only_product_details($id){
		$this->db->select('a.*, d.main_img, d.attachment, d.other_img, f.stock');
		$this->db->from('webinatech_product a');
		$this->db->join("webinatech_product_media d", "d.product_id=a.id", "left");
        $this->db->join("webinatech_stock f", "f.product_id=a.id");
		$this->db->where(array('a.id'=>$id, 'a.create_by'=>$this->session->userdata('admin_id')));
		$product_details=$this->db->get()->row();
		return array('type'=>'success', 'product_details'=>$product_details);
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
	public function fetch_model_by_item($item_id){
		return $this->db->select('group_id as name')->where(array('item_id'=>$item_id, 'status'=>1))->group_by('group_id')->get('webinatech_product')->result();
	}
	public function add_product_data($main_id, $product, $stock, $media, $attr_name, $attr_value){
		$this->db->trans_begin();
		$this->db->insert('webinatech_product', $product);
		$product_id=$this->db->insert_id();
		$stock['product_id']=$product_id;
		$media['product_id']=$product_id;
	    if(!empty($attr_name)){
	    	$pro_attr=array();
			foreach ($attr_name as $key => $value){
				if(!empty($value) && !empty($attr_value[$key])){
		            $pro_attr[]=array(
		                'product_id'=>$product_id,
		                'attr_name'=>$value,
		                'attr_value'=>$attr_value[$key],
		            );
		        }
	        }
	        if(!empty($pro_attr)){
				$this->db->insert_batch('webinatech_product_attribute', $pro_attr);
	        }
	    }
		$this->db->insert('webinatech_stock', $stock);
		$this->db->insert('webinatech_product_media', $media);
		$this->db->insert('webina_total_visitor', array('ref_id'=>$product_id));
		$this->db->insert('webinatech_product_report', array('product_id'=>$product_id));
		$this->seller_report_data('webinatech_seller_report', 'pending_product', 'pending_product + 1');
		if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            if(empty($main_id)){
            	return $product_id;
            }else{
            	return $main_id;
            }
        }
	}
	public function update_product_data($id, $product, $stock, $attr_name, $attr_value){
		$this->db->trans_begin();
		$temp=$this->db->select('status,approve,reject,trash')->where('id', $id)->get('webinatech_product')->row();
		if($temp->approve==1){
			$this->seller_report_data('webinatech_seller_report', 'total_product', 'total_product - 1');
			$this->seller_report_data('webinatech_seller_report', 'pending_product', 'pending_product + 1');
		}
		if($temp->reject==1){
			$this->seller_report_data('webinatech_seller_report', 'pending_product', 'pending_product + 1');
		}
		$this->db->where("id", $id)->update('webinatech_product', $product);
	    if(!empty($attr_name)){
			foreach ($attr_name as $key => $value) {
				if(!empty($value) && !empty($attr_value[$key])){
		            if($this->db->select('id')->from('webinatech_product_attribute')->where(array("product_id"=>$id, "attr_name"=>$value))->count_all_results()>0){
						$this->db->where(array("product_id"=>$id, "attr_name"=>$value))->update('webinatech_product_attribute', array('attr_value'=>$attr_value[$key]));
					}else{
						$this->db->insert('webinatech_product_attribute', array('product_id'=>$id, 'attr_name'=>$value, 'attr_value'=>$attr_value[$key]));
					}
		        }
	        }
	    }
		$this->db->where("product_id", $id)->update('webinatech_stock', $stock);

		if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            return true;
        }

	}
	public function get_imgs($id){
        return $this->db->select('main_img, other_img')->where("product_id", $id)->get("webinatech_product_media")->row();
    }
    public function update_product_img($id, $media){
    	return $this->db->where('product_id',  $id)->update('webinatech_product_media', $media);
    }
	public function fetch_product_attr($id, $item_id, $group_id){
		return $this->db->where('product_id', $id)->get('webinatech_product_attribute')->result();
	}
	public function delete_product_attr($attr_id){
		return $this->db->where('id', $attr_id)->delete('webinatech_product_attribute');
	}
	public function delete_attachment($pro_id, $attach){
		$temp=$this->db->select('attachment')->where('product_id', $pro_id)->get('webinatech_product_media')->row();
		$all_attch=explode("|", $temp->attachment);
		if(file_exists('./uploads/products/attachments/'.$all_attch[$attach])){
			unlink('./uploads/products/attachments/'.$all_attch[$attach]);
			unset($all_attch[$attach]);
			return $this->db->where('product_id', $pro_id)->update('webinatech_product_media', array('attachment'=>implode("|", $all_attch)));
		}
	}



}