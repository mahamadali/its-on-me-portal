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
// $route['default_controller'] = 'welcome';
$route['default_controller'] = 'Login';
$route['dashboard'] = 'Dashboard';
$route['check_login'] = 'login/check_login';
$route['logout'] = 'login/logout';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*USERS ROUTES*/
$route['users'] = 'UserController';
$route['users/ajax_list'] = 'UserController/get_users';
$route['users/create'] = 'UserController/create';
$route['users/store'] = 'UserController/store';
$route['users/status-change/(:any)/(:any)'] = 'UserController/statusChange/$1/$2';
/*END USERS ROUTES*/

/*USERS ROUTES*/
$route['merchants'] = 'MerchantController';
$route['merchants/ajax_list'] = 'MerchantController/get_merchants';
$route['merchants/create'] = 'MerchantController/create';
$route['merchants/store'] = 'MerchantController/store';
$route['merchants/status-change/(:any)/(:any)'] = 'MerchantController/statusChange/$1/$2';
$route['merchants/delete/(:any)'] = 'MerchantController/delete/$1';
$route['merchants/edit/(:any)'] = 'MerchantController/edit/$1';
$route['merchants/update'] = 'MerchantController/update';
$route['merchants/list-bank/(:any)'] = 'MerchantController/banks/$1';
$route['merchants/add-bank/(:any)'] = 'MerchantController/add_bank/$1';
$route['merchants/store-bank'] = 'MerchantController/store_bank/';
$route['merchants/delete-merchant-bank/(:any)/(:any)'] = 'MerchantController/delete_bank/$1/$2';
$route['merchants/edit-merchant-bank/(:any)/(:any)'] = 'MerchantController/edit_bank/$1/$2';
$route['merchants/update-bank'] = 'MerchantController/update_bank';
/*END USERS ROUTES*/


//Manage Products Routes
$route['products'] = 'Products';
$route['products/delete_item/(:any)'] = 'Products/delete_product_item/$1';
$route['products/approve_feature/(:any)'] = 'Products/approve_feature_item/$1';


//Manage Product Categories
$route['product-categories'] = 'ProductCategories';
$route['product-categories/add'] = 'ProductCategories/add_cat';
$route['product-categories/store'] = 'ProductCategories/store_cat';
$route['product-categories/delete/(:any)'] = 'ProductCategories/delete_cat/$1';
$route['product-categories/edit/(:any)'] = 'ProductCategories/edit_cat/$1';
$route['product-categories/update'] = 'ProductCategories/update_cat';



//Manage Product Color
$route['product-color'] = 'ProductColor';
$route['product-color/add'] = 'ProductColor/add_color';
$route['product-color/store'] = 'ProductColor/store_color';
$route['product-color/delete/(:any)'] = 'ProductColor/delete_color/$1';
$route['product-color/edit/(:any)'] = 'ProductColor/edit_color/$1';
$route['product-color/update'] = 'ProductColor/update_color';

//Manage Product Size
$route['products/size'] = 'ProductSize';
$route['products/size/add'] = 'ProductSize/add_size';
$route['products/size/store'] = 'ProductSize/store_size';
$route['products/size/delete/(:any)'] = 'ProductSize/delete_size/$1';
$route['products/size/edit/(:any)'] = 'ProductSize/edit_size/$1';
$route['products/size/update'] = 'ProductSize/update_size';

//Manage Orders
$route['products/orders'] = 'ProductOrders';
$route['products/orders/view/(:any)'] = 'ProductOrders/view_prodcut_order/$1';

//Manage Profile
$route['profile/manageprofile'] = 'Profile';
$route['profile/changepassword'] = 'Profile/changepassword';
$route['profile/memberAccesspassword'] = 'Profile/memberAccesspassword';

//Manage Members
$route['members'] = 'Members';
$route['view/(:any)'] = 'Members/view/$1';

//Chat Topic Manage
$route['chat-topic'] = 'ChatTopic';
$route['chat-topic/add'] = 'ChatTopic/add';
$route['chat-topic/store'] = 'ChatTopic/store';
$route['chat-topic/delete/(:any)'] = 'ChatTopic/delete/$1';
$route['chat-topic/edit/(:any)'] = 'ChatTopic/edit/$1';
$route['chat-topic/update'] = 'ChatTopic/update';

//Sports
$route['sports'] = 'SportsController';
$route['sports/add'] = 'SportsController/add';
$route['sports/store'] = 'SportsController/store';
$route['sports/delete/(:any)'] = 'SportsController/delete/$1';
$route['sports/edit/(:any)'] = 'SportsController/edit/$1';
$route['sports/update'] = 'SportsController/update';

