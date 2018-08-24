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
    
    function saveres($chatid) {
        $dataTele= $this->getrowteleres("fromid=$chatid");
        $waktu=date('Y/m/d H:i:s', strtotime($dataTele->tgl_res.$dataTele->jam));
        $datares= array('norm'=>$dataTele->norm,
                'waktu_rsv'=>$waktu,'jadwal_id'=>$dataTele->jadwal_id,
                'jns_jaminan_id'=>$dataTele->jaminan_id,
                'sebab_id'=>9,
                'status'=>1, 'user_id'=>2, 'jenis_rsv'=>'TELE');
        if ($this->db->insert('res_treservasi', $datares)){
            $idres=$this->db->insert_id();
            $nores=$kodeklinik.'-'.$idres;
            $this->db->update('res_treservasi', array('nores'=>$nores), "id_rsv = {$idres}");
            return TRUE;
        }
    }

}
