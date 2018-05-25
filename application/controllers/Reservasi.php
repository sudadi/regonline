<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservasi extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('mod_reservasi');
    }

    public function index()
    {
        $data['page'] = 'reservasi/step1';
        $data['action'] = site_url('reservasi/step2');
        $data['content']='';
        $this->load->view('reservasi/reservasi', $data);
    }
    private function cekvalpas($norm,$tgllahir) {
        
    }
    public function step2 () {
        if ($this->input->post()) {
            $norm = $this->input->post('norm');
            $tgllahir = $this->input->post('tgllahir');
            $datapas = $this->mod_reservasi->cekdatpas($norm, $tgllahir);
            if ($datapas) {
                $dataresv = $this->mod_reservasi->cekreserv($norm, 0);
                if ($dataresv) {
                    $this->session->set_flashdata('error', 'Pasien sudah melakukan reservasi sebelumnya');
                    $reserv = false;
                } else {
                    $this->session->set_flashdata('success', 'Data valid');
                    $reserv = true;
                }
            } else {
                $this->session->set_flashdata('error', 'Data pasien tidak ditemukan');
                $reserv = false;
            }
            if ($reserv) {
                //$this->mod_reservasi->

                $data['page'] = 'reservasi/step2';
                $data['action'] = site_url('reservasi/step3');
                $data['content']['norm']=$norm;
                $data['content']['tgllahir']=$tgllahir;
                $data['content']['namapas']=$datapas->nama;
                $this->load->view('reservasi/reservasi', $data);
            } else {
                redirect('reservasi');
            }
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
        for($i=0; $i < count($dtjadwal); $i++){
            $hari = date('l', strtotime("Sunday +{$dtjadwal[$i]['id_hari']} days"));
            $startdate = strtotime("+1 days", strtotime($hari));
            $enddate = strtotime("+2 weeks", $startdate);
            $perjam=$dtjadwal[$i]['kuota_perjam'];
            $starttime = $dtjadwal[$i]['jam_mulai'];
            $endtime = $dtjadwal[$i]['jam_selesai'];
            $perhari = ($endtime - $starttime) * $perjam;
            while ($startdate < $enddate) {
                $jadwal[]=array('jadwaltgl'=>date("Y-m-d", $startdate), 'hari'=>$hari, 'perhari'=>$perhari, 
                    'iddokter'=>$dtjadwal[$i]['id_dokter'], 'idjadwal'=>$dtjadwal[$i]['id_jadwal'],
                    'terpakai'=>$this->mod_reservasi->getkuotatgl(date("Y/m/d", $startdate), $klinik, $iddokter));
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
            $datapas = $this->mod_reservasi->cekdatpas($norm, $tgllahir);
            if ($datapas) {
                $dataresv = $this->mod_reservasi->cekreserv($norm, 0);
                if ($dataresv) {
                    $this->session->set_flashdata('error', 'Pasien sudah melakukan reservasi sebelumnya');
                    $reserv = false;
                } else {
                    $this->session->set_flashdata('success', 'Data valid');
                    $reserv = true;
                }
            } else {
                $this->session->set_flashdata('error', 'Data pasien tidak ditemukan');
                $reserv = false;
            }
            if ($reserv) {
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
                $data['content']['norm']= $datapas->norm;
                $data['content']['namapas']=$datapas->nama;
                $data['content']['tgllahir']=$datapas->tgl_lahir;
                $data['content']['alamat']=$datapas->alamat;
                $data['page'] = 'reservasi/step3';
                $data['action'] = site_url('reservasi/reserved');
                $this->load->view('reservasi/reservasi', $data);
            }else {
                redirect('reservasi');
            }
        } else {
            redirect('reservasi');
        }
    }
}
