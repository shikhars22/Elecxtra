<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Cart_model extends CI_Model{
	public function get_user_details($id){
		$this->db->select('a.*, GROUP_CONCAT(b.type SEPARATOR "||") as types, GROUP_CONCAT(b.pin SEPARATOR "||") as pins, GROUP_CONCAT(b.city SEPARATOR "||") as cities, GROUP_CONCAT(b.land_mark SEPARATOR "||") as land_marks, GROUP_CONCAT(b.address SEPARATOR "||") as addresses, GROUP_CONCAT(b.state SEPARATOR "||") as states');
		$this->db->from("webinatech_customer a");
		$this->db->where('a.id', $id);
		$this->db->join("webinatech_customer_address b", "b.user_id=a.id");
		return $this->db->get()->row();
	}
	public function get_cart_product_price($all_product_id){
		$this->db->select('a.id, a.name, a.title, a.price, a.sell_price, a.create_by, f.stock');
        $this->db->from("webinatech_product a");
        $this->db->where('a.status', 1);
        $this->db->where_in('a.id', array_unique($all_product_id));
        $this->db->join("webinatech_stock f", "f.product_id=a.id");
        $data=$this->db->get()->result();
        return $data;
	}
	public function get_cart_product_min_details($all_product_id){
		$this->db->select('a.id, a.title, a.name, a.group_id, a.price, a.sell_price, a.return_day, a.create_by, b.name as cat_name, c.name as sub_cat_name, d.main_img, i.name as item_name, s.user_name as seller_name');
        $this->db->from("webinatech_product a");
        $this->db->where_in('a.id', array_unique($all_product_id));
        $this->db->join("webinatech_category b", "b.id=a.cat_id");
        $this->db->join("webinatech_sub_category c", "c.id=a.sub_cat_id");
        $this->db->join("webinatech_item i", "i.id=a.item_id");
        $this->db->join("webinatech_product_media d", "d.product_id=a.id");
        $this->db->join("admin_user s", "s.id=a.create_by");
        $data=$this->db->group_by('a.id')->get()->result();
		
		// echo "<pre>";
		// print_r($data);
		// die();
		
		return $data;
	}
	public function get_cart_product_details($all_product_id){
		$this->db->select('a.id, a.cat_id, a.sub_cat_id, a.item_id, a.group_id, a.title, a.name, a.description, a.price, a.sell_price, b.name as cat_name, c.name as sub_cat_name, d.main_img, d.other_img, f.stock, i.name as item_name');
        $this->db->from("webinatech_product a");
        $this->db->where_in('a.id', array_unique($all_product_id));
        $this->db->join("webinatech_category b", "b.id=a.cat_id");
        $this->db->join("webinatech_sub_category c", "c.id=a.sub_cat_id");
        $this->db->join("webinatech_item i", "i.id=a.item_id");
        $this->db->join("webinatech_product_media d", "d.product_id=a.id");
        $this->db->join("webinatech_stock f", "f.product_id=a.id");
        $data=$this->db->group_by('a.id')->get()->result_array();
		
		// echo "<pre>";
		// print_r($data);
		// die();
		
		return $data;
	}
    public function submit_checkout_pincode($cart_data, $search_pin){
        if(!empty($search_pin)){
            $total_del_charge=0; $over_total=1000; $del_charge=40; $hygienic_charge=0; $total_price=0;
            if(!empty($cart_data)){
                $price_commission=json_decode(price_commission());
                $all_product_id=array_column($cart_data, 'product_id');
                $all_product_qty=array_column($cart_data, 'qty', 'product_id');
                $product_price=$this->get_cart_product_price($all_product_id);
                foreach ($product_price as $key => $value){
                    $finalPrice=0;
                    foreach ($price_commission as $k => $v){
                        if($value->price<=$v->max_price){
                            $other_charge=2;
                            $comms=$v->commission;
                            $webViewPrice=$value->price+($value->price*$v->commission/100);
                            $finalPrice=number_format((float)($webViewPrice+($webViewPrice*$other_charge/100)), 2, '.', '');
                            break;
                        }
                    }
                    if($over_total>($finalPrice*$all_product_qty[$value->id])){
                        $total_del_charge+=$del_charge;
                        $total_price+=($finalPrice*$all_product_qty[$value->id])+$del_charge;
                    }else{
                        $total_price+=($finalPrice*$all_product_qty[$value->id]);
                    }
                }
            }
            return array('type'=>'success', 'text'=>'<span class="text-success fs_11 ml-auto"> (Delivery available!)</span>', 'del_charge'=>number_format((float)($total_del_charge), 2, '.', ''), 'hygienic_charge'=>number_format((float)($hygienic_charge), 2, '.', ''), 'total'=>number_format((float)($total_price+$hygienic_charge), 2, '.', ''));
        }
    }
    public function checkout_pincode($search_pin){
        if(!empty($search_pin)){
            $over_total=1000; $del_charge=40; $hygienic_charge=0;
            return array('type'=>'success', 'over_total'=>$over_total, 'del_charge'=>number_format((float)($del_charge), 2, '.', ''), 'hygienic_charge'=>number_format((float)($hygienic_charge), 2, '.', ''));
        }
    }
    public function place_order($order_data, $order_info){
    	$this->db->trans_begin();
    	$this->db->insert_batch('webinatech_customer_order',$order_data);
    	$this->db->insert_batch('webinatech_customer_order_info',$order_info);
    	/****start report***/
    	$count=0;
    	foreach($order_data as $key => $value){
    		$count++;
    		$this->db->where('seller_id', $value['seller_id'])->set('order_count', 'order_count + 1', false)->update('webinatech_seller_report');
    		$this->db->where('product_id', $value['product_id'])->set('order_count', 'order_count + 1', false)->update('webinatech_product_report');
    		$this->db->where('product_id', $value['product_id'])->set('stock', 'stock - '.$value['qty'], false)->update('webinatech_stock');
        }
		$this->db->where('user_id', $this->session->userdata('user_id'))->set('order_count', 'order_count + '.$count, false)->update('webinatech_customer_report');

    	/****end report***/
    	if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            return true;
        }
    }


}
