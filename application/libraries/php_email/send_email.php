<?php
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);


$subject=$_POST['subject'];
$name=$_POST['name'];
$phone=$_POST['phone'];
$email=$_POST['email'];
$title=$_POST['title'];
$message=$_POST['message'];

$to="info@dalmaf.com";

$html = "   
    <p>".ucwords($name)." has enquired a question in the field of $subject.</p>
    <p><b>Details are below :</b></p>
    <p><b>Name : </b>$name</p>
    <p><b>Email : </b>$email</p>
    <p><b>Subject : </b>$title</p>
    <p><b>Message : </b>$message</p>
    <br>
    <br>
    <br>
    <div>
        <p>Thanks & Regards</p>
        <hr>
        <p><img src='https://dalmaf.com/dalmaf/assets/images/logo.png' style='max-width:100px;'></p>
        <p><b>Dalmaf</b></p>
        <p><b>Phone</b> 1800-309-8445</p><p><b>Email</b> info@dalmaf.com</p>
    </div>
";


try {
    //Server settings
    $mail->SMTPDebug = false;                                   //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.hostinger.com';                   //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'enquiry@dalmaf.com';                   //SMTP username
    $mail->Password   = 'Enquiry@123';                          //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('enquiry@dalmaf.com', 'Dalmaf');
    $mail->addAddress($to, $name);     //Add a recipient
    // $mail->addAddress('ellen@example.com');                  //Name is optional
    $mail->addReplyTo('enquiry@dalmaf.com', 'Dalmaf');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');            //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');       //Optional name

    //Content
    $mail->isHTML(true);                                        //Set email format to HTML
    $mail->Subject = ucwords($name)." has enquired a question in the field of ".$subject;
    $mail->Body    = $html;
    $mail->AltBody = '';

    $response=$mail->send();
    $mail->clearAddresses();
    $mail->clearAttachments();
    if($response){
        exit(json_encode(array('type'=>'success', 'text'=>'Successfully Sent!')));
    }else{
        exit(json_encode(array('type'=>'error', 'text'=>'Message Not Sent!')));
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


?>