<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class HomeModel extends MY_Model {

    function __construct() {
        parent::__construct();
        
    }

    public function taskStatusNotification($user_id = NULL) {

        $table = QM_NOTIFICATION;
        $this->db->select('*');
        $this->db->from($table);
        $this->db->join(QM_TASK, QM_NOTIFICATION . '.task_id = ' . QM_TASK . '.id');
        $this->db->join(QM_STATUS_TYPE, QM_NOTIFICATION . '.status_id = ' . QM_STATUS_TYPE . '.id');
        $this->db->where($table . '.user_id', $user_id);
        $this->db->order_by(QM_NOTIFICATION . ".id", "desc");
        $this->db->limit(6);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function taskStatusNotificationCount($user_id = NULL) {

        $table = QM_NOTIFICATION;
        $this->db->select('*');
        $this->db->from($table);
        $this->db->join(QM_TASK, QM_NOTIFICATION . '.task_id = ' . QM_TASK . '.id');
        $this->db->join(QM_STATUS_TYPE, QM_NOTIFICATION . '.status_id = ' . QM_STATUS_TYPE . '.id');
        $this->db->where($table . '.user_id', $user_id);
        $this->db->where($table . '.notification_status', 0);
        $this->db->order_by(QM_NOTIFICATION . ".id", "desc");
        $this->db->limit(6);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $data = $query->num_rows();
        return $data;
    }

    public function taskStatusnotificationCheck($userid) {
        $data = array('notification_status' => 1);
        $this->db->where('user_id', $userid);
        $this->db->update(QM_NOTIFICATION, $data);
        //echo $this->db->last_query();
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function totalwebuser() {
        $this->db->select('count(id) as totalwebuser');
        $this->db->from(QM_WEB_ACCESS);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->totalwebuser;
        }
        return null;
    }

    public function totalfse() {
        $this->db->select('count(id) as totalfse');
        $this->db->from(QM_FSE_DETAILS);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->totalfse;
        }
        return null;
    }

    public function totalentity() {
        $this->db->select('count(id) as totalentity');
        $this->db->from(QM_ENTITY);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->totalentity;
        }
        return null;
    }

    public function totalbranch() {
        $this->db->select('count(id) as totalbranch');
        $this->db->from(QM_BRANCH);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->totalbranch;
        }
        return null;
    }

    public function totalprojectincident() {
        $this->db->select('count(id) as totalprojectincident');
        $this->db->from(QM_PROJECT);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->totalprojectincident;
        }
        return null;
    }

    public function totaltask() {
        $this->db->select('count(id) as totaltask');
        $this->db->from(QM_TASK);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->totaltask;
        }
        return null;
    }

    public function ProjectCount() {
        $data_project = array();
        $i = 0;
        $this->db->select('id,status_type');
        $this->db->from(QM_STATUS_TYPE);
//        if ($this->session->userdata('session_data')->is_admin != 1) {
//            $this->db->where(QM_STATUS_TYPE . '.ent_id', $this->session->userdata('session_data')->ent_id);
//        }
        $this->db->where('status_stat', 1);
        $status_type_q = $this->db->get();
        if ($status_type_q->num_rows() > 0) {
            $status_type = $status_type_q->result_array();
            foreach ($status_type AS $st) {
                $this->db->select('count(id) as totaltask');
                $this->db->from(QM_TASK);
                $this->db->where(QM_TASK . '.status_id', $st['id']);
                $this->db->where(QM_TASK . '.project_id != ', 0, FALSE);
                if ($this->session->userdata('session_data')->is_admin != 1) {
                 $this->db->where(QM_TASK . '.ent_id', $this->session->userdata('session_data')->ent_id);
                }
                $query = $this->db->get();
                if ($query->num_rows() > 0) {

                    $row = $query->row();
                    $data_project[$i]['label'] = $st['status_type'];
                    $data_project[$i]['value'] = $row->totaltask;
                    $i++;
                }
            }
        } else {
            $data_project[0]['label'] = '';
            $data_project[0]['value'] = '';
        }
        return json_encode($data_project);
    }

    public function IncidentCount() {
        $data_project = array();
        $i = 0;
        $this->db->select('id,status_type');
        $this->db->from(QM_STATUS_TYPE);
        
        $this->db->where('status_stat', 1);
        $status_type_q = $this->db->get();
        if ($status_type_q->num_rows() > 0) {
            $status_type = $status_type_q->result_array();
            foreach ($status_type AS $st) {
                $this->db->select('count(id) as totaltask');
                $this->db->from(QM_TASK);
                $this->db->where(QM_TASK . '.status_id', $st['id']);
                $this->db->where(QM_TASK . '.incident_id != ', 0, FALSE);
                if ($this->session->userdata('session_data')->is_admin != 1) {
                 $this->db->where(QM_TASK . '.ent_id', $this->session->userdata('session_data')->ent_id);
                }
                $query = $this->db->get();
                if ($query->num_rows() > 0) {

                    $row = $query->row();
                    $data_project[$i]['label'] = $st['status_type'];
                    $data_project[$i]['value'] = $row->totaltask;
                    $i++;
                }
            }
        } else {
            $data_project[0]['label'] = '';
            $data_project[0]['value'] = '';
        }
        return json_encode($data_project);
    }

    public function TaskCount() {
        $data_project = array();
        $i = 0;
        $this->db->select('id,status_type');
        $this->db->from(QM_STATUS_TYPE);
        $this->db->where('status_stat', 1);
        $status_type_q = $this->db->get();
        if ($status_type_q->num_rows() > 0) {
            $status_type = $status_type_q->result_array();
            foreach ($status_type AS $st) {
                $this->db->select('count(id) as totaltask');
                $this->db->from(QM_TASK);
                $this->db->where(QM_TASK . '.status_id', $st['id']);
                if ($this->session->userdata('session_data')->is_admin != 1) {
                 $this->db->where(QM_TASK . '.ent_id', $this->session->userdata('session_data')->ent_id);
                }
                $query = $this->db->get();
                if ($query->num_rows() > 0) {

                    $row = $query->row();
                    $data_project[$i]['label'] = $st['status_type'];
                    $data_project[$i]['value'] = $row->totaltask;
                    $i++;
                }
            }
        } else {
            $data_project[0]['label'] = '';
            $data_project[0]['value'] = '';
        }
        return json_encode($data_project);
    }

    public function fseTaskComplete() {
        $i = 0;
        $data = array();
        $this->db->select('count(status_id) as total,fse_username');
        $this->db->from(QM_TASK);
        $this->db->join(QM_FSE_DETAILS, QM_FSE_DETAILS . '.id = ' . QM_TASK . '.fse_id');
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_TASK . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->order_by('total', 'desc');
        $this->db->group_by(QM_FSE_DETAILS . '.id');
        //$this->db->where('status_id', 4);
        $this->db->limit(6);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $datas = $query->result_array();
            foreach ($datas AS $d) {
                 $data[$i]['label'] = $d['fse_username'];
                 $data[$i]['value'] = $d['total'];
                 $i++;
            }
        }else {
            $data[0]['label'] = '';
            $data[0]['value'] = '';
        }
        return json_encode($data);
    }
    
    
    public function user_list($limit="") 
    {
        $this->db->select('qm_fse_details.fse_name,qm_fse_details.fse_address,qm_fse_details.fse_email,qm_fse_details.id,qm_fse_type.fse_type');
        $this->db->select('qm_fse_location.fse_lat,qm_fse_location.fse_long');
        $this->db->from('qm_fse_details');
        $this->db->join('qm_fse_location', 'qm_fse_details.id = qm_fse_location.Fse_id', 'left');
        $this->db->join('qm_fse_type', 'qm_fse_details.fse_type_id = qm_fse_type.id', 'left');
        $query = $this->db->get();
        $d = $query->result_array();
     
        return $d;
    }
    
    
