<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservasi extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('mod_reservasi');
    }

    public function index()
    {
        if ($this->input->post()) {
            $norm = $this->input->post('norm');
            $tgllahir = $this->input->post('tgllahir');
            $this->cekvalpas($norm,$tgllahir);
            if ($this->session->userdata('status')=='0'){
                redirect('reservasi/step2');
            }else if ($this->session->userdata('status')=='1'){
                
            }
        }
        $this->session->sess_destroy();
        $data['page'] = 'reservasi/step1';
        $data['action'] = site_url('reservasi');
        $data['content']='';
        $this->load->view('reservasi/main', $data);
    }
    private function cekvalpas($norm,$tgllahir) {
        $datapas = $this->mod_reservasi->cekdatpas("norm='{$norm}' and tgl_lahir='{$tgllahir}'");
        if ($datapas) {
            $this->session->set_userdata('norm', $norm);
            $this->session->set_userdata('tgllahir', $tgllahir);
            $this->session->set_userdata('namapas', $datapas->nama);
            $this->session->set_userdata('alamat', $datapas->alamat);
            $this->session->set_userdata('notelp', $datapas->notelp);
            $dataresv = $this->mod_reservasi->cekreserv($norm, '1');
            if ($dataresv) {
                $this->session->set_flashdata('error', 'Pasien sudah melakukan reservasi sebelumnya');
                $this->session->set_userdata('status', '1');
                $dataklinik=$this->mod_reservasi->getklinikbyid($dataresv->id_klinik);
                $this->session->set_userdata('nmklinik',$dataklinik->nama_klinik);
                redirect ('reservasi/finish/'.$dataresv->id_rsv);
            } else {
                $this->session->set_flashdata('success', 'Data valid');
                $this->session->set_userdata('status', '0');
            }
        } else {
            $this->session->set_flashdata('error', 'Data pasien tidak ditemukan');
            //$this->session->set_userdata('status', '0');
        }
    }
    public function step2 () {
        if ($this->session->userdata('status')=='0') {
            //$this->mod_reservasi->
            $data['page'] = 'reservasi/step2';
            $data['action'] = site_url('reservasi/step3');
            $data['content']['norm']=$this->session->userdata('norm');
            $data['content']['tgllahir']=$this->session->userdata('tgllahir');
            $data['content']['namapas']=$this->session->userdata('namapas');
            $this->load->view('reservasi/main', $data);
        } else {
            redirect('reservasi');
        }
    }

    public function ajax_getdokter($jenis) {
        $data = $this->mod_reservasi->getdokter($jenis);
        echo json_encode($data);
    }
    public function ajax_dokterbytgl($klinik,$jenis,$dow) {
        $data = $this->mod_reservasi->getdokterbytgl($klinik,$jenis,$dow);
        echo json_encode($data); 
    }    
    public function ajax_klinik($iddokter, $jenis) {
        $data = $this->mod_reservasi->getklinik($iddokter, $jenis);
        echo json_encode($data); 
    }
    private function cekjadawal($klinik=null, $iddokter=null, $jenis=null, $idjadwal=null) {
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
                    $jadwal[]=array('jadwaltgl'=>date("Y-m-d", $startdate), 'hari'=>date("l", $startdate), 
                    'iddokter'=>$dtjadwal[$i]['dokter_id'],'idklinik'=>$dtjadwal[$i]['klinik_id'],'idjadwal'=>$dtjadwal[$i]['id_jadwal']);
                }
                $startdate = strtotime("+1 week", $startdate);
            }            
        }  
        sort($jadwal);
        return $jadwal;
    }
    public function ajax_jadwal($klinik, $iddokter, $jenis) {
        if ($jadwal= $this->cekjadawal($klinik, $iddokter, $jenis)){
            echo json_encode($jadwal);
        }
//    public function ajax_jadwal($klinik, $iddokter, $jenis) {
//        $perjam= $this->mod_reservasi->getkuotaklinik($klinik)->kuota;
//        //echo $perjam;
//        $dtjadwal = $this->mod_reservasi->getjadwal($klinik, $iddokter, $jenis);
//        $dtlibur = $this->mod_reservasi->getlibur();
//        for($i=0; $i < count($dtjadwal); $i++){
//            $hari = date('l', strtotime("Sunday +{$dtjadwal[$i]['id_hari']} days"));
//            $startdate = strtotime($hari);
//            $enddate = strtotime("+2 weeks", $startdate);
//            //$perjam=$dtjadwal[$i]['kuota_perjam'];
//            $starttime = $dtjadwal[$i]['jam_mulai'];
//            $endtime = $dtjadwal[$i]['jam_selesai'];
//            $perhari = floor((strtotime($endtime) - strtotime($starttime))/(60*60)) * $perjam;
//            while ($startdate < $enddate) {
//                $newdate = date("Y-m-d", $startdate); 
//                $tglcek = array_search($newdate, array_column($dtlibur, 'tanggal'));
//                if ($tglcek || $tglcek ===0 || (date('Y-m-d', $startdate) == date('Y-m-d'))) {
//                      //nothing  or skip        
//                } else {
//                    $jadwal[]=array('jadwaltgl'=>date("Y-m-d", $startdate), 'hari'=>date("l", $startdate), 'perhari'=>$perhari, 
//                    'iddokter'=>$dtjadwal[$i]['dokter_id'], 'idjadwal'=>$dtjadwal[$i]['id_jadwal'],
//                    'terpakai'=>$this->mod_reservasi->getkuotatgl(date("Y/m/d", $startdate), $klinik, $iddokter));
//                }
//                $startdate = strtotime("+1 week", $startdate);
//            }            
//        }  
//        sort($jadwal);
//        for ($i=0; $i<count($jadwal); $i++){             
//            $jadwal[$i]['sisa'] = $jadwal[$i]['perhari'] - $jadwal[$i]['terpakai'];
//        }
//        echo json_encode($jadwal);
//        $int='+2 week';
//        $startDate = date('Y/m/d');
//        echo date('l Y/m/d',strtotime($startDate));
//        $endDate = strtotime($int, strtotime($startDate));
//        echo '<br>'.date('l Y/m/d',$endDate);
//        for($i = strtotime('Monday', strtotime($startDate)); $i <= $endDate; $i = strtotime('+1 week', $i))
//        echo date('l Y-m-d', $i);
    }
    public function ajax_jamcekin($idjadwal,$tglcekin) {
        $dtjadwal= $this->cekjadawal(null,null,null,$idjadwal);   
        $idklinik=$dtjadwal[0]['idklinik'];
        $iddokter=$dtjadwal[0]['iddokter'];   
        $kuota=$this->mod_reservasi->getkuotajam($idjadwal);
        foreach ($kuota as $value) {
            $dipakai= $this->mod_reservasi->getdipakai($idjadwal,$tglcekin,$value->jam);
            $sisa = $value->kuota - $dipakai;
            if ( $sisa>0){
                $kuotaperjam[]=array('idjadwal'=>$idjadwal,'idklinik'=>$idklinik,'iddokter'=>$iddokter,'jam'=>$value->jam,'kuota'=>$value->kuota,'sisa'=>$sisa);
            }
        }
         echo json_encode($kuotaperjam);
    }
