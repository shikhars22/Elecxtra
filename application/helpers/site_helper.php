<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
function get_version(){
    return "1.0.0.0";
}
function number_in_word($number=null){
	if(empty($number)){
		return "";
	}else{
		$no = floor($number);
		$point = round($number - $no, 2) * 100;
		$hundred = null;
		$digits_1 = strlen($no);
		$i = 0;
		$str = array();
		$words = array('0' => '', '1' => 'one', '2' => 'two',
		'3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
		'7' => 'seven', '8' => 'eight', '9' => 'nine',
		'10' => 'ten', '11' => 'eleven', '12' => 'twelve',
		'13' => 'thirteen', '14' => 'fourteen',
		'15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
		'18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
		'30' => 'thirty', '40' => 'forty', '50' => 'fifty',
		'60' => 'sixty', '70' => 'seventy',
		'80' => 'eighty', '90' => 'ninety');
		$digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
		while ($i < $digits_1) {
		 $divider = ($i == 2) ? 10 : 100;
		 $number = floor($no % $divider);
		 $no = floor($no / $divider);
		 $i += ($divider == 10) ? 1 : 2;
		 if ($number) {
		    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
		    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
		    $str [] = ($number < 21) ? $words[$number] .
		        " " . $digits[$counter] . $plural . " " . $hundred
		        :
		        $words[floor($number / 10) * 10]
		        . " " . $words[$number % 10] . " "
		        . $digits[$counter] . $plural . " " . $hundred;
		 } else $str[] = null;
		}
		$str = array_reverse($str);
		$result = implode('', $str);
		$points = ($point) ?
		"." . $words[$point / 10] . " " . 
		      $words[$point = $point % 10] : '';
		return $result . "rupees  " . $points . " paise";
	}
}
function function_name(){
	$ci=& get_instance();
	return $ci->db->where('condition')->get('table_name')->row();
}

function site_title(){
	return "Elecxtra";
}
function clean_string($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
function get_banner_images($page){
	$ci=& get_instance();
	return $ci->db->where('status', '1')->where('page', $page)->order_by('id', 'desc')->get('webina_banner')->result();
}
function get_single_banner_images($page){
	$ci=& get_instance();
	$temp=$ci->db->where('status', '1')->where('page', $page)->limit('1')->get('webina_banner');
	if($temp->num_rows()>0){
	    return $temp->row();
	}else{
	    return array();
	}
}
function get_sub_categories(){
	$ci=& get_instance();
	return $ci->db->where(array('status'=>'1'))->get('webinatech_sub_category')->result();
}
function get_items($sub_cat_id){
	$ci=& get_instance();
	return $ci->db->where(array('status'=>'1', 'sub_cat_id'=>$sub_cat_id))->get('webinatech_item')->result();
}
function price_commission(){
	$ci=& get_instance();
	$data=$ci->db->where('status', 1)->order_by('max_price', 'asc')->get('webinatech_price_commission')->result();
	$commission=array();
	foreach ($data as $key => $value){
		$temp['min_price']=$value->min_price;
		$temp['max_price']=$value->max_price;
		$temp['commission']=$value->commission;
		$commission[]=$temp;
	}
	return json_encode($commission);
}
function get_page_list(){
	$all_page=array(
		'home'=>'Home',
		'about-us'=>'About Us',
		'contact-us'=>'Contact Us',
	);
	return $all_page;
}
function get_email_list($name=""){
	$ci=& get_instance();
	return $ci->db->get('webina_email_list')->result();
}
function get_email_host(){
    return "smtp.hostinger.com";
}
function get_email_pass($name){
	switch ($name) {
		case 'customer':
			return "mhA6xQ*C2wRmp8A";
			break;
		
		default:
			return "";
			break;
	}
}
function get_email_name($name){
	if(!empty($name)){
		return $name."@elecxtra.in";
	}
}
function to_email_name($name){
	if(!empty($name)){
		return $name."elecxtra.in";
	}
}
function get_phone_list($i){
	switch ($i) {
		case '1':
			return "+91 9901642978";
			break;

		case '2':
			return "+91 9901642978";
			break;
		
		default:
			return "+91 9901642978";
			break;
	}
}
function get_subscription_plan(){
    $ci=& get_instance();
    return $ci->db->where('status', '1')->get('webina_subscription')->result();
}




