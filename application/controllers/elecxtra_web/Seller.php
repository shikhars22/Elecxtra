<?php defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once(APPPATH."libraries/php_email/vendor/autoload.php");

class Seller extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if($this->session->has_userdata('seller_id')==TRUE){
            $url=base_url('seller-profile');
            redirect($url);
        }
        $this->load->library('form_validation');
        $this->load->model('elecxtra_web/seller_model', 'current_model');
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
    //////////////////////Seller Login///////////////
    public function index(){
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
        $data['link_scripts']=$this->load->view('elecxtra_web_includes/link_script', NULL, TRUE);
        $data['header']=$this->load->view('elecxtra_web_includes/header', NULL, TRUE);
        $data['navigation']=$this->load->view('elecxtra_web_includes/navigation', NULL, TRUE);
        $data['footer']=$this->load->view('elecxtra_web_includes/footer', array('csrfName'=>$data['csrfName'], 'csrfHash'=>$data['csrfHash']), TRUE);
        $data['footer_bottom']=$this->load->view('elecxtra_web_includes/footer_bottom', NULL, TRUE);
        $this->load->view('elecxtra_web/seller_register', $data);
    }
    public function seller_login_data(){
        $this->form_validation->set_rules('user_id', 'Username', 'trim|required');
        $this->form_validation->set_rules('user_password', 'Password', 'trim|required');
        if ($this->form_validation->run() == FALSE){
            exit(json_encode(array('type'=>'warning','text'=>validation_errors())));
        }
        else{
			$data=$this->current_model->seller_login_data($this->input->post('user_id'),sha1($this->input->post('user_password')));
			if(empty($data)){
	            exit(json_encode(array('type'=>'warning','text'=>'Wrong Username or Pasword.!')));
			}else{
				$this->session->set_userdata(array( 
					'seller_id'  	=> $data->id
				));
				exit(json_encode(array('type'=>'success','text'=>'Successfully Login')));
			}
        }
	}
    public function seller_validate_account(){
        $this->form_validation->set_rules('user_name', 'Name', 'trim|required', array('is_unique' => 'Enter your name!')); 
        $this->form_validation->set_rules('user_phone', 'Phone', 'trim|required|is_unique[admin_user.user_phone]', array('is_unique' => 'The Mobile is already registered')); 
        $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|is_unique[admin_user.user_email]', array('is_unique' => 'The Email is already registered'));
        if($this->form_validation->run() == FALSE){ 
            exit(json_encode(array('type'=>'warning','text'=>validation_errors())));
        }else{
            $code=mt_rand(100000, 999999);
            $this->session->set_tempdata('seller_reg_otp', $code, 600);
            if(!empty($this->input->post('user_email'))){
                $user_name=$this->input->post('user_name');
                $user_email=$this->input->post('user_email');
                $user_subject="Your seller registration OTP in ".site_title();
                $user_message='
                <div style="font-family:Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
                  <div style="margin:50px auto;width:70%;padding:20px 0">
                    <div style="border-bottom:1px solid #eee">
                      <a href="" style="font-size:1.4em;color:#00466a;text-decoration:none;font-weight:600">'.site_title().'</a>
                    </div>
                    <p style="font-size:1.1em">Hi '.$user_name.',</p>
                    <p>Thank you for choosing '.site_title().'. Use the following OTP to complete your Sign Up procedures as a Seller Account. OTP is valid for 5 minutes</p>
                    <h2 style="background:#00466a; margin:0 auto; width:max-content; padding:0 10px; color:#fff; border-radius:4px;">'.$code.'</h2>
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
                    'smtp_user'=>get_email_name('customer'),
                    'smtp_pass'=>get_email_pass('customer'),
                    'from'=>get_email_name('customer'),
                    'from_name'=>site_title(),
                    'to'=>$user_email,
                    'to_name'=>$user_name,
                    'reply_to'=>get_email_name('info'),
                    'reply_to_name'=>site_title(),
                    'subject'=>$user_subject,
                    'html'=>$user_message,
                );
                if($this->send_email($data)){
                    exit(json_encode(array('type'=>'success', 'text'=>'Successfully sent OTP to your email')));
                }
            }
            exit(json_encode(array('type'=>'success', 'text'=>'Successfully sent OTP to your phone & email')));
        }
    }
    public function seller_register_data(){
        $this->form_validation->set_rules('otp', 'OTP', 'trim|required'); 
        $this->form_validation->set_rules('user_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('user_phone', 'Phone', 'trim|required|is_unique[admin_user.user_phone]', array('is_unique' => 'The Mobile is already registered')); 
        $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|is_unique[admin_user.user_email]', array('is_unique' => 'The Email is already registered')); 
        $this->form_validation->set_rules('user_password', 'Password', 'trim|required');
        $this->form_validation->set_rules('con_password', 'Confirm Password', 'trim|required|matches[user_password]');
        if($this->form_validation->run()== FALSE){ 
            exit(json_encode(array('type'=>'warning','text'=>validation_errors())));
        }else{
            if($this->input->post('otp')==$this->session->tempdata('seller_reg_otp')){
                if(empty($_FILES['attachments']['name'][0])){
                    exit(json_encode(array('type'=>'error', 'text'=>'Documents Required!')));
                }else{
                    $data=array(
                        'user_code'=>'ELX'.time(),
                        'user_id'=>$this->input->post('user_phone'),
                        'user_role'=>'seller',
                        'user_name'=>$this->input->post('user_name'),
                        'company_name'=>$this->input->post('company_name'),
                        'company_type'=>$this->input->post('company_type'),
                        'user_phone'=>$this->input->post('user_phone'),
                        'user_email'=>$this->input->post('user_email'),
                        'user_password'=>sha1($this->input->post('user_password')),
                        'status'=>'hold',
                    );
    
                    $attach_files=array();
                    $countfiles = count($_FILES['attachments']['name']);
                    for($i=0;$i<$countfiles;$i++){
                        $filename = time().'_'.$_FILES['attachments']['name'][$i];
                        if(in_array(strtolower(pathinfo($filename, PATHINFO_EXTENSION)), array('pdf'))){
                            $attach_folder='./uploads/seller/attachments/';
                            if(!is_dir($attach_folder)){ mkdir($attach_folder, 0755, true); }
                            move_uploaded_file($_FILES['attachments']['tmp_name'][$i], $attach_folder.$filename);
                            $attach_files[]=$filename;
                        }
                    }
                    if(!empty($attach_files)){
                        $data['user_attachment']=implode("|", $attach_files);
                    }
    
                    if($this->current_model->seller_register_data($data)){
                        $user_name=$this->input->post('user_name');
                        $user_email=$this->input->post('user_email');
                        $user_subject="Your seller registration is successfully done in ".site_title();
                        $user_message='
                        <div style="font-family:Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
                          <div style="margin:50px auto;width:70%;padding:20px 0">
                            <div style="border-bottom:1px solid #eee">
                              <a href="" style="font-size:1.4em;color:#00466a;text-decoration:none;font-weight:600">'.site_title().'</a>
                            </div>
                            <p style="font-size:1.1em">Hi '.$user_name.', You are successfully registered as a seller in '.site_title().'</p>
                            <p>Thank you for choosing '.site_title().'. Login to your seller account get a subscription plan & active your account</p>
                            <p>After you got a subscription plan you will receive an Admin Control panel.</p>
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
                            'smtp_user'=>get_email_name('customer'),
                            'smtp_pass'=>get_email_pass('customer'),
                            'from'=>get_email_name('customer'),
                            'from_name'=>site_title(),
                            'to'=>$user_email,
                            'to_name'=>$user_name,
                            'reply_to'=>get_email_name('info'),
                            'reply_to_name'=>site_title(),
                            'subject'=>$user_subject,
                            'html'=>$user_message,
                        );
                        if($this->send_email($data)){
                            exit(json_encode(array('type'=>'success', 'text'=>'Registration Successfully Done!')));
                        }
                    }
                }
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'Wrong OTP Entered!')));
            }
        } 
    }
    
    /***********recover password***********/
    public function seller_recover_pass_account_otp(){
        if($this->current_model->check_seller_exist(trim($this->input->post('username')))){
            $code=mt_rand(100000, 999999);
            $this->session->set_tempdata('pass_otp', $code, 600);
            if(is_numeric($this->input->post('username'))){
                $user_phone=$this->input->post('username');
            }else{
                $user_name="Dear Customer";
                $user_email=$this->input->post('username');
                $user_subject="Your Password Recover OTP in ".site_title();
                $user_message='
                <div style="font-family:Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
                  <div style="margin:50px auto;width:70%;padding:20px 0">
                    <div style="border-bottom:1px solid #eee">
                      <a href="" style="font-size:1.4em;color:#00466a;text-decoration:none;font-weight:600">'.site_title().'</a>
                    </div>
                    <p style="font-size:1.1em">Hi,</p>
                    <p>Your OTP for seller account reset password in '.site_title().'. is below, Use the following OTP to complete your Recover Password procedures in your Seller Account. OTP is valid for 5 minutes</p>
                    <h2 style="background:#00466a; margin:0 auto; width:max-content; padding:0 10px; color:#fff; border-radius:4px;">'.$code.'</h2>
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
                    'smtp_user'=>get_email_name('customer'),
                    'smtp_pass'=>get_email_pass('customer'),
                    'from'=>get_email_name('customer'),
                    'from_name'=>site_title(),
                    'to'=>$user_email,
                    'to_name'=>$user_name,
                    'reply_to'=>get_email_name('info'),
                    'reply_to_name'=>site_title(),
                    'subject'=>$user_subject,
                    'html'=>$user_message,
                );
                if($this->send_email($data)){
                    exit(json_encode(array('type'=>'success', 'text'=>'Successfully sent OTP to your to your email')));
                }else{
                    exit(json_encode(array('type'=>'error', 'text'=>'Something went wrong!')));
                }
            }
            exit(json_encode(array('type'=>'success', 'text'=>'Successfully sent OTP to your email')));
        }else{
            exit(json_encode(array('type'=>'error', 'text'=>'Account Not Found!')));
        }
    }
    public function seller_recover_pass_account(){
        $this->form_validation->set_rules('otp', 'OTP', 'trim|required'); 
        $this->form_validation->set_rules('username', 'Phone/Email', 'trim|required'); 
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('con_password', 'Confirm Password', 'trim|required|matches[password]');
        if ($this->form_validation->run() == FALSE){ 
            exit(json_encode(array('type'=>'warning','text'=>validation_errors())));
        }else{
            if($this->session->tempdata('pass_otp')==$this->input->post('otp')){
                $data=array('user_password'=>sha1($this->input->post('password')));
                if($this->current_model->seller_recover_pass_account($this->input->post('username'), $data)){
                    if(is_numeric($this->input->post('username'))){
                        exit(json_encode(array('type'=>'success', 'text'=>'Successfully Password Recovered!')));
                    }else{
                        $user_name="Dear Customer";
                        $user_email=$this->input->post('username');
                        $user_subject="Your Password is Recovered in ".site_title();
                        $user_message='
                        <div style="font-family:Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
                          <div style="margin:50px auto;width:70%;padding:20px 0">
                            <div style="border-bottom:1px solid #eee">
                              <a href="" style="font-size:1.4em;color:#00466a;text-decoration:none;font-weight:600">'.site_title().'</a>
                            </div>
                            <p style="font-size:1.1em">Hello welcome again! You are successfully recovered your seller account in '.site_title().'</p>
                            <p>If it is not done by you please contact us by replying this email!</p>
                            <p>Thank you for choosing '.site_title().'. Shop and Enjoy!</p>
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
                            'smtp_user'=>get_email_name('customer'),
                            'smtp_pass'=>get_email_pass('customer'),
                            'from'=>get_email_name('customer'),
                            'from_name'=>site_title(),
                            'to'=>$user_email,
                            'to_name'=>$user_name,
                            'reply_to'=>get_email_name('info'),
                            'reply_to_name'=>site_title(),
                            'subject'=>$user_subject,
                            'html'=>$user_message,
                        );
                        if($this->send_email($data)){
                            exit(json_encode(array('type'=>'success', 'text'=>'Successfully Password Recovered!')));
                        }else{
                            exit(json_encode(array('type'=>'error', 'text'=>'Something went wrong!')));
                        }
                    }
                }
            }else{
                exit(json_encode(array('type'=>'error', 'text'=>'Wrong OTP Entered!')));
            }
        }
    }
    /***********recover password***********/
    
    
    
    
}
