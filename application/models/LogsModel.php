<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LogsModel extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function Logs() {

        $this->db->select('*');
        $this->db->from(QM_LOGS);
        $this->db->limit('200');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

   
}
