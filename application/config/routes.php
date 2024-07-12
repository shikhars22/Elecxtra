<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['visitor-count'] = 'elecxtra_web/elecxtra_page/visitor_count';

$route['default_controller'] = 'elecxtra_web/elecxtra_page';
$route['about-us'] = 'elecxtra_web/elecxtra_page/about_us';
$route['contact-us'] = 'elecxtra_web/elecxtra_page/contact_us';
$route['contact-reload-captcha'] = 'elecxtra_web/elecxtra_page/contact_reload_captcha';
$route['contact-us-data'] = 'elecxtra_web/elecxtra_page/contact_form_data';
$route['terms-condition'] = 'elecxtra_web/elecxtra_page/terms_condition';
$route['privacy-policy'] = 'elecxtra_web/elecxtra_page/privacy_policy';
$route['refund-cancellation'] = 'elecxtra_web/elecxtra_page/refund_cancellation';
$route['shipping-delivery-policy'] = 'elecxtra_web/elecxtra_page/shipping_delivery_policy';
$route['support-center'] = 'elecxtra_web/elecxtra_page/support_center';

$route['seller-register'] = 'elecxtra_web/seller';
$route['seller-profile'] = 'elecxtra_web/seller_profile';
$route['seller-logout'] = 'elecxtra_web/seller_logout';
$route['seller-login-data'] = 'elecxtra_web/seller/seller_login_data';
$route['seller-recover-pass-account-otp'] = 'elecxtra_web/seller/seller_recover_pass_account_otp';
$route['seller-recover-pass-account'] = 'elecxtra_web/seller/seller_recover_pass_account';
$route['seller-validate-account'] = 'elecxtra_web/seller/seller_validate_account';
$route['seller-register-data'] = 'elecxtra_web/seller/seller_register_data';
$route['seller-subscription-change'] = 'elecxtra_web/seller_profile/seller_subscription_change';
$route['seller-details-data'] = 'elecxtra_web/seller_profile/seller_details_data';
$route['seller-business-data'] = 'elecxtra_web/seller_profile/seller_business_data';
$route['seller-address-data'] = 'elecxtra_web/seller_profile/seller_address_data';
$route['seller-bank-data'] = 'elecxtra_web/seller_profile/seller_bank_data';
$route['seller-pass-change'] = 'elecxtra_web/seller_profile/seller_pass_change';

$route['products/product-with-filter'] = 'elecxtra_web/product/product_with_filter';
$route['search-product'] = 'elecxtra_web/product/search_product';
$route['products/(:any)/(:any)'] = 'elecxtra_web/product';

$route['product-details/(:any)'] = 'elecxtra_web/product/product_details';
$route['load-siblings-subcategory'] = 'elecxtra_web/product/load_siblings_subcategory';
$route['load-siblings-item'] = 'elecxtra_web/product/load_siblings_item';
$route['load-related-products'] = 'elecxtra_web/product/load_related_products';
$route['load-selected-products'] = 'elecxtra_web/product/load_selected_products';
$route['view-product/(:any)'] = 'elecxtra_web/product/view_selected_products';
$route['load-recent-products'] = 'elecxtra_web/product/load_recent_products';
$route['cart'] = 'elecxtra_web/cart';
$route['load-cart'] = 'elecxtra_web/cart/load_cart';
$route['load-cart-price'] = 'elecxtra_web/cart/load_cart_price';
$route['add-to-cart'] = 'elecxtra_web/cart/add_to_cart';
$route['update-cart'] = 'elecxtra_web/cart/update_cart';
$route['remove-cart'] = 'elecxtra_web/cart/delete_cart';
$route['clear-cart'] = 'elecxtra_web/cart/destroy_cart';
$route['cart/checkout'] = 'elecxtra_web/cart/checkout';
$route['cart/place-order'] = 'elecxtra_web/cart/place_order';
$route['cart/submit-checkout-pincode'] = 'elecxtra_web/cart/submit_checkout_pincode';

$route['make-payment'] = 'elecxtra_web/Payment/order_pay_now';
$route['make-subscription-payment'] = 'elecxtra_web/Payment/subscription_pay_now';
$route['verify-payment'] = 'elecxtra_web/Payment/verify_payment';

