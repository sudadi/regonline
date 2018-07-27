<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_sms extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    public function getsms($orderby,$group=null,$where=null,$number=null,$offset=null) {
        if($group){
            $this->db->group_by('Number');
        }
        $this->db->order_by($orderby, 'DESC');
        return $this->db->get_where('vsms', $where, $number, $offset)->result();
    }
//    public function getsms($where) {
//        return $this->db->get_where('vsms', $where)->result_array();
//    }
    
    
}