<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/

defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/

defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/

defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

define('HEADER', 'WorkWide');
define('TITLE', 'WorkWide');
define('FOOTER', '©2017 All Rights Reserved. WorkWide. Privacy and Terms');

//Email setting
//define('TO_EMAIL', 'quinticarsa@gmail.com');

//Table Name
define('QM_BRANCH', 'qm_branch');
define('QM_CUSTOMER_DETAILS', 'qm_customer_details');
define('QM_ENTITY', 'qm_entity');
define('QM_ASSET_CATEGORY', 'qm_asset_category');
define('QM_ASSET', 'qm_asset');
define('QM_FSE_DETAILS', 'qm_fse_details');
define('QM_FSE_DETAILS_ENGINEERS', 'qm_fse_details_engineer_types');
define('QM_FSE_TYPE', 'qm_fse_type');
define('QM_ENTITY_FSE_TYPE', 'qm_entity_fse_type');
define('QM_FSE_LOCATION', 'qm_fse_location');
define('QM_INCIDENT', 'qm_incident');
define('QM_PROJECT', 'qm_project');
define('QM_SLA', 'qm_sla');
define('QM_STATUS_TYPE', 'qm_status_type');
define('QM_TASK', 'qm_task');
define('QM_TASK_DETAILS', 'qm_task_details');
define('QM_TASK_EQUIPMENT', 'qm_task_equipment');
define('QM_TASK_LOCATION', 'qm_task_location');
define('QM_TASK_TYPE', 'qm_task_type');
define('QM_CALL_STATUS_TYPE', 'qm_call_status');
define('QM_CALL_TYPE', 'qm_call_type');
define('QM_PRIORITY', 'qm_priority');
define('QM_WEB_ACCESS', 'qm_web_access');
define('QM_WEB_USER_TYPE', 'qm_web_user_type');
define('QM_WORK_ORDER', 'qm_work_order');
define('QM_USER_PERMISSION', 'qm_user_permission');
define('QM_NOTIFICATION', 'qm_notification');
define('QM_ZONE', 'qm_zone');
define('QM_MOBILE_NOTIFICATION', 'qm_mobile_notification');
define('QM_USER_ASSIGN_ENTITY', 'qm_user_assign_entity');
define('QM_FSE_VIEW_PAGE', 'qm_fse_view_page');
define('QM_FSE_ACTION_PAGE', 'qm_fse_action_page');
define('QM_TASK_ASSET', 'qm_task_asset');
define('QM_SERVICE_NOW_ASSETS', 'qm_service_now_assets');
define('QM_ENTITY_SETTING', 'qm_entity_setting');
define('QM_CLOSE_CODE', 'qm_close_code');
define('QM_TASK_CUSTOMER_DOCUMENT', 'qm_task_customer_document');
define('QM_SECTION_CODE', 'qm_section_code');
define('QM_ACTION_CODE', 'qm_action_code');
define('QM_LOCATION_CODE', 'qm_location_code');
define('QM_API_SETTING', 'qm_api_setting');
define('QM_PRODUCT_LINE', 'qm_product_line');
define('QM_PROBLEM_ONE', 'qm_problem_one');
define('QM_PROBLEM_TWO', 'qm_problem_two');
define('QM_SN_LOCATION', 'qm_sn_location');
define('QM_LOGS', 'qm_task_create_log');
define('QM_CATEGORY', 'qm_category');
define('QM_EXTRA_ATTR_DEFINITION', 'qm_extra_attr_definition');
define('QM_EXTRA_ATTR_VALUES', 'Extra_attr_Values');
define('API_SETTINGS', 'API_Settings');
define('QM_THIRDPARTY_API_LOG', 'qm_thirdparty_api_log');
define('API_MAPPING', 'API_Mapping');
define('QM_COMMANDS', 'qm_commands');
define('QM_TP_LOGS', 'qm_task_create_log');
define('QM_EXTRA_ATTR_UPDATE', 'qm_extra_attr_update');
define('QM_EXTRA_ATTR_UPDATE_VALUE', 'qm_extra_attr_update_value');
define('QM_SELECT_VALUE', 'qm_select_value');
define('QM_OFFLINE_MOBILE_DATA', 'qm_offline_mobile_data');

define('QUINTICA_PRODUCTION_URL', 'https://quinticanashuadev.service-now.com');

//define('QUINTICA_PRODUCTION_URL', 'https://quinticanashuaprod.service-now.com/');

define('SERVICE_NOW_USERNAME', 'q_mobility_integration');
define('SERVICE_NOW_PASSWORD', 'q_mobility_integration');

define('DOC_SERVICE_NOW_USERNAME', 'q_mobility_integration_attachment');
define('DOC_SERVICE_NOW_PASSWORD', 'ASDH!@#$N!%!@#$NF');

//define('DOCUMENT_STORE_PATH', '/var/www/html/customerdocument/');
define('DOCUMENT_STORE_PATH', '/home/admin/web/qwork-dev2.quintica.com/public_html/qwork-dev.com/customerdocument/');
define('ERROR_LOG_PATH', '/var/www/html/Qmobility3/errorlog/');

define('ANDROID_API_ACCESS_KEY_FOR_PUSH_NOTIFICATION', 'AAAAfLyPu_c:APA91bFwK3xb3ATM7zKAzmssI0pY5QsLAjiJN3NPXPb0Mmg9hW8cTekZ0I5HsWy5_M8Y-l5GkvCm21ntEynn4UnalzWIxo0E5Y403Y_s6uKOO4Hha509UzbFI-rTy0UH-BYf8gS3cYdt');
define('SERVICE_NOW_API_KEY', 'QmobilitySYNserviceNow');
define('SERVICE_NOW_DEFAULT_FSE_ID', 1);
