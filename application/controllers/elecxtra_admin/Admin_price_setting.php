<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_price_setting extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if($this->session->has_userdata('admin_id')==FALSE){
            redirect(base_url('admin'));
        }
        $this->load->library('form_validation');
        $this->load->model('elecxtra_admin/admin_price_setting_model', 'current_model');
    }

    ///////////////////commission///////////////////////
    public function commission(){
        if($this->session->userdata('admin_role')=="superadmin"){
            $data['session_data']=$this->session->all_userdata();
            $data['csrfHash']=$this->security->get_csrf_hash();
            $data['csrfName']=$this->security->get_csrf_token_name();
            $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
            $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
            $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
            $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
            $this->load->view('elecxtra_admin/setting/admin_view_commission',$data);
        }else{
            exit("Access denied!");
        }
    }
    public function add_commission(){
        if(empty($this->input->post('max_price'))){
            exit(json_encode(array('type'=>'warning','text'=>'Fill required fields!')));
        }else{
            if($this->input->post('min_price')>$this->input->post('max_price')){
                exit(json_encode(array('type'=>'error', 'text'=>'Min Price should be less than Max Price.!')));
            }else{
                $data=array(
                    'min_price'=>$this->input->post('min_price'),
                    'max_price'=>$this->input->post('max_price'),
                    'commission'=>$this->input->post('commission'),
                    'create_by'=>$this->session->userdata('admin_id'),
                    'create_date'=>date('Y-m-d H:i:s')
                );
                if($this->current_model->add_commission($data)==true){
                    exit(json_encode(array('type'=>'success', 'text'=>'Successfully Inserted')));
                }else{
                    exit(json_encode(array('type'=>'error', 'text'=>'Server Error.!')));
                }
            }
        }
    }
    public function commission_action_table($status, $id){
        if($status>0){$checked="checked";}else{$checked="";}
        $btn="<div class='_wtRange'>
        <small class='fs_11'>Approve </small><div class='form-check form-switch mb-0'><input type='checkbox' ".$checked." onclick=commission_status_data('".$id."') id='".$id."_status' class='form-check-input'><label class='form-check-label p-0' for='".$id."_status'></label></div></div>";
        return $btn.'<div class="btn-group">
            <button class="btn btn-sm btn-success" onclick="update_all_details('.$id.')"><i class="fa fa-edit"></i></button>
            <button class="btn btn-sm btn-danger" onclick="delete_media('.$id.')"><i class="fa fa-trash"></i></button>
        </div>';
    }
    public function fetch_all_commission(){
        $draw=intval($this->input->post("draw"));
        $data=array();
        $data_list=$this->current_model->fetch_all_commission();
        foreach($data_list['data'] as $row) {
            $sub_array=array();
            $sub_array[]='<p>'.$row->min_price.'</p>';
            $sub_array[]='<p>'.$row->max_price.'</p>';
            $sub_array[]='<p>'.$row->commission.'</p>';
            $sub_array[]=$this->commission_action_table($row->status, $row->id);
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
    public function update_commission_fetch(){
        exit(json_encode($this->current_model->update_commission_fetch($this->input->post('id'))));
    }
    public function update_commission(){
        if(empty($this->input->post('id')) || empty($this->input->post('max_price'))){
            exit(json_encode(array('type'=>'warning','text'=>'Fill required fields!')));
        }else{
            if($this->input->post('min_price')>$this->input->post('max_price')){
                exit(json_encode(array('type'=>'error', 'text'=>'Min Price should be less than Max Price.!')));
            }else{
                $data=array(
                    'min_price'=>$this->input->post('min_price'),
                    'max_price'=>$this->input->post('max_price'),
                    'commission'=>$this->input->post('commission'),
                    'create_by'=>$this->session->userdata('admin_id'),
                    'create_date'=>date('Y-m-d H:i:s')
                );
                if($this->current_model->update_commission($this->input->post('id'), $data)==true){
                    exit(json_encode(array('type'=>'success', 'text'=>'Successfully Updated')));
                }else{
                    exit(json_encode(array('type'=>'error', 'text'=>'Error.!')));
                }
            }
        }
    }
    public function commission_status_data(){
        if($this->input->post('id')!="" && $this->input->post('status')!=""){
            if($this->current_model->commission_status_data($this->input->post('id'), $this->input->post('status'))){
                exit(json_encode(array('type'=>'success', 'text'=>'successfully status updated')));
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'something went wrong!')));
            }
        }
    }
    public function delete_commission(){
        exit(json_encode($this->current_model->delete_commission($this->input->post('id'))));
    }
    
    
    ///////////////////subscription///////////////////////
    public function subscription(){
        if($this->session->userdata('admin_role')=="superadmin"){
            $data['session_data']=$this->session->all_userdata();
            $data['csrfHash']=$this->security->get_csrf_hash();
            $data['csrfName']=$this->security->get_csrf_token_name();
            $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
            $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
            $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
            $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
            $this->load->view('elecxtra_admin/setting/admin_view_subscription',$data);
        }else{
            exit("Access denied!");
        }
    }
    public function add_subscription(){
        if(empty($this->input->post('plan_name')) || empty($this->input->post('plan_price'))){
            exit(json_encode(array('type'=>'warning','text'=>'Fill required fields!')));
        }else{
            $data=array(
                'plan_name'=>$this->input->post('plan_name'),
                'plan_price'=>$this->input->post('plan_price'),
                'plan_description'=>$this->input->post('plan_description'),
                'create_by'=>$this->session->userdata('admin_id'),
                'create_date'=>date('Y-m-d H:i:s')
            );
            if($this->current_model->add_subscription($data)==true){
                exit(json_encode(array('type'=>'success', 'text'=>'Successfully Inserted')));
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'Server Error.!')));
            }
        }
    }
    public function subscription_action_table($status, $id){
        if($status>0){$checked="checked";}else{$checked="";}
        $btn="<div class='_wtRange'>
        <small class='fs_11'>Approve </small><div class='form-check form-switch mb-0'><input type='checkbox' ".$checked." onclick=subscription_status_data('".$id."') id='".$id."_status' class='form-check-input'><label class='form-check-label p-0' for='".$id."_status'></label></div></div>";
        return $btn.'<div class="btn-group">
            <button class="btn btn-sm btn-success" onclick="update_all_details('.$id.')"><i class="fa fa-edit"></i></button>
            <button class="btn btn-sm btn-danger" onclick="delete_media('.$id.')"><i class="fa fa-trash"></i></button>
        </div>';
    }
    public function fetch_all_subscription(){
        $draw=intval($this->input->post("draw"));
        $data=array();
        $data_list=$this->current_model->fetch_all_subscription();
        foreach($data_list['data'] as $row) {
            $sub_array=array();
            $sub_array[]='<p style="width:150px;">'.$row->plan_name.'</p>';
            $sub_array[]='<p style="width:150px;">'.$row->plan_price.'</p>';
            $sub_array[]='<p>'.nl2br($row->plan_description).'</p>';
            $sub_array[]=$this->subscription_action_table($row->status, $row->id);
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
    public function update_subscription_fetch(){
        exit(json_encode($this->current_model->update_subscription_fetch($this->input->post('id'))));
    }
    public function update_subscription(){
        if(empty($this->input->post('id')) || empty($this->input->post('plan_name')) || empty($this->input->post('plan_price'))){
            exit(json_encode(array('type'=>'warning','text'=>'Fill required fields!')));
        }else{
            $data=array(
                'plan_name'=>$this->input->post('plan_name'),
                'plan_price'=>$this->input->post('plan_price'),
                'plan_description'=>$this->input->post('plan_description'),
                'create_by'=>$this->session->userdata('admin_id'),
                'create_date'=>date('Y-m-d H:i:s')
            );
            if($this->current_model->update_subscription($this->input->post('id'), $data)==true){
                exit(json_encode(array('type'=>'success', 'text'=>'Successfully Updated')));
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'Error.!')));
            }
        }
    }
    public function subscription_status_data(){
        if($this->input->post('id')!="" && $this->input->post('status')!=""){
            if($this->current_model->subscription_status_data($this->input->post('id'), $this->input->post('status'))){
                exit(json_encode(array('type'=>'success', 'text'=>'successfully status updated')));
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'something went wrong!')));
            }
        }
    }
    public function delete_subscription(){
        exit(json_encode($this->current_model->delete_subscription($this->input->post('id'))));
    }
    
    

}
