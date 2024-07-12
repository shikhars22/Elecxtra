<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_customer_model extends CI_Model{
    public function fetch_all_customer($start, $length, $search, $order, $filter){
        $orderableColumns=array('a.id', 'a.name', 'a.email', 'a.phone',  '', 'a.create_date', '');
        $searchableColumns=array('a.id', 'a.name', 'a.email', 'a.phone', '', 'a.create_date', '');
        $this->db->select('a.id, a.name, a.email, a.phone, a.create_date, GROUP_CONCAT(b.type SEPARATOR "||") as types, GROUP_CONCAT(b.pin SEPARATOR "||") as pins, GROUP_CONCAT(b.city SEPARATOR "||") as cities, GROUP_CONCAT(b.land_mark SEPARATOR "||") as land_marks, GROUP_CONCAT(b.address SEPARATOR "||") as addresses, GROUP_CONCAT(b.state SEPARATOR "||") as states, c.order_count, c.cancel_count, c.return_count, c.sale_count, c.total_revenue, c.complain_count, c.faq_count, c.rating_count, c.star_count');
        $this->db->from("webinatech_customer a");
        $this->db->join("webinatech_customer_report c", "c.user_id=a.id");
        $this->db->join("webinatech_customer_address b", "b.user_id=a.id");
        if($search!=""){
            $this->db->where("(a.id LIKE '%$search%' ESCAPE '!' OR a.id LIKE '%$search%' ESCAPE '!' OR a.name LIKE '%$search%' ESCAPE '!' OR a.email LIKE '%$search%' ESCAPE '!' OR a.phone LIKE '%$search%' ESCAPE '!')");
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
        // print_r($data);
        // echo $this->db->last_query();
        // die();

        //record count
        $this->db->select("a.id");
        $this->db->from("webinatech_customer a");
        $this->db->join("webinatech_customer_report c", "c.user_id=a.id");
        if($search!=""){
            $this->db->where("(a.id LIKE '%$search%' ESCAPE '!' OR a.id LIKE '%$search%' ESCAPE '!' OR a.name LIKE '%$search%' ESCAPE '!' OR a.email LIKE '%$search%' ESCAPE '!' OR a.phone LIKE '%$search%' ESCAPE '!')");
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



}
