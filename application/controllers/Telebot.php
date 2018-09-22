<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Telebot extends CI_Controller
{
    private $hari_ID = array (1=>'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
    private $dataResTele;
    private $erropt = array("*Maaf Anda tidak memilih dari opsi yang disediakan!*\n\n",
        "*Pilihan Salah!*\n\n", "*Oops Salah!* Cukup klik dari opsi yang ada.\n\n",
        "*Salah!* Mohon lakukan sesuai instruksi.\n\n", "*Maaf Anda tidak melakukan sesuai instruksi!* \n\n");
    
    private function greeting()
    {
        $jam = date("G",time());
        if ($jam < 10 ) {$waktu = "Pagi";}
        elseif($jam < 15 ) {$waktu = "Siang";}
        elseif($jam < 18 ) {$waktu = "Sore";}
        else {$waktu = "Malam";}
        return $waktu;
    }

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('telebot_lib'));
    }
    
    public function bothook() {
        $entityBody = file_get_contents('php://input');
        $message = json_decode($entityBody, true);
        $this->prosesApiMessage($message);
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
            
            sleep(1);
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
            } elseif (isset ($message['photo'])){
                $this->prosesFile($message);
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
            $text = $pesan[0];
            $this->telebot_lib->editMessageText($chatid, $message_id, $text, null, false);
        }
        $messageupdate = $message['message'];
        $messageupdate['text'] = $data;

        $this->prosesPesanTeks($messageupdate);
    }
    
    private function keyklinik($iddokter,$jenis) {
        $kliniks = $this->mod_reservasi->getklinik("jns_layan_id ={$jenis}");
        foreach ($kliniks as $klinik) {
            $pilihan[][]= ['text'=>"$klinik->nama_klinik", 'callback_data'=>"Klinik : *".$klinik->nama_klinik."*|".$klinik->id_klinik];
            
        }
        return $pilihan;
    }


    private function casenorm($chatid, $pesan) {
        if($this->mod_reservasi->cekdatpas("norm='".$pesan."'") && 
        $this->mod_telebot->updteleres($chatid,array('status'=>'ttl','norm'=>$pesan))){
            $text = "Mohon masukkan Tgl. lahir Anda\n(dd-mm-yyyy) ct. 01-06-1978 atau 21.06.1978 :";                        
        } else {
            $text = "*Nomor Rekam Medis (No.RM) tidak ditemukan(salah)!*\n\n"
                    . "Mohon masukkan No.RM yang benar :";
        }
        return $text;
    }
    
    private function casettl($chatid, $pesan, $text=null) {
        $inkeyboard = FALSE;
        if ($tgl=date('Y/m/d', strtotime($pesan))){
            $datPas = $this->mod_reservasi->cekdatpas("norm='".$this->dataResTele->norm."' and tgl_lahir='".$tgl."'");
            if($datPas) $this->mod_telebot->updteleres($chatid, ['ttl'=>"$tgl",'status'=>'jaminan']);            
        }
        if ($datPas && $this->mod_reservasi->cekreserv($datPas->norm, 1)){
            $text = "Selamat {$this->greeting()} *{$datPas->nama}* \n\n"
                . "Maaf, Anda sudah melakukan reservasi.";
            $this->telebot_lib->sendApiMsg($chatid, $text, false, 'Markdown');
            $text = $this->showres();        
        } else if($text || $datPas){
            if (!$text){
                $text = "Selamat {$this->greeting()} *{$datPas->nama}* \n\n"
                . "ID Telegram anda sudah terdaftar di Bot Reservasi RSOS, "
                . "lanjutkan langkah berikutnya!";
                $this->telebot_lib->sendApiMsg($chatid, $text, false, 'Markdown');
                
                $text="Pilih jenis jaminan / cara bayar :";
            }    
            $inkeyboard = [
                [
                    ['text' => 'Umum', 'callback_data' => 'Jaminan : *Umum*|2'],
                    ['text' => 'JKN', 'callback_data' => 'Jaminan : *JKN*|5'],
                    ['text' => 'IKS', 'callback_data' => 'Jaminan : *IKS*|7'],
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
        if (($pesan[1] == '2' || $pesan[1] == '7') && ($text ||$this->mod_telebot->updteleres($chatid,array('status'=>'layanan','jaminan_id'=>$pesan[1])))){                            
            if(!$text) $text = "Pilih jenis layanan :";
            $inkeyboard = [
                [
                    ['text' => 'Reguler', 'callback_data' => 'Layanan : *Reguler*|1'],
                    ['text' => 'Eksekutif', 'callback_data' => 'Layanan : *Eksekutif*|2'],
                ],                                    
            ];
        } else if ($pesan[1] == '5' && ($text || $this->mod_telebot->updteleres($chatid,array('status'=>'klinik','jnslayan_id'=>1,'jaminan_id'=>(int)$pesan[1])))) {
            if(!$text) $text = "Pilih Poliklinik tujuan :";
            $inkeyboard = $this->keyklinik(FALSE, 1);

        } else {
            $text = $this->erropt[rand(0,5)]. "Pilih jenis jaminan/cara bayar berikut:";    
            list($text, $inkeyboard)=$this->casettl($chatid, $this->dataResTele->ttl, $text);
        }
        return array($text, $inkeyboard);
    }
    
    private function caselayanan($chatid, $pesan, $text=null) {
        $pesan = explode('|', $pesan);
        if ($pesan && ($text || $this->mod_telebot->updteleres($chatid,array('jnslayan_id'=>(int)$pesan[1],'status'=>'klinik')))){
            if (!$text) $text = "Pilih Poliklinik tujuan :";
            $inkeyboard = $this->keyklinik(FALSE, (int)$pesan[1]);        
        } else {
            $text = $this->erropt[rand(0,5)]."Pilih jenis layanan berikut :";
            list($text, $inkeyboard)= $this->casejaminan($chatid, 'Jaminan :|'.$this->dataResTele->jaminan_id, $text);
            
        }
        return array($text, $inkeyboard);
    }    
    
    private function caseklinik($chatid, $pesan, $text=null) {
        $pesan = explode('|', $pesan);
        $jnslayan=$this->dataResTele->jnslayan_id;
        if ($text || $this->mod_telebot->updteleres($chatid,array('klinik_id'=>(int)$pesan[1],'status'=>'dokter'))){
            if (!$text) $text = "Pilih dokter :";
            $dokters = $this->mod_reservasi->getdokter("jns_layan_id={$jnslayan} and klinik_id={$pesan[1]}");
            $i=0;
            foreach ($dokters as $key=>$dokter) {
                if ($key && $key%2==0)$i++;
                $pilihan[$i][]= ['text'=>"$dokter->nama_dokter", 'callback_data'=>"Dokter : *".$dokter->nama_dokter."*|".$dokter->id_dokter];
                
            }
            $inkeyboard = $pilihan;
        } else {
            $text = $this->erropt[rand(0,5)]. "Silahkan pilih Poliklinik yang akan dituju :";
            if($jnslayan == 1){
                list($text, $inkeyboard)= $this->caselayanan($chatid, "Layanan|".$jnslayan, $text);                
            } else {
                list($text, $inkeyboard)= $this->casejaminan($chatid, "Jaminan|5", $text);
            }
        }
        return array($text, $inkeyboard);
    }
    
    private function casedokter($chatid, $pesan, $text=null) {
        $pesan = explode('|', $pesan);
        $klinik=$this->dataResTele->klinik_id;
        $jnslayan = $this->dataResTele->jnslayan_id;
        if ($pesan) {$jadwal=$this->mod_reservasi->getjadwal($klinik,$pesan[1],$jnslayan);}
        if ($jadwal && ($text || $this->mod_telebot->updteleres($chatid,array('dokter_id'=>(int)$pesan[1],'status'=>'tglres')))){
            
                $tgls=$this->mod_reservasi->cekjadawal($klinik, $pesan[1], $jnslayan);
                $i=0;
                foreach ($tgls as $key=>$tgl) {
                    $pilihan[$i][]=['text'=>$tgl['hari']." ".$tgl['jadwaltgl'],'callback_data'=>"Tanggal : *".$tgl['hari']." ".$tgl['jadwaltgl']."*|".$tgl['jadwaltgl']."|".$tgl['idjadwal']];
                    if($key%2==0) $i++;
                }
                if(!$text) $text="Siliahkan pilih tanggal Reservasi :";
                $inkeyboard = $pilihan;
            
        } else {
            $text = $this->erropt[rand(0,5)]."Pilih Dokter berikut :";
            list($text, $inkeyboard)= $this->caseklinik($chatid, "Klinik|".$this->dataResTele->klinik_id, $text);
        }
        return array($text, $inkeyboard);
    }
    
    private function casetglres($chatid, $pesan, $text=null) {
        $pesan = explode('|', $pesan);
        $jams=$this->mod_reservasi->getjamcekin($pesan[2], $pesan[1]);
        if ($jams && ($text || $this->mod_telebot->updteleres($chatid,array('tgl_res'=>$pesan[1],'jadwal_id'=>$pesan[2],'status'=>'jam')))){
            $i=0;
            foreach ($jams as $key=>$jam) {
                if ($jam['sisa']>0){
                    if ($key && $key%2==0)$i++;
                    $pilihan[$i][]=['text'=>$jam['jam']." (".$jam['sisa'].")", 'callback_data'=>"Jam : *".$jam['jam']."*|".$jam['idjam']];
                }
            }
            if (!$text)$text = "Silahkan pilih Jam kunjungan :";
            $inkeyboard = $pilihan;
        } else {
            $text = $this->erropt[rand(0,5)]. "Silahkan pilih Tanggal rencana pemeriksaan :";
            list($text, $inkeyboard)= $this->casedokter($chatid, "Dokter|".$iddokter, $text);
        }
        return array($text, $inkeyboard);
    }
    
    private function casejam($chatid, $pesan, $text=null) {
        $pesan = explode('|', $pesan);
        $inkeyboard=false;
        $jams= $this->mod_reservasi->getjamcekin($this->dataResTele->jadwal_id, $this->dataResTele->tgl_res);
        $cekinjam = array_search($pesan[1], array_column($jams, 'idjam'));
        //var_dump($jams);
        if (($cekinjam || $cekinjam===0) && ($this->mod_telebot->updteleres($chatid,array('jam_id'=>$pesan[1],'status'=>'sukses')))){
            if ($this->mod_telebot->saveresbot($chatid)){
                $text="*Selamat Reservasi Anda Berhasil!*";
                $this->telebot_lib->sendApiMsg($chatid, $text, false, 'Markdown');
                $text = $this->showres();
            } else {
                $text="Reservasi *GAGAL*, Server bermassalah.";
            }
        } else {
            $text = $this->erropt[rand(0,5)]. "Siliahkan pilih Jam kunjungan :";
            list($text, $inkeyboard) = $this->casetglres($chatid, "Tanggal|".$this->dataResTele->tgl_res."|".$this->dataResTele->jadwal_id, $text);
        }
        return array($text, $inkeyboard);
    }

    public function showres() {
        $norm= $this->dataResTele->norm;
        $result = $this->mod_reservasi->getresfull("status=1 and norm=$norm");
        $hari = $this->hari_ID[date("N", strtotime($result[0]->waktu_rsv))];
        $text = "*Berikut Data Reservasi Anda*\n\n"
                . "Nama  : \n*{$result[0]->nama}*\n"
                . "Jaminan : \n*{$result[0]->nama_jaminan}*\n"
                . "Layanan : \n*{$result[0]->jns_layan}*\n"
                . "Dokter  : \n*".$result[0]->nama_dokter."*\n"
                . "Klinik  : \n*{$result[0]->nama_klinik}*\n"
                . "Tanggal : \n*".$hari." ".date('d-m-Y', strtotime($result[0]->waktu_rsv))."*\n"
                . "Jam     : \n*".date('H:i:s', strtotime($result[0]->waktu_rsv))."*\n\n"
                . "*Mohon datang tepat waktu sesuai jadwal yang sudah ditentukan.*\n"
                . "Terima Kasih";
        $this->mod_telebot->updteleres($this->dataResTele->fromid, ['statmenu'=>'']);
        $this->load->library('ciqrcode');
        $namafile=$this->session->userdata('norm').$result[0]->nores.".png";
        $params['data'] = $this->session->userdata('norm').' '.$result[0]->nores;
        $params['level'] = 'H';
        $params['size'] = 15;
        $params['savename'] = FCPATH."/qrcode/".$namafile;
        $this->ciqrcode->generate($params);
        $this->telebot_lib->sendApiFile($this->dataResTele->fromid, $namafile, 'photo');
        return $text;
    }

    private function prosesPesanTeks($message)
    {
        // if ($GLOBALS['debug']) mypre($message);
        $this->load->model('mod_telebot');
        $this->load->model('mod_reservasi');
        $pesan = trim($message['text']);
        $chatid = $message['chat']['id'];
        $fromid = $message['from']['id'];
        $inkeyboard = $video = $photo = $text = FALSE;
        $this->telebot_lib->sendApiAction($chatid);
        $this->dataResTele= $this->mod_telebot->getrowteleres("fromid=$chatid");
        switch (true) {

            case $pesan == '/start' :
                $text = "Selamat Datang di bot RESERVASI Layanan Pasien\n"
                ."*RS Ortopedi Prof.DR.R. Soeharso Surakarta*\n";
                $this->telebot_lib->sendApiMsg($chatid, $text, false, 'Markdown');
                $keyboard = [
                    ['/reservasi'],
                    ['/ketentuan', '/bantuan'],
                ];
                $msg = "Silahkan ketik atau klik\n"
                        . "/reservasi - mulai/mengulang proses reservasi.\n"
                        . "/ketentuan - melihat syarat & ketentuan.\n"
                        . "/bantuan - petunjuk melakukan reservasi.\n"
                        . "/id - untuk mengetahui id telegram Anda.\n"
                        . "/menu - menampilkan tombol menu(keyboard).\n"
                        . "/hidemenu - menutup tombol menu(keyboard).\n"
                        . "/hapusdata - menghapus id & data yg terdaftar di Bot Reservasi RSO.\n"
                        . "/start - menampilkan menu ini.";
                $this->telebot_lib->sendApiKeyboard($chatid, $msg, $keyboard);
                break;

            case $pesan=='/reservasi' : 
                if ($this->dataResTele && $this->dataResTele->status=='sukses' && $this->dataResTele->tgl_res > date('Y-m-d')){
                    $datPas = $this->mod_reservasi->cekdatpas("norm='".$this->dataResTele->norm."'");
                    $text = "Selamat {$this->greeting()} *{$datPas->nama}* \n\n"
                        . "Maaf, Anda sudah melakukan reservasi.";
                    $this->telebot_lib->sendApiMsg($chatid, $text, false, 'Markdown');
                    $text = $this->showres();
                }else if ($this->dataResTele && ($this->dataResTele->status!=='ttl' && $this->dataResTele->status!=='norm')){
                    $this->mod_telebot->updteleres($chatid,['status'=>'ttl','jadwal_id'=>null,'jam_id'=>null,'tgl_res'=>null,
                        'klinik_id'=>null,'dokter_id'=>null,'jnslayan_id'=>null,'jaminan_id'=>null]);
                    list($text, $inkeyboard)=$this->casettl($chatid, $this->dataResTele->ttl);
                }else {
                    if($this->dataResTele) $this->mod_telebot->delteleres($chatid);
                    $this->mod_telebot->newteleres($chatid);
                    $text = "Silahkan masukkan No. Rekam Medis (NoRM) Anda :";
                }
                $this->mod_telebot->updteleres($chatid, ['statmenu'=>'reservasi']);
                break;
                
            case $pesan=='/ketentuan':
                $text ="*Berikut Syarat & Ketentuan RESERVASI Online*\n"
                    . "1. Satu id Telegram hanya untuk reservasi satu Pasien.\n"
                    . "2. Reservasi tidak bisa dilakukan lebih dari sekali.\n"
                    . "3. Reservasi minimal 2 hari dan maksmal 2 minggu sebelum kunjungan.\n"
                    . "4. Kuota hanya berlaku di Reservasi Online.\n"
                    . "5. Jika kuota sudah tidak tersedia silahkan datang langsung (Registrasi On Site).";
                $this->mod_telebot->updteleres($chatid, ['statmenu'=>'ketentuan']);
                break;
            
            case $pesan=='/bantuan':
                $text = "Bantuan tersedia :";
                $inkeyboard = [
                    [
                        ['text' => 'Video Tutorial', 'callback_data' => 'Bantuan : Video turorial|!video'],                        
                    ],
                    [
                        ['text' => 'Jadwal Dokter', 'callback_data' => 'Bantuan : Jadwal dokter|!jadwal'],
                    ]
                ];    
                $this->mod_telebot->updteleres($chatid, ['statmenu'=>'bantuan']);
                break;
            
            case $pesan=='!video' :
                $video = "BAADBQADgAAD8MAIVeNbOzh8Y15cAg";
                break;
            
            case $pesan=='!jadwal' :
                
                break;
                
            case $pesan == '/hapusdata':
                $text ="Yakin akan menghapus data dan membatalkan proses reservasi ? \n";
                $inkeyboard = [
                    [
                        ['text'=>"Ya Yakin", 'callback_data'=>"Batal : *Ya*|Ya yakin Batal"],
                        ['text'=>"Tidak", 'callback_data'=>"Batal : *Tidak*|Tidak jadi Batal"],
                    ]
                ];
                $this->mod_telebot->updteleres($chatid, ['statmenu'=>'hapusdata']);
                break;
            
            case explode('|',$pesan)[1]=='Ya yakin Batal':
                if ($this->dataResTele->statmenu=='hapusdata' &&  $this->mod_telebot->delteleres($chatid)){              
                    $text="Proses reservasi sudah di batalkan.\n\n"
                        . "Silahkan Klik atau Ketik\n"
                        . "/reservasi untuk mulai reservasi";               
                } else {
                	$text= "Maaf data reservasi tidak ditemukan.";
                }
                $this->mod_telebot->updteleres($chatid, ['statmenu'=>'']);
                break;
            
            case $pesan == '/id':
                $text = 'ID Anda adalah: '.$fromid;
                $this->mod_telebot->updteleres($chatid, ['statmenu'=>'id']);
                break;

            case $pesan == '/menu':
                $keyboard = [
                    ['/reservasi'],
                    ['/ketentuan', '/bantuan'],
                    
                ];
                $this->telebot_lib->sendApiKeyboard($chatid, 'Menu on', $keyboard);
                $this->mod_telebot->updteleres($chatid, ['statmenu'=>'menu']);
                break;
            
            case $pesan == '/hidemenu':
                $this->telebot_lib->sendApiHideKeyboard($chatid, 'Menu off');
                break;
                
            default:
                if ($this->dataResTele && $this->dataResTele->statmenu == 'reservasi') {
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
                            $text = "Maaf, kami tidak mengerti maksud yang Anda sampaikan.";
                            break;
                    }
                } else if (explode ('|', $pesan)[1]=='!video'){
                    $video = "BAADBQADgAAD8MAIVeNbOzh8Y15cAg";
                } else { 
                    $text = "Maaf, kami tidak mengerti maksud yang Anda sampaikan.";                    
                }
                break;
        }
        if ($inkeyboard){
            $this->telebot_lib->sendApiKeyboard($chatid, $text, $inkeyboard, true);
        } else if ($video) {            
            $this->telebot_lib->sendApiVideo($chatid, $video);
        } else if ($photo) {            
            $this->telebot_lib->sendApiPhoto($chatid, $photo);
        } else {
            $this->telebot_lib->sendApiMsg($chatid, $text, false, 'Markdown');
        }
    }
    
    private function prosesFile($message) {
        
    }

}
