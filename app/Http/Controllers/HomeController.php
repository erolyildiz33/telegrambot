<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    function index()
    {

        $bot = new TelegramBot();
        $bot->setToken(env('BOT_API_TOKEN'));
        //$bot->deleteWebhook();
     $bot->setWebHook('https://pollandbot.requestcatcher.com/');
//
     $bot->sendMessage(939991767,'Bottan Gelen Deneme Mesajı');


    }

}

class TelegramBot
{

    const API_URL = "https://api.telegram.org/bot";
    public $token;

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function setWebHook($url)
    {
        return $this->request('setWebhook', [
            'url' => $url
        ]);

    }

    public function sendMessage($chat_id,$message)
    {
        return $this->request('sendMessage', [
            'chat_id' => $chat_id,
            'text' => $message
        ]);

    }
 public function deleteWebhook()
    {
        return $this->request('deleteWebhook', [
            'drop_pending_updates' => true,

        ]);

    }

    public function request($method, $posts)
    {
        $url = self::API_URL . $this->token . '/' . $method;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($posts));

        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $result;

    }

}
