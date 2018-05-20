<?php defined('BASEPATH') OR exit('No direct script access allowed');

 class Mod_reservasi extends CI_Model {
     function __construct() {
         parent:: __construct();
    }

    function cekdatpas($norm, $tgllahir){
        $this->db->from('tpasien');
        $this->db->where('norm', $norm);
        $this->db->where('tgl_lahir', $tgllahir);
        $qry = $this->db->get();
        if ($qry->num_rows() > 0) return $qry->row(); 
    }
	
    function cekreserv($norm, $status){
        $this->db->from('treservasi');
        $this->db->where('norm', $norm);
        $this->db->where('status', $status);
        $qry = $this->db->get();
        if ($qry->num_rows() > 0) return $qry->row(); 
    }
	
	
 }