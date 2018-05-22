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
        return $qry->result();
    }    
    function getklinik($iddokter,$jenis) {
        $this->db->select('refklinik.id_klinik, refklinik.nama_klinik');
        $this->db->from('refklinik');
        $this->db->join('jadwal', 'refklinik.id_klinik=jadwal.id_klinik');
        if ($iddokter=='reg'){
            $this->db->where("id_dokter=111 or id_dokter=222");
        } else {
            $this->db->where('id_dokter', $iddokter);
        }
        $this->db->where("(tipe_layanan = 3 or tipe_layanan=$jenis)");
        $this->db->group_by('refklinik.id_klinik');
        $res = $this->db->get();
        return $res->result();
    }    
    function getjadwal($klinik,$dokter,$jenis) {
        $this->db->from('jadwal');
        $this->db->where('id_dokter', $dokter);
        $this->db->where('id_klinik', $klinik);
        $this->db->where('jnslayan', $jenis);
        $res = $this->db->get();
        return $res->result_array();
    }
    function getkuotatgl($jadwaltgl) {
        $this->db->from('treservasi');
        $this->db->where("date(waktu_rsv)='$jadwaltgl'");
        return  $this->db->count_all_results();
    }
 }