$route['logout'] = 'elecxtra_web/logout';
$route['login'] = 'elecxtra_web/user';
$route['login-first'] = 'elecxtra_web/user';
$route['validate-account'] = 'elecxtra_web/user/validate_account';
$route['register'] = 'elecxtra_web/user/register';
$route['register-data'] = 'elecxtra_web/user/register_data';
$route['login-data'] = 'elecxtra_web/user/login_data';
$route['recover-pass-account'] = 'elecxtra_web/user/recover_pass_account';
$route['recover-pass-account-otp'] = 'elecxtra_web/user/recover_pass_account_otp';
$route['profile'] = 'elecxtra_web/profile';
$route['personal-form-data'] = 'elecxtra_web/profile/personal_form_data';
$route['address-form'] = 'elecxtra_web/profile/address_form';
$route['change-pass-form'] = 'elecxtra_web/profile/change_pass_form';
$route['my-order-data'] = 'elecxtra_web/profile/my_order_data';
$route['fetch-order-invoice'] = 'elecxtra_web/profile/fetch_order_invoice';
$route['cancel-order'] = 'elecxtra_web/profile/cancel_order';
$route['return-order'] = 'elecxtra_web/profile/return_order';

//Admin route
$route['admin'] = 'elecxtra_admin/admin_login';
$route['admin/admin-logout'] = 'elecxtra_admin/admin_logout';
$route['admin/admin-dashboard'] = 'elecxtra_admin/admin_dashboard';
$route['admin/banner'] = 'elecxtra_admin/admin_view_media/banner';
$route['admin/my-profile'] = 'elecxtra_admin/admin_view_profile';
$route['admin/commission'] = 'elecxtra_admin/admin_price_setting/commission';
$route['admin/subscription'] = 'elecxtra_admin/admin_price_setting/subscription';
$route['admin/contact-data'] = 'elecxtra_admin/admin_view_notification';
$route['admin/email-data'] = 'elecxtra_admin/admin_view_notification/email_data';
$route['admin/change-password'] = 'elecxtra_admin/admin_view_profile/change_password';

$route['admin/pending-seller'] = 'elecxtra_admin/admin_seller/pending_seller';
$route['admin/approved-seller'] = 'elecxtra_admin/admin_seller/approved_seller';
$route['admin/rejected-seller'] = 'elecxtra_admin/admin_seller/rejected_seller';

$route['admin/hold-order'] = 'elecxtra_admin/admin_view_order/hold_order';
$route['admin/packaged-order'] = 'elecxtra_admin/admin_view_order/packaged_order';
$route['admin/picked-order'] = 'elecxtra_admin/admin_view_order/picked_order';
$route['admin/ready-order'] = 'elecxtra_admin/admin_view_order/ready_order';
$route['admin/out-order'] = 'elecxtra_admin/admin_view_order/out_order';
$route['admin/completed-order'] = 'elecxtra_admin/admin_view_order/completed_order';
$route['admin/canceled-order'] = 'elecxtra_admin/admin_view_order/canceled_order';
$route['admin/returned-order'] = 'elecxtra_admin/admin_view_order/returned_order';
$route['admin/pending-order'] = 'elecxtra_admin/admin_view_order/pending_order';

$route['admin/all-customer'] = 'elecxtra_admin/admin_customer';

$route['admin/product-family'] = 'elecxtra_admin/admin_product_family';
$route['admin/product-feature'] = 'elecxtra_admin/admin_product_family/product_feature';


$route['admin/approved-products'] = 'elecxtra_admin/admin_product/approved_product';
$route['admin/trash-products'] = 'elecxtra_admin/admin_product/trash_product';
$route['admin/pending-products'] = 'elecxtra_admin/admin_product/pending_product';
$route['admin/rejected-products'] = 'elecxtra_admin/admin_product/rejected_product';
$route['admin/addon-products'] = 'elecxtra_admin/admin_addon_product';
$route['admin/add-product'] = 'elecxtra_admin/admin_product/add_product';
$route['admin/edit-product'] = 'elecxtra_admin/admin_product/edit_product';

