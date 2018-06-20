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
//$route['default_controller'] = 'welcome';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['default_controller'] = 'LoginController/index';
$route['logout'] = 'LoginController/logout';
$route['locked'] = 'LoginController/locked';

$route['check'] = 'LoginController/check';
$route['dashboard2'] = "HomeController/index";
$route['dashboard'] = "HomeController/dashboard";
$route['assetrouting'] = "AssetRoutingController/assetrouting";
$route['accessDenied'] = "HomeController/accessDenied";

$route['entity'] = 'ManagementController/company';
$route['addEntity'] = 'ManagementController/company_add';
$route['updateEntity'] = 'ManagementController/company_update';

$route['branch'] = 'ManagementController/branch';
$route['addBranch'] = 'ManagementController/branch_add';
$route['updateBranch'] = 'ManagementController/branch_update';


$route['asset'] = 'ManagementController/asset';
$route['addAsset'] = 'ManagementController/asset_add';
$route['updateAsset'] = 'ManagementController/asset_update';

$route['assetcategory'] = 'ManagementController/assetcategory';
$route['addAssetCategory'] = 'ManagementController/assetcategory_add';
$route['updateAssetCategory'] = 'ManagementController/assetcategory_update';


$route['serviceEngineer'] = 'ManagementController/serviceEngineer';
$route['addserviceEngineer'] = 'ManagementController/fse_add';
$route['updateserviceEngineer'] = 'ManagementController/fse_update';
$route['resetPassword'] = 'ManagementController/resetpassword';

$route['fseType'] = 'ManagementController/fseType';
$route['addFSEType'] = 'ManagementController/fseType_add';
$route['updateFSEType'] = 'ManagementController/fseType_update';

$route['customer'] = 'ManagementController/customer';
$route['addCustomer'] = 'ManagementController/customer_add';
$route['updateCustomer'] = 'ManagementController/customer_update';

$route['management'] = 'ManagementController/index';

$route['tasklist'] = 'TaskController/taskList';
$route['task'] = 'TaskController/task';
$route['addTask'] = 'TaskController/addTask';
$route['updateTask'] = 'TaskController/updateTask';
$route['alltasks'] = 'TaskController/alltasks';
$route['taskreport'] = 'TaskController/taskreporttemplate';

$route['taskType'] = 'TaskController/taskType';
$route['addTaskType'] = 'TaskController/taskType_add';
$route['updateTaskType'] = 'TaskController/taskType_update';

$route['workOrder'] = 'WorkOrderController/workOrder';
$route['addWorkOrder'] = 'WorkOrderController/addWorkOrder';
$route['updateWorkOrder'] = 'WorkOrderController/updateWorkOrder';

$route['incident'] = 'ManagementController/incident';
$route['addIncident'] = 'ManagementController/incident_add';
$route['updateIncident'] = 'ManagementController/incident_update';

$route['project'] = 'ManagementController/project';
$route['projectTask'] = 'ManagementController/projectTask';
$route['getTasks'] = 'ManagementController/getTasks';
$route['addProject'] = 'ManagementController/project_add';
$route['updateProject'] = 'ManagementController/project_update';

$route['webuser'] = 'ManagementController/webuser';
$route['addWebuser'] = 'ManagementController/webuser_add';
$route['updateWebuser'] = 'ManagementController/webuser_update';

$route['statusType'] = 'ManagementController/statusType';
$route['addStatusType'] = 'ManagementController/statusType_add';
$route['updateStatusType'] = 'ManagementController/statusType_update';

$route['userType'] = 'ManagementController/userType';
$route['addUserType'] = 'ManagementController/userType_add';
$route['updateUserType'] = 'ManagementController/userType_update';

$route['sla'] = 'ManagementController/sla';
$route['addSLA'] = 'ManagementController/sla_add';
$route['updateSLA'] = 'ManagementController/sla_update';

$route['priorityType'] = 'ManagementController/priorityType';
$route['addPriorityType'] = 'ManagementController/priorityType_add';
$route['updatePriorityType'] = 'ManagementController/priorityType_update';

$route['callType'] = 'ManagementController/callType';
$route['addCallType'] = 'ManagementController/callType_add';
$route['updateCallType'] = 'ManagementController/callType_update';

$route['callstatusType'] = 'ManagementController/callstatusType';
$route['addCallStatusType'] = 'ManagementController/callstatusType_add';
$route['updateCallStatusType'] = 'ManagementController/callstatusType_update';

$route['apiSetting'] = 'ManagementController/apiSetting';
$route['apiSetting_add'] = 'ManagementController/apiSetting_add';
$route['apiSetting_update'] = 'ManagementController/apiSetting_update';

$route['report'] = 'ReportController/index';
$route['addPermission'] = 'ReportController/permission_add';
$route['updatePermission'] = 'ReportController/permission_update';
$route['generateReport'] = 'ReportController/generate_report';
$route['Logs'] = 'LogsController/log';

$route['UiLoad'] = 'ReportController/generate_reportUiLoad';
$route['UiAction'] = 'ReportController/generate_reportUiAction';

$route['fcm'] = 'FcmController/index';

$route['setting'] = 'ManagementController/userSetting';

//$route['nuSoapServer/getMember/wsdl'] = 'nuSoapServer/index/wsdl';

$route['categories'] = 'EntitySettingController/index';
$route['category'] = 'EntitySettingController/category';
$route['addCategory'] = 'EntitySettingController/category_add';
$route['updateCategory'] = 'EntitySettingController/category_update';

$route['tasksheet'] = 'EntitySettingController/task_sheet';
