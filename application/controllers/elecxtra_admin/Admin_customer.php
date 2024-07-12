<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_customer extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if($this->session->has_userdata('admin_id')==FALSE){
            redirect(base_url('admin'));
        }
        $this->load->model('elecxtra_admin/admin_customer_model', 'current_model');
    }
    public function index(){
        $data['session_data']=$this->session->all_userdata();
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
        $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
        $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
        $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
        $this->load->view('elecxtra_admin/customer/all_customer', $data);
    }

    public function fetch_all_customer(){
        $draw=intval($this->input->post("draw"));
        $start=intval($this->input->post("start"));
        $length=intval($this->input->post("length"));
        $search=trim(strip_tags($this->input->post("search")['value']));
        $order=$this->input->post("order")[0];
        $filter=$this->input->post("columns");
        $data=array();
        $data_list=$this->current_model->fetch_all_customer($start, $length, $search, $order, $filter);
        foreach($data_list['data'] as $row) {
            $sub_array=array();
            
            $sub_array[]=$row->id;
            $sub_array[]="<div class='_wtDtInfo'><p class=''><i class='fa fa-user fs_11 txt_grey pe-2'></i>".$row->name."</p></div>";
            $sub_array[]="<div class='_wtDtInfo'><p class=''>".$row->email."</p><a class='fs_13' href='mailto:".$row->email."'><i class='fa fa-envelope fs_11 txt_grey pe-2'></i>Email</a></div>";
            $sub_array[]="<div class='_wtDtInfo'><p class=''>".$row->phone."</p><a class='fs_13' href='tel:".$row->phone."'><i class='fa fa-phone-alt fs_11 txt_grey pe-2'></i>Call</a></div>";
            $address="";
            $types=explode("||", $row->types);
            $pins=explode("||", $row->pins);
            $cities=explode("||", $row->cities);
            $land_marks=explode("||", $row->land_marks);
            $addresses=explode("||", $row->addresses);
            $states=explode("||", $row->states);
            for ($i=0; $i < count($pins); $i++) {
                $address.="<p class='fs_13'><i class='fa fa-map-marker-alt fs_11 txt_grey pe-1'></i><span class='fs_11 txt_green'>".$types[$i]."</span><br><span class='ps-2'>&nbsp;".$pins[$i].", ".$cities[$i].", ".$land_marks[$i].", ".$addresses[$i].", ".$states[$i]."</span></p>";
            }
            $sub_array[]="<div class='_wtDtInfo showFullHtml'>".$address."</div>";

            // $sub_array[]="<div class='_wtDtInfo'><p class='fs_13'>Orders: ".$row->order_count." Calceled: ".$row->cancel_count."</p><p class='fs_13'>Cancels: ".$row->cancel_count." Return: ".$row->return_count."</p></div>";
            // $sub_array[]="<div class='_wtDtInfo'><p class='fs_13'>Sale: ".$row->sale_count."<br> Revenue: ".$row->total_revenue."</p></div>";
            // $sub_array[]="<div class='_wtDtInfo'><p class='fs_13'>Complained: ".$row->complain_count." Faqs: ".$row->faq_count."</p><p class='fs_13'>Ratings: ".$row->rating_count." Star: ".$row->star_count."</p></div>";

            $sub_array[]="<div class='_wtDtInfo'><p class='fs_13'><i class='fa fa-calendar fs_11 txt_grey pe-2'></i>".date('d M, Y', strtotime($row->create_date))."<br><span class='fs_12 txt_grey'><i class='fa fa-clock fs_11 txt_grey pe-2'></i>".date('h:i a', strtotime($row->create_date))."</span></p></div>";

            $sub_array[]="<div class='_wtDtInfo'><button class='_wtBtnSm bg_green fs_13'>Email</button></div>";


            $data[]=$sub_array;
        }
        $output=array(
            "draw"=>$draw,
            "recordsTotal"=>$data_list['recordsTotal'],
            "recordsFiltered"=>$data_list['recordsFiltered'],
            "data"=>$data
        );
        exit(json_encode($output));
    }



}
