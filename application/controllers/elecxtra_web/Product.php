<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends CI_Controller {
	public function __construct(){
        parent::__construct(); 
        $this->load->library('form_validation');
        $this->load->model('elecxtra_web/product_model', 'current_model');
    }
	public function index(){
		$data['slug_arr']=$this->uri->segment_array();
		$length=200; $start=0;
		$data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
		$data['product']=$this->current_model->fetch_product($data['slug_arr'], $start, $length);
		$data['link_scripts']=$this->load->view('elecxtra_web_includes/link_script', NULL, TRUE);
		$data['header']=$this->load->view('elecxtra_web_includes/header', NULL, TRUE);
		$data['navigation']=$this->load->view('elecxtra_web_includes/navigation', NULL, TRUE);
		$data['footer']=$this->load->view('elecxtra_web_includes/footer', array('csrfName'=>$data['csrfName'], 'csrfHash'=>$data['csrfHash']), TRUE);
		$data['footer_bottom']=$this->load->view('elecxtra_web_includes/footer_bottom', NULL, TRUE);
		if(empty($data['product'])){
			$temp=$this->current_model->get_catsubcatitem_details($data['slug_arr']);
			if(empty($temp)){
				exit("Sorry something went wring!");
			}else{
				$data['cat_id']=$temp->cat_id;
				$data['cat_name']=$temp->cat_name;
				$data['sub_cat_id']=$temp->sub_cat_id;
				$data['sub_cat_name']=$temp->sub_cat_name;
				$data['item_id']=$temp->item_id;
				$data['item_name']=$temp->item_name;
				$data['found_product']=false;
				$this->load->view('elecxtra_web/products', $data);
			}
		}else{
			$data['found_product']=true;
			$this->load->view('elecxtra_web/products', $data);
		}
	}
	public function view_selected_products(){
		$slug_arr=$this->uri->segment_array();
		$length=200; $start=0;
		$data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
		$data['product']=$this->current_model->load_selected_products(end($slug_arr), $start, $length);
		$data['link_scripts']=$this->load->view('elecxtra_web_includes/link_script', NULL, TRUE);
		$data['header']=$this->load->view('elecxtra_web_includes/header', NULL, TRUE);
		$data['navigation']=$this->load->view('elecxtra_web_includes/navigation', NULL, TRUE);
		$data['footer']=$this->load->view('elecxtra_web_includes/footer', array('csrfName'=>$data['csrfName'], 'csrfHash'=>$data['csrfHash']), TRUE);
		$data['footer_bottom']=$this->load->view('elecxtra_web_includes/footer_bottom', NULL, TRUE);
		if(empty($data['product'])){
			$data['found_product']=false;
			$this->load->view('elecxtra_web/selected_products', $data);
		}else{
			$data['found_product']=true;
			$this->load->view('elecxtra_web/selected_products', $data);
			
		}
	}
	public function load_siblings_item(){
		exit(json_encode(array('type'=>'success', 'data'=>$this->current_model->load_siblings_item($this->input->post('cat_id'), $this->input->post('sub_cat_id'), $this->input->post('item_id')))));
	}
	public function load_siblings_subcategory(){
		exit(json_encode(array('type'=>'success', 'data'=>$this->current_model->load_siblings_subcategory())));
	}
	public function product_with_filter(){
		$price_commission=json_decode(price_commission());
		$length=200; $start=0;
		$filter=$this->input->post('filter');
		$sort_order=$this->input->post('sort_order');
		$all_value=array();
		if(!empty($filter)){
			$all_value=[];
			foreach ($filter as $key => $value){
				$f_n_i=explode("_", $key)[0];
				foreach ($value as $k => $v){
					if(array_key_exists($f_n_i, $all_value)){
						$all_value[$f_n_i]=$all_value[$f_n_i].",'".$v."'";
					}else{
						$all_value[$f_n_i]="'".$v."'";
					}
				}
			}
	    }
	    $product=$this->current_model->product_with_filter($this->input->post('item_id'), $all_value, $sort_order, $start, $length);
		if(empty($product)){
			exit(json_encode(array('type'=>'success', 'data'=>"<h6 class=''>Sorry! No result found!</h6>", 'total_count'=>0)));
		}else{
			$data="";
			foreach ($product as $key => $value) {
			    $other_img=explode("|", trim($value->other_img, "|"));
				$finalPrice=0;
	            foreach ($price_commission as $k => $v){
	                if($value->price<=$v->max_price){
	                    $other_charge=2;
	                    $comms=$v->commission;
	                    $webViewPrice=$value->price+($value->price*$v->commission/100);
	                    $finalPrice=number_format((float)($webViewPrice+($webViewPrice*$other_charge/100)), 2, '.', '');
	                    break;
	                }
	            }
	            $data.='<div class="prod_box">
                    <a href="'.base_url('product-details/').$value->title.'" class="prod_img img_contain">
                        '.((!empty($other_img[0]) && count($other_img)>0)?
                        	'<img class="imgHvr" src="'.base_url('uploads/products/').$value->main_img.'" alt="'.$value->name.'"><img class="imgHvr" src="'.base_url('uploads/products/').$other_img[0].'" alt="'.$value->name.'">':
                        	'<img src="'.base_url('uploads/products/').$value->main_img.'" alt="'.$value->name.'">'
                        ).'
                        <div class="top_info">
                        </div>
                    </a>
                    <div class="prod_info">
                        <p class="prod_name clip_txt_1"><small>'.$value->cat_name.', '.$value->item_name.'</small></p>
                        <p class="prod_name clip_txt_1">'.$value->name.'</p>
                        <h6>&#8377;'.$finalPrice.'</h6>
                        
                        <a href="'.base_url('product-details/').$value->title.'" class="button_1 py-2 px-3 fs_10 w-100 mt-1">View Details</a>
                    </div>
                </div>';
	        }
	        exit(json_encode(array('type'=>'success', 'data'=>$data, 'total_count'=>($key+1))));
	    }
	}
	public function product_details(){
		$data['session_data']=$this->session->all_userdata();
		$data['cart_data']=$this->session->tempdata('cart_data');
        $data['csrfHash']=$this->security->get_csrf_hash();
        $data['csrfName']=$this->security->get_csrf_token_name();
		$uid=$this->input->get('uid');
		if(empty($uid)){
			echo "something went wrong! product not found!";
		}else{
			$product=$this->current_model->fetch_product_details($uid);
			if(empty($product->id)){ 
				echo "something went wrong! product not found!";
			}else{
				$data['csrfHash']=$this->security->get_csrf_hash();
				$data['session_data']=$this->session->all_userdata();
        		$data['csrfName']=$this->security->get_csrf_token_name();
				$data['product']=$product;
				$data['main_product_id']=$product->id;
				$data['link_scripts']=$this->load->view('elecxtra_web_includes/link_script', NULL, TRUE);
				$data['header']=$this->load->view('elecxtra_web_includes/header', NULL, TRUE);
				$data['navigation']=$this->load->view('elecxtra_web_includes/navigation', NULL, TRUE);
				$data['footer']=$this->load->view('elecxtra_web_includes/footer', array('csrfName'=>$data['csrfName'], 'csrfHash'=>$data['csrfHash']), TRUE);
				$data['footer_bottom']=$this->load->view('elecxtra_web_includes/footer_bottom', NULL, TRUE);
				$this->load->view('elecxtra_web/product_details', $data);
			}
		}
	}
	public function load_related_products(){
		$data=$this->current_model->load_related_products($this->input->post('product_id'), $this->input->post('cat_id'), $this->input->post('sub_cat_id'), $this->input->post('item_id'), 0, 10);
		if(!empty($data)){
			exit(json_encode(array('type'=>'success', 'data'=>$data)));
		}else{
			exit(json_encode(array('type'=>'info', 'text'=>'related product not found!')));
		}
	}
	public function load_selected_products(){
		$start=0; $length=20;
		$product=$this->current_model->load_selected_products($this->input->post('type'), $start, $length);
		if(empty($product)){
			exit(json_encode(array('type'=>'success', 'data'=>"<h4 class='m-2'>Sorry! No result found!</h4>")));
		}else{
			$data="";
			$price_commission=json_decode(price_commission());
			foreach ($product as $key => $value) {
				$other_img=explode("|", trim($value->other_img, "|")); 
				$finalPrice=0;
	            foreach ($price_commission as $k => $v){
	                if($value->price<=$v->max_price){
	                    $other_charge=2;
	                    $comms=$v->commission;
	                    $webViewPrice=$value->price+($value->price*$v->commission/100);
	                    $finalPrice=number_format((float)($webViewPrice+($webViewPrice*$other_charge/100)), 2, '.', '');
	                    break;
	                }
	            }
	            $data.='<div class="prod_box">
                    <a href="'.base_url('product-details/').$value->title.'" class="prod_img img_contain">
                        '.((!empty($other_img[0]) && count($other_img)>0)?
                        	'<img class="imgHvr" src="'.base_url('uploads/products/').$value->main_img.'" alt="'.$value->name.'"><img class="imgHvr" src="'.base_url('uploads/products/').$other_img[0].'" alt="'.$value->name.'">':
                        	'<img src="'.base_url('uploads/products/').$value->main_img.'" alt="'.$value->name.'">'
                        ).'
                        <div class="top_info">
                        </div>
                    </a>
                    <div class="prod_info">
                        <p class="prod_name clip_txt_1"><small>'.$value->cat_name.', '.$value->item_name.'</small></p>
                        <p class="prod_name clip_txt_1">'.$value->name.'</p>
                        <h6>&#8377;'.$finalPrice.'</h6>
                        
                        <a href="'.base_url('product-details/').$value->title.'" class="button_1 py-2 px-3 fs_10 w-100 mt-1">View Details</a>
                    </div>
                </div>';
	        }
	        exit(json_encode(array('type'=>'success', 'data'=>$data)));
	    }
	}
	public function load_recent_products(){
		$data=$this->current_model->load_recent_products(0, 10);
		if(!empty($data)){
			exit(json_encode(array('type'=>'success', 'data'=>$data)));
		}else{
			exit(json_encode(array('type'=>'info', 'text'=>'related product not found!')));
		}
	}
	public function search_product(){
        exit(json_encode(array('type'=>'success', 'products'=>$this->current_model->search_product(trim($this->input->post('keywords'))))));
    }




}
