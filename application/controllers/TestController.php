<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class TestController extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('Common_helper', 'common_helper');
    }

    public function index() {
        echo date('Y-m-d H:i:s', time());
    }

    public function mail() {
        $data = array();
        $this->load->library('email'); // Note: no $config param needed
        $this->email->from('teamdemo817@gmail.com');
        $this->email->to('teamdemo817@gmail.com');
        $this->email->subject('Test email from CI and Gmail');
        $message = $this->load->view('email/resetPassword', $data, TRUE);
        $this->email->message($message);
        $this->email->send();
        print_r($this->email->print_debugger());
    }

    public function mail_check() {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.office365.com',
            'smtp_user' => 'workwide@quintica.com',
            'smtp_pass' => 'CfM99o217o',
            'smtp_crypto' => 'tls',
            'newline' => "\r\n", //REQUIRED! Notice the double quotes!
            'smtp_port' => 587,
            'mailtype' => 'html'
        ];
        $this->load->library('email', $config);
        $this->email->from('workwide@quintica.com');
        $this->email->to('teamdemo817@gmail.com');
        $this->email->subject('Test');
        $this->email->message('SMTP sending test');
        $sent = $this->email->send();
        if ($sent) {
            echo 'OK';
        } else {
            echo $this->email->print_debugger();
        }
    }

    public function soapcheck() {

        $location_URL = 'https://quinticanashuadev.service-now.com/cmdb_model.do?SOAP';
        $action_URL = 'http://www.service-now.com/cmdb_model/getRecords';
        $xml_test = '';

        $client = new SoapClient(null, array(
            'location' => $location_URL,
            'uri' => "",
            'trace' => 1,
            'login' => 'q_mobility_integration',
            'password' => 'Qm0b!lity',
        ));

        try {
            header('Content-type: text/xml');
            echo $order_return = $client->__doRequest($location_URL, $action_URL, 1);
        } catch (SoapFault $exception) {
            var_dump(get_class($exception));
            var_dump($exception);
        }
    }

    public function reset() {
        $login = 'q_mobility_integration';
        $password = 'q_mobility_integration';
        $url = 'https://quinticanashuadev.service-now.com/api/now/v1/table/cmdb_model?sysparm_view=workwide';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        $result = curl_exec($ch);
        curl_close($ch);
        echo "<pre>";
        print_r(json_decode($result));
        echo "</pre>";


        //echo($result);
    }

    public function serviceNowtaskUpdate() {
        $login = 'q_mobility_integration';
        $password = 'q_mobility_integration';
        $url = 'https://quinticanashuadev.service-now.com/api/now/table/u_qm_task_update';
        $curl = curl_init();
        $curl_post_data = array(
            "u_customer_document" => "test",
            "u_call_status" => "test",
            "u_endreading" => "test",
            "u_outstanding_calls" => "test",
            "u_previous_meter_reading" => "test",
            "u_product_name" => "test",
            "u_customer_document" => "test",
            "u_task_name" => "TASK0030629",
        );
        $data_string = json_encode($curl_post_data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        header('Content-Type: application/json');
        $result = curl_exec($ch);
        print_r($result);
        exit();
    }

    public function googlegeoCode() {
        $address = '65 Park Lane, Sandton';
        $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false');
        $geo = json_decode($geo, true);
        if ($geo['status'] == 'OK') {
            echo $latitude = $geo['results'][0]['geometry']['location']['lat'];
            echo $longitude = $geo['results'][0]['geometry']['location']['lng'];
        }
        echo "<pre>";
        print_r($geo);
    }

    public function updated_check() {

        $this->load->model("CronModel");
        $this->CronModel->updated_check_model();
    }

    public function taskmapdata() {
        $this->load->model("ApiUpdateModel");
        $this->ApiUpdateModel->updated_check_model();
    }

}