//    public function filterdata()
//    {
//        //print_r($_POST);        exit(); 
//          
//        $this->db->select('qm_fse_details.fse_name,qm_fse_details.fse_address,qm_fse_details.fse_email,qm_fse_details.id');
//        $this->db->select('fse_lat,fse_long');
//        $this->db->from('qm_fse_details');
//        $this->db->join('qm_fse_location', 'qm_fse_details.id = qm_fse_location.fse_id', 'left');
//     
//        if($this->input->post('skill_set')) 
//            $this->db->join('qm_fse_type', 'qm_fse_details.fse_type_id = qm_fse_type.id', 'left');
//        
//        if($this->input->post('Status')){
//             $this->db->join('qm_status_type', 'qm_fse_details.fse_status = qm_status_type.id', 'left');
//            
//        }
//        if($this->input->post('name_fse'))
//            $this->db->where('qm_fse_details.fse_name',  trim ($this->input->post('name_fse')));
//         
//         if($this->input->post('address'))
//            $this->db->where('qm_fse_details.fse_address',trim ($this->input->post('address')));
//      
//         if($this->input->post('Status'))
//             $this->db->where('qm_status_type.status_type',trim ($this->input->post('Status')));
//        
//       //echo  $this->db->get_compiled_select();          exit(); 
//        if($this->input->post('skill_set')) 
//            $this->db->where('qm_fse_type.fse_type',trim ($this->input->post('skill_set')));
//               
//        if($this->input->post('Redius'))
//        {
//           $ids= $this->get_redius('41.989597','-87.659934','10'); 
//           $this->db->where_in('qm_fse_details.id',$ids);
//           
//          echo  $this->db->get_compiled_select();          exit();         
//        }
//        
//        if($this->input->post('Priority')) {
//           $fse_id_data = $this->get_fseId_By_Task($this->input->post('Priority'));
//         
//           if($fse_id_data)
//           $this->db->where('qm_fse_details.id',$fse_id_data);
//           
//         } 
//         
//         $this->db->limit(3); 
//         
//        $query = $this->db->get();
//        $d = $query->result_array();
//       // print_r($d);exit(); 
//        return $d;
//    }
//    
    
