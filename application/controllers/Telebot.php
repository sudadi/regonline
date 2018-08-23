<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Telebot extends CI_Controller
{
    public $dataResTele;


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
        
        $pesan = explode("|", $data);
        if ($pesan){
            $text = $pesan[0].' : *'.$pesan[2].'*';
            $this->telebot_lib->editMessageText($chatid, $message_id, $text, null, false);
        }
        $messageupdate = $message['message'];
        $messageupdate['text'] = $data;

        $this->prosesPesanTeks($messageupdate);
    }
    
    private function keyklinik($iddokter,$jenis) {
        $kliniks = $this->mod_reservasi->getklinik($iddokter, $jenis);
        foreach ($kliniks as $klinik) {
            $pilihan[][]= ['text'=>"$klinik->nama_klinik", 'callback_data'=>"Klinik|".$klinik->id_klinik."|".$klinik->nama_klinik];
            
        }
        return $pilihan;
    }


    private function casenorm($chatid, $pesan) {
        if($this->mod_reservasi->cekdatpas("norm='".$pesan."'") && 
        $this->mod_telebot->updteleres($chatid,array('status'=>'ttl','norm'=>$pesan))){
            $text = "Mohon masukkan Tgl. lahir Anda dd-mm-yyyy\n(ct. 21-06-1978) :";                        
        } else {
            $text = "Nomor Rekam Medis (No.RM) tidak ditemukan(salah)!\n"
                    . "Mohon masukkan No.RM yang benar :";
        }
        return $text;
    }
    
    private function casettl($chatid, $pesan, $text=null) {
        if ($tgl=date('Y/m/d', strtotime($pesan))){
                $datPas = $this->mod_reservasi->cekdatpas("norm='".$this->dataResTele->norm."' and tgl_lahir='".$tgl."'");
            }
        if($text || ($datPas && $this->mod_telebot->updteleres($chatid,array('ttl'=>"$tgl",'status'=>'jaminan')))){
            if (!$text){
                $text = "Selamat datang *{$datPas->nama}* \n\n";
                $this->telebot_lib->sendApiMsg($chatid, $text, false, 'Markdown');
                
                $text="Pilih jenis jaminan :";
            }    
            $inkeyboard = [
                [
                    ['text' => 'Umum', 'callback_data' => 'Jaminan|2|Umum'],
                    ['text' => 'JKN', 'callback_data' => 'Jaminan|5|JKN'],
                    ['text' => 'IKS', 'callback_data' => 'Jaminan|7|IKS'],
                ],                                    
            ];
        } else {
            $text = "Tanggal lahir tidak sesuai (salah)!\n"
                    . "Mohon masukkan tanggal yang benar :";
        }
        return array($text, $inkeyboard);
    }
    
    private function casejaminan($chatid, $pesan, $text=null) {
        $pesan = explode('|', $pesan);
        if ($pesan[0]=='Jaminan' && ($pesan[1] == '2' || $pesan[1] == '7') && ($text ||$this->mod_telebot->updteleres($chatid,array('status'=>'layanan','jaminan_id'=>$pesan[1])))){                            
            if(!$text) $text = "Pilih jenis layanan :";
            $inkeyboard = [
                [
                    ['text' => 'Reguler', 'callback_data' => 'Layanan|1|Reguler'],
                    ['text' => 'Eksekutif', 'callback_data' => 'Layanan|2|Eksekutif'],
                ],                                    
            ];
        } else if ($pesan[0] == 'Jaminan' && $pesan[1] == '5' && ($text || $this->mod_telebot->updteleres($chatid,array('status'=>'klinik','jnslayan_id'=>1,'jaminan_id'=>(int)$pesan[1])))) {
            if(!$text) $text = "Pilih Poliklinik tujuan :";
            $inkeyboard = $this->keyklinik(FALSE, 1);

        } else {
            $text = "*Pilihan Salah!*\n\n"
                    . "Pilih jenis jaminan berikut:";    
            list($text, $inkeyboard)=$this->casettl($chatid, $this->dataResTele->ttl, $text);
        }
        return array($text, $inkeyboard);
    }
    
    private function caselayanan($chatid, $pesan, $text=null) {
        $pesan = explode('|', $pesan);
        if ($pesan[0]=='Layanan' && $pesan[1] == '1' && ($text || $this->mod_telebot->updteleres($chatid,array('jnslayan_id'=>(int)$pesan[1],'status'=>'klinik')))){
            if (!$text) $text = "Pilih Poliklinik tujuan :";
            $inkeyboard = $this->keyklinik(FALSE, 1);
        } else if ($pesan[0]=='Layanan' && $pesan[1] == '2' && ($text || $this->mod_telebot->updteleres($chatid,array('jnslayan_id'=>(int)$pesan[1],'status'=>'dokter')))){
            if (!$text) $text = "Pilih dokter :";
            $dokters = $this->mod_reservasi->getdokter(2);
            foreach ($dokters as $dokter) {
                $pilihan[]= ['text'=>"$dokter->nama_dokter", 'callback_data'=>"Dokter|".$dokter->id_dokter."|".$dokter->nama_dokter];
            }
            $inkeyboard = [$pilihan];
        } else {
            $text = "*Pilihan Salah!*\n\n"
                    ."Pilih jenis layanan berikut :";
            list($text, $inkeyboard)= $this->casejaminan($chatid, 'Jaminan|'.$this->dataResTele->jaminan_id, $text);
            
        }
        return array($text, $inkeyboard);
    }
    
    private function casedokter($chatid, $pesan, $text=null) {
        $pesan = explode('|', $pesan);
        $dokters = $this->mod_reservasi->getdokter(2);
        foreach ($dokters as $dokter) {
            if ($dokter->id_dokter == $pesan[1]){
                $valid = TRUE;
            } 
        }
        if ($valid && $pesan[0]=='Dokter' && ($text || $this->mod_telebot->updteleres($chatid,array('dokter_id'=>(int)$pesan[1],'status'=>'klinik')))){
            if (!$text) $text = "Pilih Poliklinik tujuan :";
            $inkeyboard = $this->keyklinik($pesan[1], 2);
        } else {
            $text = "*Pilihan Salah!*\n\n"
                    ."Pilih Dokter berikut :";
            list($text, $inkeyboard)= $this->caselayanan($chatid, 'Layanan|'.$this->dataResTele->jnslayan_id, $text);
        }
        return array($text, $inkeyboard);
    }
    
    private function caseklinik($chatid, $pesan, $text=null) {
        $pesan = explode('|', $pesan);
        $jnslayan=$this->dataResTele->jnslayan_id;
        if ($jnslayan == 1){
            //$iddokter = 0;
        } else {
            $iddokter = $this->dataResTele->dokter_id;
        }
        $jadwal=$this->mod_reservasi->getjadwal($pesan[1],$iddokter,$jnslayan);
        if ($pesan[0]=='Klinik' && $jadwal){
            if ($this->mod_telebot->updteleres($chatid,array('klinik_id'=>(int)$pesan[1],'status'=>'tglres'))){
                $tgls=$this->mod_reservasi->cekjadawal($pesan[1], $iddokter, $jnslayan);
                $i=$x=0;
                foreach ($tgls as $tgl) {
                    $pilihan[$i][]=['text'=>$tgl['hari']." ".$tgl['jadwaltgl'],'callback_data'=>"Tanggal|".$tgl['jadwaltgl']."|".$tgl['hari']." ".$tgl['jadwaltgl']];
                    if($x%2==0)$i++;
                    $x++;
                }
                $text="Siliahkan pilih tanggal Reservasi :";
                $inkeyboard = $pilihan;
            }
        } else {
            $text = "*Pilihan yang Anda masukkan Salah!*\n\n"
                    . "Silahkan pilih Poliklinik yang akan dituju :";
            if($iddokter){
                list($text, $inkeyboard)= $this->casedokter($chatid, "Dokter|".$iddokter, $text);
            } else if($jnslayan == 1){
                list($text, $inkeyboard)= $this->caselayanan($chatid, "Layanan|".$jnslayan, $text);                
            } else {
                list($text, $inkeyboard)= $this->casejaminan($chatid, "Jaminan|5", $text);
            }
        }
        return array($text, $inkeyboard);
    }
    
    private function casetgl($chatid, $pesan, $text=null) {
        $pesan = explode('|', $pesan);
        
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
                $this->dataResTele= $this->mod_telebot->getrowteleres("fromid=$chatid");
                if ($this->dataResTele) {
                    $status = $this->dataResTele->status;
                    switch ($status) {
                        case 'norm':
                            $text=$this->casenorm($chatid,$pesan);
                            break;
                            
                        case 'ttl':
                            list($text, $inkeyboard)= $this->casettl($chatid, $pesan);
                            break;
                            
                        case 'jaminan':
                            list($text, $inkeyboard)= $this->casejaminan($chatid, $pesan);
                            break;
                            
                        case 'layanan':
                            list($text, $inkeyboard)= $this->caselayanan($chatid, $pesan);
                            break;
                            
                        case 'dokter':
                            list($text, $inkeyboard)= $this->casedokter($chatid, $pesan);
                            break;
                            
                        case 'klinik':
                            list($text, $inkeyboard)= $this->caseklinik($chatid, $pesan);
                            break;
                            
                        case 'tgl':
                            
                            $pesan = explode(' ', $pesan);
                            if ($pesan[0]=='Tanggal');
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