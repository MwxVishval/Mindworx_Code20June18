<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Api extends REST_Controller {

    function __construct() {

        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 500; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model("ApiModel");

        // check fields
        $keyArray = array();
        $postArray = array();
    }
     public function index_getww() {
         $this->
        $message = [
            'message' => 'Invalid method',
            'status' => 'Failed',
            'code' => '0',
        ];
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function index_get() {
        $message = [
            'message' => 'Invalid method',
            'status' => 'Failed',
            'code' => '0',
        ];
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function checkPost($postArray = NULL, $keyArray = NULL) {

        $return_val = 'TRUE';

        if ((!empty($postArray)) && (!empty($keyArray))) {

            foreach ($postArray as $key => $value) {
                if (array_key_exists($key, $keyArray)) {
                    if ($keyArray[$key] == 'required') {
                        if (trim($postArray[$key]) == "") {
                            $return_val = 'FALSE';
                        }
                    }
                } else {
                    $return_val = 'FALSE';
                }
            }
        } else {
            $return_val = 'FALSE';
        }
        foreach ($keyArray AS $k => $v) {
            if (!array_key_exists($k, $postArray)) {
                if ($keyArray[$k] != "optional") {
                    $return_val = 'FALSE';
                }
            }
        }
        return $return_val;
    }

    public function tokenValid($token = NULL, $userid = NULL) {

        if ($token != NULL) {

            if ($token == "QkkdfrRNOD1OmcsdkEJKKxcv") {
                return 1;
            } else {
                return $this->ApiModel->fse_token($token, $userid);
            }
        }
    }
    
    public function disp_get() {
         $getArray = $this->get();
         $keyArray['latitude'] = 'required'; //required (or)  not_required (or) optional 
         $keyArray['langitude'] = 'required'; //required (or)  not_required (or) optional 
         $keyArray['userid'] = 'required';         
         $keyArray['TOKEN'] = 'required';
         
         if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
             //echo $getArray['TOKEN']; exit(); 
              $userID = $this->tokenValid($getArray['TOKEN']);
             if ($userID != FALSE) {
                // echo 'done '; exit(); 
                  $this->ApiModel->disp($getArray); 
                 $message = [
                    'data' => $getArray['TOKEN'],
                    'message' => 'Location insert successfully',
                    'status' => 'success',
                    'code' => '1',
                ];
                } else {
                    $message = [
                                   'message' => 'Token not valid ',
                                   'status' => 'Failed',
                                   'code' => '0',
                               ];
                }
              
         } else {
            $required_key = array('TOKEN' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);      
      
    }

    public function login_get() {

        $postArray = $this->get();

        $keyArray['username'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['password'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['device_id'] = 'optional'; //required (or)  not_required (or) optional
        $keyArray['device_OS'] = 'optional'; //required (or)  not_required (or) optional
        $keyArray['versioncode'] = 'optional'; //required (or)  not_required (or) optional
        if ($this->checkPost($postArray, $keyArray) == 'TRUE') {
            $device = NULL;
            $device_OS = NULL;
            $versioncode = NULL;
            if (isset($postArray['device_id'])) {
                $device = $postArray['device_id'];
            }
            if (isset($postArray['device_OS'])) {
                $device_OS = $postArray['device_OS'];
            }
            if (isset($postArray['versioncode'])) {
                $versioncode = $postArray['versioncode'];
            }
            $token = $this->ApiModel->fse_login($postArray['username'], $postArray['password'], $device, $device_OS, $versioncode);
            if ($token != FALSE) {
                $this->ApiModel->fseViewReportPage($token['user_id'], '1', 'Login');
                $message = [
                    'data' => $token,
                    'message' => 'Login successfully',
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $message = [
                    'TOKEN' => '',
                    'message' => 'Login Failed',
                    'status' => 'success',
                    'code' => '0',
                ];
            }
        } else {

            $required_key = array('username' => 'required', 'password' => 'required', 'device_id' => 'optional', 'device_OS' => 'optional');

            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
    }

    public function inprogessTaskId_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'optional'; //required (or)  not_required (or) optional 
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userId = NULL;
            if (isset($getArray['userid'])) {
                $userId = $getArray['userid'];
            }
            $userID = $this->tokenValid($getArray['TOKEN'], $userId);
            if ($userID != FALSE) {
                $data = $this->ApiModel->inprogessTaskId($userID);
                $message = [
                    'message' => 'Response Successfully',
                    'TaskId' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function login_post() {
        echo 'sti';        exit(); 

        $postArray = $this->post();
        $keyArray['username'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['password'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['device_id'] = 'optional'; //required (or)  not_required (or) optional 
        $keyArray['device_OS'] = 'optional'; //required (or)  not_required (or) optional
        $keyArray['versioncode'] = 'optional'; //required (or)  not_required (or) optional
        if ($this->checkPost($postArray, $keyArray) == 'TRUE') {
            $device = NULL;
            $device_OS = NULL;
            $versioncode = NULL;
            if (isset($postArray['device_id'])) {
                $device = $postArray['device_id'];
            }
            if (isset($postArray['device_OS'])) {
                $device_OS = $postArray['device_OS'];
            }
            if (isset($postArray['versioncode'])) {
                $versioncode = $postArray['versioncode'];
            }
            $token = $this->ApiModel->fse_login($postArray['username'], $postArray['password'], $device, $device_OS, $versioncode);
            if ($token != FALSE) {
                $message = [
                    'TOKEN' => $token,
                    'message' => 'Login successfully',
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $message = [
                    'TOKEN' => '',
                    'message' => 'Login Failed',
                    'status' => 'success',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('username' => 'required', 'password' => 'required', 'device_id' => 'optional', 'device_OS' => 'optional');

            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK); // CREATED (201) being the HTTP response code
    }

    public function resetPassword_post() {

        $getArray = $this->post();
        $keyArray['emailid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'optional'; //required (or)  not_required (or) optional 
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            if (filter_var($getArray['emailid'], FILTER_VALIDATE_EMAIL)) {
                $userId = NULL;
                if (isset($getArray['userid'])) {
                    $userId = $getArray['userid'];
                }
                $data = $this->ApiModel->resetPassword($getArray['emailid'], $userId);
                if ($data != FALSE) {
                    $this->load->library('email');
                    $this->email->from(TO_EMAIL);
                    $this->email->to($getArray['emailid']);
                    $this->email->subject('WorkWide Password Reset');
                    $message = $this->load->view('email/resetPassword', $data, TRUE);
                    $this->email->message($message);
                    $this->email->send();
                    $message = [
                        'message' => 'Username and password send Successfully',
                        'status' => 'success',
                        'code' => '1',
                    ];
                } else {
                    $message = [
                        'message' => 'Enter valid Email',
                        'status' => 'Failed',
                        'code' => '0',
                    ];
                }
            } else {

                $message = [
                    'message' => 'Enter valid Email',
                    'emailid' => 'Invalid email format',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('emailid' => 'required', 'userid' => 'optional');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function updatePassword_post() {

        $getArray = $this->post();
        $keyArray['oldPassword'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['newPassword'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['userId'] = 'required'; //required (or)  not_required (or) optional 

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $data = $this->ApiModel->updatePassword($getArray);
            if ($data != FALSE) {
                $this->load->library('email');
                $this->email->from(TO_EMAIL);
                $this->email->to($data['fse_email']);
                $this->email->subject('WorkWide Password Reset');
                $message = $this->load->view('email/resetPassword', $data, TRUE);
                $this->email->message($message);
                $this->email->send();
                $message = [
                    'message' => 'Username and password send Successfully',
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $message = [
                    'message' => 'Check old password',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('userId' => 'required', 'oldPassword' => 'required', 'newPassword' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function updatePassword_get() {

        $getArray = $this->get();
        $keyArray['oldPassword'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['newPassword'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['userId'] = 'required'; //required (or)  not_required (or) optional 

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $data = $this->ApiModel->updatePassword($getArray);
            if ($data != FALSE) {
                $this->load->library('email');
                $this->email->from(TO_EMAIL);
                $this->email->to($data['fse_email']);
                $this->email->subject('WorkWide  Password Reset');
                $message = $this->load->view('email/resetPassword', $data, TRUE);
                $this->email->message($message);
                $this->email->send();
                $message = [
                    'message' => 'Username and password send Successfully',
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $message = [
                    'message' => 'Check old password',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('userId' => 'required', 'oldPassword' => 'required', 'newPassword' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function emailPassword_post() {

        $getArray = $this->post();
        $keyArray['userid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['oldpassword'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['newpassword'] = 'required'; //required (or)  not_required (or) optional

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $data = $this->ApiModel->emailPassword($getArray);
            if ($data != FALSE) {
                $this->load->library('email');
                $this->email->from(TO_EMAIL);
                $this->email->to($data['emailid']);
                $this->email->subject('WorkWide Password Reset');
                $message = $this->load->view('email/resetPassword', $data, TRUE);
                $this->email->message($message);
                $this->email->send();
                $message = [
                    'message' => 'Username and password send Successfully',
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $message = [
                    'message' => 'Check your Old or New password',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('emailid' => 'required', 'userid' => 'optional');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function emailPassword_get() {

        $getArray = $this->get();
        $keyArray['userid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['oldpassword'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['newpassword'] = 'required'; //required (or)  not_required (or) optional

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $data = $this->ApiModel->emailPassword($getArray);
            if ($data != FALSE) {
                $this->load->library('email');
                $this->email->from(TO_EMAIL);
                $this->email->to($data['emailid']);
                $this->email->subject('WorkWide Password Reset');
                $message = $this->load->view('email/resetPassword', $data, TRUE);
                $this->email->message($message);
                $this->email->send();
                $message = [
                    'message' => 'Username and password send Successfully',
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $message = [
                    'message' => 'Check your Old or New password',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('emailid' => 'required', 'userid' => 'optional');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function distanceCalc_get() {

        $getArray = $this->get();
        $keyArray['origins'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['destinations'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['task_id'] = 'required';

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $destinations = '(' . urldecode($getArray['origins'] . ')');
            $insert_result = array('start_location' => $destinations);
            $this->ApiModel->UpdateDataGeo($insert_result, $getArray['task_id'], QM_TASK_LOCATION);

            $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $getArray['origins'] . "&destinations=" . $getArray['destinations'];
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $res = curl_exec($curl);
            if (curl_errno($curl)) {
                throw new Exception(curl_error($curl));
            }
            curl_close($curl);
            $json = json_decode(trim($res), true);

            // echo "<pre>";
            //print_r($json['rows'][0]['elements'][0]);
            $result = $json['rows'][0]['elements'][0];

            $code = 1;
            if (isset($result['status'])) {
                if ($result['status'] == 'ZERO_RESULTS') {
                    $code = 0;
                    $result['status'] = 'NOT_FOUND';
                }
            }
            $message = [
                'message' => 'Success fetch',
                'data' => $result,
                'status' => 'Success',
                'code' => $code,
            ];
        } else {
            $required_key = array('origins' => 'required', 'destinations' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'success',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function resetPassword_get() {

        $getArray = $this->get();
        $keyArray['emailid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'optional'; //required (or)  not_required (or) optional
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {

            if (filter_var($getArray['emailid'], FILTER_VALIDATE_EMAIL)) {
                $userId = NULL;
                if (isset($getArray['userid'])) {
                    $userId = $getArray['userid'];
                }
                $data = $this->ApiModel->resetPassword($getArray['emailid'], $userId);
                if ($data != FALSE) {
                    $this->load->library('email');
                    $this->email->from(TO_EMAIL);
                    $this->email->to($getArray['emailid']);
                    $this->email->subject('WorkWide Password Reset');
                    $message = $this->load->view('email/resetPassword', $data, TRUE);
                    $this->email->message($message);
                    $this->email->send();
                    $message = [
                        'message' => 'Username and password send Successfully',
                        'status' => 'success',
                        'code' => '1',
                    ];
                } else {
                    $message = [
                        'message' => 'Enter valid Email',
                        'status' => 'Failed',
                        'code' => '0',
                    ];
                }
            } else {
                $message = [
                    'message' => 'Enter valid Email',
                    'emailid' => 'Invalid email format',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('emailid' => 'required', 'userid' => 'optional');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function taskCount_post() {

        $getArray = $this->post();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'optional'; //required (or)  not_required (or) optional 

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userId = NULL;
            if (isset($getArray['userid'])) {
                $userId = $getArray['userid'];
            }
            $userID = $this->tokenValid($getArray['TOKEN'], $userId);
            if ($userID != FALSE) {
                $data = $this->ApiModel->taskCount($userID);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('emailid' => 'required', 'userid' => 'optional');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'userid' => 'optional');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function taskAsset_post() {

        $getArray = $this->post();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['task_id'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['asset_details'] = 'required'; //required (or)  not_required (or) optional

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userId = NULL;
            if (isset($getArray['userid'])) {
                $userId = $getArray['userid'];
            }
            $userID = $this->tokenValid($getArray['TOKEN'], $userId);
            if ($userID != FALSE) {
                $data = $this->ApiModel->taskAsset($getArray);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'task_id' => 'required', 'asset_details' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function taskAsset_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['task_id'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['asset_details'] = 'required'; //required (or)  not_required (or) optional

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userId = NULL;
            if (isset($getArray['userid'])) {
                $userId = $getArray['userid'];
            }
            $userID = $this->tokenValid($getArray['TOKEN'], $userId);
            if ($userID != FALSE) {
                $data = $this->ApiModel->taskAsset($getArray);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'task_id' => 'required', 'asset_details' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function taskUpdataServiceNow_get() {

        $getArray = $this->get();
        $keyArray['task_name'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['fse_task_comments'] = 'required'; //required (or)  not_required (or) optional 
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $data = $this->ApiModel->taskUpdataServiceNow($getArray['task_name'], $getArray['fse_task_comments']);
            $message = [
                'message' => 'Response Successfully',
                'data' => $data,
                'status' => 'success',
                'code' => '1',
            ];
        } else {
            $required_key = array('TOKEN' => 'required', 'task_id' => 'required', 'asset_details' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function taskCount_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'optional'; //required (or)  not_required (or) optional 
        $keyArray['format'] = 'optional';
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userId = NULL;
            if (isset($getArray['userid'])) {
                $userId = $getArray['userid'];
            }
            $userID = $this->tokenValid($getArray['TOKEN'], $userId);
            if ($userID != FALSE) {
                $data = $this->ApiModel->taskCount($userID);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('emailid' => 'required', 'userid' => 'optional');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'userid' => 'optional');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function statusType_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'optional'; //required (or)  not_required (or) optional 

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->statusType();
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('emailid' => 'required', 'userid' => 'optional');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'userid' => 'optional');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function statusType_post() {

        $getArray = $this->post();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'optional'; //required (or)  not_required (or) optional 
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->statusType();
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('emailid' => 'required', 'userid' => 'optional');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'userid' => 'optional');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function taskListSearch_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['startdate'] = 'required';
        $keyArray['enddate'] = 'required';
        $keyArray['statusType'] = 'optional';
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $statusType = NULL;
            if (isset($getArray['statusType'])) {
                $statusType = $getArray['statusType'];
            }
            $userID = $this->tokenValid($getArray['TOKEN'], $getArray['userid']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->taskListSearch($userID, $statusType, $getArray['startdate'], $getArray['enddate']);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('userid' => 'required', 'startdate' => 'required (Y-m-d)', 'enddate' => 'required required (Y-m-d)', 'statusType' => 'optional');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'userid' => 'required', 'startdate' => 'required (Y-m-d)', 'enddate' => 'required required (Y-m-d)', 'statusType' => 'optional');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function taskList_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['statusType'] = 'required';
        $keyArray['fromdashboard'] = 'optional';
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $statusType = NULL;
            if (isset($getArray['statusType'])) {
                $statusType = $getArray['statusType'];
            }
            $userid = NULL;
            if (isset($getArray['userid'])) {
                $userid = $getArray['userid'];
            }
            $fromdashboard = 0;
            if (isset($getArray['fromdashboard'])) {
                $fromdashboard = 1;
            }


            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->taskList($userID, $statusType, $fromdashboard);

                if (isset($data[0]['integrated_api'])) {
                    $data_api = json_decode($data[0]['integrated_api']);
                    $data[0]['task_type_flow'] = $data_api->allow_for;
                    $data[0]['integrated_api'] = null;
                    $data[0]['completed_screen_data'] = null;
                }
                $this->ApiModel->fseViewReportPage($userID, '2', 'TaskList');
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('emailid' => 'required', 'userid' => 'required', 'statusType' => 'optional');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'userid' => 'optional');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function pushNotificationViewed_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['isviewed'] = 'required';
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $statusType = NULL;
            if (isset($getArray['statusType'])) {
                $statusType = $getArray['statusType'];
            }
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->pushNotificationViewed($getArray['taskid'], $getArray['isviewed']);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'taskid' => 'required', 'isviewed' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function pushNotificationList_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $statusType = NULL;
            if (isset($getArray['statusType'])) {
                $statusType = $getArray['statusType'];
            }
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->pushNotificationList($userID);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function pushNotificationUnreadCount_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $statusType = NULL;
            if (isset($getArray['statusType'])) {
                $statusType = $getArray['statusType'];
            }
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->pushNotificationUnreadCount($userID);
                $message = [
                    'message' => 'Response Successfully',
                    'count' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function pushNotificationRead_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $statusType = NULL;
            if (isset($getArray['statusType'])) {
                $statusType = $getArray['statusType'];
            }
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->pushNotificationRead($userID);
                $message = [
                    'message' => 'Response Successfully',
                    'count' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function taskLists_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['statusType'] = 'optional';
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $statusType = NULL;
            if (isset($getArray['statusType'])) {
                $statusType = $getArray['statusType'];
            }
            $userID = $this->tokenValid($getArray['TOKEN'], $getArray['userid']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->taskLists($userID, $statusType);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('emailid' => 'required', 'userid' => 'required', 'statusType' => 'optional');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'userid' => 'optional');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function taskDetails_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        //$keyArray['userid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required';
        //  $keyArray['statusType'] = 'optional';
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $statusType = NULL;
            if (isset($getArray['statusType'])) {
                $statusType = $getArray['statusType'];
            }
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->taskDetails($getArray['taskid']);

                if (isset($data[0]['integrated_api'])) {
                    $data_api = json_decode($data[0]['integrated_api']);

                    $data[0]['task_type_flow'] = $data_api->allow_for;
                    $data[0]['integrated_api'] = null;
                    $data[0]['completed_screen_data'] = null;
                }

                $this->ApiModel->fseViewReportPage($userID, '3', 'Task Details');
                $this->ApiModel->fseUiActionReportPage($userID, '3', 'Click on tasklist');
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('emailid' => 'required', 'userid' => 'required', 'statusType' => 'optional');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'taskid' => 'optional');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function taskList_post() {

        $getArray = $this->post();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['statusType'] = 'optional';
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $statusType = NULL;
            if (isset($getArray['statusType'])) {
                $statusType = $getArray['statusType'];
            }
            $userID = $this->tokenValid($getArray['TOKEN'], $getArray['userid']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->taskList($userID, $statusType);
                $this->ApiModel->fseViewReportPage($userID, '2', 'TaskList');
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('emailid' => 'required', 'userid' => 'required', 'statusType' => 'optional');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'userid' => 'optional');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function fseProfilePic_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['pictureString'] = 'required'; //required (or)  not_required (or) optional
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN'], $getArray['userid']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->fseProfilePic($userID, $getArray['pictureString']);
                $message = [
                    'message' => 'Response Successfully',
                    'Upload status' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('emailid' => 'required', 'userid' => 'required', 'statusType' => 'optional');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'userid' => 'optional');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function fseProfilePic_post() {

        $getArray = $this->post();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['pictureString'] = 'required'; //required (or)  not_required (or) optional
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN'], $getArray['userid']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->fseProfilePic($userID, $getArray['pictureString']);
                $message = [
                    'message' => 'Response Successfully',
                    'Upload status' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('emailid' => 'required', 'userid' => 'required', 'statusType' => 'optional');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'userid' => 'optional');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function taskFeedbackold_get() {

        $getArray = $this->get();
        //  print_r($getArray);
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['fsefeedback'] = 'optional';
        $keyArray['custSign'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['taskid'] = 'required';
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                if (isset($getArray['fsefeedback'])) {
                    $fsefeedback = $getArray['fsefeedback'];
                } else {
                    $fsefeedback = NULL;
                }
                $this->base64ToimageCustomer();
                $this->serviceNowCustomerSignpush();
                $data = $this->ApiModel->fseTaskFeedbackCustSign($userID, $getArray['taskid'], $fsefeedback, $getArray['custSign']);
                $this->ApiModel->fseUiActionReportPage($userID, '3', 'Click on tasklist');
                $message = [
                    'message' => 'Response Successfully',
                    // 'Upload status' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'fsefeedback' => 'required', 'custSign' => 'required', 'userid' => 'required', 'taskid' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function taskFeedback_get() {

        $getArray = $this->get();
        //  print_r($getArray);
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['fsefeedback'] = 'optional';
        $keyArray['fseRating'] = 'optional';
        $keyArray['custSign'] = 'optional'; //required (or)  not_required (or) optional
        $keyArray['taskid'] = 'required';
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                if (isset($getArray['fsefeedback'])) {
                    $fsefeedback = $getArray['fsefeedback'];
                } else {
                    $fsefeedback = NULL;
                }

                if (isset($getArray['custSign'])) {
                    $custSign = $getArray['custSign'];
                } else {
                    $custSign = NULL;
                }

                if (isset($getArray['fseRating'])) {
                    $fseRating = $getArray['fseRating'];
                } else {
                    $fseRating = NULL;
                }
                $data = $this->ApiModel->fseTaskFeedbackCustSign($userID, $getArray['taskid'], $fsefeedback, $custSign, $fseRating);
                $this->base64ToimageCustomer();
                $this->serviceNowCustomerSignpush();
                $message = [
                    'message' => 'Response Successfully',
                    // 'Upload status' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'fsefeedback' => 'optional', 'fseRating' => 'optional', 'custSign' => 'optional', 'taskid' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function taskFeedback_post() {

        $getArray = $this->post();
        //  print_r($getArray);
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['fsefeedback'] = 'optional';
        $keyArray['fseRating'] = 'optional';
        $keyArray['custSign'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['taskid'] = 'required';
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            $this->ApiModel->thirdpartApiUpdate($getArray['taskid']);
            $this->ApiModel->thirdpartUpatetimeFeedback($getArray['taskid']);
            if ($userID != FALSE) {
                if (isset($getArray['fsefeedback'])) {
                    $fsefeedback = $getArray['fsefeedback'];
                } else {
                    $fsefeedback = NULL;
                }
                if (isset($getArray['custSign'])) {
                    $custSign = $getArray['custSign'];
                } else {
                    $fsefeedback = NULL;
                }
                if (isset($getArray['fseRating'])) {
                    $fseRating = $getArray['fseRating'];
                } else {
                    $fseRating = NULL;
                }
                $data = $this->ApiModel->fseTaskFeedbackCustSign($userID, $getArray['taskid'], $fsefeedback, $custSign, $fseRating);
                $this->base64ToimageCustomer();
                $this->serviceNowCustomerSignpush();
                $message = [
                    'message' => 'Response Successfully',
                    // 'Upload status' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'fsefeedback' => 'optional', 'fseRating' => 'optional', 'custSign' => 'optional', 'taskid' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function base64ToimageCustomer() {
        $result = $this->ApiModel->base64ToimageCustomer();
        foreach ($result AS $r) {
            $img = str_replace('data:image/png;base64,', '', $r['customer_sign']);
            $img = str_replace(' ', '+', $img);
            $datas = base64_decode($img);
            $id = $r['id'];
            file_put_contents(DOCUMENT_STORE_PATH . 'CustomerSign_' . $id . '.png', $datas);
        }
    }

    public function serviceNowCustomerSignpush() {

        $result = $this->ApiModel->pushCustomerSignToSN();
        foreach ($result AS $r) {
            $login = 'q_mobility_integration_attachment';
            $password = 'ASDH!@#$N!%!@#$NF';
            $sys_id = trim($r['sys_id']);
            $file_name = trim('CustomerSign_' . $r['id'] . '.png');
            $file = realpath(DOCUMENT_STORE_PATH . $file_name);
            $target_url = QUINTICA_PRODUCTION_URL . '/api/now/attachment/file?table_name=incident_task&table_sys_id=' . $sys_id . '&file_name=' . $file_name;
            $params = file_get_contents($file);
            $first_newline = strpos($params, "\r\n");
            $multipart_boundary = substr($params, 2, $first_newline - 2);
            $request_headers = array();
            $request_headers[] = 'Content-Length: ' . strlen($params);
            $request_headers[] = 'Content-Type: multipart/x-api-remote-integration; boundary='
                    . $multipart_boundary;
            $ch = curl_init($target_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: image/png'));
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
            $reply = curl_exec($ch);
            curl_close($ch);

            $this->ApiModel->updateCustomerSignPushed($r['id']);
            $task_log = array('task_log' => $r['sys_id'],
                'task_name' => $r['task_name'],
                'apiname' => 'Customer Sign Upload',
                'api_response' => json_encode($reply)
            );
            $this->ApiModel->InsertData('qm_task_create_log', $task_log);
        }
    }

    public function fseProfileImage_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'required'; //required (or)  not_required (or) optional 
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN'], $getArray['userid']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->fseProfileImage($userID);
                $message = [
                    'message' => 'Response Successfully',
                    // 'Upload status' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'fsefeedback' => 'required', 'custSign' => 'required', 'userid' => 'required', 'taskid' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        //  $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function entityLogo_get() {

        $getArray = $this->get();
        $keyArray['entityid'] = 'required'; //required (or)  not_required (or) optional 
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {

            if ($getArray['entityid'] != FALSE) {

                $data = $this->ApiModel->entityLogoImage($getArray['entityid']);
                $message = [
                    'message' => 'Response Successfully',
                    // 'Upload status' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'fsefeedback' => 'required', 'custSign' => 'required', 'userid' => 'required', 'taskid' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        //  $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function entityColor_get() {

        $getArray = $this->get();
        $keyArray['entityid'] = 'required'; //required (or)  not_required (or) optional 
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {

            if ($getArray['entityid'] != FALSE) {

                $data = $this->ApiModel->entityColor($getArray['entityid']);
                $message = [
                    'message' => 'Response Successfully',
                    'colorCode' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'fsefeedback' => 'required', 'custSign' => 'required', 'userid' => 'required', 'taskid' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function fseCustomerDetail_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['address'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['Landline'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['mobile'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['emailid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['attachment'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['signature'] = 'required'; //required (or)  not_required (or) optional 

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN'], $getArray['userid']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->fseProfileImage($userID);
                $message = [
                    'message' => 'Response Successfully',
                    // 'Upload status' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'userid' => 'required',
                'address' => 'required',
                'Landline' => 'required',
                'emailid' => 'required',
                'attachment' => 'required',
                'signature' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function taskCheckList_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional 

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->taskCheckList($getArray['taskid']);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'taskid' => 'required'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function taskCheckList_post() {

        $getArray = $this->post();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional 

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->taskCheckList($getArray['taskid']);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'taskid' => 'required'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function updatetaskStatus_get() {
        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['statusid'] = 'required'; //required (or)  not_required (or) optional

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->updatetaskStatus($getArray['taskid'], $getArray['statusid']);
                //$this->serviceNowtaskUpdates($getArray['taskid'], $getArray['statusid']);
                //  $this->serviceNowtaskUpdateStatusCheck($getArray['taskid'], $getArray['statusid']);

                $this->ApiModel->thirdpartApiUpdateStatus($getArray['taskid']);
                $this->ApiModel->thirdpartUpatetimeFeedback($getArray['taskid']);
                $task_log = array('task_log' => $getArray['statusid'],
                    'task_name' => $getArray['taskid'],
                    'apiname' => 'status test by cgvak',
                    'api_response' => "updatetaskStatus"
                );
                $this->ApiModel->InsertData('qm_task_create_log', $task_log);

                $message = [
                    'message' => 'Response Successfully',
                    'update' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'taskid' => 'required'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function updatetaskStatusAccept_get() {
        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['statusid'] = 'required'; //required (or)  not_required (or) optional

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->updatetaskStatusAccept($getArray['taskid'], $getArray['statusid']);
                //$this->serviceNowtaskUpdates($getArray['taskid'], $getArray['statusid']);
                $this->ApiModel->thirdpartApiUpdateStatus($getArray['taskid']);
                $task_log = array('task_log' => $getArray['statusid'],
                    'task_name' => $getArray['taskid'],
                    'apiname' => 'status test by cgvak',
                    'api_response' => "updatetaskStatusAccept"
                );
                $this->ApiModel->InsertData('qm_task_create_log', $task_log);


                //  $this->serviceNowtaskUpdateStatusCheck($getArray['taskid'], $getArray['statusid']);
                $message = [
                    'message' => 'Response Successfully',
                    'update' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'taskid' => 'required'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function updatetaskComment_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['comments'] = 'required'; //required (or)  not_required (or) optional
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->updatetaskComment($getArray['taskid'], $getArray['comments']);
                $message = [
                    'message' => 'Response Successfully',
                    'update' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'taskid' => 'required'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function updateTaskTime_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['startTime'] = 'optional';
        $keyArray['startLocation'] = 'optional';
        $keyArray['endTime'] = 'optional';
        $keyArray['startToWork'] = 'optional';
        $keyArray['endToWork'] = 'optional';

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                // $data = $this->ApiModel->updateTaskTime($getArray);
                // $this->ApiModel->fseViewReportPage($userID, '4', 'updateTaskTime');
                //  $this->ApiModel->fseUiActionReportPage($userID, '4', 'Click on End task');
                $message = [
                    'message' => 'Response Successfully',
                    // 'update' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'taskid' => 'required',
                'startTime' => 'optional',
                'startLocation' => 'optional',
                'endTime' => 'optional',
                'startToWork' => 'optional',
                'endToWork' => 'optional',
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function updateOfflineTask_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['customerId'] = 'optional';
        $keyArray['fseComment'] = 'optional';
        $keyArray['customerName'] = 'optional';
        $keyArray['customerMobile'] = 'optional';
        $keyArray['customerEmail'] = 'optional';
        $keyArray['customerAddress'] = 'optional';
        $keyArray['customerDocument'] = 'optional';
        $keyArray['customerSignature'] = 'optional';
        $keyArray['customerFeedback'] = 'optional';
        $keyArray['checklist'] = 'optional';
        $keyArray['status'] = 'optional';

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->updateOfflineTask($getArray);
                $message = [
                    'message' => 'Response Successfully',
                    'update' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'taskid' => 'required',
                'customerId' => 'required',
                'checklist' => 'optional',
                'fseComment' => 'optional',
                'customerName' => 'optional',
                'customerMobile' => 'optional',
                'customerEmail' => 'optional',
                'customerAddress' => 'optional',
                'customerDocument' => 'optional',
                'customerSignature' => 'optional',
                'customerFeedback' => 'optional',
                'status' => 'optional'
            );

            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function updateOfflineTask_post() {

        $getArray = $this->post();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['customerId'] = 'optional';
        $keyArray['fseComment'] = 'optional';
        $keyArray['customerName'] = 'optional';
        $keyArray['customerMobile'] = 'optional';
        $keyArray['customerEmail'] = 'optional';
        $keyArray['customerAddress'] = 'optional';
        $keyArray['customerDocument'] = 'optional';
        $keyArray['customerSignature'] = 'optional';
        $keyArray['customerFeedback'] = 'optional';
        $keyArray['checklist'] = 'optional';
        $keyArray['status'] = 'optional';

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->updateOfflineTask($getArray);
                $message = [
                    'message' => 'Response Successfully',
                    'update' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'taskid' => 'required',
                'customerId' => 'required',
                'checklist' => 'optional',
                'fseComment' => 'optional',
                'customerName' => 'optional',
                'customerMobile' => 'optional',
                'customerEmail' => 'optional',
                'customerAddress' => 'optional',
                'customerDocument' => 'optional',
                'customerSignature' => 'optional',
                'customerFeedback' => 'optional',
                'status' => 'optional'
            );

            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function getCustomerDetailTask_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->getCustomerDetailTask($getArray['taskid']);
                $this->ApiModel->fseViewReportPage($userID, '5', 'getCustomerDetailTask');
                $message = [
                    'message' => 'Response Successfully',
                    'update' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'taskid' => 'required'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function getUpdateTaskStatus_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['statusid'] = 'optional'; //required (or)  not_required (or) optional
        $keyArray['comment'] = 'optional'; //required (or)  not_required (or) optional
        $keyArray['reason'] = 'optional';

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);

            $reason = "";
            if (isset($getArray['reason'])) {
                $reason = $getArray['reason'];
            }

            $comment = "";
            if (isset($getArray['comment'])) {
                $comment = $getArray['comment'];
            }

            $statusid = "";
            if (isset($getArray['statusid'])) {
                $statusid = $getArray['statusid'];
            }

            if ($userID != FALSE) {
                //$comment = str_replace("_", " ", $getArray['comment']);
                // $comment = str_replace("-", "/", $comment);
                $data = $this->ApiModel->getUpdateTaskStatus($getArray['taskid'], $statusid, $comment, $reason);
                $this->ApiModel->fseUiActionReportPage($userID, '5', 'Click on End task');
                //  $this->serviceNowtaskUpdateStatusCheck($getArray['taskid'], $getArray['statusid']);
                $this->ApiModel->thirdpartApiUpdateStatus($getArray['taskid']);
                $task_log = array('task_log' => $getArray['statusid'],
                    'task_name' => $getArray['taskid'],
                    'apiname' => 'status test by cgvak',
                    'api_response' => "getUpdateTaskStatus"
                );
                $this->ApiModel->InsertData('qm_task_create_log', $task_log);
                $message = [
                    'message' => 'Response Successfully',
                    'update' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'taskid' => 'required',
                'statusid' => 'required',
                'comment' => 'required',
                'reason' => 'optional'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function getUpdateTaskCompletedCode_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['fse_feedback'] = 'optional'; //required (or)  not_required (or) optional
        $keyArray['is_Machine_operational'] = 'optional'; //required (or)  not_required (or) optional
        $keyArray['paper'] = 'optional';
        $keyArray['toner'] = 'optional';
        $keyArray['endreading'] = 'optional';
        $keyArray['startreading'] = 'optional';
        $keyArray['location_code'] = 'optional';
        $keyArray['section_code'] = 'optional';
        $keyArray['action_code'] = 'optional';
        $keyArray['close_code'] = 'optional';
        $keyArray['start_reading_black'] = 'optional';
        $keyArray['end_reading_black'] = 'optional';
        $keyArray['docketnumber'] = 'optional';
        $keyArray['book_code'] = 'optional';
        $keyArray['kilometer_travelled'] = 'optional';

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->getUpdateTaskCompletedCodeResolution($getArray);
                // $this->serviceNowtaskUpdateResolution($getArray['taskid']);
                $this->ApiModel->fseUiActionReportPage($userID, '6', 'Click on task Completed');
                $message = [
                    'message' => 'Response Successfully',
                    'update' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'taskid' => 'required',
                'capture_assets' => 'optional',
                'is_Machine_operational' => 'optional',
                'paper' => 'optional',
                'toner' => 'optional',
                'endreading' => 'optional',
                'startreading' => 'optional',
                'location_code' => 'optional',
                'section_code' => 'optional',
                'action_code' => 'optional',
                'close_code' => 'optional',
                'start_reading_black' => 'optional',
                'end_reading_black' => 'optional',
                'docketnumber' => 'optional',
                'book_code' => 'optional',
                'kilometer_travelled' => 'optional'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function selectUpdateTaskAssetscode_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional


        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->selectUpdateTaskAssetscode($getArray['taskid']);
                // $this->serviceNowtaskUpdateAssets($getArray['taskid']);
                $this->ApiModel->fseUiActionReportPage($userID, '6', 'Click on task Completed');
                $message = [
                    'message' => 'Response Successfully',
                    'assets' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'taskid' => 'required',
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function getUpdateTaskAssetCapture_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['capture_assets'] = 'required'; //required (or)  not_required (or) optional

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->getUpdateTaskAssetsCode($getArray['capture_assets'], $getArray['taskid']);
                // $this->serviceNowtaskUpdateAssets($getArray['taskid']);
                $this->ApiModel->fseUiActionReportPage($userID, '6', 'Click on task Completed');
                $message = [
                    'message' => 'Response Successfully',
                    'update' => true,
                    'value' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'taskid' => 'required',
                'capture_assets' => 'required'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function getUpdateTaskAssetCapture_post() {

        $getArray = $this->post();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['capture_assets'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['duplication'] = 'required'; //required (or)  not_required (or) optional

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->getUpdateTaskAssetsCode($getArray['capture_assets'], $getArray['taskid'], $getArray['duplication']);
                // $this->serviceNowtaskUpdateAssets($getArray['taskid']);
                $this->ApiModel->fseUiActionReportPage($userID, '6', 'Click on task Completed');
                $message = [
                    'message' => 'Response Successfully',
                    'update' => true,
                    'value' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'taskid' => 'required',
                'capture_assets' => 'required'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function customerDocumentImage_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['task_id'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['count'] = 'required';

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->customerDocumentImage($getArray);
                $message = [
                    'message' => 'Response Successfully',
                    'count' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'task_id' => 'required',
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function updateTaskCustomerDocumentCount_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['task_id'] = 'required'; //required (or)  not_required (or) optional 

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->updateTaskCustomerDocumentCount($getArray);
                $message = [
                    'message' => 'Response Successfully',
                    'count' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'task_id' => 'required',
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function updateTaskCustomerDocument_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['customer_document'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['task_id'] = 'required';

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->updateTaskCustomerDocument($getArray);

                $this->base64ToimageC();
                $this->serviceNowDocumentpush();

                $message = [
                    'message' => 'Response Successfully',
                    'update' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'task_id' => 'required',
                'customer_document' => 'required',
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function updateTaskCustomerDocument_post() {

        $getArray = $this->post();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['customer_document'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['task_id'] = 'required';

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->updateTaskCustomerDocument($getArray);
                $this->base64ToimageC();
                $this->serviceNowDocumentpush();
                $message = [
                    'message' => 'Response Successfully',
                    'update' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'TaskID' => 'required',
                'customer_document' => 'required',
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function base64ToimageC() {
        $result = $this->ApiModel->base64Toimage();
        foreach ($result AS $r) {
            $data = $r['customer_document'];
            $id = $r['id'];
            $task_id = $r['task_id'];
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
            file_put_contents(DOCUMENT_STORE_PATH . $id . $task_id . '.jpeg', $data);
            $imagename = $id . $task_id . '.jpeg';
            $this->ApiModel->updateImageName($id, $imagename);
        }
    }

    public function serviceNowDocumentpush() {

        $result = $this->ApiModel->pushImageToSN();
        foreach ($result AS $r) {
            $login = 'q_mobility_integration_attachment';
            $password = 'ASDH!@#$N!%!@#$NF';
            $sys_id = trim($r['sys_id']);
            $file_name = trim($r['image_name']);
            $file = realpath(DOCUMENT_STORE_PATH . $file_name);
            //$target_url = 'https://quinticanashuadev.service-now.com/api/now/attachment/file?table_name=incident_task&table_sys_id=' . $sys_id . '&file_name=' . $file_name;
            $target_url = QUINTICA_PRODUCTION_URL . '/api/now/attachment/file?table_name=incident_task&table_sys_id=' . $sys_id . '&file_name=' . $file_name;
            //  $file = realpath('/var/www/html/customerdocument/8149.jpeg');
            $params = file_get_contents($file);
            $first_newline = strpos($params, "\r\n");
            $multipart_boundary = substr($params, 2, $first_newline - 2);
            $request_headers = array();
            $request_headers[] = 'Content-Length: ' . strlen($params);
            $request_headers[] = 'Content-Type: multipart/x-api-remote-integration; boundary='
                    . $multipart_boundary;
            $ch = curl_init($target_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: image/jpeg'));
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
            $reply = curl_exec($ch);
            curl_close($ch);
            $this->ApiModel->updateDocumentPushCompleted($r['id']);
            $task_log = array('task_log' => $r['sys_id'],
                'task_name' => $r['task_name'],
                'apiname' => 'Customer Document Upload',
                'api_response' => json_encode($reply)
            );
            $this->ApiModel->InsertData('qm_task_create_log', $task_log);
        }
    }

    public function updateTaskCustomerDetails_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['customer_name'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['customer_contact_person'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['customer_contact_number'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['customerAddress'] = 'required';  //required (or)  not_required (or) optional
        $keyArray['o_customer_name'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['o_customer_contact_person'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['o_customer_contact_number'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['o_customerAddress'] = 'optional';  //required (or)  not_required (or) optional
        $keyArray['o_task_address'] = 'optional';  //required (or)  not_required (or) optional
        $keyArray['call_status'] = 'optional'; //required (or)  not_required (or) optional
        $keyArray['call_type'] = 'optional';  //required (or)  not_required (or) optional
        $keyArray['customerAddress'] = 'optional';  //required (or)  not_required (or) optional
        $keyArray['task_address'] = 'optional';  //required (or)  not_required (or) optional 
        $keyArray['customer_document'] = 'optional'; //required (or)  not_required (or) optional
        $keyArray['customer_sign'] = 'optional'; //required (or)  not_required (or) optional
        $keyArray['TaskID'] = 'required';

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $pass_array = array();
                $pass_array['customer_name'] = 1;
                $pass_array['customer_contact_person'] = 1;
                $pass_array['customer_contact_number'] = 1;
                $pass_array['task_address'] = 1;
                if (strcmp($getArray['o_customer_name'], $getArray['customer_name']) == 0) {
                    $pass_array['customer_name'] = 0;
                }
                if (strcmp($getArray['o_customer_contact_person'], $getArray['customer_contact_person']) == 0) {
                    $pass_array['customer_contact_person'] = 0;
                }
                if (strcmp($getArray['o_customer_contact_number'], $getArray['customer_contact_number']) == 0) {
                    $pass_array['customer_contact_number'] = 0;
                }
                if (isset($keyArray['task_address'])) {
                    if (strcmp($getArray['o_task_address'], $getArray['task_address']) == 0) {
                        $pass_array['task_address'] = 0;
                    }
                }

                $data = $this->ApiModel->updateTaskCustomerDetails($getArray);
                //$this->serviceNowtaskCustomerUpdate($getArray['TaskID'], $pass_array);
                $message = [
                    'message' => 'Response Successfully',
                    'update' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'customer_name' => 'required',
                'customer_contact_person' => 'optional',
                'customer_contact_number' => 'optional',
                'call_status' => 'optional',
                'call_type' => 'optional',
                'customerAddress' => 'optional',
                'TaskID' => 'required',
                'customer_document' => 'optional',
                'customer_sign' => 'optional',
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function entityCustomFielsList_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['entityID'] = 'required'; //required (or)  not_required (or) optional

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->entityCustomFielsList($getArray['entityID']);
                $message = [
                    'message' => 'Response Successfully',
                    'TaskFields' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'entityID' => 'required'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function updateCustomerDetails_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['name'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['mobile'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['email'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['address'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['custID'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['TaskID'] = 'required';
        $keyArray['photo'] = 'optional'; //required (or)  not_required (or) optional

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->updateCustomerDetailstaskDocument($getArray);
                $message = [
                    'message' => 'Response Successfully',
                    'update' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'name' => 'required',
                'mobile' => 'required',
                'email' => 'required',
                'address' => 'required',
                'custID' => 'required',
                'TaskID' => 'required',
                'photo' => 'optional'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function updateCustomerDetails_post() {

        $getArray = $this->post();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['name'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['mobile'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['email'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['address'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['custID'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['TaskID'] = 'required';
        $keyArray['photo'] = 'optional'; //required (or)  not_required (or) optional

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->updateCustomerDetailstaskDocument($getArray);
                $message = [
                    'message' => 'Response Successfully',
                    'update' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'name' => 'required',
                'mobile' => 'required',
                'email' => 'required',
                'address' => 'required',
                'custID' => 'required',
                'TaskID' => 'required',
                'photo' => 'optional'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function updateChecklistTask_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['data'] = 'optional'; //required (or)  not_required (or) optional
        $keyArray['unchecklist'] = 'optional'; //required (or)  not_required (or) optional

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = NULL;
                $unchecklist = NULL;
                if (isset($getArray['unchecklist'])) {
                    $unchecklist = $getArray['unchecklist'];
                }
                $checklist = NULL;
                if (isset($getArray['data'])) {
                    $checklist = $getArray['data'];
                }
                $datas = array();
                $datas['fse_checklist'] = $checklist;
                $datas['task_unchecklist'] = $unchecklist;
                $data = $this->ApiModel->updateChecklistTask($userID, $datas, $getArray['taskid']);
                $this->ApiModel->fseUiActionReportPage($userID, '7', 'Click on update button');
                $message = [
                    'message' => 'Response Successfully',
                    'update' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'taskid' => 'required',
                'data' => 'optional',
                'unchecklist' => 'optional'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function getUpdatedChecklistTask_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = NULL;
                $data = $this->ApiModel->getUpdatedChecklistTask($getArray['taskid']);
                $message = [
                    'message' => 'Response Successfully',
                    'update' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'taskid' => 'required'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function getStatusTypeEntity_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['entity_id'] = 'required'; //required (or)  not_required (or) optional
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = NULL;
                $data = $this->ApiModel->getStatusTypeEntity($getArray['taskid']);
                $message = [
                    'message' => 'Response Successfully',
                    'update' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'taskid' => 'required'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function getActionCode_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['entity_id'] = 'required';
        $keyArray['taskid'] = 'required';

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->getActionCode($getArray);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'entity_id' => 'required',
                'taskid' => 'required'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function getSectionCode_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['entity_id'] = 'required';
        $keyArray['taskid'] = 'required';

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->getSectionCode($getArray);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'entity_id' => 'required',
                'taskid' => 'required'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function getLocationCode_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['entity_id'] = 'required';
        $keyArray['searchKey'] = 'required';

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->getLocationCode($getArray);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'entity_id' => 'required',
                'searchKey' => 'required'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function taskTimeCalcu_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['task_id'] = 'optional';
        $keyArray['geo_km'] = 'optional';
        $keyArray['start_trip'] = 'optional';
        $keyArray['end_trip'] = 'optional';
        $keyArray['start_work'] = 'optional';
        $keyArray['end_work'] = 'optional';
        $keyArray['onhold'] = 'optional';
        $keyArray['traveltime'] = 'optional';

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->taskTimeCalcu($getArray);
                //   $this->serviceNowtaskUpdateTimeCalcution($getArray['task_id']);
                $this->ApiModel->thirdpartUpatetimeFeedback($getArray['task_id']);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'task_id' => 'required',
                'geo_km' => 'optional',
                'start_trip' => 'optional',
                'end_trip' => 'optional',
                'start_work' => 'optional',
                'end_work' => 'optional',
                'traveltime' => 'optional',
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function getcloseCode_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['entity_id'] = 'required';

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->getcloseCode($getArray);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'entity_id' => 'required'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function productLine_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        //$keyArray['entity'] = 'required';

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->productLine();
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function problem1_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        //$keyArray['entity'] = 'required';

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->productLine();
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function completeTaskFeildList_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['entity'] = 'required';

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->completeTaskFeildList($getArray);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'entity' => 'required'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function taskAssetsGetLike_get() {
        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['keywordSearch'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['task_id'] = 'required';

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->taskAssetsGetLike($getArray);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'keywordSearch' => 'required',
                'task_id' => 'required'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function updateCheckPendingTask_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['data'] = 'optional'; //required (or)  not_required (or) optional

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = NULL;
                if (isset($getArray['data'])) {
                    $data = $this->ApiModel->updateChecklistTask($userID, $getArray);
                }
                $message = [
                    'message' => 'Response Successfully',
                    'update' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required',
                'taskid' => 'required',
                'data' => 'required'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function CreateTasks_get() {

        $getArray = $this->get();

        $keyArray['apiKey'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskTitle'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['fseName'] = 'optional'; //required (or)  not_required (or) optional
        $keyArray['fseAddress'] = 'optional';
        $keyArray['fseMobile'] = 'optional';
        $keyArray['fseEmail'] = 'required';
        $keyArray['incidentDetails'] = 'required';
        $keyArray['projectDetails'] = 'optional';
        $keyArray['entityDetails'] = 'optional';
        $keyArray['branchDetails'] = 'optional';
        $keyArray['taskStatus'] = 'optional';
        $keyArray['taskDescription'] = 'required';
        $keyArray['taskLocationAddress'] = 'required';
        $keyArray['googleMapLatitudeLongitude'] = 'optional';
        $keyArray['customerName'] = 'required';
        $keyArray['customerAddress'] = 'optional';
        $keyArray['customerEmail'] = 'optional';
        $keyArray['customerMobile'] = 'optional';
        $keyArray['priority'] = 'required';
        $keyArray['productName'] = 'required';
        $keyArray['serialNumber'] = 'required';
        $keyArray['productCode'] = 'required';
        $keyArray['productline'] = 'required';
        $keyArray['problem1'] = 'required';
        $keyArray['problem2'] = 'required';
        $keyArray['location'] = 'required';
        /* apiKey/QmobilitySYNserviceNow/taskTitle/ServiceNowTask1/fseEmail/sathishkumar@cgvakindia.com/incidentDetails/testinciden/taskDescription/testDescrip/taskLocationAddress/tasklocationadd/customerName/carl/productName/testmobile/priority/CRITICAL/serialNumber/test/productCode/codetest/productline/Duplicator/problem1/test
         */
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $auth = $getArray['apiKey'];
            if ($auth == SERVICE_NOW_API_KEY) {
                $data = $this->ApiModel->CreateTasks($getArray);
                if ($data == true) {

                    $message = [
                        'message' => $data,
                        'status' => 'success',
                        'code' => '1',
                    ];
                } else {
                    $message = [
                        'message' => $data,
                        'status' => 'success',
                        'code' => '0',
                    ];
                }
            } else {
                $message = [
                    'message' => 'auth value not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {

            $required_key = array('apiKey' => 'required',
                'taskTitle' => 'required',
                'fseName' => 'optional',
                'fseAddress' => 'optional',
                'fseMobile' => 'optional',
                'fseEmail' => 'required',
                'incidentDetails' => 'required',
                'projectDetails' => 'optional',
                'entityDetails' => 'optional',
                'branchDetails' => 'optional',
                'taskStatus' => 'optional',
                'taskDescription' => 'required',
                'taskLocationAddress' => 'required',
                'googleMapLatitudeLongitude' => 'optional',
                'customerName' => 'required',
                'customerAddress' => 'optional',
                'customerEmail' => 'optional',
                'customerMobile' => 'optional',
                'priority' => 'required',
                'productName' => 'required',
                'serialNumber' => 'required',
                'productCode' => 'required',
                'productline' => 'required',
                'problem1' => 'required',
                'problem2' => 'required',
                'location' => 'required',
                'priority option' => array('LOW', 'MEDIUM', 'HIGH', 'CRITICAL', 'PLANING')
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function CreateTask_get() {

        $getArray = $this->post();
        if (count($getArray) == 0) {
            $inputJSON = file_get_contents('php://input');
            $getArray = json_decode($inputJSON, TRUE);
        }
        if (count($getArray) == 0) {
            $getArray = array();
        }
        $keyArray['apiKey'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskTitle'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['fseName'] = 'optional'; //required (or)  not_required (or) optional
        $keyArray['fseAddress'] = 'optional';
        $keyArray['fseMobile'] = 'optional';
        $keyArray['fseEmail'] = 'required';
        $keyArray['incidentDetails'] = 'required';
        $keyArray['projectDetails'] = 'optional';
        $keyArray['entityDetails'] = 'optional';
        $keyArray['branchDetails'] = 'optional';
        $keyArray['taskStatus'] = 'optional';
        $keyArray['taskDescription'] = 'required';
        $keyArray['taskLocationAddress'] = 'required';
        $keyArray['googleMapLatitudeLongitude'] = 'optional';
        $keyArray['customerName'] = 'required';
        $keyArray['customerAddress'] = 'optional';
        $keyArray['customerEmail'] = 'optional';
        $keyArray['customerMobile'] = 'optional';
        $keyArray['priority'] = 'required';
        $keyArray['productName'] = 'required';
        $keyArray['serialNumber'] = 'required';
        $keyArray['productCode'] = 'required';
        $keyArray['productline'] = 'required';
        $keyArray['problem1'] = 'required';
        $keyArray['problem2'] = 'required';
        $keyArray['location'] = 'required';
        $keyArray['sys_id'] = 'optional';
        $error = $this->ApiModel->errorlogs($getArray, $keyArray, 'create task error Log');

        /* apiKey/QmobilitySYNserviceNow/taskTitle/ServiceNowTask1/fseEmail/sathishkumar@cgvakindia.com/incidentDetails/testinciden/taskDescription/testDescrip/taskLocationAddress/tasklocationadd/customerName/carl/productName/testmobile/priority/CRITICAL/serialNumber/test/productCode/codetest/productline/Duplicator/problem1/test

         */
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $auth = $getArray['apiKey'];
            if ($auth == SERVICE_NOW_API_KEY) {
                $data = $this->ApiModel->CreateTask($getArray);
                if ($data == true) {
                    $message = [
                        'message' => $data,
                        'status' => 'success',
                        'code' => '1',
                    ];
                } else {
                    $message = [
                        'message' => $data,
                        'status' => 'success',
                        'code' => '0',
                    ];
                }
            } else {

                $message = [
                    'message' => 'auth value not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {

            $required_key = array('apiKey' => 'required',
                'taskTitle' => 'required',
                'fseName' => 'optional',
                'fseAddress' => 'optional',
                'fseMobile' => 'optional',
                'fseEmail' => 'required',
                'incidentDetails' => 'required',
                'projectDetails' => 'optional',
                'entityDetails' => 'optional',
                'branchDetails' => 'optional',
                'taskStatus' => 'optional',
                'taskDescription' => 'required',
                'taskLocationAddress' => 'required',
                'googleMapLatitudeLongitude' => 'optional',
                'customerName' => 'required',
                'customerAddress' => 'optional',
                'customerEmail' => 'optional',
                'customerMobile' => 'optional',
                'priority' => 'required',
                'productName' => 'required',
                'serialNumber' => 'required',
                'productCode' => 'required',
                'productline' => 'required',
                'problem1' => 'required',
                'problem2' => 'required',
                'location' => 'required',
                'sys_id' => 'optional',
                'priority option' => array('LOW', 'MEDIUM', 'HIGH', 'CRITICAL', 'PLANNING')
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'error' => $error,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function CreateTask_post() {

        $getArray = $this->post();
        if (count($getArray) == 0) {
            $inputJSON = file_get_contents('php://input');
            $getArray = json_decode($inputJSON, TRUE);
        }
        if (count($getArray) == 0) {
            $getArray = array();
        }

        $keyArray['apiKey'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskTitle'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['fseName'] = 'optional'; //required (or)  not_required (or) optional
        $keyArray['fseAddress'] = 'optional';
        $keyArray['fseMobile'] = 'optional';
        $keyArray['fseEmail'] = 'required';
        $keyArray['incidentDetails'] = 'required';
        $keyArray['projectDetails'] = 'optional';
        $keyArray['entityDetails'] = 'optional';
        $keyArray['branchDetails'] = 'optional';
        $keyArray['taskStatus'] = 'optional';
        $keyArray['taskDescription'] = 'required';
        $keyArray['taskLocationAddress'] = 'required';
        $keyArray['googleMapLatitudeLongitude'] = 'optional';
        $keyArray['customerName'] = 'required';
        $keyArray['customerAddress'] = 'optional';
        $keyArray['customerEmail'] = 'optional';
        $keyArray['customerMobile'] = 'optional';
        $keyArray['priority'] = 'required';
        $keyArray['productName'] = 'required';
        $keyArray['serialNumber'] = 'required';
        $keyArray['productCode'] = 'required';
        $keyArray['productline'] = 'required';
        $keyArray['problem1'] = 'required';
        $keyArray['problem2'] = 'required';
        $keyArray['location'] = 'required';
        $keyArray['sys_id'] = 'optional';

        $error = $this->ApiModel->errorlogs($getArray, $keyArray, 'create task error Log');
        /* apiKey/QmobilitySYNserviceNow/taskTitle/ServiceNowTask1/fseEmail/sathishkumar@cgvakindia.com/incidentDetails/testinciden/taskDescription/testDescrip/taskLocationAddress/tasklocationadd/customerName/carl/productName/testmobile/priority/CRITICAL/serialNumber/test/productCode/codetest/productline/Duplicator/problem1/test
         */
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $auth = $getArray['apiKey'];
            if ($auth == SERVICE_NOW_API_KEY) {
                $data = $this->ApiModel->CreateTask($getArray);
                if ($data == true) {
                    $message = [
                        'message' => $data,
                        'status' => 'success',
                        'code' => '1',
                    ];
                } else {
                    $message = [
                        'message' => $data,
                        'status' => 'success',
                        'code' => '0',
                    ];
                }
            } else {

                $message = [
                    'message' => 'auth value not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {

            $required_key = array('apiKey' => 'required',
                'taskTitle' => 'required',
                'fseName' => 'optional',
                'fseAddress' => 'optional',
                'fseMobile' => 'optional',
                'fseEmail' => 'required',
                'incidentDetails' => 'required',
                'projectDetails' => 'optional',
                'entityDetails' => 'optional',
                'branchDetails' => 'optional',
                'taskStatus' => 'optional',
                'taskDescription' => 'required',
                'taskLocationAddress' => 'required',
                'googleMapLatitudeLongitude' => 'optional',
                'customerName' => 'required',
                'customerAddress' => 'optional',
                'customerEmail' => 'optional',
                'customerMobile' => 'optional',
                'priority' => 'required',
                'productName' => 'required',
                'serialNumber' => 'required',
                'productCode' => 'required',
                'productline' => 'required',
                'problem1' => 'required',
                'problem2' => 'required',
                'location' => 'required',
                'sys_id' => 'optional',
                'priority option' => array('LOW', 'MEDIUM', 'HIGH', 'CRITICAL', 'PLANING')
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'error' => $error,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function CreateTaskold_post() {

        $getArray = $this->post();
        $keyArray['apiKey'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskTitle'] = 'required'; //required (or)  not_required (or) optional
        $keyArray['fseName'] = 'optional'; //required (or)  not_required (or) optional
        $keyArray['fseAddress'] = 'optional';
        $keyArray['fseMobile'] = 'optional';
        $keyArray['fseEmail'] = 'fseEmail';
        $keyArray['incidentDetails'] = 'required';
        $keyArray['projectDetails'] = 'optional';
        $keyArray['entityDetails'] = 'optional';
        $keyArray['branchDetails'] = 'optional';
        $keyArray['taskStatus'] = 'optional';
        $keyArray['taskDescription'] = 'required';
        $keyArray['taskLocationAddress'] = 'required';
        $keyArray['googleMapLatitudeLongitude'] = 'optional';
        $keyArray['customerName'] = 'required';
        $keyArray['customerAddress'] = 'optional';
        $keyArray['customerEmail'] = 'optional';
        $keyArray['customerMobile'] = 'optional';
        $keyArray['priority'] = 'optional';
        $keyArray['productName'] = 'required';
        $keyArray['serialNumber'] = 'required';
        $keyArray['productCode'] = 'required';
        $keyArray['productline'] = 'optional';
        $keyArray['problem1'] = 'required';
        $keyArray['problem2'] = 'required';
        $keyArray['location'] = 'required';
        /* apiKey/12345/taskTitle/ServiceNowTask1/fseName/sathish/fseAddress/fseAddressfortask/fseMobile/1234567/fseEmail/sathishkumar@cgvakindia.com/
          incidentORproject/1/incidentDetails/
         */
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $auth = $getArray['apiKey'];
            if ($auth == SERVICE_NOW_API_KEY) {
                $data = $this->ApiModel->CreateTask($getArray);
                if ($data == true) {
                    $message = [
                        'message' => $data,
                        'status' => 'success',
                        'code' => '1',
                    ];
                } else {
                    $message = [
                        'message' => $data,
                        'status' => 'success',
                        'code' => '0',
                    ];
                }
            } else {

                $message = [
                    'message' => 'auth value not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('apiKey' => 'required',
                'taskTitle' => 'required',
                'fseName' => 'optional',
                'fseAddress' => 'optional',
                'fseMobile' => 'optional',
                'fseEmail' => 'required',
                'incidentDetails' => 'required',
                'projectDetails' => 'optional',
                'entityDetails' => 'optional',
                'branchDetails' => 'optional',
                'taskStatus' => 'optional',
                'taskDescription' => 'required',
                'taskLocationAddress' => 'required',
                'googleMapLatitudeLongitude' => 'optional',
                'customerName' => 'required',
                'customerAddress' => 'optional',
                'customerEmail' => 'optional',
                'customerMobile' => 'optional',
                'priority' => 'optional',
                'productName' => 'required',
                'serialNumber' => 'required',
                'productCode' => 'required',
                'productline' => 'required',
                'problem1' => 'required',
                'problem2' => 'required',
                'location' => 'required',
                'priority option' => array('LOW', 'MEDIUM', 'HIGH', 'CRITICAL', 'PLANNING')
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function UpdateTask_post() {

        $getArray = $this->post();
        if (count($getArray) == 0) {
            $inputJSON = file_get_contents('php://input');
            $getArray = json_decode($inputJSON, TRUE);
        }
        if (count($getArray) == 0) {
            $getArray = array();
        }
        // $getArray = $this->post();
        $keyArray['apiKey'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskTitle'] = 'required'; //required (or)  not_required (or) optional
        // $keyArray['fseName'] = 'optional'; //required (or)  not_required (or) optional
        // $keyArray['fseAddress'] = 'optional';
        // $keyArray['fseMobile'] = 'optional';
        $keyArray['fseEmail'] = 'optional';
        // $keyArray['incidentDetails'] = 'optional';
        // $keyArray['projectDetails'] = 'optional';
        // $keyArray['entityDetails'] = 'optional';
        // $keyArray['branchDetails'] = 'optional';
        $keyArray['taskStatus'] = 'optional';
        $keyArray['taskDescription'] = 'optional';
        $keyArray['taskLocationAddress'] = 'optional';
        // $keyArray['googleMapLatitudeLongitude'] = 'optional';
        $keyArray['customerName'] = 'optional';
        // $keyArray['customerAddress'] = 'optional';
        $keyArray['customerEmail'] = 'optional';
        $keyArray['customerMobile'] = 'optional';
        $keyArray['productName'] = 'optional';
        $keyArray['serialNumber'] = 'optional';
        $keyArray['productCode'] = 'optional';
        $keyArray['problem1'] = 'optional';
        $keyArray['problem2'] = 'optional';
        $keyArray['location'] = 'optional';
        $keyArray['asset'] = 'optional';
        $keyArray['priority'] = 'optional';

        $error = $this->ApiModel->errorlogs($getArray, $keyArray, 'Update task error Log');
        /* apiKey/12345/taskTitle/ServiceNowTask1/fseName/sathish/fseAddress/fseAddressfortask/fseMobile/1234567/fseEmail/sathishkumar@cgvakindia.com/
          incidentORproject/1/incidentDetails/
         */
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $auth = $getArray['apiKey'];
            if ($auth == SERVICE_NOW_API_KEY) {
                $data = $this->ApiModel->updateTask($getArray);
                //$fse_device_id = $this->ApiModel->getFseDeviceIDs($data);
                // if ($fse_device_id != NULL) {
                //$this->ApiModel->send_android_pushs($fse_device_id->fse_device_id, $getArray);
                // }
                // echo $data['Condition'];

                if ($data == TRUE) {
                    $message = [
                        'message' => $data,
                        'status' => 'success',
                        'code' => '1',
                    ];
                } else {
                    $message = [
                        'message' => $data['msg'],
                        'status' => 'Failed',
                        'code' => '0',
                    ];
                }
            } else {

                $message = [
                    'message' => 'auth value not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('apiKey' => 'required',
                'taskTitle' => 'required',
                //   'fseName' => 'optional',
                //   'fseAddress' => 'optional',
                //   'fseMobile' => 'optional',
                'fseEmail' => 'optional',
                // 'incidentDetails' => 'optional',
                // 'projectDetails' => 'optional',
                // 'entityDetails' => 'optional',
                // 'branchDetails' => 'optional',
                'taskStatus' => 'optional',
                'taskDescription' => 'optional',
                'taskLocationAddress' => 'optional',
                // 'googleMapLatitudeLongitude' => 'optional',
                'customerName' => 'optional',
                // 'customerAddress' => 'optional',
                'customerEmail' => 'optional',
                'customerMobile' => 'optional',
                'productName' => 'optional',
                'serialNumber' => 'optional',
                'productCode' => 'optional',
                'problem1' => 'optional',
                'problem2' => 'optional',
                'location' => 'optional',
                'asset' => 'optional',
                'priority' => 'optional',
                'priority option' => array('LOW', 'MEDIUM', 'HIGH', 'CRITICAL', 'PLANNING'),
                'task status' => array('Assigned', 'Pending', 'Accepted', 'Completed', 'InProgress', 'Canceled', 'Reject')
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'error' => $error,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function UpdateTask_get() {

        $getArray = $this->post();
        if (count($getArray) == 0) {
            $inputJSON = file_get_contents('php://input');
            $getArray = json_decode($inputJSON, TRUE);
        }
        if (count($getArray) == 0) {
            $getArray = array();
        }
        $keyArray['apiKey'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskTitle'] = 'required'; //required (or)  not_required (or) optional
        // $keyArray['fseName'] = 'optional'; //required (or)  not_required (or) optional
        // $keyArray['fseAddress'] = 'optional';
        // $keyArray['fseMobile'] = 'optional';
        $keyArray['fseEmail'] = 'optional';
        // $keyArray['incidentDetails'] = 'optional';
        // $keyArray['projectDetails'] = 'optional';
        // $keyArray['entityDetails'] = 'optional';
        // $keyArray['branchDetails'] = 'optional';
        $keyArray['taskStatus'] = 'optional';
        $keyArray['taskDescription'] = 'optional';
        $keyArray['taskLocationAddress'] = 'optional';
        // $keyArray['googleMapLatitudeLongitude'] = 'optional';
        $keyArray['customerName'] = 'optional';
        // $keyArray['customerAddress'] = 'optional';
        $keyArray['customerEmail'] = 'optional';
        $keyArray['customerMobile'] = 'optional';
        $keyArray['productName'] = 'optional';
        $keyArray['serialNumber'] = 'optional';
        $keyArray['productCode'] = 'optional';
        $keyArray['problem1'] = 'optional';
        $keyArray['problem2'] = 'optional';
        $keyArray['location'] = 'optional';
        $keyArray['priority'] = 'optional';
        $keyArray['asset'] = 'optional';

        $error = $this->ApiModel->errorlogs($getArray, $keyArray, 'Update task error Log');

        /* apiKey/12345/taskTitle/ServiceNowTask1/fseName/sathish/fseAddress/fseAddressfortask/fseMobile/1234567/fseEmail/sathishkumar@cgvakindia.com/
          incidentORproject/1/incidentDetails/
         */
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $auth = $getArray['apiKey'];
            if ($auth == SERVICE_NOW_API_KEY) {
                $data = $this->ApiModel->updateTask($getArray);
                //$fse_device_id = $this->ApiModel->getFseDeviceIDs($data);
                // if ($fse_device_id != NULL) {
                //$this->ApiModel->send_android_pushs($fse_device_id->fse_device_id, $getArray);
                // }

                if ($data == TRUE) {
                    $message = [
                        'message' => $data['msg'],
                        'status' => $data['Status'],
                        'code' => $data['Code'],
                    ];
                } else {
                    $message = [
                        'message' => $data,
                        'status' => 'success',
                        'code' => '0',
                    ];
                }
            } else {

                $message = [
                    'message' => 'auth value not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('apiKey' => 'required',
                'taskTitle' => 'required',
                //   'fseName' => 'optional',
                //   'fseAddress' => 'optional',
                //   'fseMobile' => 'optional',
                'fseEmail' => 'optional',
                // 'incidentDetails' => 'optional',
                // 'projectDetails' => 'optional',
                // 'entityDetails' => 'optional',
                //  'branchDetails' => 'optional',
                'taskStatus' => 'optional',
                'taskDescription' => 'optional',
                'taskLocationAddress' => 'optional',
                //   'googleMapLatitudeLongitude' => 'optional',
                'customerName' => 'optional',
                // 'customerAddress' => 'optional',
                'customerEmail' => 'optional',
                'customerMobile' => 'optional',
                'productName' => 'optional',
                'serialNumber' => 'optional',
                'productCode' => 'optional',
                'problem1' => 'optional',
                'problem2' => 'optional',
                'priority' => 'optional',
                'asset' => 'optional',
                'priority option' => array('LOW', 'MEDIUM', 'HIGH', 'CRITICAL', 'PLANNING'),
                'task status' => array('Assigned', 'Pending', 'Accepted', 'Completed', 'InProgress', 'Canceled', 'Reject')
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'error' => $error,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function taskRequriedDetails_get() {
        $getArray = $this->get();
        $keyArray['auth'] = 'required'; //required (or)  not_required (or) optional 

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['auth']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->getDetailsForTaskCreate();
                $message = [
                    'message' => 'Response Successfully',
                    'update' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {

                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array(
                'auth' => 'required'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }
    
     public function getAutoCompleteSelectOption_get() {
        
        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['id'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['value'] = 'optional';
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                
                if (isset($getArray['value'])) {
                $value = $getArray['value'];
                }else{$value = NULL;}
                
                $data = $this->ApiModel->getAutoCompleteSelectOption($getArray['id'], $value);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('emailid' => 'required', 'cat_id' => 'optional');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'id' => 'required', 'value' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function updateTaskScreen_get() {
        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['task_id'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['cat_id'] = 'required';
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->updateTaskScreen($getArray['task_id'], $getArray['cat_id']);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('emailid' => 'required', 'cat_id' => 'optional');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'task_id' => 'required', 'cat_id' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function updateTaskScreens_get() {
        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['task_id'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['cat_id'] = 'required';
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->updateTaskScreens($getArray['task_id'], $getArray['cat_id']);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('emailid' => 'required', 'cat_id' => 'optional');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'task_id' => 'required', 'cat_id' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function updateTaskScreenData_get() {
        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['cat_id'] = 'required';
        $keyArray['postData'] = 'required';

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->updateTaskScreenData($getArray['taskid'], $getArray['cat_id'], $getArray['postData']);
                $this->ApiModel->thirdpartApiUpdate($getArray['taskid']);
                $this->ApiModel->thirdpartUpatetimeFeedback($getArray['taskid']);

                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('emailid' => 'required', 'cat_id' => 'optional');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'taskid' => 'required', 'cat_id' => 'required', 'postData' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function updateTaskScreenData_post() {
        $getArray = $this->post();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['cat_id'] = 'required';
        $keyArray['postData'] = 'required';
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->updateTaskScreenData($getArray['taskid'], $getArray['cat_id'], $getArray['postData']);
                $this->ApiModel->thirdpartApiUpdate($getArray['taskid']);
                $this->ApiModel->thirdpartUpatetimeFeedback($getArray['taskid']);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('emailid' => 'required', 'cat_id' => 'optional');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'taskid' => 'required', 'cat_id' => 'required', 'postData' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function templete() {
        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'optional'; //required (or)  not_required (or) optional 

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($token != FALSE) {
                $data = $this->ApiModel->taskCount($userID);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('emailid' => 'required', 'userid' => 'optional');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'userid' => 'optional', 'pictureString' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function fseViewGet_get() {
        $this->ApiModel->fseUiActionReportPage(2, '1', 'Login');
    }

    public function serviceNowtaskUpdates($tasksid = NULL, $stutusid = NULL) {

        $status = "";
        if ($stutusid == 1) {
            $status = "Assigned";
        }
        if ($stutusid == 3) {
            $status = "Accept";
        }
        if ($stutusid == 7) {
            $status = "Reject";
        }
        if ($stutusid == 5) {
            $status = "In progress";
        }
        if ($stutusid == 2) {
            $status = "On Hold";
        }
        if ($stutusid == 4) {
            $status = "Resolved";
        }
        if ($stutusid == 6) {
            $status = "Cancelled";
        }

        $res = $this->ApiModel->serviceNowTaskUpdate($tasksid);
        if ($res->task_type_id != 1) {
            return;
        }
        $login = SERVICE_NOW_USERNAME;
        $password = SERVICE_NOW_PASSWORD;
        //   $url = 'https://quinticanashuadev.service-now.com/api/now/table/u_qm_task_update?sysparm_fields=sys_import_state_comment,sys_import_state';
        $url = QUINTICA_PRODUCTION_URL . '/api/now/table/u_qm_task_update?sysparm_fields=sys_import_state_comment,sys_import_state';
        $curl = curl_init();
        $curl_post_data = array(
            "u_call_status" => $res->calltype_type,
            "u_outstanding_calls" => $res->outstanding_calls,
            //  "u_previous_meter_reading" => $res->previous_meter_reading,
            "u_serial_number" => $res->serial_number,
            "u_customer_contact_person" => $res->customer_contact_person,
            //  "u_manual_docket_number" => $res->manual_docket_number,
            "u_task_address" => $res->task_address,
            //  "u_product_code" => $res->product_code,
            //  "u_section_code" => $res->section_code,
            "u_status_id" => $status,
            "u_customer_order_number" => $res->customer_order_number,
            "u_task_description" => $res->task_description,
            //  "u_problem" => $res->sn_problem1,
            "u_task_name" => $res->task_name,
            "u_messagetext" => $res->task_description,
            "u_call_number" => $res->call_number,
            "u_comment_charge" => $res->comment_charge,
            //  "u_fse_feedback" => $res->fse_feedback,
            "u_fse_checklist" => $res->fse_checklist,
            //  "u_customer_name" => $res->customer_name,
            //  "u_priority" => $res->priority_type,
            //  "u_book_code" => $res->book_code,
            "u_model" => $res->model,
            "u_task_unchecklist" => $res->task_unchecklist,
            "u_task_checklist" => $res->task_checklist,
            "u_call_type" => $res->calltype_type,
            //  "u_previous_color_reading" => $res->previous_color_reading,
            "u_customer_contact_number" => $res->customer_contact_number,
                //  "u_close_code" => $res->close_code,
        );
        $data_string = json_encode($curl_post_data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        $result = json_encode(curl_exec($ch));

        $task_log = array('task_log' => $data_string,
            'task_name' => $res->task_name,
            'apiname' => 'End Task SN',
            'api_response' => $result
        );
        $this->ApiModel->InsertData('qm_task_create_log', $task_log);
        return TRUE;
    }

    public function serviceNowtaskCustomerUpdate($tasksid = NULL, $pass_array = NULL) { //$tasksid = NULL
        $res = $this->ApiModel->serviceNowTaskUpdate($tasksid);

        if ($res->task_type_id != 1) {
            return;
        }
        $login = SERVICE_NOW_USERNAME;
        $password = SERVICE_NOW_PASSWORD;
        //$url = 'https://quinticanashuadev.service-now.com/api/now/table/u_qm_task_update?sysparm_fields=sys_import_state_comment,sys_import_state';
        $url = QUINTICA_PRODUCTION_URL . '/api/now/table/u_qm_task_update?sysparm_fields=sys_import_state_comment,sys_import_state';
        $curl = curl_init();

        $curl_post_data = array(
            "u_customer_name" => $res->customer_name,
            "u_customer_contact_person" => $res->customer_contact_person,
            "u_customer_contact_number" => $res->customer_contact_number,
            "u_task_address" => $res->task_address,
            "u_task_name" => $res->task_name,
        );



        if ($pass_array['customer_name'] == 0) {
            unset($curl_post_data['u_customer_name']);
        }
        if ($pass_array['customer_contact_person'] == 0) {
            unset($curl_post_data['u_customer_contact_person']);
        }
        if ($pass_array['customer_contact_number'] == 0) {
            unset($curl_post_data['u_customer_contact_number']);
        }
        if ($pass_array['task_address'] == 0) {
            unset($curl_post_data['u_task_address']);
        }
        $data_string = json_encode($curl_post_data);
        if (count($curl_post_data) <= 1) {
            $task_log = array('task_log' => $data_string,
                'task_name' => $res->task_name,
                'apiname' => 'Customer Deatils Update',
                'api_response' => "No Change"
            );
            $this->ApiModel->InsertData('qm_task_create_log', $task_log);
            return TRUE;
        }

        // $data_string = json_encode($curl_post_data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        $result = json_encode(curl_exec($ch));
        $task_log = array('task_log' => $data_string,
            'task_name' => $res->task_name,
            'apiname' => 'Customer Deatils Update',
            'api_response' => $result
        );
        $this->ApiModel->InsertData('qm_task_create_log', $task_log);
        // $insert_result = array('servicenow_api_request' => $data_string);
        //$this->ApiModel->UpdateData($insert_result, $tasksid, QM_TASK);
    }

    public function serviceNowtaskUpdateTimeCalcution($tasksid = NULL) {

        $res = $this->ApiModel->serviceNowTaskUpdate($tasksid);
        if ($res->task_type_id != 1) {
            return;
        }
        $login = SERVICE_NOW_USERNAME;
        $password = SERVICE_NOW_PASSWORD;
        //$url = 'https://quinticanashuadev.service-now.com/api/now/table/u_qm_task_update?sysparm_fields=sys_import_state_comment,sys_import_state';
        $url = QUINTICA_PRODUCTION_URL . '/api/now/table/u_qm_task_update?sysparm_fields=sys_import_state_comment,sys_import_state';
        $curl = curl_init();
        $is_Machine_operational = FALSE;
        $toner = FALSE;
        $paper = FALSE;

        if ($res->toner == 'on') {
            $toner = 'YES';
        } else {
            $toner = 'NO';
        }
        if ($res->is_Machine_operational == 'on') {
            $is_Machine_operational = 'YES';
        } else {
            $is_Machine_operational = 'NO';
        }
        if ($res->paper == 'on') {
            $paper = 'YES';
        } else {
            $paper = 'NO';
        }
        $curl_post_data = array(
            "u_task_name" => $res->task_name,
            "u_repair_time" => $res->total_worked_time,
            "u_travel_time" => $res->total_travel_time,
            "u_calculated_distance" => $res->geo_km,
        );
        $data_string = json_encode($curl_post_data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        $result = json_encode(curl_exec($ch));
        $task_log = array('task_log' => $data_string,
            'task_name' => $res->task_name,
            'apiname' => 'Time Calcution',
            'api_response' => $result
        );
        $this->ApiModel->InsertData('qm_task_create_log', $task_log);
        // $insert_result = array('servicenow_api_request' => $data_string);
        //  $this->ApiModel->UpdateData($insert_result, $tasksid, QM_TASK);
    }

    public function serviceNowtaskUpdateResolution($tasksid = NULL) {

        $res = $this->ApiModel->serviceNowTaskUpdate($tasksid);

        if ($res->task_type_id != 1) {
            return;
        }
        $login = SERVICE_NOW_USERNAME;
        $password = SERVICE_NOW_PASSWORD;
        //$url = 'https://quinticanashuadev.service-now.com/api/now/table/u_qm_task_update?sysparm_fields=sys_import_state_comment,sys_import_state';
        $url = QUINTICA_PRODUCTION_URL . '/api/now/table/u_qm_task_update?sysparm_fields=sys_import_state_comment,sys_import_state';
        $curl = curl_init();

        $is_Machine_operational = FALSE;
        $toner = FALSE;
        $paper = FALSE;

        if ($res->toner == 'on') {
            $toner = 'YES';
        } else {
            $toner = 'NO';
        }
        if ($res->is_Machine_operational == 'on') {
            $is_Machine_operational = 'YES';
        } else {
            $is_Machine_operational = 'NO';
        }
        if ($res->paper == 'on') {
            $paper = 'YES';
        } else {
            $paper = 'NO';
        }

        //      "u_startreading" => $res->startreading, 
        //      "u_endreading" => $res->endreading,
        //      "u_startreading_color" => $res->start_reading_black,
        //      "u_endreading_color"  => $res->end_reading_black,

        $curl_post_data = array(
            "u_action_code" => $res->action_code,
            "u_section_code" => $res->section_code,
            "u_location_code" => $res->location_code,
            "u_close_code" => $res->close_code,
            "u_startreading" => $res->start_reading_black,
            "u_endreading" => $res->end_reading_black,
            "u_startreading_color" => $res->startreading,
            "u_endreading_color" => $res->endreading,
            "u_fse_task_comments" => $res->fse_feedback,
            "u_status_id" => 'In progress',
            "u_book_code" => $res->book_code,
            "u_manual_docket_number" => $res->docketnumber,
            "u_task_name" => $res->task_name,
            "u_actual_distance_travelled" => $res->kilometer_travelled,
            "u_is_machine_operational" => $is_Machine_operational,
            "u_toner" => $toner,
            "u_paper" => $paper,
        );
        $data_string = json_encode($curl_post_data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        $result = json_encode(curl_exec($ch));
        $task_log = array('task_log' => $data_string,
            'task_name' => $res->task_name,
            'apiname' => 'resolution',
            'api_response' => $result
        );
        $this->ApiModel->InsertData('qm_task_create_log', $task_log);
        // $insert_result = array('servicenow_api_request' => $data_string);
        //$this->ApiModel->UpdateData($insert_result, $tasksid, QM_TASK);
    }

    public function serviceNowtaskUpdateAssets($tasksid = NULL) {

        $res = $this->ApiModel->serviceNowTaskUpdate($tasksid);

        if ($res->task_type_id != 1) {
            return;
        }
        if ($res->capture_assets == NULL) {
            return;
        }

        $asset['parts'] = json_decode($res->capture_assets);
        //  $capture_assets  = json_encode($asset);

        $login = SERVICE_NOW_USERNAME;
        $password = SERVICE_NOW_PASSWORD;
        //$url = 'https://quinticanashuadev.service-now.com/api/now/table/u_qm_task_update?sysparm_fields=sys_import_state_comment,sys_import_state';
        $url = QUINTICA_PRODUCTION_URL . '/api/now/table/u_qm_task_update?sysparm_fields=sys_import_state_comment,sys_import_state';
        $curl = curl_init();
        $curl_post_data = array(
            "u_task_name" => $res->task_name,
            "u_capture_assets" => $asset,
        );
        $data_string = json_encode($curl_post_data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );

        $result = json_encode(curl_exec($ch));
        $task_log = array('task_log' => $data_string,
            'task_name' => $res->task_name,
            'apiname' => 'Capture Assets',
            'api_response' => $result
        );
        $this->ApiModel->InsertData('qm_task_create_log', $task_log);

        //  $insert_result = array('servicenow_api_request' => $data_string);
        //  $this->ApiModel->UpdateData($insert_result, $tasksid, QM_TASK);
    }

    public function serviceNowDocumentUpload_get() {

        $login = 'q_mobility_integration';
        $password = 'q_mobility_integration';

        $sys_id = 'de21b55cdb55830011a9338ffe9619e1';
        $file_name = 'img.png';

        $target_url = QUINTICA_PRODUCTION_URL . '/api/now/attachment/file?table_name=incident_task&table_sys_id=' . $sys_id . '&file_name=' . $file_name;

        $file_name_with_full_path = realpath('/var/www/html/Qmobility2/application/controllers/' . $file_name);

        $postdata = json_encode(array('data-binary' => '@' . $file_name_with_full_path));
        // $postdata = array('data-binary' => '@' . $file_name_with_full_path);

        $headers = array("Content-Type:multipart/form-data");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        $data = curl_exec($ch);
        curl_close($ch);
        //header('Content-Type: application/json');
        echo $data;


        exit();

        $post = array('data-binary' => '@' . $file_name_with_full_path);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: image/png'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        $result = curl_exec($ch);
        curl_close($ch);
        header('Content-Type: application/json');
        echo $result;
    }

    public function serviceNowtaskUpdateStatusCheck($tasksid = NULL, $stutusid = NULL) {
        $status = "";
        if ($stutusid == 1) {
            $status = "Assigned";
        }
        if ($stutusid == 3) {
            $status = "Accept";
        }
        if ($stutusid == 7) {
            $status = "Reject";
        }
        if ($stutusid == 5) {
            $status = "In progress";
        }
        if ($stutusid == 2) {
            $status = "On Hold";
        }
        if ($stutusid == 4) {
            $status = "Resolved";
        }
        if ($stutusid == 6) {
            $status = "Cancelled";
        }
        $res = $this->ApiModel->serviceNowTaskUpdate($tasksid);
        if ($res->task_type_id != 1) {
            return;
        }
        $login = SERVICE_NOW_USERNAME;
        $password = SERVICE_NOW_PASSWORD;
        $url = QUINTICA_PRODUCTION_URL . '/api/now/table/u_qm_task_update?sysparm_fields=sys_import_state_comment,sys_import_state';
        $curl = curl_init();

        $fsereson = $res->fse_reason;

        if ($fsereson == 'Re Installation') {
            $fsereson = 'Re-Installation';
        }

        $curl_post_data = array(
            "u_task_name" => $res->task_name,
            "u_status_id" => $status,
            "u_fse_task_comments" => $res->fse_task_comments,
            "u_fse_reason" => $fsereson
        );

        if ($stutusid == 7) {
            $curl_post_data = array(
                "u_task_name" => $res->task_name,
                "u_status_id" => $status,
                "u_fse_task_comments" => $res->fse_reason,
            );
        }

        if ($stutusid == 3) {
            $curl_post_data = array(
                "u_task_name" => $res->task_name,
                "u_status_id" => $status,
            );
        }


        //"u_status_id" => 'On Hold',
        $data_string = json_encode($curl_post_data, JSON_UNESCAPED_SLASHES);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        $result = json_encode(curl_exec($ch));
        $task_log = array('task_log' => $data_string,
            'task_name' => $res->task_name,
            'apiname' => 'status Update',
            'api_response' => $result
        );
        $this->ApiModel->InsertData('qm_task_create_log', $task_log);
    }

    /* chinnarasu */

    public function taskCompleted_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'optional'; //required (or)  not_required (or) optional 
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            $taskid = $getArray['taskid'];
            $userid = "";
            if (isset($getArray['userid'])) {
                $userid = $getArray['userid'];
            }
            if ($userID != FALSE) {
                $data = $this->ApiModel->taskCompleted($taskid);
                if (isset($data[0]['completed_screen_data'])) {
                    $completed_screen_data = json_decode($data[0]['completed_screen_data']);
                    $array = array();

                    foreach ($completed_screen_data as $key => $value) {
                        $array[$key] = $value;
                    }
                    unset($data[0]['completed_screen_data']);
                    $data['completed_screen_data'] = $array;
                }


                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('TOKEN' => 'required', 'taskid' => 'required', 'userid' => 'optional');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'taskid' => 'required', 'userid' => 'optional');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function taskDetailsGroupCategories_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'optional'; //required (or)  not_required (or) optional 

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            $taskid = $getArray['taskid'];


            if ($userID != FALSE) {
                $data = $this->ApiModel->taskDetailsGroupCategories($taskid);
                $userid = "";
                if (isset($getArray['userid'])) {
                    $userid = $getArray['userid'];
                }

                if (isset($data['integrated_api'])) {
                    $data_api = json_decode($data['integrated_api']);
                    // $data['task_type_flow'] = $data_api->allow_for;
                    unset($data['integrated_api']);
                }

                if (isset($data['created_date'])) {
                    $data['created_date'] = $this->date_convert($data['created_date']);
                }

                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('TOKEN' => 'required', 'taskid' => 'required', 'userid' => 'optional');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'taskid' => 'required', 'userid' => 'optional');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function casorOfflineSave_post() {

        $getArray = $this->post();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['json_data'] = 'required';
        $keyArray['object_data'] = 'optional';
        $keyArray['fse_id'] = 'required';
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $object_data = "";
                if (isset($getArray['object_data'])) {
                    $object_data = $getArray['object_data'];
                }
                $data_ins['data'] = $getArray['json_data'];
                $data_ins['fse_id'] = $getArray['fse_id'];
                $data_ins['object_data'] = $object_data;


                $data = $this->ApiModel->InsertData(QM_OFFLINE_MOBILE_DATA, $data_ins);
                $data = $this->ApiModel->casorOfflineSave($getArray['json_data']);

                $this->base64ToimageC();
                $this->serviceNowDocumentpush();

                $this->base64ToimageCustomer();
                $this->serviceNowCustomerSignpush();


                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'json_data' => 'required', 'fse_id' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function OfflineAssset_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->OfflineAssset($userID);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function selectDepondOn_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['label'] = 'required'; //required (or)  not_required (or) optional 
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->selectDepondOns($getArray['taskid'], $getArray['label']);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'taskid' => 'required', 'label' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function casorOffline_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->casorOffline($userID);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function task_list_get() {
       
        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['statusType'] = 'optional';
        $keyArray['fromdashboard'] = 'optional';
        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            // $statusType = $getArray['statusType'];
            $fromdashboard = 0;
            if (isset($getArray['fromdashboard'])) {
                $fromdashboard = 1;
            }

            $statusType = NULL;
            if (isset($getArray['statusType'])) {
                $statusType = $getArray['statusType'];
            }
            if ($userID != FALSE) {
                $data = $this->ApiModel->task_list($userID, $statusType, $fromdashboard);
                //print_r($data);


                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('TOKEN' => 'required', 'userid' => 'required', 'statusType' => 'optional');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'fromdashboard' => 'optional', 'userid' => 'required', 'statusType' => 'optional');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function taskOnhold_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'optional'; //required (or)  not_required (or) optional 

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            $taskid = $getArray['taskid'];
            $userid = "";
            if (isset($getArray['userid'])) {
                $userid = $getArray['userid'];
            }

            if ($userID != FALSE) {
                $data = $this->ApiModel->taskOnhold($taskid, 8);
                $onhold_array = array();
                foreach ($data as $key => $value) {
                    $onhold_array[] = $value['command'];
                }
                // print_r($onhold_array);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $onhold_array,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('TOKEN' => 'required', 'taskid' => 'required', 'userid' => 'optional');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'taskid' => 'required', 'userid' => 'optional');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function taskReject_get() {

        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'optional'; //required (or)  not_required (or) optional 



        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            $taskid = $getArray['taskid'];

            $userid = "";
            if (isset($getArray['userid'])) {
                $userid = $getArray['userid'];
            }
            if ($userID != FALSE) {
                $data = $this->ApiModel->taskOnhold($taskid, 9);
                $onhold_array = array();
                foreach ($data as $key => $value) {
                    $onhold_array[] = $value['command'];
                }
                // print_r($onhold_array);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $onhold_array,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('TOKEN' => 'required', 'taskid' => 'required', 'userid' => 'optional');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'taskid' => 'required', 'userid' => 'optional');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function offlineData_get() {

        $this->ApiModel->offlineDatas();
    }

    public function update_screen_cat_get() {
        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskID'] = 'required'; //required (or)  not_required (or) optional 

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->update_screen_cat($getArray['taskID']);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'taskID' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function tab_categories_get() {
        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional 
        //$keyArray['task_type_id'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'optional'; //required (or)  not_required (or) optional 

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            $taskid = $getArray['taskid'];

            if ($userID != FALSE) {

                $userid = "";
                if (isset($getArray['userid'])) {
                    $userid = $getArray['userid'];
                }
                $data = $this->ApiModel->tab_categories($taskid);
                $cat_array1 = array();
                $cat_array2 = array();
                $cat_array3 = array();
                foreach ($data as $key => $value) {
                    if ($value['separate_update_screen'] == 1) {
                        $req = $this->ApiModel->tab_categories_requried_fileds($value['id']);
                    } else {
                        $req = 0;
                    }
                    $cat_array1[$value['id']] = $value['category'];
                    $cat_array3[$value['category']] = $req;
                    $cat_array2[$value['category']] = $value['separate_update_screen'];
                }
                // $this->ApiModel->update_screen_cat($taskid);
                $cat_array = array();
                $cat_array['0'] = $cat_array1;
                $cat_array['1'] = $cat_array2;
                $cat_array['2'] = $cat_array3;
                $cat_array['3'] = $this->ApiModel->update_screen_cat($taskid);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $cat_array,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('TOKEN' => 'required', 'userid' => 'optional', 'taskid' => 'required');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'userid' => 'optional', 'taskid' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function tabcategories_fields_get() {


        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['catid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'optional'; //required (or)  not_required (or) optional 

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            $catid = $getArray['catid'];
            $userid = $getArray['userid'];
            $taskid = $getArray['taskid'];


            if ($userID != FALSE) {

                $userid = "";
                if (isset($getArray['userid'])) {
                    $userid = $getArray['userid'];
                }
                $data = $this->ApiModel->tabcategories_fields($catid, $taskid);



                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $required_key = array('TOKEN' => 'required', 'userid' => 'optional', 'catid' => 'required');
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'userid' => 'optional', 'catid' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function taskStatusAsset_get() {


        $getArray = $this->get();
        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskID'] = 'required'; //required (or)  not_required (or) optional 

        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);
            if ($userID != FALSE) {
                $data = $this->ApiModel->taskStatusAsset($getArray['taskID']);
                $message = [
                    'message' => 'Response Successfully',
                    'data' => $data,
                    'status' => 'success',
                    'code' => '1',
                ];
            } else {
                $message = [
                    'message' => 'Token not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {
            $required_key = array('TOKEN' => 'required', 'taskID' => 'required');
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function date_convert($date) {

        return date('Y-m-d', strtotime($date));
    }

    public function updatetab_catigoriesfield_get() {

        $getArray = $this->get();
        if (count($getArray) == 0) {
            $inputJSON = file_get_contents('php://input');
            $getArray = json_decode($inputJSON, TRUE);
        }
        if (count($getArray) == 0) {
            $getArray = array();
        }

        $keyArray['TOKEN'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['taskid'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['postData'] = 'required'; //required (or)  not_required (or) optional 
        $keyArray['userid'] = 'optional'; //required (or)  not_required (or) optional


        if ($this->checkPost($getArray, $keyArray) == 'TRUE') {
            $userID = $this->tokenValid($getArray['TOKEN']);

            if ($userID != FALSE) {
                $userid = "";
                if (isset($getArray['userid'])) {
                    $userid = $getArray['userid'];
                }
                $data = $this->ApiModel->updatetab_catigoriesfield($getArray);

                if ($data == TRUE) {
                    $message = [
                        'message' => $data,
                        'status' => 'success',
                        'code' => '1',
                    ];
                } else {
                    $message = [
                        'message' => $data,
                        'status' => 'success',
                        'code' => '0',
                    ];
                }
            } else {

                $message = [
                    'message' => 'auth value not valid ',
                    'status' => 'Failed',
                    'code' => '0',
                ];
            }
        } else {

            $required_key = array('TOKEN' => 'required',
                'taskid' => 'required',
                'postData' => 'required',
                'userid' => 'optional'
            );
            $message = [
                'message' => 'Check Passing Paramter',
                'required key ' => $required_key,
                'status' => 'Failed',
                'code' => '0',
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function getLocation()
    {
        $name="vitthal";
          $this->ApiModel->getuserlocation($name); 
    }

    /* chinnarasu */
}

/*API LIST
 
Login
Get method
 * http://202.129.196.133/Qmobility/Api/login/username/maurice/password/maurice
Post Method
 * http://202.129.196.133/Qmobility/Api/login
 
Reset Password
Get Method
 * http://202.129.196.133/Qmobility/Api/resetPassword/emailid/817testuser@gmail.com/userid/1
Post Method
 * http://202.129.196.133/Qmobility/Api/resetPassword
 
 Task Count
 Get Method
 * http://202.129.196.133/Qmobility/Api/taskCount/TOKEN/1ffeb03a41bd1be20a4adb180ebcc7bd/userid/1
 * Post Method
 * http://202.129.196.133/Qmobility/Api/taskCount
 
 Task Status
 Get Method
 * http://202.129.196.133/Qmobility/Api/statusType/TOKEN/1ffeb03a41bd1be20a4adb180ebcc7bd
 Post Methos
 * http://202.129.196.133/Qmobility/Api/statusType
 
 Task List
 Get Method
 * http://202.129.196.133/Qmobility/Api/taskList/TOKEN/1ffeb03a41bd1be20a4adb180ebcc7bd/userid/1/statusType/1
 Post Method
 * http://202.129.196.133/Qmobility/Api/taskList
  
 Profile Picture
 Get Method
 * http://202.129.196.133/Qmobility/Api/fseProfilePic/TOKEN/2b9cdebb444dbb2fe8380860104f0573/userid/1/pictureString/123
 Post Method
 * http://202.129.196.133/Qmobility/Api/fseProfilePic 
 
 Task Check list
 Get Method
 * http://202.129.196.133/Qmobility/Api/taskCheckList/TOKEN/2b9cdebb444dbb2fe8380860104f0573/taskid/51
 Post Method
 *http://202.129.196.133/Qmobility/Api/taskCheckList 

 Task comment update
 Get Method
 * http://202.129.196.133/Qmobility/Api/updatetaskComment/TOKEN/2b9cdebb444dbb2fe8380860104f0573/taskid/35/comments/test
 * 
 Create TASK Service Now
 * 
 http://202.129.196.133/Qmobility/Api/CreateTask/apiKey/QmobilitySYNserviceNow/taskTitle/ServiceNow/incidentDetails/sinciden/taskDescription/serviceNowtest/customerName/serviceCustomer/productName/snproduct/serialNumber/test12345/productCode/QWERTY1234/taskLocationAddress/addresstask/googleMapLatitudeLongitude/(13.239945499286314,79.03564453125)
 * 
 * 
 */
