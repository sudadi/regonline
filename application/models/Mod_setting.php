<?php defined('BASEPATH') OR exit('No direct script access allowed');
 class Mod_setting extends CI_Model {
     function __construct() {
         parent:: __construct();
    }
    function getdokter($number=0,$offset=0,$where=null) {
        return $this->db->get_where('res_refdokter',$where,$number,$offset)->result();
    }
    function getklinik($number=0,$offset=0,$where=null) {
        return $this->db->get_where('res_refklinik',$where,$number,$offset)->result();
    }
    function getjnslayan() {
        return $this->db->get('res_refjns_layan')->result();
    }
    function getjadwal($idjadwal) {
        $this->db->where('id_jadwal',$idjadwal);
        return $this->db->get('res_jadwal')->row();
    }
    function getjadwalfull($number=0,$offset=0) {
        $this->db->select('res_refdokter.nama_dokter,res_refklinik.nama_klinik,res_refjns_layan.jns_layan,res_jadwal.id_jadwal,'
                . 'res_jadwal.id_hari,res_jadwal.jam_mulai,res_jadwal.jam_selesai,res_jadwal.kuota_perjam,res_jadwal.status');
        $this->db->join('res_refdokter', 'res_refdokter.id_dokter=res_jadwal.dokter_id');
        $this->db->join('res_refklinik', 'res_refklinik.id_klinik=res_jadwal.klinik_id');
        $this->db->join('res_refjns_layan', 'res_refjns_layan.id_jns_layan=res_jadwal.jns_layan_id');
        $this->db->order_by('res_jadwal.id_jadwal');

        return $this->db->get('res_jadwal',$number, $offset)->result();
    }
    function getjmljadwal() {
        return $this->db->get('res_jadwal')->num_rows();
    }
    function getdatalibur($number,$offset) {
        return $this->db->get('res_tgl_libur',$number,$offset)->result();
    }
    function getnumlibur() {
       return $this->db->get('res_tgl_libur')->num_rows(); 
    }
    function getmodemrt($where=null) {
        return $this->db->get_where('sms_routing', $where)->result();
    }
    function getkonfirm() {
        return $this->db->get_where('sms_konfirm', 'id=1')->row();
    }
    function savekuota($idjadwal, $jammulai, $jamselesai, $kuota) {
        $this->db->delete('res_kuota', "id_jadwal={$idjadwal}");
        $jammulai = strtotime($jammulai);
        $jamselesai = strtotime($jamselesai);
        while ($jammulai <= $jamselesai) {
            $this->db->insert('res_kuota', ['id_jadwal'=>$idjadwal, 'jam'=>date('H:i:s',$jammulai), 'kuota'=>$kuota]);
            $jammulai = strtotime('+1 hours', $jammulai);
        }
        return TRUE;
    }
    function getinfo($where) {
        $this->db->order_by('start', 'desc');
        return $this->db->get_where('res_tinfo', $where)->result();
    }
    function saveinfo($data) {
        return $this->db->insert('res_tinfo', $data);
    }
    function updateinfo($data, $idinfo) {
        return $this->db->update('res_tinfo', $data, "id_info='".$idinfo."'");
    }
 }