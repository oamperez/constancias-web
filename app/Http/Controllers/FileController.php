<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use App\Mail\MailConstancia;
use Mail;

class FileController extends Controller
{
    public function index(){
        $collect = collect();
        //$files = Storage::disk('s3')->files('files');
        //$files = File::files(public_path('send'));
        foreach($files as $f){
            $ext = pathinfo($f);
            if($ext['extension'] == 'pdf'){
                $res = Http::get('http://fifcoone.saprosa.co/ws/sap/data/showmember?user='.$ext['filename']);
                $json = $res->json();
                if($json['result']){
                    if(!Storage::disk('constancias')->exists($ext['basename'])){
                        $ruta = $ext['dirname'].'/'.$ext['basename'];
                        //$path = Storage::disk('constancias')->putFileAs($ruta , $ext['basename']);
                        //Mail::to('oscar9913amperez@gmail.com')->send(new MailConstancia($ext['filename'],$ruta));
                        $collect->push($ext);
                    }
                }
            }
        }
        return $collect;
    }
}
