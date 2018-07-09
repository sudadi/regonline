<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_sms extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    public function getsms($orderby,$group=null,$where=null,$number=null,$offset=null) {
        if($group){
            $this->db->group_by('no_telp,id_sms,pesan,stat_baca,stat_kirim');
        }
        $this->db->order_by($orderby, 'DESC');
        return $this->db->get_where('tsms', $where, $number, $offset)->result();
    }
    
}