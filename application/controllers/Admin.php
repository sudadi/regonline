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
    }

    public function index()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/login', 'refresh');
        }
        
        $this->data['page']='admin/dasboard';
        $this->data['content']='';
        $this->load->view('admin/main', $this->data);
    }
    public function login() {
        $this->data['title'] = $this->lang->line('login_heading');
        $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');
        if ($this->form_validation->run() === TRUE) {
            $remember = (bool)$this->input->post('remember');
            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
            {
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('admin', 'refresh');
            } else  {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('admin/login', 'refresh'); 
            }
        }  else {
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['content']['identity'] = array('name' => 'identity',
                    'id' => 'identity',
                    'type' => 'text',
                    'value' => $this->form_validation->set_value('identity'),
                    'class'=>'form-control', 'placeholder'=>'Email'
            );
            $this->data['content']['password'] = array('name' => 'password',
                    'id' => 'password',
                    'type' => 'password',
                    'class'=>'form-control', 'placeholder'=>'Password'
            );
            $this->data['page']='admin/login';
            $this->data['content']['action']='admin/login';
            $this->load->view('admin' . DIRECTORY_SEPARATOR . 'main', $this->data);
        }
    }  
    public function reservasi() {
        $this->data['page']='admin/reservasi';
        $this->data['content']='';
        $this->load->view('admin/main', $this->data);
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
        $data['content']['jadwal']= $this->mod_setting->getjadwal($config['per_page'],$this->uri->segment('3'));
        
        $data['page']='admin/jadwal';
        $data['content']['dokter']= $this->mod_setting->getdokter(0,1000);
        $data['content']['klinik']= $this->mod_setting->getklinik(0,1000);
        $data['content']['jnslayan']= $this->mod_setting->getjnslayan();
        $this->load->view('admin/main', $data);
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
?>