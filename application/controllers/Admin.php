<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
/* 
 * The MIT License
 *
 * Copyright 2017 DotKom <sudadi.kom@yahoo.com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

class Admin extends CI_Controller
{
    var $pageconf=array();
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('ion_auth'));
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        $this->load->model('mod_setting');
        $this->load->model('mod_sms');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $this->pageconf['per_page'] = 10;
        $this->pageconf['num_links'] = 2;
        $this->pageconf['uri_segment']=3;
        $this->pageconf['full_tag_open'] = "<ul class='pagination pagination-sm' style='position:relative; top:-15px;'>";
        $this->pageconf['full_tag_close'] ="</ul>";
        $this->pageconf['num_tag_open'] = '<li>';
        $this->pageconf['num_tag_close'] = '</li>';
        $this->pageconf['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $this->pageconf['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $this->pageconf['next_tag_open'] = "<li>";
        $this->pageconf['next_tagl_close'] = "</li>";
        $this->pageconf['prev_tag_open'] = "<li>";
        $this->pageconf['prev_tagl_close'] = "</li>";
        $this->pageconf['first_tag_open'] = "<li>";
        $this->pageconf['first_tagl_close'] = "</li>";
        $this->pageconf['last_tag_open'] = "<li>";
        $this->pageconf['last_tagl_close'] = "</li>";
    }

    public function index()
    {   
        $this->load->model('mod_reservasi');
        $currentres=$this->mod_reservasi->getgraphres("DATE_FORMAT(first_update, '%Y/%m/%d') = CURRENT_DATE()");
        $lastweekday=$this->mod_reservasi->getgraphres("DATE_FORMAT(first_update, '%Y/%m/%d') = DATE_FORMAT(NOW() - INTERVAL 7 DAY, '%Y/%m/%d')");
        if (empty($lastweekday)){
            $lastwa=$lastsms=$lastweb=$lasttele=0;
        } else {
            $lastwa=$lastweekday[0]['WA'];
            $lastsms=$lastweekday[0]['SMS'];
            $lastweb=$lastweekday[0]['WEB'];
            $lasttele=$lastweekday[0]['TG'];
        }
        if (empty($currentres)) {
            $currwa=$currsms=$currweb=$currtele=0;
        } else {
            $currwa=$currentres[0]['WA'];
            $currsms=$currentres[0]['SMS'];
            $currweb=$currentres[0]['WEB'];
            $currtele=$currentres[0]['TG'];
        }
//        $currtele=$currsms+$currwa+$currweb;
//        $lasttele=$lastsms+$lastwa+$lastweb;
        if ($lasttele == 0){
            $percenttele=$currtele*100;
        } else {
            $percenttele=round((($currtele-$lasttele)/$lasttele)*100,2);
        }
        if ($lastwa == 0){
            $percentwa=$currwa*100;
        } else {
            $percentwa= round((($currwa-$lastwa)/$lastwa)*100, 2);
        }
        if ($lastsms == 0){
            $percentsms=$currsms*100;
        } else {
            $percentsms= round((($currsms-$lastsms)/$lastsms)*100, 2);
        }
        if ($lastweb == 0){
            $percentweb=$currweb*100;
        } else {
            $percentweb= round((($currweb-$lastweb)/$lastweb)*100, 2);
        }
        $data['content']['jmlwa']=$currwa;
        $data['content']['jmlsms']=$currsms;
        $data['content']['jmlweb']=$currweb;
        $data['content']['jmltele']=$currtele;
        $data['content']['percentsms']=$percentsms;
        $data['content']['percentwa']=$percentwa;
        $data['content']['percentweb']=$percentweb;
        $data['content']['percenttele']=$percenttele;
        $data['page']='admin/dasboard';
        $data['content']['action']='';
        $this->load->view('admin/main', $data);
    }
    public function ajaxdashres() {
        if ($this->input->is_ajax_request()) {
            $this->load->model('mod_reservasi');
            $data=$this->mod_reservasi->getgraphres('first_update BETWEEN (NOW() - INTERVAL 15 DAY) AND NOW()');
            echo json_encode($data);
        } else {
            exit('No direct script access allowed');
        }
    }
    public function reservasi() {
        $this->load->model('mod_reservasi');
        if ($this->input->get('filtglres')){
            $filtglres = $this->input->get('filtglres');
            $where = "date(waktu_rsv)='$filtglres'";
        } else {
            $filtglres = date('Y-m-d');
            $where = "waktu_rsv >='$filtglres'";
        }
        if ($this->input->get('hapus')){
            $this->db->delete("res_treservasi", "id_rsv={$this->input->get('hapus')}");
            redirect('admin/reservasi');
        }
        if ($this->input->post()){
            $this->load->model('mod_sms');
            if ($this->input->post('savestat')){
                $idres= $this->input->post('idres');
                $status= $this->input->post('dpstatus');
                $alasan= $this->input->post('alasan');
                $notelp= $this->input->post('telpstat');
                if($this->db->update('res_treservasi', array('status'=>$status), 'id_rsv='.$idres)) {
                    if($status==4){
                        $this->mod_sms->sendsms($notelp, $alasan);
                    }
                    $this->session->set_flashdata('success', 'Update data BERHASIL');
                } else {
                    $this->session->set_flashdata('error', 'Update data GAGAL');
                }
            } else if ($this->input->post('saveres')){
                $datatgl= explode("|",$this->input->post('tglcekin'));
                $waktursv=date('Y/m/d H:i:s', strtotime($datatgl[2].$this->input->post('jamcekin')));
                $dataklinik= $this->mod_reservasi->getklinikbyid($this->input->post('klinik'));
                $kodeklinik=$dataklinik->kode_poli;
                $norm=$this->input->post('norm');
                $notelp= $this->input->post('notelp');
                $datares= array('norm'=>$this->input->post('norm'),
                    'waktu_rsv'=>$waktursv,'jadwal_id'=>$datatgl[0],
                    'jns_jaminan_id'=>$this->input->post('jnsjaminan'),
                    'sebab_id'=>$this->input->post('sebab'),
                    'status'=>1, 'user_id'=>2, 
                    'jenis_rsv'=>$this->input->post('jenisres'));
                if(empty($this->input->post('edit'))){
                    $this->db->insert('res_treservasi', $datares);
                } else {
                    $this->db->update('res_treservasi', $datares, "id_rsv={$this->input->post('edit')}");
                    $edit='[Koreksi]\n';
                }
                if ($this->db->affected_rows()>0){
                    $this->session->set_flashdata('success', 'Data sudah tersimpan');
                    if(empty($this->input->post('edit'))){
                        //$this->session->set_userdata('status', '1');
                        $idres=$this->db->insert_id();
                        $nores=$kodeklinik.'-'.$idres;
                        $this->db->update('res_treservasi', array('nores'=>$nores), "id_rsv = {$idres}");
                        $this->db->update('res_tpasien', array('notelp'=>$notelp), "norm={$norm}");
                        $this->mod_sms->sendkonfirm($idres, $edit);
                    }
                } else {
                    $this->session->set_flashdata('error', 'Data tidak dapat di simpan');
                }
            }
            redirect('admin/reservasi');
        }
        $data['page']='admin/reservasi';
        $data['content']['dokter']= $this->mod_setting->getdokter(0,1000);
        $data['content']['klinik']= $this->mod_setting->getklinik(0,1000);
        $data['content']['datares']= $this->mod_reservasi->getresfull($where);
        $data['content']['filtglres']= $filtglres;
        $data['content']['action']='admin/reservasi';
        $this->load->view('admin/main', $data);
    }
    public function ajaxresv($idrsv) {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $this->load->model('mod_reservasi');
        $data = $this->mod_reservasi->getreserv($idrsv);
        echo json_encode($data); 
    }
    public function ajaxpasien($norm) {
        $this->load->model('mod_reservasi');
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $data = $this->mod_reservasi->cekdatpas("norm='{$norm}'");
        echo json_encode($data);
    }
    public function datares() {
        $this->data['page']='admin/datares';
        $this->data['content']='';
        $this->load->view('admin/main', $this->data);
    }
    
    public function sms() {
        $this->load->model('mod_sms');
        if ($this->input->post()){
            if ($this->input->post('pesan') && $this->input->post('notelp')) {
                $pesan= $this->input->post('pesan');
                $notelp= $this->input->post('notelp');
                if ($this->mod_sms->sendsms($notelp, $pesan)) {
                    $this->session->set_flashdata("success", "Berhasil, pesan masuk dalam antrian pengiriman");
                } else {
                    $this->session->set_flashdata("error", "Gagal, pesan tidak tersimpan");
                }
            } else if ($this->input->post('kirimussd')) {
                $ussd = $this->input->post('txtussd');            
                if ($this->mod_sms->cekpulsa($ussd)) {
                    $this->session->set_flashdata("success", "Berhasil, pesan masuk dalam antrian pengiriman");
                } else {
                    $this->session->set_flashdata("error", "Gagal, pesan tidak tersimpan");
                }
                unset($_POST);
            }
            redirect('admin/sms');
        }
        $data['page']='admin/sms';
        $this->load->library('pagination');
        $datanotelp=$this->mod_sms->getsms('UpdatedInDB',true,null);
        $jmldata=count($datanotelp);
        $this->pageconf['base_url'] = base_url().'admin/sms/';
        $this->pageconf['total_rows'] = $jmldata;        
        $this->pagination->initialize($this->pageconf);
        $data['content']['datanotelp']= $this->mod_sms->getsms('TransTime',true,null,$this->pageconf['per_page'],$this->uri->segment('3'));
        $data['content']['datasms']= '';
        $data['content']['action']='admin/sms';
        $this->load->view('admin/main', $data);
    }
    public function ajaxlistelp() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $this->load->model('mod_sms');
        $data = $this->mod_sms->getsms("UpdatedInDB",false,"stat=false");
        echo json_encode($data);
    }
    public function ajaxsms() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        if ($this->input->post()){
            $notelp=$this->input->post('notelp');
            $this->load->model('mod_sms');
            $data = $this->mod_sms->getsms("TransTime",false,"Number='$notelp'");
            $this->db->update("sms_full_inbox", array("Processed"=>"true"), "SenderNumber='$notelp'");
        }
        for ($i=0;$i < count($data);$i++) {
            $data[$i]->TextDecoded = nl2br($data[$i]->TextDecoded);
        }
        echo json_encode($data);
    }
    public function ajaxdelsms() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        if($this->input->post('id') && $this->input->post('type')) {
            $this->load->model('mod_sms');
            $res = array_combine($this->input->post('id'), $this->input->post('type'));
            foreach($res as $key => $value) {
                if ($value == 'inbox'){
                    $this->db->delete("sms_full_inbox", "ID='$key'");
                } else {
                    $this->db->delete("sms_full_outbox", "ID='$key'");
                }
            }
        }
        echo json_encode($res);        
    }
    public function laporan() {
        $this->load->model('mod_reservasi');
        $where = "waktu_rsv>='".date('Y-m-d'."'");
        $data['page']='admin/laporan';
        $data['content']['datares']= $this->mod_reservasi->getresfull($where);
        $this->load->view('admin/main', $data);
    }
    public function datadok() {
        if ($this->input->get('hapus')) {
            $id= $this->input->get('hapus');
            $this->db->delete('res_refdokter', 'id_dokter='.$id);
            if ($this->db->affected_rows()>0){
                $this->session->set_flashdata('success', 'Data sudah dihapus');    
                redirect('admin/datadok');
            } else {
                $this->session->set_flashdata('error', 'Data GAGAL dihapus');
            }            
        }
        if($this->input->post()){
            $iddr= $this->input->post('iddr');
            $namadr= $this->input->post('namadr');
            $status= $this->input->post('status');
            $telpdr= $this->input->post('telpdr');
            if ($this->input->post('edit')){
                $this->db->update('res_refdokter', array('id_dokter'=>$iddr,'status'=>$status,'nama_dokter'=>$namadr,'telp_dokter'=>$telpdr), 'id_dokter='.$iddr);
            }else{
                $this->db->insert('res_refdokter', array('id_dokter'=>$iddr,'nama_dokter'=>$namadr,'telp_dokter'=>$telpdr,'status'=>$status));
            }
            if ($this->db->affected_rows()>0){
               $this->session->set_flashdata('success', 'Data sudah tersimpan');
            } else {
                $this->session->set_flashdata('error', 'Data TIDAK tidak tersimpan. \n Cek kembali data yang anda masukkan');
            }
            redirect('admin/datadok');
        }
        $this->load->library('pagination');
        $jmldata= count($this->mod_setting->getdokter());
        $this->pageconf['base_url'] = base_url().'admin/datadok/';
        $this->pageconf['total_rows'] = $jmldata;
        $this->pagination->initialize($this->pageconf);		
        $data['content']['datadr'] = $this->mod_setting->getdokter($this->pageconf['per_page'],$this->uri->segment('3'));
        $data['page']='admin/datadok';
        $data['content']['action']='admin/datadok';
        $this->load->view('admin/main', $data);
    }
    public function dataklinik() {
        if ($this->input->get('hapus')) {
            $id= $this->input->get('hapus');
            $this->db->delete('res_refklinik', 'id_klinik='.$id);
            if ($this->db->affected_rows()>0){
                $this->session->set_flashdata('success', 'Data sudah dihapus');
            } else {
                $this->session->set_flashdata('error', 'Data GAGAL dihapus');
            }    
            redirect('admin/dataklinik');            
        }
        if($this->input->post()){
            $idklinik= $this->input->post('idklinik');
            $nmklinik= $this->input->post('nmklinik');
            $kuota= $this->input->post('kuota');
            $status= $this->input->post('status');
            if ($this->input->post('edit')){
                $this->db->update('res_refklinik', array('id_klinik'=>$idklinik,'status'=>$status,'nama_klinik'=>$nmklinik,'kuota'=>$kuota), 'id_klinik='.$idklinik);
            }else{
                $this->db->insert('res_refklinik', array('id_klinik'=>$idklinik,'nama_klinik'=>$nmklinik,'status'=>$status,'kuota'=>$kuota));
            }
            if ($this->db->affected_rows()>0){
               $this->session->set_flashdata('success', 'Data sudah tersimpan');
            } else {
                $this->session->set_flashdata('error', 'Data TIDAK tidak tersimpan. \n Cek kembali data yang anda masukkan');
            }
            redirect('admin/dataklinik');
        }
        $this->load->library('pagination');
        $jmldata= count($this->mod_setting->getklinik());
        $this->pageconf['base_url'] = base_url().'admin/dataklinik/';
        $this->pageconf['total_rows'] = $jmldata;
        $this->pagination->initialize($this->pageconf);
        $data['page']='admin/dataklinik';
        $data['content']['dataklinik']= $this->mod_setting->getklinik($this->pageconf['per_page'],$this->uri->segment('3'));
        $data['content']['action']='admin/dataklinik';
        $this->load->view('admin/main', $data);
    }
    public function jadwal() {
        if ($this->input->get('hapus')) {
            $id= $this->input->get('hapus');
            $this->db->delete('res_jadwal', 'id_jadwal='.$id);
            if ($this->db->affected_rows()>0){
                $this->session->set_flashdata('success', 'Data sudah dihapus');
            } else {
                $this->session->set_flashdata('error', 'Data GAGAL dihapus');
            }                
            redirect('admin/jadwal');
        }
        if($this->input->post() && (strtotime($this->input->post('mulai')) < strtotime($this->input->post('selesai')))){
            $dokter= $this->input->post('dokter');
            $klinik= $this->input->post('klinik');
            $jnslayan= $this->input->post('jnslayan');
            $hari = $this->input->post('hari');
            $mulai = $this->input->post('mulai');
            $selesai = $this->input->post('selesai');
            $status = $this->input->post('status');
            $kuota = $this->input->post('kuota');
            $idjadwal= $this->input->post('edit');
            
            if ($idjadwal){
                $this->db->update('res_jadwal', array('dokter_id'=>$dokter,'klinik_id'=>$klinik,'jns_layan_id'=>$jnslayan,'kuota_perjam'=>$kuota,
                    'id_hari'=>$hari,'jam_mulai'=>$mulai,'jam_selesai'=>$selesai,'status'=>$status), 'id_jadwal='.$idjadwal);
            }else{
                $this->db->insert('res_jadwal', array('dokter_id'=>$dokter,'klinik_id'=>$klinik,'jns_layan_id'=>$jnslayan,
                    'kuota_perjam'=>$kuota,'id_hari'=>$hari,'jam_mulai'=>$mulai,'jam_selesai'=>$selesai,'status'=>$status));
            
                $idjadwal = $this->db->insert_id();
            }
            if ($this->db->affected_rows()>0){
                $this->mod_setting->savekuota($idjadwal, $mulai, $selesai, $kuota);
                $this->session->set_flashdata('success', 'Data sudah tersimpan');
            } else {
                $this->session->set_flashdata('error', 'Data TIDAK tidak tersimpan. \n Cek kembali data yang anda masukkan');
            }
            redirect('admin/jadwal');
        } else if($this->input->post()) {
            $this->session->set_flashdata('error', 'Data TIDAK tidak tersimpan. \n Cek kembali data yang anda masukkan');
        }
        
        $this->load->library('pagination');
        $jmldata= $this->mod_setting->getjmljadwal();
        $this->pageconf['base_url'] = base_url().'admin/jadwal/';
        $this->pageconf['total_rows'] = $jmldata;        
        $this->pagination->initialize($this->pageconf);	
        $data['content']['jadwal']= $this->mod_setting->getjadwalfull($this->pageconf['per_page'],$this->uri->segment('3'));
        $data['page']='admin/jadwal';
        $data['content']['dokter']= $this->mod_setting->getdokter(0,1000);
        $data['content']['klinik']= $this->mod_setting->getklinik(0,1000);
        $data['content']['jnslayan']= $this->mod_setting->getjnslayan();
        $data['content']['action']='admin/jadwal';
        $this->load->view('admin/main', $data);
    }
    public function ajaxjadwal($idjadwal) {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $data = $this->mod_setting->getjadwal($idjadwal);
        echo json_encode($data); 
    }
    public function libur() {
        if ($this->input->get('hapus')) {
            $id= $this->input->get('hapus');
            $this->db->delete('tgl_libur', 'id_libur='.$id);
            if ($this->db->affected_rows()>0){
                $this->session->set_flashdata('success', 'Data sudah dihapus');
            } else {
                $this->session->set_flashdata('error', 'Data GAGAL dihapus');
            }                
            redirect('admin/libur');
        }
        if($this->input->post()){
            $tgl= $this->input->post('tgl');
            $ket= $this->input->post('ket');
            if ($this->input->post('edit')){
                $idlibur= $this->input->post('idlibur');
                $status= $this->input->post('status');
                $this->db->update('tgl_libur', array('tanggal'=>$tgl,'status'=>$status,'ket'=>$ket), 'id_libur='.$idlibur);
            }else{
                $this->db->insert('tgl_libur', array('tanggal'=>$tgl,'ket'=>$ket));
            }
            if ($this->db->affected_rows()>0){
               $this->session->set_flashdata('success', 'Data sudah tersimpan');
            } else {
                $this->session->set_flashdata('error', 'Data TIDAK tidak tersimpan. \n Cek kembali data yang anda masukkan');
            }
            redirect('admin/libur');
        }
        $this->load->library('pagination');
        $jmldata= $this->mod_setting->getnumlibur();
        $this->pageconf['base_url'] = base_url().'admin/libur/';
        $this->pageconf['total_rows'] = $jmldata;
        $this->pagination->initialize($this->pageconf);		
        $this->data['content']['dtlibur'] = $this->mod_setting->getdatalibur($this->pageconf['per_page'],$this->uri->segment('3'));
        $this->data['page']='admin/libur';
        $this->data['content']['action']='admin/libur';
        $this->load->view('admin/main', $this->data);
    }
     public function users() {
        $this->load->library('pagination');
        $jmldata= $this->mod_setting->getnumlibur();
        $this->pageconf['base_url'] = base_url().'admin/users/';
        $this->pageconf['total_rows'] = $jmldata;
        $this->pagination->initialize($this->pageconf);	 
        $this->data['page']='admin/users';
        $this->data['content']['datauser']= $this->mod_setting->getuser($this->pageconf['per_page'],$this->uri->segment('3'));
        $this->load->view('admin/main', $this->data);
    }
    public function genset() {
        if ($this->input->post()) {
            if ($this->input->post('smtmodem')){
                if ($this->input->post('editmodem')){
                    $this->db->update("sms_routing", array('prefix'=> $this->input->post('premodem'), 'modem'=> $this->input->post('modem')),"id=".$this->input->post('editmodem'));
                } else {
                    $this->db->insert('sms_routing', array('prefix'=> $this->input->post('premodem'), 'modem'=> $this->input->post('modem')));
                }                
            } else if ($this->input->post('smtkonfirm')) {
                if ($this->input->post('fmtkonfirm')){
                    $this->db->update('sms_konfirm', array('format'=> $this->input->post('fmtkonfirm')), 'id=1');
                }
            }
            if ($this->db->affected_rows() > 0){
                $this->session->set_flashdata('success', 'Data berhasil disimpan');
            } else {
                $this->session->set_flashdata('error', 'GAGAL, data tidak disimpan');
            }
            redirect('admin/genset', 'refresh');
        } else if ($this->input->get('delmodem')){
            if($this->db->delete('sms_routing', 'id='.$this->input->post('delmodem'))){
                $this->session->set_flashdata('success', 'Hapus data BERHASIL');
            } else {
                $this->session->set_flashdata('error', 'Hapus data GAGAL');
            }
        }
        $this->load->model('mod_setting');
        $data['page']='admin/genset';
        $data['content']['rtmodem']=$this->mod_setting->getmodemrt();
        $data['content']['smskonfirm']= $this->mod_setting->getkonfirm();
        $this->load->view('admin/main', $data);
    }
    public function postinfo() {
        if($idinfo=$this->input->get('hapus')){
            if($this->db->delete('res_tinfo',"id_info='{$idinfo}'")) {
                $this->session->set_flashdata('success', 'Data berhasil di hapus.');
                redirect('admin/postinfo', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Hapus data GAGAL!');
                redirect('admin/postinfo', 'refresh');
            }
        } else if($this->input->post('saveinfo')){
            $arrData=['subject'=>$this->input->post('subject'),
                'content'=> $this->input->post('content'),
                'start'=> $this->input->post('start'),
                'status'=> $this->input->post('status')];
            if($this->input->post('saveinfo')=='new'){
                if ($this->mod_setting->saveinfo($arrData)) {
                    $this->session->set_flashdata('success', 'Data berhasil di simpan.');
                } else {
                    $this->session->set_flashdata('error', 'Tambah data GAGAL.!');
                }
            }elseif ($this->input->post('saveinfo') == 'edit') {
                $idinfo= $this->input->post('idinfo');
                if ($this->mod_setting->updateinfo($arrData, $idinfo)){
                    $this->session->set_flashdata('success', 'Data berhasil di simpan.');
                } else {
                    $this->session->set_flashdata('error', 'Edit data GAGAL.!');
                }
            }
            redirect('admin/postinfo');
        } 
        $this->load->helper('text');
        $this->load->model('mod_reservasi');
        $datainfo= $this->mod_setting->getinfo('1=1');
        $data['page']='admin/postinfo';
        $data['content']['datainfo']=$datainfo;
        $data['content']['action']='admin/postinfo';
        $this->load->view('admin/main', $data);
    }
    public function ajaxStatInfo($stat,$idinfo) {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        if($this->db->update('res_tinfo', ['status'=>$stat], "id_info=$idinfo")) {
            //echo $this->db->last_query();
            $data = ['status'=>$stat];
        } else {
            $data = ['status'=>!$stat];
        }
        echo json_encode($data);
    }
}
