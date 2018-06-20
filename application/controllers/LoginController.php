<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LoginController extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Data', 'data');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->load->model("LoginModel");
    }

    public function index() {
        $data['page'] = 'LoginView';
        $valid = $this->session->userdata('session_data');
        if (isset($valid)) {
            if ($valid->user_id != NULL && $valid->user_type != NULL) {
                redirect('dashboard', 'refresh');
            }
        }                
        $this->load->view("LoginView", $data);
    }

    public function check() {
        $username = $this->input->post("username");
        $password = $this->input->post("password");
        $this->form_validation->set_rules('username', 'password', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Check Username and Password !!!');
            redirect('/','refresh');
        } else {
            $this->LoginModel->login($username, $password);
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('/','refresh');
    }
    
    public function locked() {
        redirect('/','refresh');
    }
    
    public function error_404() {
        $this->load->view("page_404");
    }

}
