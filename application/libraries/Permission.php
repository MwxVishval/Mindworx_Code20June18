<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Permission {

    public function user_permission($datas = NULL) {
        $page = array();
        //$page['PAGE_DASHBOARD'] = 1;
        $page['PAGE_ENTITY'] = 2;
        $page['PAGE_ENTITY_OPTION'] = 25;
//        $page['PAGE_BRANCH'] = 3;
        //$page['PAGE_ASSET'] = 4;
        //$page['PAGE_ASSET_CATEGORY'] = 5;
        $page['PAGE_SERVICE_ENGINEER'] = 6;
        $page['PAGE_FSE_TYPE'] = 7;
        $page['PAGE_TASK'] = 8;
//        $page['PAGE_WORK_ORDER'] = 9;
//        $page['PAGE_INCIDENT'] = 10;
//        $page['PAGE_PROJECT'] = 11;
        $page['PAGE_WEB_USER'] = 12;
//        $page['PAGE_STATUS_TYPE'] = 13;
        $page['PAGE_USER_TYPE'] = 14;
//        $page['PAGE_SLA'] = 15;
       // $page['PAGE_PERMISSION'] = 16;
        //$page['PAGE_TASK_TYPE'] = 17;
        //$page['PAGE_CUSTOMER'] = 18;
//        $page['PAGE_CALL_STATUS'] = 22;
//        $page['PAGE_CALL_TYPE'] = 23;
        $page['PAGE_PRIORITY'] = 24;
//        $page['PAGE_REPORT'] = 19;
        $page['PAGE_UI_LOAD_REPORT'] = 20;
        $page['PAGE_UI_ACTION_REPORT'] = 21;
        

       // $option['PAGE_DASHBOARD'] = array('1');
        $option['PAGE_ENTITY'] = array('1', '2', '3', '4');
        $option['PAGE_ENTITY_OPTION'] = array('1', '2', '3', '4');
      //  $option['PAGE_BRANCH'] = array('1', '2', '3', '4');
        //$option['PAGE_ASSET'] = array('1', '2', '3', '4');
        //$option['PAGE_ASSET_CATEGORY'] = array('1', '2', '3', '4');
        $option['PAGE_SERVICE_ENGINEER'] = array('1', '2', '3', '4');
        $option['PAGE_FSE_TYPE'] = array('1', '2', '3', '4');
        $option['PAGE_TASK'] = array('1', '2', '3', '4');
     //   $option['PAGE_WORK_ORDER'] = array('1', '2', '3', '4');
     //   $option['PAGE_INCIDENT'] = array('1', '2', '3', '4');
     //   $option['PAGE_PROJECT'] = array('1', '2', '3', '4');
        $option['PAGE_WEB_USER'] = array('1', '2', '3', '4');
     //   $option['PAGE_STATUS_TYPE'] = array('1', '2', '3', '4');
        $option['PAGE_USER_TYPE'] = array('1', '2', '3', '4');
     //   $option['PAGE_SLA'] = array('1', '2', '3', '4');
       // $option['PAGE_PERMISSION'] = array('1', '2', '3', '4');
        //$option['PAGE_TASK_TYPE'] = array('1', '2', '3', '4');
        //$option['PAGE_CUSTOMER'] = array('1', '2', '3', '4');
     //   $option['PAGE_REPORT'] = array('1');
        $option['PAGE_UI_LOAD_REPORT'] = array('1');
        $option['PAGE_UI_ACTION_REPORT'] = array('1');
   //     $option['PAGE_CALL_STATUS'] = array('1', '2', '3', '4');
    //    $option['PAGE_CALL_TYPE'] = array('1', '2', '3', '4');
        $option['PAGE_PRIORITY'] = array('1', '2', '3', '4');
        
        
        
        $radio['VIEW'] = 1;
        $radio['ADD'] = 2;
        $radio['EDIT'] = 3;
        $radio['DELETE'] = 4;
        // $radio['HIDE'] = 0;
//        $data['page'] = $page;
//        $data['radio'] = $radio;
        $html = "";
        foreach ($page AS $key => $value) {
            $page_key = str_replace("_", " ", $key);
            $html .= '<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">' . $page_key . ' <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <!--<input type="text" id="permission_value" name="permission_value" value="" class="form-control col-md-7 col-xs-12">-->
		 <div class="checkbox">';
            foreach ($radio AS $k => $v) {

                $option_check = $option[$key];
                if (in_array($v, $option_check)) {
                    $checked = "";
                    if ($datas != NULL) {
                        $permission = json_decode($datas[0]['permission_code']);
                        $check = $value . '#' . $v;
                        if ($permission != NULL) {
                            if (in_array($check, $permission)) {
                                $checked = "checked";
                            }
                        }
                    }
                    $html .= '<label><input type="checkbox" value="' . $value . '#' . $v . '" id="permission_value" name="permission_code[]" ' . $checked . '> ' . $k . '</label>  ';
                }
            }
            $html .= '</div>
                       </div>
			 <div>
                   <!-- <span class="text-danger"></span>-->
		</div>
            </div>';
        }

        return $html;
    }

}
