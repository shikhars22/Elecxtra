<?php defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once(APPPATH."libraries/php_email/vendor/autoload.php");

class Elecxtra_page extends CI_Controller {
    public function __construct(){
        parent::__construct(); 
        $this->load->library('form_validation');
        $this->load->model('elecxtra_web/Elecxtra_page_model', 'current_model');
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
    public function visitor_count(){
        $ref_id=$this->input->post('ref_id');
        $ip_address=$_SERVER['REMOTE_ADDR'];
        $view_date=date('Y-m-d');
        exit(json_encode($this->current_model->visitor_count($ref_id, $ip_address, $view_date)));
    }
    /***********************CAPCHA GENERATE DATA********************/
    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function contact_reload_captcha(){
        $captcha['word']=$this->generateRandomString(6);
        $captcha['image']='<input type="text" readonly value="'.$captcha['word'].'">';
        $this->session->set_tempdata('contact_captcha', $captcha['word'], 600);
        echo $captcha['image']."<span onclick='reload_captcha()' class='reload_icn'>&#8635;<span>";
    }
    public function career_reload_captcha(){
        $captcha['word']=$this->generateRandomString(6);
        $captcha['image']='<input type="text" readonly value="'.$captcha['word'].'">';
        $this->session->set_tempdata('career_captcha', $captcha['word'], 600);
        echo $captcha['image']."<span onclick='reload_captcha()' class='reload_icn'>&#8635;<span>";
    }
    /***********************CAPCHA GENERATE DATA********************/

    public function index(){
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_scripts']=$this->load->view('elecxtra_web_includes/link_script', NULL, TRUE);
        $data['header']=$this->load->view('elecxtra_web_includes/header', NULL, TRUE);
        $data['navigation']=$this->load->view('elecxtra_web_includes/navigation', NULL, TRUE);
        $data['footer']=$this->load->view('elecxtra_web_includes/footer', array('csrfName'=>$data['csrfName'], 'csrfHash'=>$data['csrfHash']), TRUE);
        $data['footer_bottom']=$this->load->view('elecxtra_web_includes/footer_bottom', NULL, TRUE);
        $this->load->view('elecxtra_web/home', $data);
    }
    public function about_us(){
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_scripts']=$this->load->view('elecxtra_web_includes/link_script', NULL, TRUE);
        $data['header']=$this->load->view('elecxtra_web_includes/header', NULL, TRUE);
        $data['navigation']=$this->load->view('elecxtra_web_includes/navigation', NULL, TRUE);
        $data['footer']=$this->load->view('elecxtra_web_includes/footer', array('csrfName'=>$data['csrfName'], 'csrfHash'=>$data['csrfHash']), TRUE);
        $data['footer_bottom']=$this->load->view('elecxtra_web_includes/footer_bottom', NULL, TRUE);
        $this->load->view('elecxtra_web/about_us', $data);
    }
    public function terms_condition(){
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_scripts']=$this->load->view('elecxtra_web_includes/link_script', NULL, TRUE);
        $data['header']=$this->load->view('elecxtra_web_includes/header', NULL, TRUE);
        $data['navigation']=$this->load->view('elecxtra_web_includes/navigation', NULL, TRUE);
        $data['footer']=$this->load->view('elecxtra_web_includes/footer', array('csrfName'=>$data['csrfName'], 'csrfHash'=>$data['csrfHash']), TRUE);
        $data['footer_bottom']=$this->load->view('elecxtra_web_includes/footer_bottom', NULL, TRUE);
        $this->load->view('elecxtra_web/terms_condition', $data);
    }
    public function privacy_policy(){
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_scripts']=$this->load->view('elecxtra_web_includes/link_script', NULL, TRUE);
        $data['header']=$this->load->view('elecxtra_web_includes/header', NULL, TRUE);
        $data['navigation']=$this->load->view('elecxtra_web_includes/navigation', NULL, TRUE);
        $data['footer']=$this->load->view('elecxtra_web_includes/footer', array('csrfName'=>$data['csrfName'], 'csrfHash'=>$data['csrfHash']), TRUE);
        $data['footer_bottom']=$this->load->view('elecxtra_web_includes/footer_bottom', NULL, TRUE);
        $this->load->view('elecxtra_web/privacy_policy', $data);
    }
    public function refund_cancellation(){
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_scripts']=$this->load->view('elecxtra_web_includes/link_script', NULL, TRUE);
        $data['header']=$this->load->view('elecxtra_web_includes/header', NULL, TRUE);
        $data['navigation']=$this->load->view('elecxtra_web_includes/navigation', NULL, TRUE);
        $data['footer']=$this->load->view('elecxtra_web_includes/footer', array('csrfName'=>$data['csrfName'], 'csrfHash'=>$data['csrfHash']), TRUE);
        $data['footer_bottom']=$this->load->view('elecxtra_web_includes/footer_bottom', NULL, TRUE);
        $this->load->view('elecxtra_web/refund_cancellation', $data);
    }
    public function shipping_delivery_policy(){
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_scripts']=$this->load->view('elecxtra_web_includes/link_script', NULL, TRUE);
        $data['header']=$this->load->view('elecxtra_web_includes/header', NULL, TRUE);
        $data['navigation']=$this->load->view('elecxtra_web_includes/navigation', NULL, TRUE);
        $data['footer']=$this->load->view('elecxtra_web_includes/footer', array('csrfName'=>$data['csrfName'], 'csrfHash'=>$data['csrfHash']), TRUE);
        $data['footer_bottom']=$this->load->view('elecxtra_web_includes/footer_bottom', NULL, TRUE);
        $this->load->view('elecxtra_web/shipping_delivery_policy', $data);
    }
    public function support_center(){
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_scripts']=$this->load->view('elecxtra_web_includes/link_script', NULL, TRUE);
        $data['header']=$this->load->view('elecxtra_web_includes/header', NULL, TRUE);
        $data['navigation']=$this->load->view('elecxtra_web_includes/navigation', NULL, TRUE);
        $data['footer']=$this->load->view('elecxtra_web_includes/footer', array('csrfName'=>$data['csrfName'], 'csrfHash'=>$data['csrfHash']), TRUE);
        $data['footer_bottom']=$this->load->view('elecxtra_web_includes/footer_bottom', NULL, TRUE);
        $this->load->view('elecxtra_web/support_center', $data);
    }
    public function contact_us(){
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $captcha['word']=$this->generateRandomString(6);
        $captcha['image']='<input type="text" readonly value="'.$captcha['word'].'">';
        $this->session->set_tempdata('contact_captcha', $captcha['word'], 600);
        $data['captchaImg'] = $captcha['image']."<span onclick='reload_captcha()' class='reload_icn'>&#8635;<span>";
        $data['link_scripts']=$this->load->view('elecxtra_web_includes/link_script', NULL, TRUE);
        $data['header']=$this->load->view('elecxtra_web_includes/header', NULL, TRUE);
        $data['navigation']=$this->load->view('elecxtra_web_includes/navigation', NULL, TRUE);
        $data['footer']=$this->load->view('elecxtra_web_includes/footer', array('csrfName'=>$data['csrfName'], 'csrfHash'=>$data['csrfHash']), TRUE);
        $data['footer_bottom']=$this->load->view('elecxtra_web_includes/footer_bottom', NULL, TRUE);
        $this->load->view('elecxtra_web/contact_us', $data);
    }
    public function contact_form_data(){
        $this->form_validation->set_rules('captcha', 'Captcha', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email',  'trim|required|valid_email');
        $this->form_validation->set_rules('message', 'Message', 'trim|required');
        if ($this->form_validation->run() == FALSE) { 
            exit(json_encode(array('type'=>'warning','text'=>validation_errors())));
        }else{
            if($this->session->tempdata('contact_captcha')==$this->input->post('captcha')){
                $contact_data=array(
                    'name'=>$this->input->post('name'),
                    'email'=>$this->input->post('email'),
                    'phone'=>$this->input->post('phone'),
                    'message'=>$this->input->post('message')
                );
                
                if($this->current_model->contact_form_data($contact_data)){
                    $user_name=$contact_data['name'];
                    $user_email=$contact_data['email'];
                    $user_subject="Hello ".$user_name.", thank you for your interest in ".sort_title();
                    $user_message="<h3>Hello ".$user_name.", thank you for your interest in ".site_title().". We'll contact you soon!</h3>
                    <br><br><br><br>
                    <div>
                        <p>Kind Regards</p>
                        <p><b>Website: </b>".base_url()."</p>
                        <p><b>Email: </b>".get_email_name('info')."</p>
                        <p><b>Phone</b> ".get_phone_no(1)."</p>
                        <p><img src='".base_url('viewer_assets/images/logo.png')."' style='max-width:150px;'></p>
                        <p>".site_title()."</p>
                    </div>";
                    $data=array(
                        'smtp_host'=>get_email_host(),
                        'smtp_user'=>get_email_name('info'),
                        'smtp_pass'=>get_email_pass('info'),
                        'from'=>get_email_name('info'),
                        'from_name'=>site_title(),
                        'to'=>$user_email,
                        'to_name'=>$user_name,
                        'reply_to'=>get_email_name('info'),
                        'reply_to_name'=>site_title(),
                        'subject'=>$user_subject,
                        'html'=>$user_message,
                    );
                    $user_send_email=$this->send_email($data);

                    /*****To Admin*****/
                    $user_name=$contact_data['name'];
                    
                    $admin_name="Admin";
                    $admin_email=array(
                        get_email_name('info')=>'ElecxtraAdmin',
                    );
                    $admin_subject="Hello ".$admin_name.", A new message from ".$user_name." in ".sort_title();
                    $admin_message="
                    <h3>Hello ".$admin_name.",</h3>
                    <h3>".$user_name." has sent you a new message with below given details:</h3>
                    <div><p><b>Details: </b></p>
                        <p><b>Name: </b>".$contact_data['name']."</p>
                        <p><b>Email: </b>".$contact_data['email']."</p>
                        <p><b>Phone: </b>".$contact_data['phone']."</p>
                        <p><b>Message: </b>".$contact_data['message']."</p>
                    </div>
                    <br><br><br><br>
                    <div>
                        <p>Kind Regards</p>
                        <p><b>Website: </b>".base_url()."</p>
                        <p><b>Email: </b>".get_email_name('info')."</p>
                        <p><b>Phone</b> ".get_phone_no(1)."</p>
                        <p><img src='".base_url('viewer_assets/images/logo.png')."' style='max-width:150px;'></p>
                        <p>".site_title()."</p>
                    </div>";
                    $data=array(
                        'smtp_host'=>get_email_host(),
                        'smtp_user'=>get_email_name('info'),
                        'smtp_pass'=>get_email_pass('info'),
                        'from'=>get_email_name('info'),
                        'from_name'=>site_title(),
                        'to'=>$admin_email,
                        'to_name'=>$admin_name,
                        'reply_to'=>get_email_name('info'),
                        'reply_to_name'=>site_title(),
                        'subject'=>$admin_subject,
                        'html'=>$admin_message,
                    );
                    $admin_send_email=$this->send_email($data);
                    
                    if($user_send_email && $admin_send_email){
                        exit(json_encode(array('type'=>'success', 'text'=>'Message Sent Successfully')));
                    }

                }else{
                    exit(json_encode(array('type'=>'error', 'text'=>'something went wrong!')));
                }
            }else{
                exit(json_encode(array('type'=>'warning','text'=>'Captcha not matched!')));
            }
        }
    }
    


}