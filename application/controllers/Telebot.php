<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Telebot extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('telebot_lib'));
    }
    
    public function bothook() {
        $entityBody = file_get_contents('php://input');
        $message = json_decode($entityBody, true);
        prosesApiMessage($message);
    }
    
    public function botloop() {
        //global $debug;
        while (true) {
            $idfile = './botupdate.txt';
            $update_id = 0;

            if (file_exists($idfile)) {
                $update_id = (int) file_get_contents($idfile);
                echo '-';
            }

            $updates = $this->telebot_lib->getApiUpdate($update_id);

            foreach ($updates as $message) {
                $update_id = $this->prosesApiMessage($message);
                echo '+';
            }
            file_put_contents($idfile, $update_id + 1);
            
            //sleep(1);
        }
    }
    
    private function prosesApiMessage($sumber)
    {
        $updateid = $sumber['update_id'];

       // if ($GLOBALS['debug']) mypre($sumber);

        if (isset($sumber['message'])) {
            $message = $sumber['message'];

            if (isset($message['text'])) {
                $this->prosesPesanTeks($message);
            } elseif (isset($message['sticker'])) {
                $this->prosesPesanSticker($message);
            } else {
                // gak di proses silakan dikembangkan sendiri
            }
        }

        if (isset($sumber['callback_query'])) {
            $this->prosesCallBackQuery($sumber['callback_query']);
        }

        return $updateid;
    }

    private function prosesPesanSticker($message)
    {
        // if ($GLOBALS['debug']) mypre($message);
    }

    private function prosesCallBackQuery($message)
    {
        // if ($GLOBALS['debug']) mypre($message);

        $message_id = $message['message']['message_id'];
        $chatid = $message['message']['chat']['id'];
        $data = $message['data'];

//        $inkeyboard = [
//                    [
//                        ['text' => 'Update 1', 'callback_data' => 'data update tes'],
//                        ['text' => 'Update 2', 'callback_data' => 'data update tes2'],
//                    ],
//                    [
//                        ['text' => 'keyboard on', 'callback_data' => '!keyboard'],
//                        ['text' => 'keyboard inline', 'callback_data' => '!inline'],
//                    ],
//                    [
//                        ['text' => 'keyboard off', 'callback_data' => '!hide'],
//                    ],
//                ];
//
//        $text = '*'.date('H:i:s').'* data baru : '.$data;
//
//        $this->telebot_lib->editMessageText($chatid, $message_id, $text, $inkeyboard, true);

        $messageupdate = $message['message'];
        $messageupdate['text'] = $data;

        $this->prosesPesanTeks($messageupdate);
    }


    private function prosesPesanTeks($message)
    {
        // if ($GLOBALS['debug']) mypre($message);
        $this->load->model('mod_telebot');
        $this->load->model('mod_reservasi');
        $pesan = trim($message['text']);
        $chatid = $message['chat']['id'];
        $fromid = $message['from']['id'];
        $inkeyboard = FALSE;
        switch (true) {

            case $pesan == '/start' :
                $this->telebot_lib->sendApiAction($chatid);
                $text = "Selamat Datang di bot RESERVASI Pasien\n"
                ."*RS Ortopedi Prof.DR.R. Soeharso Surakarta*\n";
                $this->telebot_lib->sendApiMsg($chatid, $text, false, 'Markdown');
                $keyboard = [
                    ['/reservasi'],
                    ['/ketentuan', '/bantuan'],

                ];
                $this->telebot_lib->sendApiKeyboard($chatid, 'Silahkan Klik tombol /reservasi untuk mulai.', $keyboard);
                break;

            case $pesan=='/reservasi' :
                if($this->mod_telebot->newteleres($chatid)){
                    $text = "Mohon masukkan No. Rekam Medis (NoRM) Anda :";
                } else {
                    $text = "Maaf perintah /reservasi gagal, silahkan ulangi lagi!";                        
                }
                $this->telebot_lib->sendApiAction($chatid);
                $this->telebot_lib->sendApiMsg($chatid, $text);
                break;

            case $pesan == '/id':
                $this->telebot_lib->sendApiAction($chatid);
                $text = 'ID Kamu adalah: '.$fromid;
                $this->telebot_lib->sendApiMsg($chatid, $text);
                break;

            case $pesan == '!keyboard':
                $this->telebot_lib->sendApiAction($chatid);
                $keyboard = [
                    ['tombol 1', 'tombol 2'],
                    ['!keyboard', '!inline'],
                    ['!hide'],
                ];
                $this->telebot_lib->sendApiKeyboard($chatid, 'tombol pilihan', $keyboard);
                break;

            case $pesan == '!inline':
                $this->telebot_lib->sendApiAction($chatid);
                $inkeyboard = [
                    [
                        ['text' => 'Update 1', 'callback_data' => 'data update 1'],
                        ['text' => 'Update 2', 'callback_data' => 'data update 2'],
                    ],
                    [
                        ['text' => 'keyboard on', 'callback_data' => '!keyboard'],
                        ['text' => 'keyboard inline', 'callback_data' => '!inline'],
                    ],
                    [
                        ['text' => 'keyboard off', 'callback_data' => '!hide'],
                    ],
                ];
                $this->telebot_lib->sendApiKeyboard($chatid, 'Tampilan Inline', $inkeyboard, true);
                break;

            case $pesan == '!hide':
                $this->telebot_lib->sendApiAction($chatid);
                $this->telebot_lib->sendApiHideKeyboard($chatid, 'keyboard off');
                break;

            case preg_match("/\/echo (.*)/", $pesan, $hasil):
                $this->telebot_lib->sendApiAction($chatid);

                $text = '*Echo:* '.$hasil[1];
                $this->telebot_lib->sendApiMsg($chatid, $text, false, 'Markdown');
                break;

            default:
                $dataResTele= $this->mod_telebot->getrowteleres("fromid=$chatid");
                if ($dataResTele) {
                    $status = $dataResTele->status;
                    switch ($status) {
                        case 'norm':
                            if($this->mod_reservasi->cekdatpas("norm='".$pesan."'") && 
                            $this->mod_telebot->updteleres($chatid,'ttl',array('name'=>'norm','val'=>$pesan))){
                                $text = "Mohon masukkan Tgl. lahir Anda dd/mm/yyyy\n(ct. 21/06/1978) :";                        
                            } else {
                                $text = "Nomor Rekam Medis (No.RM) tidak ditemukan(salah)!\n"
                                        . "Mohon masukkan No.RM yang benar :";
                            }
                            break;
                            
                        case 'ttl':
                            $tgl = DateTime::createFromFormat('d/m/Y', $pesan)->format('Y-m-d');
                            if($this->mod_reservasi->cekdatpas("norm='".$dataResTele->norm."' and tgl_lahir='".$tgl."'") && 
                            $this->mod_telebot->updteleres($chatid,'jaminan')){
                                $text = "Pilih jenis jaminan :";    
                                $inkeyboard = [
                                    [
                                        ['text' => 'Umum', 'callback_data' => '2'],
                                        ['text' => 'JKN', 'callback_data' => '5'],
                                        ['text' => 'IKS', 'callback_data' => '7'],
                                    ],                                    
                                ];
                            } else {
                                $text = "Tanggal lahir tidak sesuai (salah)!\n"
                                        . "Mohon masukkan tanggal yang benar :";
                            }
                            break;
                            
                        case 'jaminan':
                            if (($pesan == '2' || $pesan == '7') && $this->mod_telebot->updteleres($chatid,'layanan',array('name'=>'jaminan_id','val'=>$pesan))){                            
                                $text = "Pilih jenis layanan :";
                                $inkeyboard = [
                                    [
                                        ['text' => 'Reguler', 'callback_data' => '1'],
                                        ['text' => 'Eksekutif', 'callback_data' => '2'],
                                    ],                                    
                                ];
                            } else if ($pesan == '5' && $this->mod_telebot->updteleres($chatid,'klinik',array('name'=>'jaminan_id','val'=>(int)$pesan))) {
                                $text = "Pilih Poliklinik tujuan :";
                                $kliniks = $this->mod_reservasi->getklinik(false, 1);
                                foreach ($kliniks as $klinik) {
                                    $pilihan[]= ['text'=>"$klinik->nama_klinik", 'callback_data'=>"$klinik->id_klinik"];
                                }
                                $inkeyboard = [$pilihan];
                                
                            } else {
                                $text = "anda pilih {$pesan} Pilih jenis jaminan :";    
                                $inkeyboard = [
                                    [
                                        ['text' => 'Umum', 'callback_data' => '2'],
                                        ['text' => 'JKN', 'callback_data' => '5'],
                                        ['text' => 'IKS', 'callback_data' => '7'],
                                    ],                                    
                                ];
                            }
                            break;
                            
                        case 'layanan':
                            if ($pesan == '1' && $this->mod_telebot->updteleres($chatid,'klinik',array('name'=>'jnslayan_id','val'=>(int)$pesan))){
                                $text = "Pilih Poliklinik tujuan :";
                                $kliniks = $this->mod_reservasi->getklinik(false, 1);
                                foreach ($kliniks as $klinik) {
                                    $pilihan[]= ['text'=>"$klinik->nama_klinik", 'callback_data'=>"$klinik->id_klinik"];
                                }
                                $inkeyboard = [$pilihan];
                            } else if ($pesan == '2' && $this->mod_telebot->updteleres($chatid,'dokter',array('name'=>'jnslayan_id','val'=>(int)$pesan))){
                                $text = "Pilih dokter :";
                                $dokters = $this->mod_reservasi->getdokter(2);
                                foreach ($dokters as $dokter) {
                                    $pilihan[]= ['text'=>"$dokter->nama_dokter", 'callback_data'=>"$dokter->id_dokter"];
                                }
                                $inkeyboard = [$pilihan];
                            } else {
                                $text = "Pilih jenis layanan :";
                                $inkeyboard = [
                                    [
                                        ['text' => 'Reguler', 'callback_data' => '1'],
                                        ['text' => 'Eksekutif', 'callback_data' => '2'],
                                    ],                                    
                                ];
                            }
                            break;
                            
                        case 'dokter':
                            $dokters = $this->mod_reservasi->getdokter(2);
                            if (in_array($pesan, $dokter)){
                                $this->mod_telebot->updteleres($chatid,'klinik',array('name'=>'dokter_id','val'=>(int)$pesan));
                                $text = "Pilih Poliklinik tujuan :";
                                $kliniks = $this->mod_reservasi->getklinik(false, 1);
                                foreach ($kliniks as $klinik) {
                                    $pilihan[]= ['text'=>"$klinik->nama_klinik", 'callback_data'=>"$klinik->id_klinik"];
                                }
                                $inkeyboard = [$pilihan];
                            }
                            break;
                            
                        default:
                            $text = "Maaf {$fromid}, kami tidak mengerti perintah '{$pesan}' yang Anda maksud.";
                            break;
                    }
                } else {
                    $text = "Maaf {$fromid}, kami tidak mengerti perintah '{$pesan}' yang Anda maksud.";                    
                }
                $this->telebot_lib->sendApiAction($chatid);
                if ($inkeyboard){
                    $this->telebot_lib->sendApiKeyboard($chatid, $text, $inkeyboard, true);
                } else {
                    $this->telebot_lib->sendApiMsg($chatid, $text);
                }
                break;
        }
    }

}