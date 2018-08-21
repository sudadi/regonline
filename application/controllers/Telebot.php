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
                    ['/batal'],
                ];
                $this->telebot_lib->sendApiKeyboard($chatid, 'Silahkan Klik tombol /reservasi untuk mulai reservasi', $keyboard);
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
                
            case $pesan == '/batal':
                $text ="Yakin akan membatalkan proses reservasi ini.? \n"
                    . "Ketik 'Ya yakin batal' jika Anda yakin.\n";
                $this->telebot_lib->sendApiAction($chatid);
                $this->telebot_lib->sendApiMsg($chatid, $text);
                break;
            
            case $pesan=='Ya yakin batal' :
                if ($this->mod_telebot->delteleres($chatid)){
                    $text="Proses reservasi sudah di batalkan.\n\n"
                            . "Silahkan Klik tombol /reservasi untuk mulai reservasi";
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
                            $this->mod_telebot->updteleres($chatid,array('status'=>'ttl','norm'=>$pesan))){
                                $text = "Mohon masukkan Tgl. lahir Anda dd/mm/yyyy\n(ct. 21/06/1978) :";                        
                            } else {
                                $text = "Nomor Rekam Medis (No.RM) tidak ditemukan(salah)!\n"
                                        . "Mohon masukkan No.RM yang benar :";
                            }
                            break;
                            
                        case 'ttl':
                            if ($tgl=date('Y/m/d', strtotime($pesan))){
                                $datPas = $this->mod_reservasi->cekdatpas("norm='".$dataResTele->norm."' and tgl_lahir='".$tgl."'");
                            }
                            if($datPas && $this->mod_telebot->updteleres($chatid,array('status'=>'jaminan'))){
                                $text = "Selamat datang *{$datPas->nama}* \n\n"
                                        . "Pilih jenis jaminan :";    
                                $inkeyboard = [
                                    [
                                        ['text' => 'Umum', 'callback_data' => 'jaminan 2'],
                                        ['text' => 'JKN', 'callback_data' => 'jaminan 5'],
                                        ['text' => 'IKS', 'callback_data' => 'jaminan 7'],
                                    ],                                    
                                ];
                            } else {
                                $text = "Tanggal lahir tidak sesuai (salah)!\n"
                                        . "Mohon masukkan tanggal yang benar :";
                            }
                            break;
                            
                        case 'jaminan':
                            $pesan = explode(' ', $pesan);
                            if ($pesan[0]=='jaminan' && ($pesan[1] == '2' || $pesan[1] == '7') && $this->mod_telebot->updteleres($chatid,array('status'=>'layanan','jaminan_id'=>$pesan[1]))){                            
                                $text = "Pilih jenis layanan :";
                                $inkeyboard = [
                                    [
                                        ['text' => 'Reguler', 'callback_data' => 'layanan 1'],
                                        ['text' => 'Eksekutif', 'callback_data' => 'layanan 2'],
                                    ],                                    
                                ];
                            } else if ($pesan[0] == 'jaminan' && $pesan[1] == '5' && $this->mod_telebot->updteleres($chatid,array('status'=>'klinik','jnslayan_id'=>1,'jaminan_id'=>(int)$pesan[1]))) {
                                $text = "Pilih Poliklinik tujuan :";
                                $kliniks = $this->mod_reservasi->getklinik(false, 1);
                                foreach ($kliniks as $klinik) {
                                    $pilihan[]= ['text'=>"$klinik->nama_klinik", 'callback_data'=>"klinik ".$klinik->id_klinik];
                                }
                                $inkeyboard = [$pilihan];
                                
                            } else {
                                $text = "Pilih jenis jaminan :";    
                                $inkeyboard = [
                                    [
                                        ['text' => 'Umum', 'callback_data' => 'jaminan 2'],
                                        ['text' => 'JKN', 'callback_data' => 'jaminan 5'],
                                        ['text' => 'IKS', 'callback_data' => 'jaminan 7'],
                                    ],                                    
                                ];
                            }
                            break;
                            
                        case 'layanan':
                            $pesan = explode(' ', $pesan);
                            if ($pesan[0]=='layanan' && $pesan[1] == '1' && $this->mod_telebot->updteleres($chatid,array('jnslayan_id'=>(int)$pesan[1],'status'=>'klinik'))){
                                $text = "Pilih Poliklinik tujuan :";
                                $kliniks = $this->mod_reservasi->getklinik(false, 1);
                                foreach ($kliniks as $klinik) {
                                    $pilihan[]= ['text'=>"$klinik->nama_klinik", 'callback_data'=>"klinik ".$klinik->id_klinik];
                                }
                                $inkeyboard = [$pilihan];
                            } else if ($pesan[0]=='layanan' && $pesan[1] == '2' && $this->mod_telebot->updteleres($chatid,array('jnslayan_id'=>(int)$pesan[1],'status'=>'dokter'))){
                                $text = "Pilih dokter :";
                                $dokters = $this->mod_reservasi->getdokter(2);
                                foreach ($dokters as $dokter) {
                                    $pilihan[]= ['text'=>"$dokter->nama_dokter", 'callback_data'=>"dokter ".$dokter->id_dokter];
                                }
                                $inkeyboard = [$pilihan];
                            } else {
                                $text = "Pilih jenis layanan :";
                                $inkeyboard = [
                                    [
                                        ['text' => 'Reguler', 'callback_data' => 'layanan 1'],
                                        ['text' => 'Eksekutif', 'callback_data' => 'layanan 2'],
                                    ],                                    
                                ];
                            }
                            break;
                            
                        case 'dokter':
                            $pesan = explode(' ', $pesan);
                            $dokters = $this->mod_reservasi->getdokter(2);
                            foreach ($dokters as $dokter) {
                                if ($dokter->id_dokter == $pesan[1]){
                                    $valid = TRUE;
                                } 
                            }
                            if ($valid && $pesan[0]==dokter && $this->mod_telebot->updteleres($chatid,array('dokter_id'=>(int)$pesan[1],'status'=>'klinik'))){
                                $text = "Pilih Poliklinik tujuan :";
                                $kliniks = $this->mod_reservasi->getklinik($pesan[1], 2);
                                foreach ($kliniks as $klinik) {
                                    $pilihan[]= ['text'=>$klinik->nama_klinik, 'callback_data'=>"klinik ".$klinik->id_klinik];
                                }
                                $inkeyboard = [$pilihan];
                            }
                            break;
                            
                        case 'klinik':
                            $pesan = explode(' ', $pesan);
                            $jnslayan=$dataResTele->jnslayan_id;
                            if ($jnslayan == 1){
                                $iddokter = 0;
                            } else {
                                $iddokter = $dataResTele->dokter_id;
                            }
                            $jadwal=$this->mod_reservasi->getjadwal($pesan[1],$iddokter,$jnslayan);
                            if ($pesan[0]=='klinik' && $jadwal){
                                if ($this->mod_telebot->updteleres($chatid,array('klinik_id'=>(int)$pesan[1],'status'=>'tglres'))){
                                    $tgls=$this->mod_reservasi->cekjadawal($pesan[1], $iddokter, $jnslayan);
                                    $i=$x=0;
                                    foreach ($tgls as $tgl) {
                                        $pilihan[$i][]=['text'=>$tgl['hari']." ".$tgl['jadwaltgl'],'callback_data'=>"tgl".$tgl['jadwaltgl']];
                                        if($x%2==0)$i++;
                                        $x++;
                                    }
                                    $text="Siliahkan pilih tanggal Reservasi :";
                                    $inkeyboard = $pilihan;
                                }
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