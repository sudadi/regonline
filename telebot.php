<?php
    $url = "http://localhost/regonline/telebot/botloop";
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url);  
    curl_exec($ch);
    
?>