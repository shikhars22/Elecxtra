<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Product_model extends CI_Model{
    public function get_catsubcatitem_details($slug_arr){
        return $this->db->select('a.id as item_id, a.name as item_name, a.sub_cat_id, b.name as sub_cat_name, b.cat_id, c.name as cat_name')->from('webinatech_item a')->join('webinatech_sub_category b', 'b.id=a.sub_cat_id')->join('webinatech_category c', 'c.id=b.cat_id')->where('a.title', $slug_arr[3])->get()->row();
    }
    public function fetch_product($slug_arr, $start, $length){
        $this->db->select('a.id, a.cat_id, a.sub_cat_id, a.item_id, a.group_id, a.title, a.name, a.description, a.price, a.sell_price, a.manufacturer, a.manufacturer_pro_num, a.manufacturer_lead_time, a.create_by, b.name as cat_name, c.name as sub_cat_name, d.main_img, d.other_img, d.attachment, f.stock, i.name as item_name, GROUP_CONCAT(atr.attr_name SEPARATOR "||") as attr_names, GROUP_CONCAT(atr.attr_value SEPARATOR "||") as attr_values');
        $this->db->where(array('a.status'=>1, 'a.approve'=>1, 'a.trash'=>0));
        $this->db->where('c.title', $slug_arr[2]);
        $this->db->where('i.title', $slug_arr[3]);
        $this->db->from("webinatech_product a");
        $this->db->join("webinatech_category b", "b.id=a.cat_id");
        $this->db->join("webinatech_sub_category c", "c.id=a.sub_cat_id");
        $this->db->join("webinatech_item i", "i.id=a.item_id");
        $this->db->join("webinatech_product_media d", "d.product_id=a.id");
        $this->db->join("webinatech_stock f", "f.product_id=a.id", "left");
        $this->db->join("webinatech_product_attribute atr", "atr.product_id=a.id", "left");
        $product_data=$this->db->group_by('a.id')->order_by('a.id', 'desc')->limit($length, $start)->get()->result();
        // echo "<pre>".$this->db->last_query();
        // print_r($product_data);
        // die();
        return $product_data;
    }
    public function load_siblings_item($cat_id, $sub_cat_id, $item_id){
        $all_other_item=$this->db->select('id')->where('sub_cat_id', $sub_cat_id)->where('id != ', $item_id)->get('webinatech_item')->result();
        $all_other_item_id = array_column($all_other_item, 'id');
        // print_r($all_other_item);
        // die();
        if(!empty($all_other_item_id)){
            $this->db->select('d.main_img, b.title as cat_title, c.title as sub_cat_title, i.name as item_name');
            $this->db->from('webinatech_product a');
            $this->db->join("webinatech_category b", "b.id=a.cat_id");
            $this->db->join("webinatech_sub_category c", "c.id=a.sub_cat_id");
            $this->db->join("webinatech_item i", "i.id=a.item_id");
            $this->db->join("webinatech_product_media d", "d.product_id=a.id");
            $this->db->where(array('a.status'=>1, 'a.approve'=>1, 'a.trash'=>0));
            $this->db->where_in('a.item_id', $all_other_item_id);
            $product_data=$this->db->group_by('a.item_id')->order_by('a.id', 'desc')->get()->result();
            // echo "<pre>".$this->db->last_query();
            // print_r($product_data);
            // die();
            return $product_data;
        }
    }
    public function load_siblings_subcategory(){
        $all_other_subcat=$this->db->select('id')->get('webinatech_sub_category')->result();
        $all_other_subcat_id = array_column($all_other_subcat, 'id');
        // print_r($all_other_subcat);
        // die();
        $this->db->select('d.main_img, b.title as cat_title, c.name as sub_cat_name, c.title as sub_cat_title, i.title as item_title');
        $this->db->from('webinatech_product a');
        $this->db->join("webinatech_category b", "b.id=a.cat_id");
        $this->db->join("webinatech_sub_category c", "c.id=a.sub_cat_id");
        $this->db->join("webinatech_item i", "i.id=a.item_id");
        $this->db->join("webinatech_product_media d", "d.product_id=a.id");
        $this->db->where(array('a.status'=>1, 'a.approve'=>1, 'a.trash'=>0));
        $this->db->where_in('a.sub_cat_id', $all_other_subcat_id);
        $product_data=$this->db->group_by('a.sub_cat_id')->order_by('a.id', 'desc')->get()->result();
        // echo "<pre>".$this->db->last_query();
        // print_r($product_data);
        // die();
        return $product_data;
    }
    public function load_selected_products($type, $start, $length){
        $this->db->select('a.id, a.cat_id, a.sub_cat_id, a.item_id, a.group_id, a.title, a.name, a.description, a.price, a.sell_price, a.manufacturer, a.manufacturer_pro_num, a.manufacturer_lead_time, a.create_by, b.name as cat_name, c.name as sub_cat_name, d.main_img, d.other_img, d.attachment, f.stock, i.name as item_name, GROUP_CONCAT(atr.attr_name SEPARATOR "||") as attr_names, GROUP_CONCAT(atr.attr_value SEPARATOR "||") as attr_values');
        $this->db->where(array('a.status'=>1, 'a.approve'=>1, 'a.trash'=>0, 'a.'.$type=>1));
        $this->db->from("webinatech_product a");
        $this->db->join("webinatech_category b", "b.id=a.cat_id");
        $this->db->join("webinatech_sub_category c", "c.id=a.sub_cat_id");
        $this->db->join("webinatech_item i", "i.id=a.item_id");
        $this->db->join("webinatech_product_media d", "d.product_id=a.id");
        $this->db->join("webinatech_stock f", "f.product_id=a.id", "left");
        $this->db->join("webinatech_product_attribute atr", "atr.product_id=a.id", "left");
        $product_data=$this->db->group_by('a.id')->order_by('a.id', 'desc')->limit($length, $start)->get()->result();
        // echo "<pre>".$this->db->last_query();
        // print_r($product_data);
        // die();
        return $product_data;
    }
    public function product_with_filter($item_id, $all_value, $sort_order, $start, $length){
        $sort_order_arr=array('price_asc'=>"`a.sell_price` ASC", 'price_desc'=>"`a.sell_price` DESC", 'id_desc'=>"`a.id` DESC", 'id_asc'=>"`a.id` ASC");
        $product_ids=array();
        if(!empty($all_value)){
            $i=0;
            foreach ($all_value as $key => $value){
                if($i==0){
                    ${"temp".$i}=$this->db->distinct()->select('product_id')->where("item_id", $item_id)->where("feature_name_id='".$key."' AND feature_value IN (".$value.")")->get('webinatech_filter')->result_array();
                    ${"temp".$i}=array_column(${"temp".$i}, 'product_id');
                    $product_ids=${"temp".$i};
                    // print_r(${"temp".$i});
                    if(empty(${"temp".$i})){ break; }
                }else{
                    ${"temp".$i}=$this->db->distinct()->select('product_id')->where("item_id", $item_id)->where("feature_name_id='".$key."' AND feature_value IN (".$value.") AND product_id IN ('".implode("','", ${"temp".($i-1)})."')")->get('webinatech_filter')->result_array();
                    ${"temp".$i}=array_column(${"temp".$i}, 'product_id');
                    $product_ids=${"temp".$i};
                    // print_r(${"temp".$i});
                    if(empty(${"temp".$i})){ break; }
                }
                $i++;
                // echo $key."->".$value."<br>";
            }
            // print_r($product_ids);
            // echo $this->db->last_query();
            // die();
        }
        $this->db->select('a.id, a.cat_id, a.sub_cat_id, a.item_id, a.group_id, a.title, a.name, a.description, a.price, a.sell_price, a.manufacturer, a.manufacturer_pro_num, a.manufacturer_lead_time, a.create_by, b.name as cat_name, c.name as sub_cat_name, d.main_img, d.other_img, d.attachment, f.stock, i.name as item_name, GROUP_CONCAT(atr.attr_name SEPARATOR "||") as attr_names, GROUP_CONCAT(atr.attr_value SEPARATOR "||") as attr_values');
        $this->db->from("webinatech_product a");
        $this->db->where(array('a.status'=>1, 'a.approve'=>1, 'a.trash'=>0, 'a.item_id'=>$item_id));
        if(!empty($product_ids)){
            $this->db->where_in('a.id', $product_ids);
        }
        $this->db->join("webinatech_category b", "b.id=a.cat_id");
        $this->db->join("webinatech_sub_category c", "c.id=a.sub_cat_id");
        $this->db->join("webinatech_item i", "i.id=a.item_id");
        $this->db->join("webinatech_product_media d", "d.product_id=a.id");
        $this->db->join("webinatech_stock f", "f.product_id=a.id");
        $this->db->join("webinatech_product_attribute atr", "atr.product_id=a.id", "left");
        $data=$this->db->group_by('a.id')->order_by($sort_order_arr[$sort_order])->limit($length, $start)->get()->result();
        // echo $this->db->last_query();
        // print_r($data);
        // die();
        return $data;
    }
    public function fetch_product_details($uid){
        $this->db->select('a.id, a.cat_id, a.sub_cat_id, a.item_id, a.group_id, a.title, a.name, a.description, a.price, a.sell_price, a.manufacturer, a.manufacturer_pro_num, a.manufacturer_lead_time, a.create_by, b.name as cat_name, c.name as sub_cat_name, d.main_img, d.other_img, d.attachment, f.stock, i.name as item_name, GROUP_CONCAT(atr.attr_name SEPARATOR "||") as attr_names, GROUP_CONCAT(atr.attr_value SEPARATOR "||") as attr_values');
        $this->db->where(array('a.status'=>1, 'a.approve'=>1, 'a.trash'=>0, 'a.uid'=>$uid));
        $this->db->from("webinatech_product a");
        $this->db->join("webinatech_category b", "b.id=a.cat_id");
        $this->db->join("webinatech_sub_category c", "c.id=a.sub_cat_id");
        $this->db->join("webinatech_item i", "i.id=a.item_id");
        $this->db->join("webinatech_product_media d", "d.product_id=a.id");
        $this->db->join("webinatech_stock f", "f.product_id=a.id");
        $this->db->join("webinatech_product_attribute atr", "atr.product_id=a.id", "left");
        $data=$this->db->get()->row();
        // echo $this->db->last_query();
        // print_r($data);
        // die();
        return $data;
    }
    public function load_related_products($product_id, $cat_id, $sub_cat_id, $item_id, $start, $length){
        $this->db->select('a.id, a.cat_id, a.sub_cat_id, a.item_id, a.group_id, a.title, a.name, a.description, a.price, a.sell_price, a.manufacturer, a.manufacturer_pro_num, a.manufacturer_lead_time, a.create_by, b.name as cat_name, c.name as sub_cat_name, d.main_img, d.other_img, d.attachment, f.stock, i.name as item_name, GROUP_CONCAT(atr.attr_name SEPARATOR "||") as attr_names, GROUP_CONCAT(atr.attr_value SEPARATOR "||") as attr_values');
        $this->db->from("webinatech_product a");
        $this->db->where(array('a.status'=>1, 'a.approve'=>1, 'a.trash'=>0, 'a.cat_id'=>$cat_id, 'a.sub_cat_id'=>$sub_cat_id));
        $this->db->join("webinatech_category b", "b.id=a.cat_id");
        $this->db->join("webinatech_sub_category c", "c.id=a.sub_cat_id");
        $this->db->join("webinatech_item i", "i.id=a.item_id");
        $this->db->join("webinatech_product_media d", "d.product_id=a.id");
        $this->db->join("webinatech_stock f", "f.product_id=a.id");
        $this->db->join("webinatech_product_attribute atr", "atr.product_id=a.id", "left");
        $data=$this->db->group_by('a.id')->order_by('a.id', 'desc')->limit($length, $start)->get()->result();
        return $data;
    }
    public function load_recent_products($start, $length){
        $this->db->select('a.id, a.cat_id, a.sub_cat_id, a.item_id, a.group_id, a.title, a.name, a.description, a.price, a.sell_price, a.manufacturer, a.manufacturer_pro_num, a.manufacturer_lead_time, a.create_by, b.name as cat_name, c.name as sub_cat_name, d.main_img, d.other_img, d.attachment, f.stock, i.name as item_name, GROUP_CONCAT(atr.attr_name SEPARATOR "||") as attr_names, GROUP_CONCAT(atr.attr_value SEPARATOR "||") as attr_values');
        $this->db->from("webinatech_product a");
        $this->db->where(array('a.status'=>1, 'a.approve'=>1, 'a.trash'=>0));
        $this->db->join("webinatech_category b", "b.id=a.cat_id");
        $this->db->join("webinatech_sub_category c", "c.id=a.sub_cat_id");
        $this->db->join("webinatech_item i", "i.id=a.item_id");
        $this->db->join("webinatech_product_media d", "d.product_id=a.id");
        $this->db->join("webinatech_stock f", "f.product_id=a.id");
        $this->db->join("webinatech_product_attribute atr", "atr.product_id=a.id", "left");
        $data=$this->db->group_by('a.id')->order_by('a.id', 'desc')->limit($length, $start)->get()->result();
        return $data;
    }
    public function search_product($keywords){
        if(!empty($keywords)){
            $this->db->select('a.id, a.cat_id, a.sub_cat_id, a.item_id, a.group_id, a.title, a.name, a.description, a.price, a.sell_price, b.name as cat_name, c.name as sub_cat_name, i.name as item_name, d.main_img, d.other_img');

            $this->db->from("webinatech_product a");
            $this->db->join("webinatech_category b", "b.id=a.cat_id");
            $this->db->join("webinatech_sub_category c", "c.id=a.sub_cat_id");
            $this->db->join("webinatech_item i", "i.id=a.item_id");
            $this->db->join("webinatech_product_media d", "d.product_id=a.id");
            $this->db->where(array('a.status'=>1, 'a.approve'=>1, 'a.trash'=>0));
            $all_keywords=explode(" ", $keywords);
            $srchFiltr="a.name LIKE '%$keywords%' ESCAPE '!' OR ";
            foreach ($all_keywords as $key => $value){
                if(strlen($value)>1){
                    $srchFiltr.="i.name LIKE '%$value%' ESCAPE '!' OR ";
                }
            }
            if(!empty(trim($srchFiltr, " OR "))){
                $this->db->where("(".trim($srchFiltr, " OR ").")");
            }

            // $data=$this->db->group_by('a.id')->get()->result();
            // echo $this->db->last_query();
            // print_r($data);

            return $this->db->group_by('a.id')->limit(15)->get()->result();
        }

    }

    
}