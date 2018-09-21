<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservasi extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('mod_reservasi');
    }
    public function index() {
        $this->session->sess_destroy();
        $this->load->model('mod_setting');
        $datainfo= $this->mod_setting->getinfo("status=1 and start <='".date('Y-m-d')."'");
        $data['page'] = 'reservasi/informasi';
        $data['contenthead'] = false;
        $data['linkbc'] = '';
        $data['action'] = site_url('reservasi/index');
        $data['content']['datainfo']=$datainfo;
        $this->load->view('reservasi/main', $data);
    }

    public function respas()
    {
        if ($this->input->post()) {
            $norm = $this->input->post('norm');
            $tgllahir = $this->input->post('tgllahir');
            $this->cekvalpas($norm,$tgllahir);
            if ($this->session->userdata('status')=='1'){
                redirect('reservasi/step2');
            }
        }
        $this->session->sess_destroy();
        $data['page'] = 'reservasi/step1';
        $data['contenthead'] = true;
        $data['linkbc'] = 'reservasi';
        $data['action'] = site_url('reservasi/respas');
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
            $dataresv = $this->mod_reservasi->getreserv("norm=$norm and status='1'"); //cek data reservasi yg aktif
            if ($dataresv) {
                $this->session->set_flashdata('error', 'Pasien sudah melakukan reservasi sebelumnya');
                $this->session->set_userdata('status', '3');
                $dataklinik=$this->mod_reservasi->getklinik("id_klinik={$dataresv->id_klinik}");
                $this->session->set_userdata('nmklinik',$dataklinik[0]->nama_klinik);
                redirect ('reservasi/finish/'.$dataresv->id_rsv);
            } else {
                $this->session->set_flashdata('success', 'Data valid');
                $this->session->set_userdata('status', '1');
            }
        } else {
            $this->session->set_flashdata('error', 'Data pasien tidak ditemukan');
            redirect('reservasi');
        }
    }
    public function step2 () {
        if ($this->session->userdata('status')=='1' || $this->session->userdata('status')=='2') {
            if ($this->input->post() && $this->session->userdata('status')=='1'){
                $jnsjaminan= $this->mod_reservasi->getjnspasien($this->input->post('jnsjaminan'));
                $dokter= $this->mod_reservasi->getdokterbyid($this->input->post('dokter'));
                $klinik= $this->mod_reservasi->getklinik("id_klinik={$this->input->post('poliklinik')}");
                $datatgl= explode("|",$this->input->post('tglcekin'));
                $this->session->set_userdata('idjadwal', $datatgl[0]);
                $this->session->set_userdata('tglcekin', $datatgl[1]);
                $this->session->set_userdata('waktursv', date('Y/m/d H:i:s', strtotime($datatgl[1].' '.$this->input->post('jamcekin'))));
                $this->session->set_userdata('jamcekin', $this->input->post('jamcekin'));
                $this->session->set_userdata('iddokter', $dokter->id_dokter);
                $this->session->set_userdata('nmdokter', $dokter->nama_dokter);
                $this->session->set_userdata('idklinik', $klinik[0]->id_klinik);
                $this->session->set_userdata('nmklinik', $klinik[0]->nama_klinik);
                $this->session->set_userdata('kdpoli', $klinik[0]->kode_poli);
                $this->session->set_userdata('idjaminan', $jnsjaminan->id_jaminan);
                $this->session->set_userdata('jnsjaminan', $jnsjaminan->nama_jaminan);
                $this->session->set_userdata('jnslayan', $this->input->post('jnslayan'));
                $this->session->set_userdata('layanan', [1=>'Reguler','Eksekutif'][$this->input->post('jnslayan')]);
//                if($this->input->post('jnslayan')==1) {
//                    $this->session->set_userdata('layanan', "Reguler");
//                } else {
//                    $this->session->set_userdata('layanan', "Eksekutif");
//                }
                $this->session->set_userdata('status','2');
                redirect('reservasi/step3', 'refresh');
            }
            $this->session->set_userdata('status','1');
            $data['page'] = 'reservasi/step2';
            $data['contenthead'] = true;
            $data['linkbc'] = 'reservasi';
            $data['action'] = site_url('reservasi/step2');
            $data['content']['norm']=$this->session->userdata('norm');
            $data['content']['tgllahir']=$this->session->userdata('tgllahir');
            $data['content']['namapas']=$this->session->userdata('namapas');
            $this->load->view('reservasi/main', $data);
        } else {
            redirect('reservasi');
        }
    }

    public function ajax_getdokter($jenis, $klinik) {
        $data = $this->mod_reservasi->getdokter("jns_layan_id={$jenis} and klinik_id={$klinik}");
        echo json_encode($data);
    }   
    public function ajax_klinik($iddokter, $jenis) {
        $data = $this->mod_reservasi->getklinik("jns_layan_id ={$jenis}");
        echo json_encode($data); 
    }
    
    public function ajax_jadwal($klinik, $iddokter, $jenis) {
        if ($jadwal= $this->mod_reservasi->cekjadawal($klinik, $iddokter, $jenis)){
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
        $kuotaperjam=$this->mod_reservasi->getjamcekin($idjadwal,$tglcekin);
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
        if ($this->session->userdata('status')=='2') {
            if ($this->input->post()){
                $waktursv=$this->session->userdata('waktursv');
                $idklinik=$this->session->userdata('idklinik');
                $kdpoli=$this->session->userdata('kdpoli');
                $norm= $this->session->userdata('norm');
                $datares= array('norm'=>$norm,
                'waktu_rsv'=>$waktursv,'jadwal_id'=>$this->session->userdata('idjadwal'),
                'jns_jaminan_id'=>$this->session->userdata('idjaminan'),
                'sebab_id'=>$this->input->post('sebab'),
                'status'=>1, 'user_id'=>2, 'jenis_rsv'=>'WEB');
                $idres=$this->mod_reservasi->saveres($datares,$kdpoli);
                if ($idres) {
                    $this->load->model('mod_sms');
                    $this->mod_sms->sendkonfirm($idres);
                    $this->session->set_userdata('status', '3');
                    $this->session->set_flashdata('success', 'Reservasi berhasil, data sudah tersimpan');
                redirect('reservasi/finish/'.$idres);
                } else {
                    $this->session->set_flashdata('error', 'Data tidak dapat di simpan');
                }             
            }
            $data['content']['idjadwal']= $this->session->userdata('idjadwal');
            $data['content']['tglcekin']= $this->session->userdata('tglcekin');
            $data['content']['jamcekin']= $this->session->userdata('jamcekin');
            $data['content']['iddokter']= $this->session->userdata('iddokter');
            $data['content']['nmdokter']= $this->session->userdata('nmdokter');
            $data['content']['idklinik']= $this->session->userdata('idklinik');
            $data['content']['nmklinik']= $this->session->userdata('nmklinik');
            $data['content']['idjaminan']= $this->session->userdata('idjaminan');
            $data['content']['jnsjaminan']= $this->session->userdata('jnsjaminan');
            $data['content']['jnslayan']= $this->session->userdata('jnslayan');
            $data['content']['layanan']= $this->session->userdata('layanan');
            $data['content']['waktursv']= $this->session->userdata('waktursv');
            $data['content']['norm']= $this->session->userdata('norm');
            $data['content']['namapas']=$this->session->userdata('namapas');
            $data['content']['tgllahir']=$this->session->userdata('tgllahir');
            $data['content']['alamat']=$this->session->userdata('alamat');
            $data['content']['notelp']=$this->session->userdata('notelp');
            $data['page'] = 'reservasi/step3';
            $data['contenthead'] = true;
            $data['linkbc'] = 'reservasi';
            $data['action'] = site_url('reservasi/step3');
            $this->load->view('reservasi/main', $data);
        }else {
            redirect('reservasi');
        }
    }
    public function finish($idres) {
        if ($this->session->userdata('status')=='3'){
            $datares= $this->mod_reservasi->getreserv("id_rsv=$idres");
            $this->load->library('ciqrcode');
//            header("Content-Type: image/png");
            $namafile=$this->session->userdata('norm').$datares->nores.".png";
            $params['data'] = $this->session->userdata('norm').' '.$datares->nores;
            $params['level'] = 'H';
            $params['size'] = 15;
            $params['savename'] = FCPATH."/qrcode/".$namafile;
            $this->ciqrcode->generate($params);

            $data['page'] = 'reservasi/finish';
            $data['contenthead'] = true;
            $data['linkbc'] = 'reservasi';
            $data['action'] = site_url('reservasi');
            $data['content']['norm']= $this->session->userdata('norm');
            $data['content']['namapas']=$this->session->userdata('namapas');
            $data['content']['nmklinik']=$this->session->userdata('nmklinik');
            $data['content']['nmdokter']= $datares->nama_dokter;
            $data['content']['jnsjaminan']= $datares->nama_jaminan;
            $data['content']['layanan']= $datares->jns_layan;
            $data['content']['qrcode']= $namafile;
            $data['content']['nores']=$datares->nores;
            $data['content']['waktures']=$datares->waktu_rsv;
            $this->load->view('reservasi/main', $data);
        } else {
            redirect('reservasi');
        }
    }
    public function help() {
        $data['page'] = 'reservasi/help';
        $data['contenthead'] = true;
        $data['linkbc'] = 'help';
        $data['action'] = site_url('reservasi');
        $data['content']='';
        $this->load->view('reservasi/main', $data);
    }
    public function ketentuan() {
        $data['page'] = 'reservasi/ketentuan';
        $data['contenthead'] = true;
        $data['linkbc'] = 'ketentuan';
        $data['action'] = site_url('reservasi');
        $data['content']='';
        $this->load->view('reservasi/main', $data);
    }
    
}

