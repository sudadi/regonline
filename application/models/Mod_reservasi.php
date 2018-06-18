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
    function getdokter($jenis) {
        $this->db->select('refdokter.id_dokter, refdokter.nama_dokter');
        $this->db->from('refdokter');
        $this->db->join('jadwal','refdokter.id_dokter=jadwal.id_dokter');
        $this->db->group_by('jadwal.id_dokter');
        $this->db->where('jnslayan', $jenis);
        $qry = $this->db->get();
        return $qry->result();
    }    
    function getdokterbytgl($klinik,$jenis,$dow){
        $this->db->from('jadwal');
        $this->db->where("id_klinik=$klinik and jnslayan=$jenis and id_hari=$dow");
        $res = $this->db->get();
        return $res->row(); 
    }
    function getdokterbyid($iddokter) {
        $this->db->from('refdokter');
        $this->db->where('id_dokter',$iddokter);
        $qry= $this->db->get();
        return $qry->row();
    }
    function getklinik($iddokter,$jenis) {
        $this->db->select('refklinik.id_klinik, refklinik.nama_klinik');
        $this->db->from('refklinik');
        $this->db->join('jadwal', 'refklinik.id_klinik=jadwal.id_klinik');
        if ($iddokter){
            $this->db->where('id_dokter', $iddokter);
        }
        $this->db->where("(tipe_layanan = 3 or tipe_layanan=$jenis)");
        $this->db->group_by('refklinik.id_klinik');
        $res = $this->db->get();
        return $res->result();
    }  
    function getklinikbyid($idklinik) {
        $this->db->from('refklinik');
        $this->db->where('id_klinik',$idklinik);
        $qry= $this->db->get();
        return $qry->row();
    }
    function getjadwal($klinik,$dokter,$jenis) {
        $this->db->from('jadwal');
        if ($dokter){
        $this->db->where('id_dokter', $dokter);
        }
        $this->db->where('id_klinik', $klinik);
        $this->db->where('jnslayan', $jenis);
        $res = $this->db->get();
        return $res->result_array();
    }
    function getkuotatgl($jadwaltgl,$klinik,$dokter) {
        $this->db->from('treservasi');
        $this->db->where("date(waktu_rsv)='$jadwaltgl'");
        $this->db->where('id_klinik',$klinik);
        if ($dokter){
            $this->db->where('id_dokter',$dokter);
        }
        return  $this->db->count_all_results();
    }
    function getkuotajam($klinik,$dokter,$tglcekin,$jamcekin) {
        $this->db->from('treservasi');
        $this->db->where("id_klinik=$klinik and id_dokter=$dokter and DATE(waktu_rsv)='$tglcekin' and TIME(waktu_rsv)='$jamcekin'");
        return $this->db->count_all_results();
    }
    function getjadwalbyid($idjadwal) {
        $this->db->from('jadwal');
        $this->db->where('id_jadwal', $idjadwal);
        $qry = $this->db->get();
        return $qry->row();
    }
    function getjnspasien($idjenis) {
        $this->db->from('jenis_pasien');
        $this->db->where('jenis_flag',1);
        $this->db->where('jenis_id',$idjenis);
        return $this->db->get()->row();
    }
    function getsebabsakit() {
        $this->db->from('sebab_sakit');
        return $this->db->get()->result_array();
    }
    function getlibur() {
        $this->db->from('tgl_libur');
        return $this->db->get()->result_array();
    }
    function getreserv($idres) {
        $this->db->from('treservasi');
        $this->db->join('tpasien', 'treservasi.norm=tpasien.norm');
        $this->db->where('id_rsv', $idres);
        return $this->db->get()->row();
    }
    function getantrian($idklinik, $tglres) {
        $this->db->select();
    }
    function getresfull($where) {
        return $this->db->get_where('vreservasi', $where)->result();
    }
 }