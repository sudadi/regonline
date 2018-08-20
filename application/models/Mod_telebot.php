<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Mod_telebot extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function getrowteleres($where=null) {
        $result = $this->db->get_where('res_telebot', $where, 1);
        return $result->row();
    }
    
    function newteleres($fromid) {
        $this->db->insert('res_telebot',array('fromid'=>$fromid,'status'=>'norm'));
        return $this->db->affected_rows();
    }
    
    function updteleres($fromid, $set) {        
        $this->db->where('fromid', $fromid);
        $this->db->update('res_telebot',$set);
        return $this->db->affected_rows();
    }
    
    function delteleres($fromid) {
        $this->db->delete('res_telebot', "fromid={$fromid}");
        return $this->db->affected_rows();
    }

}
