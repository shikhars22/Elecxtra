<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_view_media extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if($this->session->has_userdata('admin_id')==FALSE){
            redirect(base_url('admin'));
        }
        $this->load->library('form_validation');
        $this->load->model('elecxtra_admin/admin_view_media_model', 'current_model');
    }

    ///////////////////BANNER///////////////////////
    public function banner(){
        $data['session_data']=$this->session->all_userdata();
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
        $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
        $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
        $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
        $this->load->view('elecxtra_admin/media/admin_view_banner',$data);
    }
    public function add_banner(){
        if(empty($this->input->post('image')) && empty($this->input->post('vdo')) && empty($this->input->post('youtube_link'))){
            exit(json_encode(array('type'=>'warning','text'=>'Media is required!')));
        }else{
            $data=array(
                'title'=>preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $this->input->post('name'))),
                'name'=>$this->input->post('name'),
                'button_1'=>$this->input->post('button_1'),
                'button_2'=>$this->input->post('button_2'),
                'button_1_link'=>$this->input->post('button_1_link'),
                'button_2_link'=>$this->input->post('button_2_link'),
                'vdo'=>$this->input->post('vdo'),
                'youtube_link'=>$this->input->post('youtube_link'),
                'page'=>$this->input->post('page'),
                'description'=>$this->input->post('description'),
                'position'=>$this->input->post('position'),
                'create_by'=>$this->session->userdata('admin_id'),
                'create_date'=>date('Y-m-d H:i:s')
            );
            if(!empty($this->input->post('image'))){
                $folder='./uploads/media/banner/';
                if(!is_dir($folder)){ mkdir($folder, 0755, true); }
                $img_data=$this->input->post('image');
                $image_array_1=explode(";", $img_data);
                $image_array_2=explode(",", $image_array_1[1]);
                $img_data=base64_decode($image_array_2[1]);
                $image_name=time().'.'.$this->input->post('img_extention');
                if(file_put_contents($folder.$image_name, $img_data)!== false){
                    $data['img']="banner/".$image_name;
                }
            }
            if($this->current_model->add_banner($data)==true){
                exit(json_encode(array('type'=>'success', 'text'=>'Successfully Inserted')));
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'Server Error.!')));
            }
        }
    }
    public function banner_action_table($status, $id){
        if($status>0){$checked="checked";}else{$checked="";}
        $btn="<div class='_wtRange'><small class='fs_11'>Approve </small><div class='form-check form-switch mb-0'><input type='checkbox' ".$checked." onclick=banner_status_data('".$id."') id='".$id."_status' class='form-check-input'><label class='form-check-label p-0' for='".$id."_status'></label></div></div>";
        return $btn.'<div class="btn-group">
            <button class="btn btn-sm btn-success" onclick="update_all_details('.$id.')"><i class="fa fa-edit"></i></button>
            <button class="btn btn-sm btn-danger" onclick="delete_media('.$id.')"><i class="fa fa-trash"></i></button>
        </div>';
    }
    public function fetch_all_banner(){
        $draw=intval($this->input->post("draw"));
        $data=array();
        $data_list=$this->current_model->fetch_all_banner();
        foreach($data_list['data'] as $row) {
            $sub_array=array();
            if(!empty($row->img)){
                $sub_array[]='<img src='.base_url("uploads/media/").$row->img.' style="width:100px;">';
            }else{
                if(!empty($row->vdo)){
                    $sub_array[]='<video src="'.base_url("uploads/uploader/").$row->vdo.'" style="width:200px; height:100px;" controls></video>';
                }else{
                    if(!empty($row->youtube_link)){
                        $sub_array[]='<iframe src="'.$row->youtube_link.'" title="'.$row->name.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                    }else{
                        $sub_array[]='No Media Found!';
                    }
                }
            }
            $sub_array[]=ucwords($row->page);
            $sub_array[]='<p class="clip_txt_2 showFullTxt">'.$row->name.'</p>';
            $sub_array[]='<p class="clip_txt_3 showFullTxt">'.$row->description.'</p>';
            $sub_array[]=$this->banner_action_table($row->status, $row->id);
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
    public function update_banner_fetch(){
        exit(json_encode($this->current_model->update_banner_fetch($this->input->post('id'))));
    }
    public function update_banner(){
        $this->form_validation->set_rules('id', 'ID', 'trim|required');
        if($this->form_validation->run() == FALSE){
            exit(json_encode(array('type'=>'warning','text'=>validation_errors())));
        }else{
            $data=array(
                'title'=>preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $this->input->post('name'))),
                'name'=>$this->input->post('name'),
                'button_1'=>$this->input->post('button_1'),
                'button_2'=>$this->input->post('button_2'),
                'button_1_link'=>$this->input->post('button_1_link'),
                'button_2_link'=>$this->input->post('button_2_link'),
                'vdo'=>$this->input->post('vdo'),
                'youtube_link'=>$this->input->post('youtube_link'),
                'page'=>$this->input->post('page'),
                'description'=>$this->input->post('description'),
                'position'=>$this->input->post('position'),
                'edit_by'=>$this->session->userdata('admin_id'),
                'edit_date'=>date('Y-m-d H:i:s')
            );
            if(!empty($this->input->post('image'))){
                $folder='./uploads/media/banner/';
                if(!is_dir($folder)){ mkdir($folder, 0755, true); }
                $img_data=$this->input->post('image');
                $image_array_1=explode(";", $img_data);
                $image_array_2=explode(",", $image_array_1[1]);
                $img_data=base64_decode($image_array_2[1]);
                $image_name=time().'.'.$this->input->post('img_extention');
                if(file_put_contents($folder.$image_name, $img_data)!== false){
                    $data['img']="banner/".$image_name;
                }
            }
            if($this->current_model->update_banner($this->input->post('id'), $data)==true){
                exit(json_encode(array('type'=>'success', 'text'=>'Successfully Updated')));
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'Error.!')));
            }
        }
    }
    public function banner_status_data(){
        if($this->input->post('id')!="" && $this->input->post('status')!=""){
            if($this->current_model->banner_status_data($this->input->post('id'), $this->input->post('status'))){
                exit(json_encode(array('type'=>'success', 'text'=>'successfully status updated')));
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'something went wrong!')));
            }
        }
    }
    public function delete_banner(){
        exit(json_encode($this->current_model->delete_banner($this->input->post('id'))));
    }
    
    

}
