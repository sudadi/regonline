<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_sms extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    public function getsms($orderby,$where=null) {
        $this->db->order_by($orderby, 'DESC');
        return $this->db->get_where('tsms', $where)->result();
    }
    
}