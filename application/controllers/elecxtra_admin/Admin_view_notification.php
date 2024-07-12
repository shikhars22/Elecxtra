<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_view_notification extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if($this->session->has_userdata('admin_id')==FALSE){
            redirect(base_url('admin'));
        }
        $this->load->library('email');
        $this->load->library('form_validation');
        $this->load->model('elecxtra_admin/admin_view_notification_model');
    }
    public function index(){
        $data['session_data']=$this->session->all_userdata();
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
        $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
        $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
        $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
        $this->load->view('elecxtra_admin/notification/admin_view_contact',$data);
    }
    public function email_data(){
        $data['session_data']=$this->session->all_userdata();
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
        $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
        $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
        $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
        $this->load->view('elecxtra_admin/notification/admin_view_email',$data);
    }
    public function fetch_all_contact(){
        $draw = intval($this->input->post("draw"));
        $data = array();
        $data_list = $this->admin_view_notification_model->fetch_all_contact();
        foreach($data_list['data'] as $p) {
            $sub_array = array();
            $sub_array[] = $p->name;
            $sub_array[] = $p->company_name;
            $sub_array[] = $p->email;
            $sub_array[] = $p->phone;
            $sub_array[] = $p->designation;
            $sub_array[] = $p->address;
            $sub_array[] = $p->message;
            $sub_array[] = date('l, d M, Y', strtotime($p->create_date));
            $sub_array[] = '<div class="btn-group">
                                <button class="btn btn-sm btn-danger" onclick="delete_contact('.$p->id.')"><i class="fa fa-trash"></i> Delete</button>
                            </div>';
            $data[]=$sub_array;
        }
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $data_list['recordsTotal'],
            "recordsFiltered" => $data_list['recordsFiltered'],
            "data" => $data
        );
        exit(json_encode($output));
    }
    public function delete_contact(){
        exit(json_encode($this->admin_view_notification_model->delete_contact($this->input->post('id'))));
    }
    public function fetch_all_email(){
        $draw = intval($this->input->post("draw"));
        $data = array();
        $data_list = $this->admin_view_notification_model->fetch_all_email();
        foreach($data_list['data'] as $p) {
            $sub_array = array();
            $sub_array[] = $p->email_from;
            $sub_array[] = implode("<br>",explode(",", $p->email_to));
            $sub_array[] = $p->email_subject;
            $sub_array[] = $p->email_message;
            $sub_array[] = $p->create_date;
            $sub_array[] = "<div class='btn-group'><button class='btn btn-sm btn-primary' onclick='resend_email(".$p->id.")'>Edit & Resend</button><button class='btn btn-sm btn-danger' onclick='delete_send_email(".$p->id.")'>Delete</button></div>";
            $data[]=$sub_array;
        }
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $data_list['recordsTotal'],
            "recordsFiltered" => $data_list['recordsFiltered'],
            "data" => $data
        );
        exit(json_encode($output));
    }
    public function send_email(){
        $this->form_validation->set_rules('email_to', 'To', 'trim|required');
        $this->form_validation->set_rules('email_from', 'From', 'trim|required');
        $this->form_validation->set_rules('email_subject', 'Subject', 'trim|required');
        $this->form_validation->set_rules('email_message', 'Message', 'trim|required');
        if ($this->form_validation->run() == FALSE){
            exit(json_encode(array('type'=>'warning','text'=>validation_errors())));
        }
        else{
            $data=array(
                'email_to' => $this->input->post('email_to'),
                'email_from' => $this->input->post('email_from'),
                'email_subject' => $this->input->post('email_subject'),
                'email_message' => $this->input->post('email_message'),
            );
            //sending email
            $config['mailtype'] = 'html';
            $this->email->initialize($config);
            $this->email->from($data['email_from'], 'Ride Collie');
            $this->email->to($data['email_from']);
            $this->email->bcc($data['email_to']);
            $this->email->subject($data['email_subject']);
            $this->email->message($data['email_message']);
            $this->email->send();
            if($this->admin_view_notification_model->save_send_email($data)==true){
                exit(json_encode(array('type'=>'success', 'text'=>'Successfully Send & Saved Your Email')));
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'Server Error.!')));
            }
        }
    }
    public function get_saved_email_fetch(){
        exit(json_encode($this->admin_view_notification_model->get_saved_email_fetch($this->input->post('id'))));
    }
    public function delete_send_email(){
        exit(json_encode($this->admin_view_notification_model->delete_send_email($this->input->post('id'))));
    }

}