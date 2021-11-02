<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller {

    public function __construct()
    {

        $this->middleware('api.auth', ['except' => ['basic_email', 'html_email','attachment_email']]);
    }


   public function basic_email() {
      $data = array('name'=>"Virat Gandhi");

      Mail::send(['text'=>'mail'], $data, function($message) {
         $message->to('encordencord0@gmail.com', 'Tutorials Point')->subject
            ('Laravel Basic Testing Mail');
         $message->from('hs2.delgado@gmail.com','Virat Gandhi');
      });
      echo "Basic Email Sent. Check your inbox.";
   }



   public function html_email() {

    Mail::send('mail',['name','Ripon Uddin Arman'],function($message){
        $message->to('vastiansalcedo97@gmail.com')->subject("Email Testing with Laravel");
        $message->from('encordencord0@gmail.com','Aplicacion de encord');
    });

   }









   public function attachment_email() {
      $data = array('name'=>"Virat Gandhi");
      Mail::send('mail', $data, function($message) {
         $message->to('encordencord0@gmail.com', 'Tutorials Point')->subject
            ('Laravel Testing Mail with Attachment');
        //  $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
        //  $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
         $message->from('hs2.delgado@gmail.com','Virat Gandhi');
      });
      echo "Email Sent with attachment. Check your inbox.";
   }
}
