<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Telebot_lib 
{
    
    public function __construct()
    {
        $this->config->load('telebot_lib');
    }
    
    public function __get($var)
	{
		return get_instance()->$var;
	}
    
    public function myPre($value)
    {
        echo '<pre>';
        print_r($value);
        echo '</pre>';
    }

    private function apiRequest($method, $data)
    {
        if (!is_string($method)) {
            error_log("Nama method harus bertipe string!\n");

            return false;
        }

        if (!$data) {
            $data = [];
        } elseif (!is_array($data)) {
            error_log("Data harus bertipe array\n");

            return false;
        }

        $url = 'https://api.telegram.org/bot'.$this->config->item('token').'/'.$method;

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ],
        ];
        $context = stream_context_create($options);

        $result = file_get_contents($url, false, $context);

        return $result;
    }

    public function getApiUpdate($offset)
    {
        $method = 'getUpdates';
        $data['offset'] = $offset;

        $result = $this->apiRequest($method, $data);

        $result = json_decode($result, true);
        if ($result['ok'] == 1) {
            return $result['result'];
        }

        return [];
    }

    public function sendApiMsg($chatid, $text, $msg_reply_id = false, $parse_mode = false, $disablepreview = false)
    {
        $method = 'sendMessage';
        $data = ['chat_id' => $chatid, 'text'  => $text];

        if ($msg_reply_id) {
            $data['reply_to_message_id'] = $msg_reply_id;
        }
        if ($parse_mode) {
            $data['parse_mode'] = $parse_mode;
        }
        if ($disablepreview) {
            $data['disable_web_page_preview'] = $disablepreview;
        }

        $result = $this->apiRequest($method, $data);
    }


    public function sendApiAction($chatid, $action = 'typing')
    {
        $method = 'sendChatAction';
        $data = [
            'chat_id' => $chatid,
            'action'  => $action,

        ];
        $result = $this->apiRequest($method, $data);
    }

    public function sendApiKeyboard($chatid, $text, $keyboard = [], $inline = false)
    {
        $method = 'sendMessage';
        $replyMarkup = [
            'keyboard'        => $keyboard,
            'resize_keyboard' => true,
        ];

        $data = [
            'chat_id'    => $chatid,
            'text'       => $text,
            'parse_mode' => 'Markdown',

        ];

        $inline
        ? $data['reply_markup'] = json_encode(['inline_keyboard' => $keyboard])
        : $data['reply_markup'] = json_encode($replyMarkup);

        $result = $this->apiRequest($method, $data);
    }


    public function editMessageText($chatid, $message_id, $text, $keyboard = [], $inline = false)
    {
        $method = 'editMessageText';
        if ($keyboard){
            $replyMarkup = [
                'keyboard'        => $keyboard,
                'resize_keyboard' => true,
            ];
            $inline
            ? $data['reply_markup'] = json_encode(['inline_keyboard' => $keyboard])
            : $data['reply_markup'] = json_encode($replyMarkup);
        }
        
        $data = [
            'chat_id'    => $chatid,
            'message_id' => $message_id,
            'text'       => $text,
            'parse_mode' => 'Markdown',

        ];        

        $result = $this->apiRequest($method, $data);
    }

    public function sendApiHideKeyboard($chatid, $text)
    {
        $method = 'sendMessage';
        $data = [
            'chat_id'       => $chatid,
            'text'          => $text,
            'parse_mode'    => 'Markdown',
            'reply_markup'  => json_encode(['hide_keyboard' => true]),

        ];

        $result = $this->apiRequest($method, $data);
    }

    public function sendApiSticker($chatid, $sticker, $msg_reply_id = false)
    {
        $method = 'sendSticker';
        $data = [
            'chat_id'  => $chatid,
            'sticker'  => $sticker,
        ];

        if ($msg_reply_id) {
            $data['reply_to_message_id'] = $msg_reply_id;
        }

        $result = $this->apiRequest($method, $data);
    }
    
    public function sendApiVideo($chatid, $video) {
        $method = 'sendVideo';
        $data = [
            'chat_id'   => $chatid,
            'video'     => $video,
        ];
        $result = $this->apiRequest($method, $data);
    }
    
    public function sendApiPhoto($chatid, $photo) {
        $method = 'sendVideo';
        $data = [
            'chat_id'   => $chatid,
            'photo'     => $photo,
        ];
        $result = $this->apiRequest($method, $data);
    }
    
    public function sendApiFile($chatid, $file, $method) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file);
        if ($method=="sendVideo") {   
            $field = ['chat_id'=>$chatid, 'video'=>new CURLFile($file,$mime,$file)];
        } else if ($method=="sendPhoto") {            
            $field = ['chat_id'=>$chatid, 'photo'=>new CURLFile($file,$mime,$file)];
        } else {
            $method="sendDocument";
            $field = ['chat_id'=>$chatid, 'file'=>new CURLFile($file,$mime,$file)];
        }

        $url = 'https://api.telegram.org/bot'.$this->config->item('token').'/'.$method;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $field);
        $output = curl_exec ($ch);
        curl_close ($ch);
        //var_dump($output); // show output
    }
}
