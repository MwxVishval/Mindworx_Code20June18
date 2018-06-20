<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LoginModel extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function login($username, $password) {
        $query = $this->db->query('SELECT * FROM ' . QM_WEB_ACCESS . ' WHERE web_username = "' . $username . '"  AND web_password = "' . $password . '";');
        if ($query->num_rows() == 1) {
            $row = $query->row_array();
            $session_data = $this->data;
            $session_data->user_id = $row['id'];
            $session_data->name = $row['web_name'];
            $session_data->branch_id = $row['branch_id'];
            $session_data->user_type = $row['user_type'];
            $entity_is_admin = NULL;
            $q = $this->db->query('SELECT user_id FROM ' . QM_USER_ASSIGN_ENTITY . ' WHERE entity_id = "' . $row['ent_id'] . '"  ORDER BY id DESC LIMIT 1;');
            if($q->num_rows() > 0){
            $p = $q->row_array();
            $session_data->entity_admin = $p['user_id'];
            $entity_is_admin = $p['user_id'];
            }else{$session_data->entity_admin = NULL;}
            if($entity_is_admin == $row['id'])
            {$session_data->is_entity_admin = 1;}else{$session_data->is_entity_admin = NULL;}
            $session_data->email = $row['web_email'];
            $session_data->ent_id = $row['ent_id'];
            $session_data->is_admin = $row['is_admin'];
            $this->session->set_userdata('session_data',$session_data);
            redirect('dashboard','refresh');
        } else {
            $this->session->set_flashdata('error', 'Check Username and Password !!!');
            redirect('/','refresh');
        }
    }
}
