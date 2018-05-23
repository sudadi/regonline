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
                $data['content']['namapas']=$datapas->nama;
                $this->load->view('reservasi/reservasi', $data);
            } else {
                redirect('reservasi');
            }
        }
    }

    public function ajax_getdokter() {
        $data = $this->mod_reservasi->getdokter();
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
            $startdate = strtotime($hari);
            $enddate = strtotime("+2 weeks", $startdate);
            $perjam=$dtjadwal[$i]['kuota_perjam'];
            $starttime = $dtjadwal[$i]['jam_mulai'];
            $endtime = $dtjadwal[$i]['jam_selesai'];
            $perhari = ($endtime - $starttime) * $perjam;
            while ($startdate < $enddate) {
                $jadwal[]=array('jadwaltgl'=>date("Y/m/d", $startdate), 'hari'=>$hari, 'perhari'=>$perhari, 'iddokter'=>$dtjadwal[$i]['id_dokter']);
                $startdate = strtotime("+1 week", $startdate);
            }            
        }  
        sort($jadwal);
        for ($i=0; $i<count($jadwal); $i++){
            $jadwal[$i]['terpakai'] = $this->mod_reservasi->getkuotatgl($jadwal[$i]['jadwaltgl']);
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
}
