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

        $text = '*'.date('H:i:s').'* data baru : '.$data;

        $this->telebot_lib->editMessageText($chatid, $message_id, $text, $inkeyboard, true);

        $messageupdate = $message['message'];
        $messageupdate['text'] = $data;

        $this->prosesPesanTeks($messageupdate);
    }


    private function prosesPesanTeks($message)
    {
        // if ($GLOBALS['debug']) mypre($message);
        $this->load->model('mod_telebot');
        $pesan = $message['text'];
        $chatid = $message['chat']['id'];
        $fromid = $message['from']['id'];
        $dataResTele= $this->mod_telebot->getrestele("fromid=$fromid");
        if ($dataResTele) {
            
        } else {
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
                    $this->telebot_lib->sendApiAction($chatid);
                    $text = "Mohon masukkan No. Rekam Medis (NoRM) Anda :";
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
                    $this->telebot_lib->sendApiAction($chatid);
                    $text = "Maaf, kami tidak mengerti perintah yang Anda maksud.";
                    $this->telebot_lib->sendApiMsg($chatid, $text);
                    break;
            }
        }
    }

}