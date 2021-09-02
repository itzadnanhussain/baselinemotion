<?php

defined('BASEPATH') OR exit('No direct script access allowed');  
$route['default_controller'] = 'dashboard';  

///\\\\\\\\\Start Of Pre Events Routes////////////\\\

$route['pre_event/checklist']='Pre_Event'; 
$route['pre_event/manage_checklist']='Pre_Event/manage_pre_event';  

///\\\\\\\\\\\\End Of Pre Event Routes/////////////\\\


///Debuging Routes
$route['testfn']="Pre_Event/test";


///\\\\\\\\\\\\\Delete////////////////////\\\
$route['delete/(:any)/(:any)/(:num)']='Pre_Event/DeleteRecord'; 
$route['testemail'] = 'cronjob/test_email';  
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
