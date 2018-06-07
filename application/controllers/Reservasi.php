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
        $data['page'] = 'reservasi/step1';
        $data['action'] = site_url('reservasi');
        $data['content']='';
        $this->load->view('reservasi/reservasi', $data);
    }
    private function cekvalpas($norm,$tgllahir) {
        $datapas = $this->mod_reservasi->cekdatpas($norm, $tgllahir);
        if ($datapas) {
            $this->session->set_userdata('norm', $norm);
            $this->session->set_userdata('tgllahir', $tgllahir);
            $this->session->set_userdata('namapas', $datapas->nama);
            $this->session->set_userdata('alamat', $datapas->alamat);
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
            $this->load->view('reservasi/reservasi', $data);
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
    public function ajax_jadwal($klinik, $iddokter, $jenis) {
        $dtjadwal = $this->mod_reservasi->getjadwal($klinik, $iddokter, $jenis);
        $dtlibur = $this->mod_reservasi->getlibur();
        for($i=0; $i < count($dtjadwal); $i++){
            $hari = date('l', strtotime("Sunday +{$dtjadwal[$i]['id_hari']} days"));
            $startdate = strtotime($hari);
            $enddate = strtotime("+2 weeks", $startdate);
            $perjam=$dtjadwal[$i]['kuota_perjam'];
            $starttime = $dtjadwal[$i]['jam_mulai'];
            $endtime = $dtjadwal[$i]['jam_selesai'];
            $perhari = floor((strtotime($endtime) - strtotime($starttime))/(60*60)) * $perjam;
            while ($startdate < $enddate) {
                $newdate = date("Y-m-d", $startdate); 
                $tglcek = array_search($newdate, array_column($dtlibur, 'tanggal'));
                if ($tglcek || $tglcek ===0 || (date('Y-m-d', $startdate) == date('Y-m-d'))) {
                      //nothing          
                } else {
                    $jadwal[]=array('jadwaltgl'=>date("Y-m-d", $startdate), 'hari'=>date("l", $startdate), 'perhari'=>$perhari, 
                    'iddokter'=>$dtjadwal[$i]['id_dokter'], 'idjadwal'=>$dtjadwal[$i]['id_jadwal'],
                    'terpakai'=>$this->mod_reservasi->getkuotatgl(date("Y/m/d", $startdate), $klinik, $iddokter));
                }
                $startdate = strtotime("+1 week", $startdate);
            }            
        }  
        sort($jadwal);
        for ($i=0; $i<count($jadwal); $i++){             
            $jadwal[$i]['sisa'] = $jadwal[$i]['perhari'] - $jadwal[$i]['terpakai'];
        }
        echo json_encode($jadwal);
//        $int='+2 week';
//        $startDate = date('Y/m/d');
//        echo date('l Y/m/d',strtotime($startDate));
//        $endDate = strtotime($int, strtotime($startDate));
//        echo '<br>'.date('l Y/m/d',$endDate);
//        for($i = strtotime('Monday', strtotime($startDate)); $i <= $endDate; $i = strtotime('+1 week', $i))
//        echo date('l Y-m-d', $i);
    }
    public function ajax_jamcekin($idjadwal,$tglcekin) {
        $dtjadwal= $this->mod_reservasi->getjadwalbyid($idjadwal);
        //var_dump($dtjadwal);
        $klinik=$dtjadwal->id_klinik;
        $dokter=$dtjadwal->id_dokter;
        $perjam=$dtjadwal->kuota_perjam;
        $starttime= strtotime($dtjadwal->jam_mulai);
        $endtime=strtotime($dtjadwal->jam_selesai);
        $kuotaperjam='';
        while ($starttime <= $endtime) {
            $jamcekin=date('H:i:s', $starttime);
            $dipakai= $this->mod_reservasi->getkuotajam($klinik,$dokter,$tglcekin,$jamcekin);
            if ($perjam-$dipakai >0) {
                $kuotaperjam[]=array('jam'=>$jamcekin, 'kouta'=>$perjam, 'sisa'=>$perjam-$dipakai);
            }
            $starttime = strtotime("+1 hours", $starttime);
        }
         echo json_encode($kuotaperjam);
    }
    public function step3() {
        if ($this->input->post()){   
            $norm = $this->input->post('norm');
            $tgllahir = $this->input->post('tgllahir');
            $this->cekvalpas($norm, $tgllahir);
            if ($this->session->userdata('status')=='0') {
                $jenispas= $this->mod_reservasi->getjnspasien($this->input->post('jnspasien'));
                $dokter= $this->mod_reservasi->getdokterbyid($this->input->post('dokter'));
                $klinik= $this->mod_reservasi->getklinikbyid($this->input->post('poliklinik'));
                $datatgl= explode("|",$this->input->post('tglcekin'));
                $data['content']['idjadwal']= $datatgl[0];
                $data['content']['tglcekin']= $datatgl[2];
                $data['content']['jamcekin']= $this->input->post('jamcekin');
                $data['content']['iddokter']= $this->input->post('dokter');
                $data['content']['nmdokter']= $dokter->nama_dokter;
                $data['content']['idklinik']= $this->input->post('poliklinik');
                $data['content']['nmklinik']= $klinik->nama_klinik;
                $data['content']['jnspasien']= $this->input->post('jnspasien');
                $data['content']['jenispas']= $jenispas->jenis_nama;
                $data['content']['jnslayan']= $this->input->post('jnslayan');
                if($this->input->post('jnslayan')==1) {
                    $data['content']['layanan']= "Reguler";
                } else {
                    $data['content']['layanan']= "Eksekutif";
                }
                $data['content']['waktureserv']= date('Y/m/d H:i:s', strtotime($datatgl[2].' '.$this->input->post('jamcekin')));
                $data['content']['norm']= $this->session->userdata('norm');
                $data['content']['namapas']=$this->session->userdata('namapas');
                $data['content']['tgllahir']=$this->session->userdata('tgllahir');
                $data['content']['alamat']=$this->session->userdata('alamat');
                $data['page'] = 'reservasi/step3';
                $data['action'] = site_url('reservasi/simpan');
                $this->load->view('reservasi/reservasi', $data);
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
            $datares= array('norm'=>$this->input->post('norm'),
                'notelp'=>$this->input->post('notelp'),
                'waktu_rsv'=>$waktursv,'id_jadwal'=>$this->input->post('idjadwal'),
                'id_klinik'=>$idklinik,
                'id_dokter'=>$this->input->post('iddokter'),
                'cara_bayar'=>$this->input->post('jnspasien'),
                'sebab'=>$this->input->post('sebab'),
                'status'=>1, 'user_id'=>2);
            $this->db->insert('treservasi', $datares);
            if ($this->db->affected_rows()>0){
                $this->session->set_userdata('status', '1');
                $this->session->set_flashdata('success', 'Data sudah tersimpan');
                $idres=$this->db->insert_id();
                $nores=$kodeklinik.'-'.$idres;
                $this->db->update('treservasi', array('nores'=>$nores), "id_rsv = {$idres}");
                $this->session->set_userdata('nmklinik',$nmklinik);
                redirect('reservasi/finish/'.$idres);
            } else {
                $this->session->set_flashdata('error', 'Data tidak dapat di simpan');
            }                
            redirect('usulan');
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
            $this->load->view('reservasi/reservasi', $data);
        }
    }
    
}

