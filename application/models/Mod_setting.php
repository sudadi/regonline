<?php defined('BASEPATH') OR exit('No direct script access allowed');
 class Mod_setting extends CI_Model {
     function __construct() {
         parent:: __construct();
    }
    function getdokter($number,$offset) {
        return $this->db->get('refdokter',$number,$offset)->result();
    }
    function getklinik($number,$offset) {
        return $this->db->get('refklinik',$number,$offset)->result();
    }
    function getjnslayan() {
        return $this->db->get('refklinik')->result();
    }
    function getjadwal($number,$offset) {
        $this->db->select('refdokter.nama_dokter,refklinik.nama_klinik,refjns_layan.jnslayan,jadwal.id_jadwal,'
                . 'jadwal.id_hari,jadwal.jam_mulai,jadwal.jam_selesai,jadwal.kuota_perjam,jadwal.status');
        $this->db->join('refdokter', 'refdokter.id_dokter=jadwal.id_dokter');
        $this->db->join('refklinik', 'refklinik.id_klinik=jadwal.id_klinik');
        $this->db->join('refjns_layan', 'refjns_layan.id_jnslayan=jadwal.jnslayan');
        $this->db->order_by('jadwal.id_jadwal');
        return $this->db->get('jadwal',$number,$offset)->result();
    }
    function getjmljadwal() {
        return $this->db->get('jadwal')->num_rows();
    }
    function getdatalibur($number,$offset) {
        return $this->db->get('tgl_libur',$number,$offset)->result();
    }
    function getnumlibur() {
       return $this->db->get('tgl_libur')->num_rows(); 
    }
 }