//    public function ajax_jamcekin($idjadwal,$tglcekin) {
//        $dtjadwal= $this->mod_reservasi->getjadwalbyid($idjadwal);
//        $klinik=$dtjadwal->klinik_id;
//        $dokter=$dtjadwal->dokter_id;
//        $perjam= $this->mod_reservasi->getkuotaklinik($klinik)->kuota;
//        $starttime= strtotime($dtjadwal->jam_mulai);
//        $endtime=strtotime($dtjadwal->jam_selesai);
//        $kuotaperjam=[];
//        while ($starttime <= $endtime) {
//            $jamcekin=date('H:i:s', $starttime);
//            $dipakai= $this->mod_reservasi->getkuotajam($klinik,$dokter,$tglcekin,$jamcekin);
//            if ($perjam-$dipakai >0) {
//                $kuotaperjam[]=array('jam'=>$jamcekin, 'kouta'=>$perjam, 'sisa'=>$perjam-$dipakai);
//            }
//            $starttime = strtotime("+1 hours", $starttime);
//        }
//         echo json_encode($kuotaperjam);
//    }
    public function step3() {
        if ($this->input->post()){   
            $norm = $this->input->post('norm');
            $tgllahir = $this->input->post('tgllahir');
            $this->cekvalpas($norm, $tgllahir);
            if ($this->session->userdata('status')=='0') {
                $jnsjaminan= $this->mod_reservasi->getjnspasien($this->input->post('jnsjaminan'));
                $dokter= $this->mod_reservasi->getdokterbyid($this->input->post('dokter'));
                $klinik= $this->mod_reservasi->getklinikbyid($this->input->post('poliklinik'));
                $datatgl= explode("|",$this->input->post('tglcekin'));
                $data['content']['idjadwal']= $datatgl[0];
                $data['content']['tglcekin']= $datatgl[1];
                $data['content']['jamcekin']= $this->input->post('jamcekin');
                $data['content']['iddokter']= $this->input->post('dokter');
                $data['content']['nmdokter']= $dokter->nama_dokter;
                $data['content']['idklinik']= $this->input->post('poliklinik');
                $data['content']['nmklinik']= $klinik->nama_klinik;
                $data['content']['idjaminan']= $this->input->post('jnsjaminan');
                $data['content']['jnsjaminan']= $jnsjaminan->nama_jaminan;
                $data['content']['jnslayan']= $this->input->post('jnslayan');
                if($this->input->post('jnslayan')==1) {
                    $data['content']['layanan']= "Reguler";
                } else {
                    $data['content']['layanan']= "Eksekutif";
                }
                $data['content']['waktureserv']= date('Y/m/d H:i:s', strtotime($datatgl[1].' '.$this->input->post('jamcekin')));
                $data['content']['norm']= $this->session->userdata('norm');
                $data['content']['namapas']=$this->session->userdata('namapas');
                $data['content']['tgllahir']=$this->session->userdata('tgllahir');
                $data['content']['alamat']=$this->session->userdata('alamat');
                $data['content']['notelp']=$this->session->userdata('notelp');
                $data['page'] = 'reservasi/step3';
                $data['action'] = site_url('reservasi/simpan');
                $this->load->view('reservasi/main', $data);
            }else {
                redirect('reservasi');
            }
        } else {
            redirect('reservasi');
        }
    }
    public function simpan() {
        if ($this->input->post() && $this->session->userdata('status')=='0'){
            $waktursv=date('Y/m/d H:i:s', strtotime($this->input->post('tglcekin').$this->input->post('jamcekin')));
            $idklinik=$this->input->post('idklinik');
            $nmklinik=$this->input->post('nmklinik');
            $dataklinik= $this->mod_reservasi->getklinikbyid($idklinik);
            $kodeklinik=$dataklinik->kode_poli;
            $norm= $this->input->post('norm');
            $datares= array('norm'=>$norm,
                'waktu_rsv'=>$waktursv,'jadwal_id'=>$this->input->post('idjadwal'),
                'jns_jaminan_id'=>$this->input->post('idjaminan'),
                'sebab_id'=>$this->input->post('sebab'),
                'status'=>1, 'user_id'=>2, 'jenis_rsv'=>'WEB');
            $this->db->insert('res_treservasi', $datares);
            if ($this->db->affected_rows()>0){
                $idres=$this->db->insert_id();
                $nores=$kodeklinik.'-'.$idres;
                $this->db->update('res_treservasi', array('nores'=>$nores), "id_rsv = {$idres}");
                $this->db->update('res_tpasien', array('notelp'=>$this->input->post('notelp')), 'norm='.$norm);
                $this->session->set_userdata('nmklinik',$nmklinik);
                $this->load->model('mod_sms');
                $this->mod_sms->sendkonfirm($idres);
                $this->session->set_userdata('status', '1');
                $this->session->set_flashdata('success', 'Reservasi berhasil, data sudah tersimpan');
                redirect('reservasi/finish/'.$idres);
            } else {
                $this->session->set_flashdata('error', 'Data tidak dapat di simpan');
            }                
            redirect('reservasi');
        }
    }
    public function finish($idres) {
        if ($this->session->userdata('status')=='1'){
            $datares= $this->mod_reservasi->getreserv($idres);
            $data['page'] = 'reservasi/finish';
            $data['action'] = site_url('reservasi');
            $data['content']['norm']= $this->session->userdata('norm');
            $data['content']['namapas']=$this->session->userdata('namapas');
            $data['content']['nmklinik']=$this->session->userdata('nmklinik');
            $data['content']['nores']=$datares->nores;
            $data['content']['waktures']=$datares->waktu_rsv;
            $this->load->view('reservasi/main', $data);
        } else {
            redirect('reservasi');
        }
    }
    public function info() {
        $data['page'] = 'reservasi/informasi';
        $data['action'] = site_url('reservasi');
        $data['content']='';
        $this->load->view('reservasi/main', $data);
    }
    public function help() {
        $data['page'] = 'reservasi/help';
        $data['action'] = site_url('reservasi');
        $data['content']='';
        $this->load->view('reservasi/main', $data);
    }
    public function ketentuan() {
        $data['page'] = 'reservasi/ketentuan';
        $data['action'] = site_url('reservasi');
        $data['content']='';
        $this->load->view('reservasi/main', $data);
    }
    
}

