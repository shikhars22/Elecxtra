<?php defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once(APPPATH."libraries/php_email/vendor/autoload.php");

class Admin_seller extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if($this->session->has_userdata('admin_id')==FALSE){
            redirect(base_url('admin'));
        }
        $this->load->model('elecxtra_admin/admin_seller_model', 'current_model');
    }
    public function send_email($data){
        /*$data=array(
            'smtp_host'=>$smtp_host,
            'smtp_user'=>$smtp_user,
            'smtp_pass'=>$smtp_pass,
            'from'=>$from,
            'from_name'=>$from_name,
            'to'=>$to,
            'to_name'=>$to_name,
            'reply_to'=>$reply_to,
            'reply_to_name'=>$reply_to_name,
            'subject'=>$subject,
            'html'=>$html,
        );*/
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = false;                                   //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $data['smtp_host'];                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $data['smtp_user'];                     //SMTP username
            $mail->Password   = $data['smtp_pass'];                     //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom($data['from'], $data['from_name']);
            $mail->addAddress($data['to'], $data['to_name']);           //Add a recipient
            // $mail->addAddress('ellen@example.com');                  //Name is optional
            $mail->addReplyTo($data['reply_to'], $data['reply_to_name']);
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
        
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');            //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');       //Optional name
        
            //Content
            $mail->isHTML(true);                                        //Set email format to HTML
            $mail->Subject = $data['subject'];
            $mail->Body    = $data['html'];
            $mail->AltBody = '';
        
            $response=$mail->send();
            $mail->clearAddresses();
            $mail->clearAttachments();
            if($response){
                return true;
            }else{
                return false;
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        
    }
    
    public function pending_seller(){
        if($this->session->userdata('admin_role')=='superadmin'){
            $data['status']="hold";
            $data['session_data']=$this->session->all_userdata();
            $data['csrfHash']=$this->security->get_csrf_hash();
            $data['csrfName']=$this->security->get_csrf_token_name();
            $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
            $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
            $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
            $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
            $this->load->view('elecxtra_admin/seller/all_seller', $data);
        }else{
            exit("Access denied!");
        }
    }
    public function approved_seller(){
        if($this->session->userdata('admin_role')=='superadmin'){
            $data['status']="approved";
            $data['session_data']=$this->session->all_userdata();
            $data['csrfHash']=$this->security->get_csrf_hash();
            $data['csrfName']=$this->security->get_csrf_token_name();
            $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
            $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
            $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
            $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
            $this->load->view('elecxtra_admin/seller/all_seller', $data);
        }else{
            exit("Access denied!");
        }
    }
    public function rejected_seller(){
        if($this->session->userdata('admin_role')=='superadmin'){
            $data['status']="rejected";
            $data['session_data']=$this->session->all_userdata();
            $data['csrfHash']=$this->security->get_csrf_hash();
            $data['csrfName']=$this->security->get_csrf_token_name();
            $data['link_script']=$this->load->view('elecxtra_admin_includes/admin_link_script', array('session_data'=>$data['session_data']), TRUE);
            $data['header']=$this->load->view('elecxtra_admin_includes/admin_header', array('session_data'=>$data['session_data']), TRUE);
            $data['left_nav']=$this->load->view('elecxtra_admin_includes/admin_left_nav', array('session_data'=>$data['session_data']), TRUE);
            $data['right_nav']=$this->load->view('elecxtra_admin_includes/admin_right_nav', array('session_data'=>$data['session_data']), TRUE);
            $this->load->view('elecxtra_admin/seller/all_seller', $data);
        }else{
            exit("Access denied!");
        }
    }

    public function fetch_all_seller(){
        $draw=intval($this->input->post("draw"));
        $start=intval($this->input->post("start"));
        $length=intval($this->input->post("length"));
        $search=trim(strip_tags($this->input->post("search")['value']));
        $order=$this->input->post("order")[0];
        $filter=$this->input->post("columns");
        $data=array();
        $data_list=$this->current_model->fetch_all_seller($this->input->post('status'), $start, $length, $search, $order, $filter);
        foreach($data_list['data'] as $row) {
            $sub_array=array();
            
            $sub_array[]=$row->id;
            $sub_array[]="<div class='_wtDtInfo clip_txt_1'><p>".$row->user_code."</p><p class='text-primary fs_12'><b>Plan: </b>".$row->subscription_plan."</p></div>";
            $sub_array[]="<div class='_wtDtInfo clip_txt_1'><p class='fs_15 showFullTxt'>".$row->user_name."</p><p class='fs_11 clip_txt_2 showFullTxt clip_txt_2'><code>".$row->reject_note."</code></p></div>";
            $sub_array[]="<div class='_wtDtInfo showFullHtml'><p class='fs_13'><i class='fa fa-phone-alt pe-2 txt_grey'></i>".$row->user_phone."</p><p class='fs_13'><i class='fa fa-envelope pe-2 txt_grey'></i>".$row->user_email."</p></div>";

            $attach_list="";
            $all_attachment=explode("|", $row->user_attachment);
            for ($i=0; $i < count($all_attachment); $i++) { 
                $attach_list.="<p class='fs_13 clip_txt_2'><i class='fa fa-file pe-2 txt_grey'></i><a href='".base_url('uploads/seller/attachments/'.$all_attachment[$i])."' target='_blank'>".$all_attachment[$i]."</a></p>";
            }
            $sub_array[]="<div class='_wtDtInfo'>".$attach_list."</div>";

            $sub_array[]="<div class='_wtDtInfo showFullHtml'><p class='fs_13 clip_txt_2'>".$row->user_address."</p></div>";
            $sub_array[]="<div class='_wtDtInfo showFullHtml'><p class='fs_15 clip_txt_1'>".$row->company_name."</p><p class='fs_13 clip_txt_1 txt_grey'>".$row->company_type."</p></div>";
            $sub_array[]="<div class='_wtDtInfo showFullHtml'><p class='fs_13 clip_txt_2'>Products: ".$row->total_product." Orders: ".$row->order_count."</p><p class='fs_13 clip_txt_2'>Cancels: ".$row->cancel_count." Return: ".$row->return_count."</p><p class='fs_13 clip_txt_2'>Sale: ".$row->sale_count." Revenue: ".$row->total_revenue."</p></div>";
            $sub_array[]="<div class='_wtDtInfo'><p class='fs_13'>".date('d M, Y', strtotime($row->create_date))."<br><span class='fs_12 txt_grey'>".date('h:i a', strtotime($row->create_date))."</span></p></div>";

            $sub_array[]="<div class='_actionBox'>
                <button class='_wtBtnSm _actionBtn m-auto' type='button'><img src='".base_url('admin_assets/images/dots.svg')."'></button>
                <ul class='_actionList'>
                    <li data-id='".$row->id."' data-subscription_plan='".$row->subscription_plan."' data-expire_month_count='".$row->expire_month_count."' onclick=approve_data(this)><a href='javascript:void(0)'><i class='fa fa-check me-2'></i> Approve</a></li>
                    <li onclick=reject_data('".$row->id."')><a href='javascript:void(0)'><i class='fa fa-times me-2'></i> Reject</a></li>
                    ".($row->status=='rejected'?"<li onclick=delete_data_permanent('".$row->id."')><a href='javascript:void(0)'><i class='fa fa-trash me-2'></i> Delete</a></li>":"")."
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
    public function delete_permanently_data(){
        if($this->session->userdata('admin_role')=='superadmin'){
            if($this->input->post('id')!=""){
                if($this->current_model->delete_permanently_data($this->input->post('id'))){
                    exit(json_encode(array('type'=>'success', 'text'=>'seller deleted permanently!')));
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
            if(empty($this->input->post('id'))){
                exit(json_encode(array('type'=>'error', 'text'=>'something went wrong! Id is missing!')));
            }else{
                $data=$this->current_model->approve_data($this->input->post('id'));
                if($data['type']=='success'){
                    $user_name=$data['user_name'];
                    $user_phone=$data['user_phone'];
                    $user_email=$data['user_email'];
                    if(!empty($user_email)){
                        $user_subject="Your seller account is approved in ".site_title();
                        $user_message='
                        <div style="font-family:Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
                          <div style="margin:50px auto;width:70%;padding:20px 0">
                            <div style="border-bottom:1px solid #eee">
                              <a href="" style="font-size:1.4em;color:#00466a;text-decoration:none;font-weight:600">'.site_title().'</a>
                            </div>
                            <p style="font-size:1.1em">Hi '.$user_name.', Your seller account is approved in '.site_title().'</p>
                            <p>Your are now able to login your seller admin panel.</p>
                            <p><a href="'.base_url('admin').'">Admin Seller Login</a></p>
                            <p style="font-size:0.9em;">Regards,<br />'.site_title().'</p>
                            <hr style="border:none;border-top:1px solid #eee" />
                            <div style="float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300">
                              <p>'.site_title().'</p>
                              <p>'.get_email_name('info').'</p>
                              <p>'.get_phone_list(1).'</p>
                              <p><a href="'.base_url().'"><img style="max-width:150px;" src="'.base_url('viewer_assets/images/logo.png').'"></a></p>
                            </div>
                          </div>
                        </div>';
                        $data=array(
                            'smtp_host'=>get_email_host(),
                            'smtp_user'=>get_email_name('info'),
                            'smtp_pass'=>get_email_pass('info'),
                            'from'=>get_email_name('info'),
                            'from_name'=>site_title(),
                            'to'=>$user_email,
                            'to_name'=>$user_name,
                            'reply_to'=>get_email_name('support'),
                            'reply_to_name'=>site_title(),
                            'subject'=>$user_subject,
                            'html'=>$user_message,
                        );
                        if($this->send_email($data)){
                            exit(json_encode(array('type'=>'success', 'text'=>'seller approved!')));
                        }else{
                            exit(json_encode(array('type'=>'error', 'text'=>'something went wrong!')));
                        }
                    }
                }
            }
        }else{
            exit("Access denied!");
        }
    }
    public function reject_data(){
        if($this->session->userdata('admin_role')=='superadmin'){
            if($this->input->post('id')!="" && $this->input->post('reject_note')!=""){
                $data=$this->current_model->reject_data($this->input->post('id'), $this->input->post('reject_note'));
                if($data['type']=='success'){
                    /*send email*/
                    $this->load->library('email');
                    $config = array(
                        'protocol' =>   'SMTP',
                        'smtp_host' => get_email_host(),
                        'smtp_port' => 465,
                        'priority'  => 1,
                        'smtp_user' => get_email_name('info'), // change it to yours
                        'smtp_pass' => get_email_pass('info'), // change it to yours
                        'mailtype' => 'html',
                        'charset' => 'iso-8859-1',
                        'wordwrap' => TRUE
                    );
                    $this->email->initialize($config);
                    
                    $user_name=$data['user_name'];
                    $user_phone=$data['user_phone'];
                    $user_email=$data['user_email'];
                    $user_subject="Your seller account is rejected from ".site_title();
                    $user_message="<h4>Hello $user_name, your seller account is rejected from ".site_title().".</h3><h5>Read the reason below:</h5><div><p>".$this->input->post('reject_note')."</p></div><br><br><br><br>Thanks,<br>".site_title()."<br><a href='".base_url()."'><img src='".base_url('viewer_assets/images/logo.png')."'  style='width:150px;'>";
                    $this->email->from(get_email_name('info'), site_title());
                    $this->email->to($user_email);
                    $this->email->subject($user_subject);
                    $this->email->message($user_message);
                    $user_send=$this->email->send();
                    /*end send email*/
                    exit(json_encode(array('type'=>'success', 'text'=>'seller rejected!')));
                }else{
                    exit(json_encode(array('type'=>'error', 'text'=>'something went wrong!')));
                }
            }
        }else{
            exit("Access denied!");
        }
    }



}
