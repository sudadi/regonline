<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Informasi extends CI_Controller {
    function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $data['page'] = 'reservasi/info';
        $data['action'] = site_url('reservasi/info');
        $data['content']='';
        $this->load->view('reservasi/reservasi', $data);
    }
}