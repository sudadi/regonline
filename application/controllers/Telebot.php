<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Telebot extends CI_Controller
{
    private $dataResTele;
    private $erropt = array("*Maaf Anda tidak memilih dari opsi yang disediakan!*\n\n",
        "*Pilihan Salah!*\n\n", "*Oops Salah!* Cukup klik dari opsi yang ada.\n\n",
        "*Salah!* Mohon lakukan sesuai instruksi.\n\n", "*Maaf Anda tidak melakukan sesuai instruksi!* \n\n");

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
            $text = "*Nomor Rekam Medis (No.RM) tidak ditemukan(salah)!*\n\n"
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
            $text = "*Tanggal lahir tidak sesuai (salah)!*\n\n"
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
            $text = $this->erropt[rand(0,5)]. "Pilih jenis jaminan berikut:";    
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
            $text = $this->erropt[rand(0,5)]."Pilih jenis layanan berikut :";
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
            $text = $this->erropt[rand(0,5)]."Pilih Dokter berikut :";
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
            if ($text || $this->mod_telebot->updteleres($chatid,array('klinik_id'=>(int)$pesan[1],'status'=>'tglres'))){
                $tgls=$this->mod_reservasi->cekjadawal($pesan[1], $iddokter, $jnslayan);
                $i=$x=0;
                foreach ($tgls as $tgl) {
                    $pilihan[$i][]=['text'=>$tgl['hari']." ".$tgl['jadwaltgl'],'callback_data'=>"Tanggal|".$tgl['jadwaltgl']."|".$tgl['hari']." ".$tgl['jadwaltgl']."|".$tgl['idjadwal']];
                    if($x%2==0)$i++;
                    $x++;
                }
                if(!$text) $text="Siliahkan pilih tanggal Reservasi :";
                $inkeyboard = $pilihan;
            }
        } else {
            $text = $this->erropt[rand(0,5)]. "Silahkan pilih Poliklinik yang akan dituju :";
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
    
    private function casetglres($chatid, $pesan, $text=null) {
        $pesan = explode('|', $pesan);
        $jams=$this->mod_reservasi->getjamcekin($pesan[3], $pesan[1]);
        if ($jams && ($text || $this->mod_telebot->updteleres($chatid,array('tgl_res'=>$pesan[1],'jadwal_id'=>$pesan[3],'status'=>'jam')))){
            $i=0;
            foreach ($jams as $key=>$jam) {
                if ($jam['sisa']>0){
                    $pilihan[$i][]=['text'=>$jam['jam']." (".$jam['sisa'].")", 'callback_data'=>"Jam|".$jam['idjam']."|".$jam['jam']];
                    if ($key%2==0)$i++;
                }
            }
            if (!$text)$text = "Silahkan pilih Jam kunjungan :";
            $inkeyboard = $pilihan;
        } else {
            $text = $this->erropt[rand(0,5)]. "Silahkan pilih Poliklinik yang akan dituju :";
            list($text, $inkeyboard)= $this->caseklinik($chatid, "Klinik|".$this->dataResTele->klinik_id, $text);
        }
        return array($text, $inkeyboard);
    }
    
    private function casejam($chatid, $pesan, $text=null) {
        $pesan = explode('|', $pesan);
        //var_dump($pesan);
        $jams= $this->mod_reservasi->getjamcekin($this->dataResTele->jadwal_id, $this->dataResTele->tgl_res);
        $cekinjam = array_search($pesan[1], array_column($jams, 'idjam'));
        var_dump($jams);
        if (($cekinjam || $cekinjam===0) && ($this->mod_telebot->updteleres($chatid,array('jam_id'=>$pesan[1],'status'=>'Sukses')))){
            $text="*Selamat Reservasi Anda Berhasil!*";
        } else {
            $text = $this->erropt[rand(0,5)]. "Siliahkan pilih Jam Reservasi :";
            list($text, $inkeyboard) = $this->casetglres($chatid, "Tanggal|".$this->dataResTele->tgl_res."|xxx|".$this->dataResTele->jadwal_id, $text);
        }
        return array($text, $inkeyboard);
    }
    
    private function showres($param) {
        
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
        $this->dataResTele= $this->mod_telebot->getrowteleres("fromid=$chatid");
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
                if($this->dataResTele){
                    if ($this->dataResTele->tgl_res >= date() && $this->dataResTele->status=='Sukses'){
                        $this->showres($param);
                    } else if ($this->dataResTele->status!=='ttl' || $this->dataResTele->status!=='norm'){
                        $this->mod_telebot->updteleres($chatid,array('status'=>'ttl','jadwal_id'=>null,'jam_id'=>null,'tgl_res'=>null,
                            'klinik_id'=>null,'dokter_id'=>null,'jnslayan_id'=>null,'jaminan_id'=>null));
                        list($text, $inkeyboard)=$this->casettl($chatid, $this->dataResTele->ttl);
                    } else {
                        $text = "Silahkan masukkan No. Rekam Medis (NoRM) Anda :";
                    }
                }else {
                    $this->mod_telebot->newteleres($chatid);
                    $text = "Silahkan masukkan No. Rekam Medis (NoRM) Anda :";
                }
                $this->telebot_lib->sendApiAction($chatid);
                $inkeyboard 
                        ? $this->telebot_lib->sendApiKeyboard($chatid, $text, $inkeyboard, true)
                        : $this->telebot_lib->sendApiMsg($chatid, $text, false, 'Markdown');
                break;
                
            case $pesan == '/batal':
                $text ="Yakin akan membatalkan proses reservasi ini.? \n"
                    . "Ketik 'Ya yakin batal' jika Anda yakin.\n";
                $this->telebot_lib->sendApiAction($chatid);
                $this->telebot_lib->sendApiMsg($chatid, $text, false, 'Markdown');
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
                            
                        case 'tglres':
                            list($text, $inkeyboard)= $this->casetglres($chatid, $pesan);
                            break;
                        
                        case 'jam':
                            list($text, $inkeyboard)= $this->casejam($chatid, $pesan);
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
                    $this->telebot_lib->sendApiMsg($chatid, $text, false, 'Markdown');
                }
                break;
        }
    }

}