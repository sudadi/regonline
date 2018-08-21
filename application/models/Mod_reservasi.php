<?php defined('BASEPATH') OR exit('No direct script access allowed');
 class Mod_reservasi extends CI_Model {
     function __construct() {
         parent:: __construct();
    }
    function cekdatpas($where){
        return $this->db->get_where('res_tpasien', $where)->row();
    }	
    function cekreserv($norm, $status){
        $this->db->join('res_jadwal', 'res_treservasi.jadwal_id=res_jadwal.id_jadwal');
        $this->db->join('res_refklinik', 'res_refklinik.id_klinik=res_jadwal.klinik_id');
        $qry = $this->db->get_where("res_treservasi", "res_treservasi.norm ={$norm} and res_treservasi.status={$status}");
        if ($qry->num_rows() > 0) return $qry->row(); 
    }	
    function getdokter($jenis) {
        $this->db->select('res_refdokter.id_dokter, res_refdokter.nama_dokter');
        $this->db->from('res_refdokter');
        $this->db->join('res_jadwal','res_refdokter.id_dokter=res_jadwal.dokter_id');
        $this->db->group_by('res_jadwal.dokter_id');
        $this->db->where('jns_layan_id', $jenis);
        $qry = $this->db->get();
        return $qry->result();
    }    
    function getdokterbytgl($klinik,$jenis,$dow){
        $res = $this->db->get_where('res_jadwal',"klinik_id=$klinik and jns_layan_id=$jenis and id_hari=$dow");
        return $res->row(); 
    }
    function getdokterbyid($iddokter) {
        $qry= $this->db->get_where('res_refdokter',"id_dokter = $iddokter");
        return $qry->row();
    }
    function getklinik($iddokter,$jenis) {
        $this->db->select('res_refklinik.id_klinik, res_refklinik.nama_klinik');
        $this->db->from('res_refklinik');
        $this->db->join('res_jadwal', 'res_refklinik.id_klinik=res_jadwal.klinik_id');
        if ($iddokter){
            $this->db->where('dokter_id', $iddokter);
        }
        $this->db->where("(jns_layan_id =$jenis)");
        $this->db->group_by('res_refklinik.id_klinik');
        $res = $this->db->get();
        return $res->result();
    }  
    function getklinikbyid($idklinik) {
        $this->db->where('id_klinik',$idklinik);
        return $this->db->get('res_refklinik')->row();
    }
    function getkuotaklinik($klinik) {
        $this->db->select('kuota');
        return $this->db->get_where("res_refklinik", "id_klinik=$klinik")->row();
    }
    function cekjadawal($klinik=null, $iddokter=null, $jenis=null, $idjadwal=null) {
        $hari_ID = array (1=>'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
        if ($idjadwal){
            $dtjadwal= $this->mod_reservasi->getjadwalbyid($idjadwal);
        } else {
            $dtjadwal = $this->mod_reservasi->getjadwal($klinik, $iddokter, $jenis);
        }
        $dtlibur = $this->mod_reservasi->getlibur();
        for($i=0; $i < count($dtjadwal); $i++){
            $hari = date('l', strtotime("Sunday +{$dtjadwal[$i]['id_hari']} days"));
            $startdate = strtotime($hari);
            $enddate = strtotime("+2 weeks", $startdate);
            while ($startdate < $enddate) {
                $newdate = date("Y-m-d", $startdate); 
                $tglcek = array_search($newdate, array_column($dtlibur, 'tanggal'));
                if ($tglcek || $tglcek ===0 || (date('Y-m-d', $startdate) == date('Y-m-d'))) {
                      //nothing  or skip        
                } else {
                    $jadwal[]=array('jadwaltgl'=>date("Y-m-d", $startdate), 'hari'=>$hari_ID[date("N", $startdate)], 
                    'iddokter'=>$dtjadwal[$i]['dokter_id'],'idklinik'=>$dtjadwal[$i]['klinik_id'],'idjadwal'=>$dtjadwal[$i]['id_jadwal']);
                }
                $startdate = strtotime("+1 week", $startdate);
            }            
        }  
        sort($jadwal);
        return $jadwal;
    }
    function getjadwal($klinik,$dokter,$jenis) {
        if ($dokter){
        $this->db->where('dokter_id', $dokter);
        }
        $this->db->where('klinik_id', $klinik);
        $this->db->where('jns_layan_id', $jenis);
        return $this->db->get('res_jadwal')->result_array();
    }
    function getkuotatgl($jadwaltgl,$klinik,$dokter) {
        $this->db->from('vreservasi');
        $this->db->where("date(waktu_rsv)='$jadwaltgl'");
        $this->db->where('id_klinik',$klinik);
        if ($dokter){
            $this->db->where('id_dokter',$dokter);
        }
        return  $this->db->count_all_results();
    }
    function getdipakai($idjadwal,$tglcekin,$jamcekin) {
        $this->db->from('vreservasi');
        $this->db->where("id_jadwal='$idjadwal' and DATE(waktu_rsv)='$tglcekin' and TIME(waktu_rsv)='$jamcekin'");
        return $this->db->count_all_results();
    }
    function getkuotajam($idjadwal) {
        return $this->db->get_where('res_kuota', 'id_jadwal='.$idjadwal)->result();
    }
    function getjadwalbyid($idjadwal) {
        $this->db->where('id_jadwal', $idjadwal);
        return $this->db->get('res_jadwal')->result_array();
    }
    function getjnspasien($idjenis) {
        return $this->db->get_where("res_jns_jaminan", "flag_jaminan = 1 and id_jaminan = '$idjenis'")->row();
    }
    function getsebabsakit() {
        return $this->db->get('res_sebab_sakit')->result_array();
    }
    function getlibur() {
        return $this->db->get('res_tgl_libur')->result_array();
    }
    function getreserv($idres) {
        $this->db->where('id_rsv', $idres);
        return $this->db->get('vreservasi')->row();
    }
    function getantrian($idklinik, $tglres) {
        $this->db->select();
    }
    function getresfull($where) {
        return $this->db->get_where('vreservasi', $where)->result();
    }
    function getdatares($where,$group=null){
        if($group){
            $this->db->group_by($group);
        }
        return $this->db->get_where('res_treservasi', $where)->result();
    }
    function getgraphres($where) {
        $this->db->select("sum(jenis_rsv='WA')as'WA',sum(jenis_rsv='SMS')as'SMS',sum(jenis_rsv='WEB')as'WEB',DATE_FORMAT(first_update, '%m/%d') as tgl");
        $this->db->group_by('tgl');
        $this->db->order_by('tgl');
        return $this->db->get_where('res_treservasi',$where)->result_array();
    }
 }