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
    function getdokter($where) {
        $this->db->select('res_refdokter.id_dokter, res_refdokter.nama_dokter, res_jadwal.klinik_id');
        $this->db->from('res_refdokter');
        $this->db->join('res_jadwal','res_refdokter.id_dokter=res_jadwal.dokter_id');
        $this->db->group_by('res_jadwal.dokter_id');
        $this->db->where("{$where}");
        $qry = $this->db->get();
        return $qry->result();
    } 
    function getdokterbyid($iddokter) {
        $qry= $this->db->get_where('res_refdokter',"id_dokter = $iddokter");
        return $qry->row();
    }
    function getklinik($where) {
        $this->db->select('res_refklinik.id_klinik, res_refklinik.nama_klinik, res_refklinik.kode_poli');
        $this->db->from('res_refklinik');
        $this->db->join('res_jadwal', 'res_refklinik.id_klinik=res_jadwal.klinik_id');
        $this->db->where("{$where}");
        $this->db->group_by('res_refklinik.id_klinik');
        $res = $this->db->get();
        return $res->result();
    }
    function getkuotaklinik($klinik) {
        $this->db->select('kuota');
        return $this->db->get_where("res_refklinik", "id_klinik=$klinik")->row();
    }
    function cekjadawal($klinik=null, $iddokter=null, $jenis=null, $idjadwal=null) {
        $hari_ID = array (1=>'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
        if ($idjadwal){
            $dtjadwal= $this->getjadwalbyid($idjadwal);
        } else {
            $dtjadwal = $this->getjadwal($klinik, $iddokter, $jenis);
        }
        $dtlibur = $this->getlibur();
        for($i=0; $i < count($dtjadwal); $i++){
            $hari = date('l', strtotime("Sunday +{$dtjadwal[$i]['id_hari']} days"));
            $startdate = strtotime($hari);
            $enddate = strtotime("+8 day", $startdate);
            while ($startdate < $enddate) {
                $newdate = date("Y-m-d", $startdate); 
                $tglcek = array_search($newdate, array_column($dtlibur, 'tanggal'));
                $inihari = new DateTime();
                $newdate = new DateTime($newdate);
                if ($tglcek || $tglcek ===0 || ($newdate->diff($inihari)->format("%a") < 2))  {
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
        $this->db->where('status', 1);
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
        return $this->db->get_where('res_kuota', "id_jadwal='".$idjadwal."'")->result();
    }
    function getjamcekin($idjadwal,$tglcekin) {
        $dtjadwal= $this->cekjadawal(null,null,null,$idjadwal);   
        $idklinik=$dtjadwal[0]['idklinik'];
        $iddokter=$dtjadwal[0]['iddokter'];   
        $kuota=$this->getkuotajam($idjadwal);
        foreach ($kuota as $value) {
            $dipakai= $this->getdipakai($idjadwal,$tglcekin,$value->jam);
            $sisa = $value->kuota - $dipakai;
            if ( $sisa>0){
                $kuotaperjam[]=array('idjadwal'=>$idjadwal,'idklinik'=>$idklinik,'iddokter'=>$iddokter,'jam'=>$value->jam,'idjam'=>$value->id_kuota,'kuota'=>$value->kuota,'sisa'=>$sisa);
            }
        }
        return $kuotaperjam;
    }
    function getjadwalbyid($idjadwal) {
        $this->db->where('id_jadwal', $idjadwal);
        $this->db->where('status', 1);
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
    function saveres($datares, $kdpoli) {
        $this->db->insert('res_treservasi', $datares);
        if ($this->db->affected_rows()>0){
            $idres=$this->db->insert_id();
            $nores=$kdpoli.'-'.$idres;
            $this->db->update('res_treservasi', array('nores'=>$nores), "id_rsv = {$idres}");
            if ($datares['jenis_rsv'] !== 'TG'){
                $this->db->update('res_tpasien', array('notelp'=>$datares['identity']), 'norm='.$datares['norm']);
            }
            return $idres;
        } else {
            return false;
        }
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
        $this->db->select("sum(jenis_rsv='TG')as'TG',sum(jenis_rsv='WA')as'WA',sum(jenis_rsv='SMS')as'SMS',sum(jenis_rsv='WEB')as'WEB',DATE_FORMAT(first_update, '%m/%d') as tgl");
        $this->db->group_by('tgl');
        $this->db->order_by('tgl');
        return $this->db->get_where('res_treservasi',$where)->result_array();
    }
 }