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
    function getdokter() {
        $this->db->from('refdokter');
        $qry = $this->db->get();
        return $qry->row();
    }    
    function getklinik($jenis) {
        $this->db->from('refklinik');
        $this->db->where('jenis', $jenis);
        $this->db->or_where('jenis', 3);
        $res = $this->db->get();
        return $res->row();
    }    
    function getklinikbydok($dokter) {
        $this->db->from('refklinik');
        $this->db->join('tjadwal', 'refklinik.id_klinik=tjadwal.id_klinik');
        $this->db->join('refdokter', 'refklinik.id_dokter=refdokter.id_dokter');
        $this->db->where('id_dokter', $dokter);
        $res = $this->db->get();
        return $res->row();
    }
 }