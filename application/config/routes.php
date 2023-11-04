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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
//fontend
$login = 'Login/';
$route['login'] = $login.'login';
$route['verify-otp'] = $login.'user_otp';
$route['myprofile'] = 'Profile/myprofile';
$route['forgetpassword'] = $login.'forgetpass';
$route['passwordrecover'] = $login.'passwordrecover';
$route['urllink'] = $login.'urllink';
$route['contact'] = 'Contact/contact';
$route['registration'] = 'UserDetails/register';

//backend

$back_path = 'backend/BackAPI';
$front_path = 'backend/back';
$route[SKYDASH] = $front_path; 
$route[SKYDASH.'/dashboard'] = $front_path.'/dashboard'; 
$route[SKYDASH.'/changepassword'] = $front_path.'/changepassword';
$route[SKYDASH.'/manageuser'] = $front_path.'/manageuser';
$route['admin_login'] = $back_path.'/admin_login';
$route['showuserlist'] = $back_path.'/showuserlist';
$route['backuseredit'] = $back_path.'/backuseredit';
$route['backpassupd'] = $back_path.'/backpassupd';
$route['userstatus'] = $back_path.'/userstatus';
$route['userdelete'] = $back_path.'/userdelete';
$route['editmodal'] = $back_path.'/editmodal';
$route['userpassword'] = $back_path.'/edituserpassword';
$route['exportexcel'] = $back_path.'/excelexport';
$route['generatepdf'] = $back_path.'/generatepdf';
$route['importexcel'] = $back_path.'/importexcel';
$route[SKYDASH.'/logout'] = $back_path.'/logout';


// admin login password enc: X>|Rq+zvOhnY+_?7
// admin session enc: ")Pf_1R}*E><d>#*ReY%
// public & private key file ma store 
// RSA thi encription thse
//http://www.unit-conversion.info/texttools/random-string-generator/
//abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+{}":><?\|>


