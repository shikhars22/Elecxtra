<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_product_family extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if($this->session->has_userdata('admin_id')==FALSE){
            redirect(base_url('admin'));
        }
        $this->load->library('form_validation');
        $this->load->model('elecxtra_admin/Admin_product_family_model', 'current_model');
    }

    ////////////////////ALL VIEW///////////////////////////
    public function index(){
        $data['session_data']=$this->session->all_userdata();
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
        $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
        $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
        $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
        $this->load->view('elecxtra_admin/product/product_family',$data);
    }
    /*************category****************/
    public function fetch_category(){
        exit(json_encode($this->current_model->fetch_category()));
    }
    public function add_category(){
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        if ($this->form_validation->run() == FALSE){
            exit(json_encode(array('type'=>'warning','text'=>validation_errors())));
        }else{
            $data=array(
                'name' => $this->input->post('name'),
                'title'=>strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', ($this->input->post('name'))))),
                'status'=>1,
                'create_date'=>date('Y-m-d H:i:s'),
            );
            if($this->current_model->add_category($data)){
                exit(json_encode(array('type'=>'success', 'text'=>'Successfully Added')));
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'Server Error.!')));
            }
        }
    }
    /*************sub_category****************/
    public function fetch_sub_category(){
        exit(json_encode($this->current_model->fetch_sub_category($this->input->post('cat_id'))));
    }
    public function add_sub_category(){
        $this->form_validation->set_rules('cat_id', 'Cat Id', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        if ($this->form_validation->run() == FALSE){
            exit(json_encode(array('type'=>'warning','text'=>validation_errors())));
        }else{
            $data=array(
                'cat_id' => $this->input->post('cat_id'),
                'name' => $this->input->post('name'),
                'title'=>strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', ($this->input->post('name'))))).'-'.$this->input->post('cat_id'),
                'status'=>1,
                'create_date'=>date('Y-m-d H:i:s'),
            );
            if($this->current_model->add_sub_category($data)){
                exit(json_encode(array('type'=>'success', 'text'=>'Successfully Added')));
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'Server Error.!')));
            }
        }
    }
    /*************item_category****************/
    public function fetch_item(){
        exit(json_encode($this->current_model->fetch_item($this->input->post('sub_cat_id'))));
    }
    public function add_item(){
        $this->form_validation->set_rules('sub_cat_id', 'SubCat Id', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        if ($this->form_validation->run() == FALSE){
            exit(json_encode(array('type'=>'warning','text'=>validation_errors())));
        }else{
            $data=array(
                'sub_cat_id' => $this->input->post('sub_cat_id'),
                'name' => $this->input->post('name'),
                'title'=>strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', ($this->input->post('name'))))).'-'.$this->input->post('sub_cat_id'),
                'status'=>1,
                'create_date'=>date('Y-m-d H:i:s'),
            );
            if($this->current_model->add_item($data)){
                exit(json_encode(array('type'=>'success', 'text'=>'Successfully Added')));
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'Server Error.!')));
            }
        }
    }
    public function each_save_data(){
        $array=array('category','sub_category','item');
        if(in_array($this->input->post('type'), $array) && !empty($this->input->post('id')) && !empty($this->input->post('val'))){
            if($this->current_model->each_save_data($this->input->post('type'), $this->input->post('id'), $this->input->post('val'))){
                exit(json_encode(array('type'=>'success', 'text'=>'Successfully Updated')));
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'Server Error.!')));
            }
        }else{
            exit(json_encode(array('type'=>'error', 'text'=>'something went wrong!')));
        }
    }
    public function delete_check(){
        $data=$this->current_model->delete_check($this->input->post('id'), $this->input->post('type'));
        exit(json_encode(array('type'=>'success', 'products'=>$data)));
    }
    public function delete_parmanent(){
        if($this->current_model->delete_parmanent($this->input->post('id'), $this->input->post('type'))){
            exit(json_encode(array('type'=>'success', 'text'=>'Successfully Deleted!')));
        }else{
            exit(json_encode(array('type'=>'error', 'text'=>'something went wrong!')));
        }
    }



}