//Sports Accessories
$route['sport_accessories'] = 'SportsAccessoriesController';
$route['sport_accessories/add'] = 'SportsAccessoriesController/add';
$route['sport_accessories/store'] = 'SportsAccessoriesController/store';
$route['sport_accessories/delete/(:any)'] = 'SportsAccessoriesController/delete/$1';
$route['sport_accessories/edit/(:any)'] = 'SportsAccessoriesController/edit/$1';
$route['sport_accessories/update'] = 'SportsAccessoriesController/update';

//Sports Players
$route['sport_players'] = 'SportsPlayersController';
$route['sport_players/add'] = 'SportsPlayersController/add';
$route['sport_players/store'] = 'SportsPlayersController/store';
$route['sport_players/delete/(:any)'] = 'SportsPlayersController/delete/$1';
$route['sport_players/edit/(:any)'] = 'SportsPlayersController/edit/$1';
$route['sport_players/update'] = 'SportsPlayersController/update';

//Insurance Services
$route['insurance_service'] = 'ServicesController/insurance_service_index';
$route['insurance_service/add'] = 'ServicesController/insurance_service_add';
$route['insurance_service/store'] = 'ServicesController/insurance_service_store';
$route['insurance_service/delete/(:any)'] = 'ServicesController/insurance_service_delete/$1';
$route['insurance_service/edit/(:any)'] = 'ServicesController/insurance_service_edit/$1';
$route['insurance_service/update'] = 'ServicesController/insurance_service_update';


//Authentication Services
$route['authentication_service'] = 'ServicesController/authentication_service_index';
$route['authentication_service/add'] = 'ServicesController/authentication_service_add';
$route['authentication_service/store'] = 'ServicesController/authentication_service_store';
$route['authentication_service/delete/(:any)'] = 'ServicesController/authentication_service_delete/$1';
$route['authentication_service/edit/(:any)'] = 'ServicesController/authentication_service_edit/$1';
$route['authentication_service/update'] = 'ServicesController/authentication_service_update';


//Storage Services
$route['storage_service'] = 'ServicesController/storage_service_index';
$route['storage_service/add'] = 'ServicesController/storage_service_add';
$route['storage_service/store'] = 'ServicesController/storage_service_store';
$route['storage_service/delete/(:any)'] = 'ServicesController/storage_service_delete/$1';
$route['storage_service/edit/(:any)'] = 'ServicesController/storage_service_edit/$1';
$route['storage_service/update'] = 'ServicesController/storage_service_update';


//Custom Display Cases Services
$route['custom_display_service'] = 'ServicesController/custom_display_service_index';
$route['custom_display_service/add'] = 'ServicesController/custom_display_service_add';
$route['custom_display_service/store'] = 'ServicesController/custom_display_service_store';
$route['custom_display_service/delete/(:any)'] = 'ServicesController/custom_display_service_delete/$1';
$route['custom_display_service/edit/(:any)'] = 'ServicesController/custom_display_service_edit/$1';
$route['custom_display_service/update'] = 'ServicesController/custom_display_service_update';

//Photo Match  Services
$route['photo_match_service'] = 'ServicesController/photo_match_service_index';
$route['photo_match_service/add'] = 'ServicesController/photo_match_service_add';
$route['photo_match_service/store'] = 'ServicesController/photo_match_service_store';
$route['photo_match_service/delete/(:any)'] = 'ServicesController/photo_match_service_delete/$1';
$route['photo_match_service/edit/(:any)'] = 'ServicesController/photo_match_service_edit/$1';
$route['photo_match_service/update'] = 'ServicesController/photo_match_service_update';

//general Heading Settings

$route['general_heading_setting'] = 'GeneralHeadingSettingController/index';
$route['general_heading_setting/store'] = 'GeneralHeadingSettingController/update_heading';


//Services Main Title 


$route['services_title'] = 'GeneralHeadingSettingController/services_title';
$route['general_heading_setting/update_services_title'] = 'GeneralHeadingSettingController/update_services_title';

//Invitations
$route['pending_invitations'] = 'InviationController/pending_invitations';
$route['registered_invitations'] = 'InviationController/registered_invitations';

//Reports 
$route['reports'] = 'ReportController/index';
$route['preregister_members'] = 'ReportController/preregister_member';
$route['member_collections'] = 'ReportController/member_collections';
$route['members_report'] = 'ReportController/members_report';


//Site Visitors Reports
$route['site_visitors'] = 'ReportController/site_visitors';


$route['corporate_members'] = 'Members/corporate_members';

/*Merchant ROUTES*/

