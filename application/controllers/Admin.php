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
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('ion_auth'));
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        $this->load->model('mod_setting');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }

    public function index()
    {   
        $this->data['page']='admin/dasboard';
        $this->data['content']='';
        $this->load->view('admin/main', $this->data);
    }
    public function reservasi() {
        if ($this->input->get('hapus')){
            $this->db->delete("treservasi", "id_rsv={$this->input->get('hapus')}");
            redirect('admin/reservasi', 'refresh');
        }
        $this->load->model('mod_reservasi');
        if ($this->input->post()){
            $datatgl= explode("|",$this->input->post('tglcekin'));
            $waktursv=date('Y/m/d H:i:s', strtotime($datatgl[2].$this->input->post('jamcekin')));
            $dataklinik= $this->mod_reservasi->getklinikbyid($this->input->post('klinik'));
            $kodeklinik=$dataklinik->kode_poli;
            $datares= array('norm'=>$this->input->post('norm'),
                'notelp'=>$this->input->post('notelp'),
                'waktu_rsv'=>$waktursv,'id_jadwal'=>$datatgl[0],
                'id_klinik'=>$this->input->post('klinik'),
                'id_dokter'=>$this->input->post('dokter'),
                'cara_bayar'=>$this->input->post('jnspasien'),
                'sebab'=>$this->input->post('sebab'),
                'id_jnslayan'=>$this->input->post('jnslayan'),
                'status'=>1, 'user_id'=>2, 
                'jenis_res'=>$this->input->post('jenisres'));
            if(empty($this->input->post('edit'))){
                $this->db->insert('treservasi', $datares);
            } else {
                $this->db->update('treservasi', $datares, "id_rsv={$this->input->post('edit')}");
            }
            if ($this->db->affected_rows()>0){
                $this->session->set_flashdata('success', 'Data sudah tersimpan');
                if(empty($this->input->post('edit'))){
                    $this->session->set_userdata('status', '1');
                    $idres=$this->db->insert_id();
                    $nores=$kodeklinik.'-'.$idres;
                    $this->db->update('treservasi', array('nores'=>$nores), "id_rsv = {$idres}");
                }
            } else {
                $this->session->set_flashdata('error', 'Data tidak dapat di simpan');
            }
            redirect('admin/reservasi', 'refresh');
        }
        $data['page']='admin/reservasi';
        $data['content']['dokter']= $this->mod_setting->getdokter(0,1000);
        $data['content']['klinik']= $this->mod_setting->getklinik(0,1000);
        $data['content']['datares']= $this->mod_reservasi->getresfull("waktu_rsv>={date('Y-m-d')}");
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
    public function datadok() {
        $this->data['page']='admin/datadok';
        $this->data['content']='';
        $this->load->view('admin/main', $this->data);
    }
    public function dataklinik() {
        $this->data['page']='admin/dataklinik';
        $this->data['content']='';
        $this->load->view('admin/main', $this->data);
    }
    public function jadwal() {
        if ($this->input->get('hapus')) {
            $id= $this->input->get('hapus');
            $this->db->delete('jadwal', 'id_jadwal='.$id);
            if ($this->db->affected_rows()>0){
                $this->session->set_flashdata('success', 'Data sudah dihapus');    
                redirect('admin/jadwal');
            } else {
                $this->session->set_flashdata('error', 'Data GAGAL dihapus');
            }            
        }
        if($this->input->post()){
            $dokter= $this->input->post('dokter');
            $klinik= $this->input->post('klinik');
            $jnslayan= $this->input->post('jnslayan');
            $hari = $this->input->post('hari');
            $mulai = $this->input->post('mulai');
            $selesai = $this->input->post('selesai');
            $status = $this->input->post('status');
            $kuota = $this->input->post('kuota');
            if ($this->input->post('edit')){
                $idjadwal= $this->input->post('edit');
                $status= $this->input->post('status');
                $this->db->update('jadwal', array('id_dokter'=>$dokter,'id_klinik'=>$klinik,'jnslayan'=>$jnslayan,'kuota_perjam'=>$kuota,
                    'id_hari'=>$hari,'jam_mulai'=>$mulai,'jam_selesai'=>$selesai,'status'=>$status), 'id_jadwal='.$idjadwal);
            }else{
                $this->db->insert('jadwal', array('id_dokter'=>$dokter,'id_klinik'=>$klinik,'jnslayan'=>$jnslayan,
                    'kuota_perjam'=>$kuota,'id_hari'=>$hari,'jam_mulai'=>$mulai,'jam_selesai'=>$selesai,'status'=>$status));
            }
            if ($this->db->affected_rows()>0){
               $this->session->set_flashdata('success', 'Data sudah tersimpan');
               redirect('admin/jadwal', 'refres');
            } else {
                $this->session->set_flashdata('error', 'Data TIDAK tidak tersimpan. \n Cek kembali data yang anda masukkan');
            }
        }
        $this->load->library('pagination');
        $jmldata= $this->mod_setting->getjmljadwal();
        $config['base_url'] = base_url().'admin/jadwal/';
        $config['total_rows'] = $jmldata;
        $config['per_page'] = 10;
        $config['num_links'] = 2;
        $config['uri_segment']=3;
        $config['full_tag_open'] = "<ul class='pagination pagination-sm' style='position:relative; top:-25px;'>";
        $config['full_tag_close'] ="</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        $this->pagination->initialize($config);	
        $data['content']['jadwal']= $this->mod_setting->getjadwalfull($config['per_page'],$this->uri->segment('3'));
        
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
                redirect('admin/libur');
            } else {
                $this->session->set_flashdata('error', 'Data GAGAL dihapus');
            }            
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
               redirect('admin/libur', 'refres');
            } else {
                $this->session->set_flashdata('error', 'Data TIDAK tidak tersimpan. \n Cek kembali data yang anda masukkan');
            }
        }
        $this->load->library('pagination');
        $jmldata= $this->mod_setting->getnumlibur();
        $config['base_url'] = base_url().'admin/libur/';
        $config['total_rows'] = $jmldata;
        $config['per_page'] = 10;
        $config['num_links'] = 2;
        $config['uri_segment']=3;
        $config['full_tag_open'] = "<ul class='pagination pagination-sm' style='position:relative; top:-25px;'>";
        $config['full_tag_close'] ="</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        $this->pagination->initialize($config);		
        $this->data['content']['dtlibur'] = $this->mod_setting->getdatalibur($config['per_page'],$this->uri->segment('3'));
        $this->data['page']='admin/libur';
        $this->data['content']['action']='admin/libur';
        $this->load->view('admin/main', $this->data);
    }
     public function users() {
        $this->data['page']='admin/users';
        $this->data['content']='';
        $this->load->view('admin/main', $this->data);
    }
}
