<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_product extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if($this->session->has_userdata('admin_id')==FALSE){
            redirect(base_url('admin'));
        }

        $this->product_width=500;
        $this->load->library('upload');

        $this->load->library('form_validation');
        $this->load->model('elecxtra_admin/Admin_product_model', 'current_model');
    }
    private function set_upload_options($upload_path){   
        //upload an image options
        $config=array();
        $config['upload_path']=$upload_path;
        $config['allowed_types']='jpg|png|jpeg';
        $config['overwrite']=TRUE;
        if(!is_dir($config['upload_path'])){
            mkdir($config['upload_path'], 0755, TRUE);
        }
        return $config;
    }
    private function upload_product($all_files){
        $media_file=array(); $temp_error_file=array();
        for($i=0; $i < count($all_files); $i++){ 
            if(empty($_FILES[$all_files[$i]]['name'])){
                $img_data=$this->input->post($all_files[$i]."_link");
                if(!empty($img_data)){
                    $folder='./uploads/products/';
                    // if(!is_dir($folder)){ mkdir($folder, 0755, true); }
                    $image_array_1=explode(";", $img_data);
                    $image_array_2=explode(",", $image_array_1[1]);
                    $img_data=base64_decode($image_array_2[1]);
                    $new_file_name=time().'_'.($i+1).'.jpg';
                    if(file_put_contents($folder.$new_file_name, $img_data)!== false){
                        $media_file[]=$new_file_name;
                    }
                }
            }else{
                $new_file_name=time().'_'.($i+1).'.'.pathinfo($_FILES[$all_files[$i]]['name'], PATHINFO_EXTENSION);
                $_FILES['cur_media']['name']=$new_file_name;
                $temp_error_file[]=$new_file_name;
                $_FILES['cur_media']['type']= $_FILES[$all_files[$i]]['type'];
                $_FILES['cur_media']['tmp_name']= $_FILES[$all_files[$i]]['tmp_name'];
                $_FILES['cur_media']['error']= $_FILES[$all_files[$i]]['error'];
                $_FILES['cur_media']['size']= $_FILES[$all_files[$i]]['size'];    

                if($this->upload->do_upload('cur_media')==FALSE){
                    $error=$this->upload->display_errors();
                    if(!empty($temp_error_file)){
                        foreach ($temp_error_file as $temp_key => $temp_value) {
                            if(file_exists('uploads/products/'.$temp_value)){
                                unlink('uploads/products/'.$temp_value);
                            }
                        }
                    }
                    return array('type'=>'error', 'message'=>$error, 'media'=>$media_file);
                }else{  
                    $upload_data=$this->upload->data();
                    $media_file[]=$upload_data["file_name"];
                    $image_width=$upload_data['image_width'];
                    if($image_width < $this->product_width){
                        if($upload_data['file_size']>150){
                            $image_process=true;
                            $image_process_size=$image_width;
                        }else{
                            $image_process=false;
                        }
                    }else{
                        $image_process=true;
                        $image_process_size=$this->product_width;
                    }
                    if($image_process){
                        $this->load->library('image_lib');
                        $image_config["source_image"]=$upload_data["full_path"];
                        $image_config['create_thumb']=FALSE;
                        $image_config['maintain_ratio']=TRUE;
                        $image_config['overwrite']=TRUE;
                        $image_config['new_image']=$upload_data["file_path"].$upload_data["file_name"];
                        $image_config['quality']="90%";
                        $image_config['width']=$image_process_size;
                        $image_config['height']=1;
                        $dim=(intval($upload_data["image_width"]) / intval($upload_data["image_height"])) - ($image_config['width'] / $image_config['height']);
                        $image_config['master_dim']=($dim > 0)? "height" : "width";         
                        $this->image_lib->initialize($image_config);
                        if($this->image_lib->resize()==FALSE){
                            $error=$this->image_lib->display_errors();
                            exit(json_encode(array('type'=>'error', 'message'=>$error)));
                        }
                    }                   
                }
            }
        }
        if(empty($media_file)){
            return array('type'=>'error', 'message'=>"No files are uploaded!", 'media'=>$media_file);
        }else{
            return array('type'=>'error', 'message'=>"Successfully Uploaded!", 'media'=>$media_file);
        }
    }
    ////////////////////ALL VIEW///////////////////////////
    public function approved_product(){
        $data['product_status']=array('trash'=>'0', 'reject'=>'0', 'approve'=>'1');
        $data['session_data']=$this->session->all_userdata();
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
        $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
        $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
        $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
        $this->load->view('elecxtra_admin/product/all_products',$data);
    }
    public function pending_product(){
        $data['product_status']=array('trash'=>'0', 'reject'=>'0', 'approve'=>'0');
        $data['session_data']=$this->session->all_userdata();
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
        $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
        $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
        $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
        $this->load->view('elecxtra_admin/product/all_products',$data);
    }
    public function rejected_product(){
        $data['product_status']=array('trash'=>'0', 'reject'=>'1', 'approve'=>'0');
        $data['session_data']=$this->session->all_userdata();
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
        $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
        $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
        $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
        $this->load->view('elecxtra_admin/product/all_products',$data);
    }
    public function trash_product(){
        if($this->session->userdata('admin_role')=="seller"){
            $data['product_status']=array('trash'=>'1', 'reject'=>'0,1', 'approve'=>'0,1');
            $data['session_data']=$this->session->all_userdata();
            $data['csrfHash']=$this->security->get_csrf_hash();
            $data['csrfName']=$this->security->get_csrf_token_name();
            $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
            $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
            $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
            $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
            $this->load->view('elecxtra_admin/product/all_products',$data);
        }else{
            exit("Access denied!");
        }
    }
    public function fetch_all_product(){
        $price_commission=json_decode(price_commission());
        $draw=intval($this->input->post("draw"));
        $start=intval($this->input->post("start"));
        $length=intval($this->input->post("length"));
        $search=trim(strip_tags($this->input->post("search")['value']));
        $order=$this->input->post("order")[0];
        $filter=$this->input->post("columns");
        $data=array();
        $data_list=$this->current_model->fetch_all_product($this->input->post('approve'), $this->input->post('reject'), $this->input->post('trash'), $start, $length, $search, $order, $filter);
        foreach($data_list['data'] as $row) {
            $sub_array=array();
            
            $sub_array[]=$row->id;
            
            $sub_array[]="<div class='img'><img src='".base_url('uploads/products/').$row->main_img."'></div>";
            
            $sub_array[]="<div class='_wtDtInfo'><p class='fs_15 clip_txt_1'>".$row->name."</p><p class='fs_13 clip_txt_1 txt_grey'><span class='fs_11'>".$row->item_name."</span>, ".$row->sub_cat_name."</p>".(!empty($row->reject_note)?"<p class='fs_11 showFullTxt'><code>".$row->reject_note."</code> <i class='fas fa-info-circle'></i></p>":"")."</div>";
           
            $sub_array[]="<div class='_wtDtInfo'><p class='fs_13'>".$row->manufacturer."</p></div>";

            if($this->session->userdata('admin_role')=="seller"){
                $sub_array[]="<div class='_wtDtInfo d-flex align-items-center stock_holder' style='border:1px solid #ddd; border-radius:3px;'><input type='number' value='".$row->stock."' style='padding:2px 5px !important; width:60px; margin:0; text-align:center; border: none !important;'>
                    <button class='btn btn-sm btn-info text-white fs_10' data-id='".$row->id."' onclick='update_stock(this)'><i class='fa fa-file'></i></button>";
            }
            if($this->session->userdata('admin_role')=="superadmin"){
                $sub_array[]="<div class='_wtDtInfo'><p class='fs_13 ".($row->stock==0?"text-danger text-blink":($row->stock<3?"text-danger":"text-success"))."'>".$row->stock." in stock</p></div>";
            }

            $finalPrice=0;
            $priceTxt="";
            foreach ($price_commission as $k => $v){
                if($row->price<=$v->max_price){
                    $other_charge=2;
                    $comms=$v->commission;
                    $webViewPrice=$row->price+($row->price*$v->commission/100);
                    $finalPrice=number_format((float)($webViewPrice+($webViewPrice*$other_charge/100)), 2, '.', '');
                    $priceTxt="<code>(".($comms*1)."% added! + ".$other_charge."% including all taxes!)</code>";
                    break;
                }
            }

            $sub_array[]="<div class='_wtDtInfo'><p class='fs_13'>Seller Price: &#8377;".$row->price."</p><p>".$priceTxt."</p><p class='fs_13'>Final Price: &#8377;".$finalPrice."</p></div>";
            
            $sub_array[]="<div class='_wtDtInfo'><p class='fs_13'><i class='fa fa-calendar txt_grey fs_11 pe-2'></i>".date('d M, Y', strtotime($row->create_date))."</p><p class='fs_12 txt_grey'><i class='fa fa-clock fs_11 pe-2'></i>".date('h:i a', strtotime($row->create_date))."</p></div>";

            $sub_array[]="<div class='_wtDtInfo'><p class='fs_13'><i class='fa fa-calendar txt_grey fs_11 pe-2'></i>".date('d M, Y', strtotime($row->update_date))."</p><p class='fs_12 txt_grey'><i class='fa fa-clock fs_11 pe-2'></i>".date('h:i a', strtotime($row->create_date))."</p></div>";

            if ($this->session->userdata('admin_role')=="superadmin") {
                $sub_array[]="<div class='_wtDtInfo'><p class='fs_13'><i class='fa fa-flag fs_11 text-warning pe-2'></i>".$row->user_name." <i class='fas fa-info-circle'></i></p><p class='fs_13'>".$row->company_name."</p></div>";
            }
            if ($this->session->userdata('admin_role')=="seller") {
                if($row->status>0){$checked="checked";}else{$checked="";}
                $sub_array[]="<div class='_wtRange'><small class='_resp_label'>Status </small><div class='form-check form-switch mb-0'><input type='checkbox' ".$checked." onclick=status_data('".$row->id."') id='".$row->id."_status' class='form-check-input'><label class='form-check-label p-0' for='".$row->id."_status'></label></div></div>";
            }
            if($this->session->userdata('admin_role')=="superadmin") {
                if($row->feature>0){$checked1="checked";}else{$checked1="";}
                if($row->deal>0){$checked2="checked";}else{$checked2="";}
                $sub_array[]="
                    <div class='_wtRange'><small class='fs_11'>Feature </small><div class='form-check form-switch mb-0'><input type='checkbox' ".$checked1." onclick=feature_data('".$row->id."') id='".$row->id."_feature' class='form-check-input'><label class='form-check-label p-0' for='".$row->id."_feature'></label></div></div>
                    <div class='_wtRange'><small class='fs_11'>deal </small><div class='form-check form-switch mb-0'><input type='checkbox' ".$checked2." onclick=deal_data('".$row->id."') id='".$row->id."_deal' class='form-check-input'><label class='form-check-label p-0' for='".$row->id."_deal'></label></div></div>";
            }
            $sub_array[]="<div class='_actionBox'><button class='_wtBtnSm _actionBtn m-auto' type='button'><img src='".base_url('admin_assets/images/dots.svg')."'></button>
            <ul class='_actionList'>
                <li><a href='".base_url('product-details/'.$row->title)."' target='_blank'><i class='fa fa-eye me-2'></i> View Product</a></li>
                ".($this->session->userdata('admin_role')=="seller"?"<li onclick=edit_data('".$row->id."')><a href='javascript:void(0)'><i class='fa fa-edit me-2'></i> Edit Product</a></li>": "")."
                ".(($this->session->userdata('admin_role')=="superadmin")?((empty($row->approve) && empty($row->reject))?"<li onclick=approve_data(".$row->id.",".$row->create_by.")><a href='javascript:void(0)'><i class='fa fa-check me-2'></i> Approved</a></li><li onclick=reject_data(".$row->id.",".$row->create_by.")><a href='javascript:void(0)'><i class='fa fa-times me-2'></i> Reject</a></li>": ""):"")."
                ".($this->session->userdata('admin_role')=="seller"?(empty($row->trash)?"<li onclick=delete_data('".$row->id."')><a href='javascript:void(0)'><i class='fa fa-trash me-2'></i> Delete Product</a></li>": "<li onclick=restore_data('".$row->id."')><a href='javascript:void(0)'><i class='fa fa-recycle me-2'></i> Restore</a></li><li onclick=delete_data_permanent('".$row->id."')><a href='javascript:void(0)'><i class='fa fa-trash me-2'></i> Delete Permanent</a></li>"):"")."
            </ul>
            </div>";
            
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
    public function update_stock(){
        if($this->session->userdata('admin_role')=="seller"){
            if($this->input->post('id')!="" && $this->input->post('stock')!=""){
                if($this->current_model->update_stock($this->input->post('id'), $this->input->post('stock'))){
                    exit(json_encode(array('type'=>'success', 'text'=>'successfully product stock updated')));
                }else{
                    exit(json_encode(array('type'=>'error', 'text'=>'something went wrong!')));
                }
            }
        }else{
            exit("Access denied!");
        }
    }
    public function status_data(){
        if($this->session->userdata('admin_role')=="seller"){
            if($this->input->post('id')!="" && $this->input->post('status')!=""){
                if($this->current_model->status_data($this->input->post('id'), $this->input->post('status'))){
                    exit(json_encode(array('type'=>'success', 'text'=>'successfully product status updated')));
                }else{
                    exit(json_encode(array('type'=>'error', 'text'=>'something went wrong!')));
                }
            }
        }else{
            exit("Access denied!");
        }
    }
    public function feature_data(){
        if($this->session->userdata('admin_role')=="superadmin"){
            if($this->input->post('id')!="" && $this->input->post('feature')!=""){
                if($this->current_model->feature_data($this->input->post('id'), $this->input->post('feature'))){
                    exit(json_encode(array('type'=>'success', 'text'=>'successfully product feature updated')));
                }else{
                    exit(json_encode(array('type'=>'error', 'text'=>'something went wrong!')));
                }
            }
        }else{
            exit("Access denied!");
        }
    }
    public function deal_data(){
        if($this->session->userdata('admin_role')=="superadmin"){
            if($this->input->post('id')!="" && $this->input->post('deal')!=""){
                if($this->current_model->deal_data($this->input->post('id'), $this->input->post('deal'))){
                    exit(json_encode(array('type'=>'success', 'text'=>'successfully product deal updated')));
                }else{
                    exit(json_encode(array('type'=>'error', 'text'=>'something went wrong!')));
                }
            }
        }else{
            exit("Access denied!");
        }
    }
    public function delete_data(){
        if($this->session->userdata('admin_role')=="seller"){
            if($this->input->post('id')!=""){
                if($this->current_model->delete_data($this->input->post('id'))){
                    exit(json_encode(array('type'=>'success', 'text'=>'product removed to trash!')));
                }else{
                    exit(json_encode(array('type'=>'error', 'text'=>'something went wrong!')));
                }
            }
        }else{
            exit("Access denied!");
        }
    }
    public function delete_permanently_data(){
        if($this->session->userdata('admin_role')=="seller"){
            if($this->input->post('id')!=""){
                if($this->current_model->delete_permanently_data($this->input->post('id'))){
                    exit(json_encode(array('type'=>'success', 'text'=>'product deleted permanently!')));
                }else{
                    exit(json_encode(array('type'=>'error', 'text'=>'something went wrong!')));
                }
            }
        }else{
            exit("Access denied!");
        }
    }
    public function restore_data(){
        if($this->session->userdata('admin_role')=="seller"){
            if($this->input->post('id')!=""){
                if($this->current_model->restore_data($this->input->post('id'))){
                    exit(json_encode(array('type'=>'success', 'text'=>'product restored!')));
                }else{
                    exit(json_encode(array('type'=>'error', 'text'=>'something went wrong!')));
                }
            }
        }else{
            exit("Access denied!");
        }
    }
    public function approve_data(){
        if($this->session->userdata('admin_role')=='superadmin'){
            if($this->input->post('id')!=""){
                if($this->current_model->approve_data($this->input->post('seller_id'), $this->input->post('id'))){
                    exit(json_encode(array('type'=>'success', 'text'=>'product approved!')));
                }else{
                    exit(json_encode(array('type'=>'error', 'text'=>'something went wrong!')));
                }
            }
        }else{
            exit("Access denied!");
        }
    }
    public function reject_data(){
        if($this->session->userdata('admin_role')=='superadmin'){
            if($this->input->post('seller_id')!="" && $this->input->post('id')!="" && $this->input->post('reject_note')!=""){
                if($this->current_model->reject_data($this->input->post('seller_id'), $this->input->post('id'), $this->input->post('reject_note'))){
                    exit(json_encode(array('type'=>'success', 'text'=>'product rejected!')));
                }else{
                    exit(json_encode(array('type'=>'error', 'text'=>'something went wrong!')));
                }
            }
        }else{
            exit("Access denied!");
        }
    }
    /*************Add Products**************/
    public function add_product(){
        if($this->session->userdata('admin_role')=="seller"){
            $data['session_data']=$this->session->all_userdata();
            $data['csrfHash']=$this->security->get_csrf_hash();
            $data['csrfName']=$this->security->get_csrf_token_name();
            $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
            $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
            $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
            $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
            $this->load->view('elecxtra_admin/product/add_product',$data);
        }else{
            exit("Access denied!");
        }
    }
    public function edit_product(){
        if($this->session->userdata('admin_role')=="seller"){
            $product_id=trim($this->input->get('product_id'));
            if(!empty($product_id)){
                $product=$this->current_model->get_prod_data($product_id);
                if(!empty($product)){
                    $data['main_product_id']=$product->id;
                    $data['main_item_id']=$product->item_id;
                    $data['main_group_id']=$product->group_id;
                    $data['session_data']=$this->session->all_userdata();
                    $data['csrfHash']=$this->security->get_csrf_hash();
                    $data['csrfName']=$this->security->get_csrf_token_name();
                    $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
                    $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
                    $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
                    $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
                    $this->load->view('elecxtra_admin/product/edit_product',$data);
                }else{
                    exit("something went wrong!");
                }
            }else{
                exit("something went wrong!");
            }
        }else{
            exit("Access denied!");
        }
    }
    public function fetch_product_details(){
        exit(json_encode($this->current_model->fetch_product_details($this->input->post('id'), $this->input->post('item_id'), $this->input->post('group_id'))));
    }
    public function fetch_only_product_details(){
        exit(json_encode($this->current_model->fetch_only_product_details($this->input->post('id'))));
    }
    public function fetch_cat(){
        $select_data="";
        $data=$this->current_model->fetch_cat();
        foreach ($data as $key => $value) {
            $select_data.="<li data-value='".$value->id."'>".$value->name."</li>";
        }
        exit(json_encode(array('type'=>'success', 'select_data'=>$select_data)));
    }
    public function fetch_sub_cat(){
        $select_data="";
        $data=$this->current_model->fetch_sub_cat($this->input->post('cat_id'));
        foreach ($data as $key => $value) {
            $select_data.="<li data-value='".$value->id."'>".$value->name."</li>";
        }
        exit(json_encode(array('type'=>'success', 'select_data'=>$select_data)));
    }
    public function fetch_item(){
        $select_data="";
        $data=$this->current_model->fetch_item($this->input->post('sub_cat_id'));
        foreach ($data as $key => $value) {
            $select_data.="<li data-value='".$value->id."'>".$value->name."</li>";
        }
        exit(json_encode(array('type'=>'success', 'select_data'=>$select_data)));
    }    
    public function add_product_data(){
        $main_id=$this->input->post('id');
        $this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
        $this->form_validation->set_rules('sub_cat_id', 'Sub Category', 'trim|required');
        $this->form_validation->set_rules('item_id', 'Item', 'trim|required');
        $this->form_validation->set_rules('group_id', 'Group', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'trim|numeric|required');
        // $this->form_validation->set_rules('sell_price', 'Sell Price', 'trim|numeric|required');
        $this->form_validation->set_rules('stock', 'Stock', 'trim|integer|required');
        if($this->form_validation->run()){
            if($this->input->post('price')<=0){
                exit(json_encode(array('type'=>'error', 'text'=>"Price can't be equal or less 0")));
            }
            $this->upload->initialize($this->set_upload_options('uploads/products/'));

            $uid=time();
            $product=array(
                'uid'=>$uid,
                'cat_id'=>$this->input->post('cat_id'),
                'sub_cat_id'=>$this->input->post('sub_cat_id'),
                'item_id'=>$this->input->post('item_id'),
                'group_id'=>$this->input->post('group_id'),
                'sku'=>$this->input->post('sku'),
                'title'=>clean_string($this->input->post('name')).'?uid='.$uid,
                'return_day'=>$this->input->post('return_day'),
                'warranty'=>$this->input->post('warranty'),
                'name'=>$this->input->post('name'),
                'description'=>$this->input->post('description'),
                'manufacturer'=>$this->input->post('manufacturer'),
                'manufacturer_pro_num'=>$this->input->post('manufacturer_pro_num'),
                'manufacturer_lead_time'=>$this->input->post('manufacturer_lead_time'),
                'price'=>$this->input->post('price'),
                // 'sell_price'=>$this->input->post('sell_price'),
                'status'=>1,
                'create_by'=>$this->session->userdata('admin_id'),
                'create_date'=>date('Y-m-d H:i:s'),
            );
            $stock=array(
                'stock'=>$this->input->post('stock'),
            );
            $media=array(
                'main_img'=>'',
                'other_img'=>'',
            );

            $main_uploaded_media=$this->upload_product(array('main_img'));
            if(empty($main_uploaded_media['media'])){
                exit(json_encode(array('type'=>'error', 'text'=>$main_uploaded_media['message'])));
            }else{
                $media['main_img']=$main_uploaded_media['media'][0];
                $totalImgList=array('1_img', '2_img', '3_img', '4_img', '5_img', '6_img');
                $other_uploaded_media=$this->upload_product($totalImgList);
                $media['other_img'].=trim(implode("|", $other_uploaded_media['media']), "|");
            }
            
            $attach_files=array();
            $countfiles = count($_FILES['attachments']['name']);
            for($i=0;$i<$countfiles;$i++){
                $filename = $_FILES['attachments']['name'][$i];
                if(in_array(strtolower(pathinfo($filename, PATHINFO_EXTENSION)), array('txt', 'pdf', 'docx'))){
                    $attach_folder='./uploads/products/attachments/'; $time=time();
                    if(!is_dir($attach_folder)){ mkdir($attach_folder, 0755, true); }
                    move_uploaded_file($_FILES['attachments']['tmp_name'][$i], $attach_folder.$filename);
                    $attach_files[]=$filename;
                }
            }
            if(!empty($attach_files)){
                $media['attachment']=implode("|", $attach_files);
            }

            $product_id=$this->current_model->add_product_data($main_id, $product, $stock, $media, $this->input->post('attr_name'), $this->input->post('attr_value'));
            if($product_id){
                exit(json_encode(array('type'=>'success', 'text'=>'successfully added', 'product_id'=>$product_id)));
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'duplicate entry or something went wrong!')));
            }
        }else{
            exit(json_encode(array('type'=>'error', 'text'=>validation_errors())));
        }
    }
    public function delete_product_img(){
        $this->form_validation->set_rules('id', 'ID', 'trim|required');
        if($this->form_validation->run()){
            $all_old_img=$this->current_model->get_imgs($this->input->post('id'));
            $all_old_other_img_arr=explode("|", $all_old_img->other_img);
            for ($i=0; $i < count($all_old_other_img_arr); $i++) { 
                if($this->input->post('old_img')==$all_old_other_img_arr[$i]){
                    if(file_exists('uploads/products/'.$all_old_other_img_arr[$i])){
                        unlink('uploads/products/'.$all_old_other_img_arr[$i]);
                    }
                    unset($all_old_other_img_arr[$i]);
                }
            }
            $media=array(
                'other_img'=>trim(implode("|", $all_old_other_img_arr), "|"),
            );
            if($this->current_model->update_product_img($this->input->post('id'), $media)){
                exit(json_encode(array('type'=>'success', 'text'=>'successfully deleted!')));
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'something went wrong!')));
            }
        }else{
            exit(json_encode(array('type'=>'error', 'text'=>validation_errors())));
        }
    }
    public function update_product_img(){
        $this->form_validation->set_rules('id', 'ID', 'trim|required');
        $this->form_validation->set_rules('img_pos', 'Img Position', 'trim|required');
        if($this->form_validation->run()){
            $this->upload->initialize($this->set_upload_options('uploads/products/'));
            
            $this->upload->initialize($this->set_upload_options('uploads/products/'));
            $singleImgList=array($this->input->post('img_pos'));
            $uploaded_media=$this->upload_product($singleImgList);
            if(empty($uploaded_media['media'])){
                exit(json_encode(array('type'=>'error', 'text'=>$uploaded_media['message'])));
            }else{
                $all_old_img=$this->current_model->get_imgs($this->input->post('id'));
                if($this->input->post('img_pos')=="main_img"){
                    if(file_exists('uploads/products/'.$all_old_img->main_img)){
                        unlink('uploads/products/'.$all_old_img->main_img);
                    }
                    $media=array(
                        'main_img'=>$uploaded_media['media'][0],
                    );
                }else{
                    if(empty($this->input->post('old_img'))){
                        $media=array(
                            'other_img'=>trim(($all_old_img->other_img.'|'.$uploaded_media['media'][0]), "|"),
                        );
                    }else{
                        $all_old_other_img_arr=explode("|", $all_old_img->other_img);
                        for ($i=0; $i < count($all_old_other_img_arr); $i++) { 
                            if($this->input->post('old_img')==$all_old_other_img_arr[$i]){
                                if(file_exists('uploads/products/'.$all_old_other_img_arr[$i])){
                                    unlink('uploads/products/'.$all_old_other_img_arr[$i]);
                                }
                                $all_old_other_img_arr[$i]=$uploaded_media['media'][0];
                            }
                        }
                        $media=array(
                            'other_img'=>trim(implode("|", $all_old_other_img_arr), "|"),
                        );
                    }
                }
                if($this->current_model->update_product_img($this->input->post('id'), $media)){
                    exit(json_encode(array('type'=>'success', 'img'=>$uploaded_media['media'][0], 'text'=>'successfully updated!')));
                }else{
                    exit(json_encode(array('type'=>'error', 'text'=>'something went wrong!')));
                }
            }
        }else{
            exit(json_encode(array('type'=>'error', 'text'=>validation_errors())));
        }
    }
    public function update_product_data(){
        $this->form_validation->set_rules('id', 'ID', 'trim|required');
        $this->form_validation->set_rules('uid', 'UID', 'trim|required');
        $this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
        $this->form_validation->set_rules('sub_cat_id', 'Sub Category', 'trim|required');
        $this->form_validation->set_rules('item_id', 'Item', 'trim|required');
        $this->form_validation->set_rules('group_id', 'Group', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'trim|numeric|required');
        // $this->form_validation->set_rules('sell_price', 'Sell Price', 'trim|numeric|required');
        $this->form_validation->set_rules('stock', 'Stock', 'trim|integer|required');
        if($this->form_validation->run()){
            if($this->input->post('price')<=0){
                exit(json_encode(array('type'=>'error', 'text'=>"Price can't be equal or less 0")));
            }
            $product=array(
                'uid'=>$this->input->post('uid'),
                'cat_id'=>$this->input->post('cat_id'),
                'sub_cat_id'=>$this->input->post('sub_cat_id'),
                'item_id'=>$this->input->post('item_id'),
                'group_id'=>$this->input->post('group_id'),
                'sku'=>$this->input->post('sku'),
                'title'=>clean_string($this->input->post('name')).'?uid='.$this->input->post('uid'),
                'return_day'=>$this->input->post('return_day'),
                'warranty'=>$this->input->post('warranty'),
                'name'=>$this->input->post('name'),
                'description'=>$this->input->post('description'),
                'manufacturer'=>$this->input->post('manufacturer'),
                'manufacturer_pro_num'=>$this->input->post('manufacturer_pro_num'),
                'manufacturer_lead_time'=>$this->input->post('manufacturer_lead_time'),
                'price'=>$this->input->post('price'),
                // 'sell_price'=>$this->input->post('sell_price'),
                'trash'=>0,
                'reject'=>0,
                'approve'=>0
            );
            
            $stock=array(
                'stock'=>$this->input->post('stock'),
            );

            $attach_files=array();
            $countfiles = count($_FILES['attachments']['name']);
            for($i=0;$i<$countfiles;$i++){
                $filename = $_FILES['attachments']['name'][$i];
                if(in_array(strtolower(pathinfo($filename, PATHINFO_EXTENSION)), array('txt', 'pdf', 'docx'))){
                    $attach_folder='./uploads/products/attachments/'; $time=time();
                    if(!is_dir($attach_folder)){ mkdir($attach_folder, 0755, true); }
                    move_uploaded_file($_FILES['attachments']['tmp_name'][$i], $attach_folder.$filename);
                    $attach_files[]=$filename;
                }
            }
            if(!empty($attach_files)){
                $media['attachment']=implode("|", $attach_files);
            }

            if($this->current_model->update_product_data($this->input->post('id'), $product, $stock, $this->input->post('attr_name'), $this->input->post('attr_value'))){
                exit(json_encode(array('type'=>'success', 'text'=>'successfully updated')));
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'duplicate entry or something went wrong!')));
            }
        }else{
            exit(json_encode(array('type'=>'error', 'text'=>validation_errors())));
        }
    }


    public function fetch_product_attr(){
        exit(json_encode($this->current_model->fetch_product_attr($this->input->post('id'), $this->input->post('item_id'), $this->input->post('group_id'))));
    }
    public function delete_product_attr(){
        if($this->current_model->delete_product_attr($this->input->post('attr_id'))){
            exit(json_encode(array('type'=>'success', 'text'=>'successfully removed!')));
        }else{
            exit(json_encode(array('type'=>'error', 'text'=>'duplicate entry or something went wrong!')));
        }
    }
    public function delete_attachment(){
        if($this->current_model->delete_attachment($this->input->post('pro_id'), $this->input->post('attach'))){
            exit(json_encode(array('type'=>'success', 'text'=>'successfully removed!')));
        }else{
            exit(json_encode(array('type'=>'error', 'text'=>'duplicate entry or something went wrong!')));
        }
    }


}