$route['merchant/login'] = 'MerchantController/merchant_login';
$route['merchant/check_login'] = 'MerchantController/check_login';
$route['merchant/dashboard'] = 'MerchantDashboardController';
$route['merchant/profile'] = 'MerchantDashboardController/profile';
$route['merchants/profile_update'] = 'MerchantDashboardController/profileupdate';
$route['merchant/list-bank/(:any)'] = 'MerchantDashboardController/list_banks/$1';
$route['merchant/add-bank/(:any)'] = 'MerchantDashboardController/add_bank/$1';
$route['merchant/store-bank'] = 'MerchantDashboardController/store_bank/';
$route['merchant/delete-merchant-bank/(:any)/(:any)'] = 'MerchantDashboardController/delete_bank/$1/$2';
$route['merchant/edit-merchant-bank/(:any)/(:any)'] = 'MerchantDashboardController/edit_bank/$1/$2';
$route['merchant/update-bank'] = 'MerchantDashboardController/update_bank';
$route['merchant/logout'] = 'MerchantController/logout';


/*Merchant Products Routes*/

$route['merchant/products'] = 'MerchantProductController/index';
$route['merchant/products/add_item'] = 'MerchantProductController/add_product_items';
$route['merchant/products/store_item'] = 'MerchantProductController/store_product_items';
$route['merchant/products/delete_item/(:any)'] = 'MerchantProductController/delete_product_item/$1';
$route['merchant/products/edit_item/(:any)'] = 'MerchantProductController/edit_product_item/$1';
$route['merchant/products/update_item'] = 'MerchantProductController/update_product_item';


/*Merchant Products Routes*/

/*Merchant ROUTES*/


/*Advertising Routes*/

$route['advertising'] = 'AdvertisingController/index';
$route['advertise/add'] = 'AdvertisingController/add';
$route['advertise/store'] = 'AdvertisingController/store';
$route['advertise/delete/(:any)'] = 'AdvertisingController/delete/$1';
$route['advertise/edit/(:any)'] = 'AdvertisingController/edit/$1';
$route['advertise/update'] = 'AdvertisingController/update';
$route['advertise/status-change/(:any)/(:any)'] = 'AdvertisingController/statusChange/$1/$2';

/*Advertising Routes*/

/*Advertising Routes*/

$route['push-notifications'] = 'PushNotificationController/index';
$route['push-notifications/ajax_list'] = 'PushNotificationController/ajax_list';
$route['push-notifications/create'] = 'PushNotificationController/create';
$route['push-notifications/store'] = 'PushNotificationController/store';

/*Advertising Routes*/

/*Admin Create Routes*/

$route['admin-list'] = 'AdminController/index';
$route['admin-list/add'] = 'AdminController/add';
$route['admin-list/store'] = 'AdminController/store';
$route['admin-list/delete/(:any)'] = 'AdminController/delete/$1';
$route['admin-list/edit/(:any)'] = 'AdminController/edit/$1';
$route['admin-list/update'] = 'AdminController/update';


/*Admin Create Routes*/

/*Support Ticket Routes*/

$route['inquiries'] = 'InquiryController/index';

/*Support Ticket Routes*/

/*Vouchers Routes*/

$route['vouchers'] = 'VoucherController/index';
$route['voucher/add'] = 'VoucherController/add';
$route['voucher/store'] = 'VoucherController/store';
$route['voucher/delete/(:any)'] = 'VoucherController/delete/$1';
$route['voucher/edit/(:any)'] = 'VoucherController/edit/$1';
$route['voucher/update'] = 'VoucherController/update';

/*Vouchers Routes*/

/*API ROUTES*/
$route['api/login'] = 'api/Auth/login';
$route['api/province'] = 'api/Auth/province';
$route['api/register'] = 'api/Auth/register';
$route['api/forgot-password'] = 'api/Auth/forgotPassword';
$route['api/verify-email-code'] = 'api/Auth/verifyEmailCode';
$route['api/reset-password'] = 'api/Auth/resetPassword';
$route['api/categories'] = 'api/Product/categories';
$route['api/merchants-by-category'] = 'api/Product/merchantsBycategory';
$route['api/banners'] = 'api/General/banners';
$route['api/product-offers'] = 'api/Product/productOffers';
$route['api/product-gift-ideas'] = 'api/Product/productGiftIdeas';
$route['api/products/search-by-location'] = 'api/Product/searchByProvince';
$route['api/products/search-by-name'] = 'api/Product/searchByName';
$route['api/products/search-by-brand'] = 'api/Product/searchByBrand';
$route['api/user-notifications'] = 'api/Notification/userNotifications';
$route['api/user-notification-details'] = 'api/Notification/userNotificationDetails';
$route['api/brands-categories'] = 'api/Product/brandCategories';
$route['api/fetch-brands-by-category'] = 'api/Product/fetchBrandsByCat';
$route['api/brands-top-offers'] = 'api/Product/brandsTopOffers';
$route['api/edit-info'] = 'api/Auth/editProfile';
$route['api/user-info'] = 'api/Auth/userProfileInfo';
$route['api/product-search'] = 'api/Product/searchProductByText';
$route['api/brand-product-search'] = 'api/Product/searchBrandProductByText';
