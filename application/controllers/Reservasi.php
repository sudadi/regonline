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

    private function val_step1 ($norm, $tgllahir) {	
        $datpas = $this->mod_reservasi->cekdatpas($norm, $tgllahir);
        if ($datpas) {
            $datresv = $this->mod_reservasi->cekreserv($norm, 0);
            if ($datresv) {
                $this->session->set_flashdata('error', 'Pasien sudah melakukan reservasi sebelumnya');
                return false;
            } else {
                $this->session->set_flashdata('success', 'Data valid');
                return true;
            }
        } else {
            $this->session->set_flashdata('error', 'Data pasien tidak ditemukan');
            return false;
        }
    }


    public function step2 () {
        if ($this->input->post()) {
            $norm = $this->input->post('norm');
            $tgllahir = $this->input->post('tgllahir');
            if ($this->val_step1($norm, $tgllahir)) {
                //$this->mod_reservasi->

                $data['page'] = 'reservasi/step2';
                $data['action'] = site_url('reservasi/step3');
                $data['content']='';
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
    
    public function ajax_klinik($iddokter, $jenis) {
        $data = $this->mod_reservasi->getklinik($iddokter, $jenis);
        echo json_encode($data); 
    }
}