//    public function get_redius($lat,$lng,$miles)
//    {
//        $this->db->select("( 3959 * acos( cos( radians($lat) ) * cos( radians( fse_lat ) ) * cos( radians( fse_long ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( fse_lat ) ) ) ) AS distance");                         
//        $this->db->having('distance <= ' . $miles);                     
//        $this->db->order_by('distance');                    
//        $this->db->limit(20, 0);
//        $query = $this->db->get();
//         $a = $query->result_array();
//       
//         foreach($a as $aa)
//        {
//            $data[]=$aa['id']; 
//        }
//        if($query->num_rows()>0)
//            return implode(',',$data); 
//    }
//    
    public function filterdata1()
    {
       $sql="SELECT qm_fse_details.fse_name,qm_fse_details.fse_address,qm_fse_details.fse_email,qm_fse_details.id,qm_fse_location.fse_lat,qm_fse_location.fse_long From qm_fse_details LEFT JOIN qm_fse_location ON qm_fse_details.id = qm_fse_location.fse_id";
              
       if($this->input->post('skill_set')) 
            $sql.=" LEFT JOIN qm_fse_type ON qm_fse_details.fse_type_id = qm_fse_type.id ";
          
       // $this->db->select('qm_fse_details.fse_name,qm_fse_details.fse_address,qm_fse_details.fse_email,qm_fse_details.id');
       // $this->db->select('fse_lat,fse_long');
      //  $this->db->from('qm_fse_details');
        //$this->db->join('qm_fse_location', 'qm_fse_details.id = qm_fse_location.fse_id', 'left');
     
        
        if($this->input->post('Status')){
             $sql.=" LEFT JOIN qm_status_type ON qm_fse_details.fse_status = qm_status_type.id";
            
        }
        $sql.=" where 1";
        if($this->input->post('name_fse'))
        {      $uname= trim($this->input->post('name_fse'));
            $sql.=" AND qm_fse_details.fse_name LIKE '%$uname%'";
        }
         if($this->input->post('address')){
             $address=  trim ($this->input->post('address'));
             $sql.=" AND qm_fse_details.fse_address LIKE '%$address%'";
         }
         if($this->input->post('Status')){
            $ustatus= trim ($this->input->post('Status')); 
             $sql.=" AND qm_status_type.status_type LIKE '%$ustatus%'";
         } 
       //echo  $this->db->get_compiled_select();          exit(); 
        if($this->input->post('skill_set')) 
        {
            $skillss= trim ($this->input->post('skill_set')); 
            $sql.=" AND qm_fse_type.fse_type LIKE '%$skillss%'";
        }
               
        if($this->input->post('Redius'))
        {
            $ids= $this->get_redius($this->input->post('latitude'),$this->input->post('langitude'),$this->input->post('Redius')); 
           if($ids)
           $sql.=" AND qm_fse_details.id IN ($ids)" ;
        }
        if($this->input->post('Priority')) {
           $fse_id_data = $this->get_fseId_By_Task($this->input->post('Priority'));
         
           if($fse_id_data)
            $sql.=" AND qm_fse_details.id IN ($fse_id_data)" ;
         } 
         $sql.=" LIMIT 5";  
       
       //print_r($sql); exit(); 
        $query = $this->db->query($sql);
         if($query->num_rows()>0){
            $d = $query->result_array();
            return $d;
        }
        
    }
    
    
    public function get_redius($lat,$lng,$miles)
    {
       $sql="SELECT *,( 6371 * acos( cos( radians(41.989597) ) * cos( radians( `fse_lat` ) ) * cos( radians( `fse_long` ) - radians(-87.659934) ) + sin( radians(41.989597) ) * sin( radians( `fse_lat` ) ) ) ) AS distance
       FROM `qm_fse_location` HAVING distance <= 3 ORDER BY distance ASC ";
       $query = $this->db->query($sql);
        if($query->num_rows()>0)
        { $b = $query->result_array();
            foreach($b as $bb)
            {
                $data[]=$bb['fse_id']; 
            }
          return implode(',',$data); 
        }
      
        
    }

    public function get_fseId_By_Task($priority)
    {  
        $sql="SELECT qm_task.fse_id from qm_task where priority ='".$priority."' LIMIT 10";
       $query = $this->db->query($sql);
        $a = $query->result_array();
        foreach($a as $aa)
        {
            $data[]=$aa['fse_id']; 
        }
        if($query->num_rows()>0)
         return implode(',',$data); 
      
        
        
    }
    
    public function getuserdetail()
    {
         $this->db->select('qm_fse_details.fse_name,qm_fse_details.fse_address,qm_fse_details.fse_email,qm_fse_details.id');
         $this->db->select('qm_task.*');
         $this->db->from('qm_fse_details');
         $this->db->join('qm_task', 'qm_fse_details.id = qm_task.fse_id', 'left');
       
         if($this->input->post('id'))
            $this->db->where('qm_fse_details.id',$this->input->post('id'));
         
        $query = $this->db->get();
        $a = $query->result_array();
        foreach ($a As $aa) 
        {           
          $aa['taskType']= $this->getta($aa['task_type_id']);
        }
      return $a; 
    }
    public function getta($Tid)
    {
        $this->db->select('status_type');
        $this->db->from('qm_status_type');
        $this->db->where('id',$Tid);
        $query = $this->db->get();
        $a = $query->result_array();
        return $a;
        
    }
    public function get_skill_set()
    {
        $this->db->select('fse_type');
        $this->db->from(QM_FSE_TYPE);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $datas = $query->result_array();
            return $datas;
            
        }
    }
    public function get_status_set()
    {
        $this->db->select('status_type');
        $this->db->from(QM_STATUS_TYPE);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $datas = $query->result_array();
          //  print_r($datas);            die(); 
            return $datas;
            
        }
    }
    public function get_priority_set()
    {
        $this->db->select('priority_type,id');
        $this->db->from(QM_PRIORITY);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $datas = $query->result_array();
           // print_r($datas);            die(); 
            return $datas;
            
        }
    }
    
    
}
