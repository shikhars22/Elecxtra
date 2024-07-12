<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_view_order extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if($this->session->has_userdata('admin_id')==FALSE){
            redirect(base_url('admin'));
        }
        $this->load->library('form_validation');
        $this->load->model('elecxtra_admin/admin_view_order_model', 'current_model');
    }
    public function hold_order(){
        $data['status']="hold";
        $data['session_data']=$this->session->all_userdata();
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
        $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
        $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
        $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
        $this->load->view('elecxtra_admin/order/all_orders', $data);
    }
    public function packaged_order(){
        $data['status']="packaged";
        $data['session_data']=$this->session->all_userdata();
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
        $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
        $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
        $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
        $this->load->view('elecxtra_admin/order/all_orders', $data);
    }
    public function picked_order(){
        $data['status']="picked";
        $data['session_data']=$this->session->all_userdata();
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
        $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
        $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
        $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
        $this->load->view('elecxtra_admin/order/all_orders', $data);
    }
    public function ready_order(){
        $data['status']="ready_order";
        $data['session_data']=$this->session->all_userdata();
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
        $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
        $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
        $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
        $this->load->view('elecxtra_admin/order/all_orders', $data);
    }
    public function out_order(){
        $data['status']="out_order";
        $data['session_data']=$this->session->all_userdata();
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
        $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
        $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
        $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
        $this->load->view('elecxtra_admin/order/all_orders', $data);
    }
    public function completed_order(){
        $data['status']="completed";
        $data['session_data']=$this->session->all_userdata();
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
        $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
        $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
        $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
        $this->load->view('elecxtra_admin/order/all_orders', $data);
    }
    public function canceled_order(){
        $data['status']="canceled";
        $data['session_data']=$this->session->all_userdata();
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
        $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
        $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
        $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
        $this->load->view('elecxtra_admin/order/all_orders', $data);
    }
    public function returned_order(){
        $data['status']="returned";
        $data['session_data']=$this->session->all_userdata();
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
        $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
        $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
        $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
        $this->load->view('elecxtra_admin/order/all_orders', $data);
    }
    public function pending_order(){
        $data['status']="pending";
        $data['session_data']=$this->session->all_userdata();
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
        $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
        $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
        $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
        $this->load->view('elecxtra_admin/order/all_orders', $data);
    }
    public function fetch_all_order(){
        $draw=intval($this->input->post("draw"));
        $start=intval($this->input->post("start"));
        $length=intval($this->input->post("length"));
        $search=trim(strip_tags($this->input->post("search")['value']));
        $order=$this->input->post("order")[0];
        $filter=$this->input->post("columns");
        $data = array();
        $alldata = $this->current_model->fetch_all_order($this->input->post("status"), $start, $length, $search, $order, $filter);
        $data=array();
        foreach($alldata['data'] as $row) {
            $sub_array = array();
            if(!empty($row->note)){
                $note=explode("_|_", $row->note);
            }
            $sub_array[]="<div class='_wtDtInfo text-start'>
                <p class='fs_13 mb-1'>".$row->order_id."</p>
                <p class='fs_11 txt_green mb-1'><b>".$row->payment_mode."</b></p>
                ".(!empty($row->note)?"<div class='fs_11 txt_red clip_txt_1 showFullHtml'><p><b>".$note[0]."</b><br>".$note[1]."</p></div>":"")."
            </div>";
            $sub_array[]="<div class='img'><img src='".base_url('uploads/products/').$row->product_img."'></div>";
            $sub_array[]="<div class='_wtDtInfo'><p class='fs_15 clip_txt_1'>".$row->product_name."</p><p class='fs_13 clip_txt_1 txt_grey'>".$row->cat_name.", ".$row->sub_cat_name."</p><p class='fs_11 clip_txt_1'>".(empty($row->brand_name)?"":$row->brand_name.", ").$row->group_id."</p></div>";
            $sub_array[]="<div class='_wtDtInfo'><p class='fs_15 clip_txt_1'>".$row->qty." x &#8377;".$row->sell_price." = &#8377;".$row->subtotal."</p></div>";
            $sub_array[]="<div class='_wtDtInfo'><p class='fs_13'><i class='fa fa-calendar txt_grey fs_11 pe-2'></i>".date('d M, Y', strtotime($row->order_date))."</p><p class='fs_12 txt_grey'><i class='fa fa-clock fs_11 pe-2'></i>".date('h:i a', strtotime($row->order_date))."</p></div>";
            if($this->session->userdata('admin_role')=="superadmin"){
                $sub_array[]="<div class='_wtDtInfo'><p class='fs_15'>".$row->customer_name."</p><p class='fs_12 txt_grey'>".$row->phone."</p><p class='fs_12 txt_grey'>".$row->email."</p></div>";
                $sub_array[]="<div class='_wtDtInfo showFullHtml'><p class='mb-2 fs_13'><i class='fa fa-map-marker-alt fs_11 txt_grey pe-1'></i><span class='fs_11 txt_green'>Billing Address</span><br><span class='clip_txt_1 ps-2'>&nbsp;".$row->billing_address."</span></p><p class='fs_13'><i class='fa fa-map-marker-alt fs_11 txt_grey pe-1'></i><span class='fs_11 txt_green'>Shipping Address</span><br><span class='clip_txt_1 ps-2'>&nbsp;".$row->shipping_address."</span></p></div>";
                $sub_array[]="<div class='_wtDtInfo'><p class='fs_15'>".$row->seller_name."</p></div>";
            }
            $sub_array[]="<div class='_actionBox'><button class='_wtBtnSm _actionBtn m-auto' type='button'><img src='".base_url('admin_assets/images/dots.svg')."'></button>
            <ul class='_actionList'>
                <li><a href='javascript:void(0)' data-order_id='".$row->order_id."' data-user_id='".$row->user_id."' onclick=view_invoice(this)><i class='fa fa-info me-2'></i> View Invoice</a></li>
                ".(($this->session->userdata('admin_role')=="seller" && $row->status=="hold" && $row->final_status=="")?"<li><a href='javascript:void(0)' onclick=order_packaged('".$row->order_id."')><i class='fa fa-check me-2'></i> Confirm & Packaged</a></li>":"")."

                ".(($this->session->userdata('admin_role')=="superadmin" && $row->status=="packaged" && $row->final_status=="")?"<li><a href='javascript:void(0)' onclick=order_pickedup('".$row->order_id."')><i class='fa fa-check me-2'></i> Picked Up</a></li>":"")."

                ".(($this->session->userdata('admin_role')=="superadmin" && $row->status=="picked" && $row->final_status=="")?"<li  onclick=order_ready_to_deliver('".$row->order_id."')><a href='javascript:void(0)'><i class='fa fa-check me-2'></i> Ready To Deliver</a></li>":"")."

                ".(($this->session->userdata('admin_role')=="superadmin" && $row->status=="ready_order" && $row->final_status=="")?"<li onclick=order_out_for_deliver('".$row->order_id."')><a href='javascript:void(0)'><i class='fa fa-check me-2'></i> Out For Delivery</a></li>":"")."

                ".(($this->session->userdata('admin_role')=="superadmin" && $row->status=="out_order" && $row->final_status=="")?"<li data-seller_id='".$row->seller_id."' data-user_id='".$row->user_id."' data-order_id='".$row->order_id."' data-qty='".$row->qty."' data-product_id='".$row->product_id."' onclick=order_complete_deliver(this)><a href='javascript:void(0)'><i class='fa fa-check me-2'></i> Complete Delivery</a></li>":"")."

                ".(($this->session->userdata('admin_role')=="superadmin" && $row->status=="canceled" && $row->final_status=="")?"<li data-seller_id='".$row->seller_id."' data-user_id='".$row->user_id."' data-order_id='".$row->order_id."' data-qty='".$row->qty."' data-product_id='".$row->product_id."' onclick=order_complete_canceled(this)><a href='javascript:void(0)'><i class='fa fa-check me-2'></i> Complete Canceled</a></li>":"")."

                ".(($this->session->userdata('admin_role')=="superadmin" && $row->status=="returned" && $row->final_status=="delivered")?"<li data-seller_id='".$row->seller_id."' data-user_id='".$row->user_id."' data-order_id='".$row->order_id."' data-qty='".$row->qty."' data-product_id='".$row->product_id."' onclick=order_complete_returned(this)><a href='javascript:void(0)'><i class='fa fa-check me-2'></i> Complete Returned</a></li>":"")."
            </ul>
            </div>";
            $data[]=$sub_array;
        }
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $alldata['recordsTotal'],
            "recordsFiltered" => $alldata['recordsFiltered'],
            "data" => $data
        );
        exit(json_encode($output));
    }
    public function order_packaged(){
        $order_id=$this->input->post('order_id');
        if($this->current_model->order_packaged($order_id)){
            exit(json_encode(array('type'=>'success','text'=>'Successfully Confirmed & Packaged')));
        }else{
            exit(json_encode(array('type'=>'error','text'=>'something went wrong!')));
        }
    }
    public function order_pickedup(){
        $order_id=$this->input->post('order_id');
        if($this->current_model->order_pickedup($order_id)){
            exit(json_encode(array('type'=>'success','text'=>'Successfully Picked')));
        }else{
            exit(json_encode(array('type'=>'error','text'=>'something went wrong!')));
        }
    }
    public function order_ready_to_deliver(){
        $order_id=$this->input->post('order_id');
        if($this->current_model->order_ready_to_deliver($order_id)){
            exit(json_encode(array('type'=>'success','text'=>'Successfully Ready To Deliver')));
        }else{
            exit(json_encode(array('type'=>'error','text'=>'something went wrong!')));
        }
    }
    public function order_out_for_deliver(){
        $order_id=$this->input->post('order_id');
        $tracking_id=$this->input->post('tracking_id');
        if(empty($order_id) || empty($tracking_id)){
            exit(json_encode(array('type'=>'error', 'data'=>"Something went wrong!")));
        }
        if($this->current_model->order_out_for_deliver($order_id, $tracking_id)){
            exit(json_encode(array('type'=>'success','text'=>'Successfully Ready To Deliver')));
        }else{
            exit(json_encode(array('type'=>'error','text'=>'something went wrong!')));
        }
    }
    public function order_complete_deliver(){
        $order_id=$this->input->post('order_id');
        $seller_id=$this->input->post('seller_id');
        $user_id=$this->input->post('user_id');
        $product_id=$this->input->post('product_id');
        $qty=$this->input->post('qty');
        if(empty($order_id) || empty($seller_id) || empty($user_id) || empty($qty) || empty($product_id)){
            exit(json_encode(array('type'=>'error','text'=>'something went wrong!')));
        }else{
            if($this->current_model->order_complete_deliver($order_id, $seller_id, $user_id, $qty, $product_id)){
                exit(json_encode(array('type'=>'success','text'=>'Successfully Completed')));
            }else{
                exit(json_encode(array('type'=>'error','text'=>'something went wrong!')));
            }
        }
    }
    public function order_complete_canceled(){
        $order_id=$this->input->post('order_id');
        $seller_id=$this->input->post('seller_id');
        $user_id=$this->input->post('user_id');
        $product_id=$this->input->post('product_id');
        $qty=$this->input->post('qty');
        if(empty($order_id) || empty($seller_id) || empty($user_id) || empty($qty) || empty($product_id)){
            exit(json_encode(array('type'=>'error','text'=>'something went wrong! missing data!!')));
        }else{
            if($this->current_model->order_complete_canceled($order_id, $seller_id, $user_id, $qty, $product_id)){
                exit(json_encode(array('type'=>'success','text'=>'Successfully Completed')));
            }else{
                exit(json_encode(array('type'=>'error','text'=>'something went wrong!')));
            }
        }
    }
    public function order_complete_returned(){
        $order_id=$this->input->post('order_id');
        $seller_id=$this->input->post('seller_id');
        $user_id=$this->input->post('user_id');
        $product_id=$this->input->post('product_id');
        $qty=$this->input->post('qty');
        if(empty($order_id) || empty($seller_id) || empty($user_id) || empty($qty) || empty($product_id)){
            exit(json_encode(array('type'=>'error','text'=>'something went wrong!')));
        }else{
            if($this->current_model->order_complete_returned($order_id, $seller_id, $user_id, $qty, $product_id)){
                exit(json_encode(array('type'=>'success','text'=>'Successfully Completed')));
            }else{
                exit(json_encode(array('type'=>'error','text'=>'something went wrong!')));
            }
        }
    }
    public function view_invoice(){
        $order_id=$this->input->post('order_id');
        $user_id=$this->input->post('user_id');
        $data['order_data']=$this->current_model->get_order_details($order_id, $user_id);
        $invData=$this->load->view('elecxtra_admin_includes/load_invoice', $data, TRUE);
        exit(json_encode(array('type'=>'success', 'data'=>$invData)));
    }


}
