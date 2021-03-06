<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use App\Mail\MailConstancia;
use Mail;

class FileEmail extends Command
{

    protected $signature = 'email:constancy';

    protected $description = 'Send of constancy';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $collect = collect();
        $files = Storage::disk('s3')->files('constancias');
        //$files = File::files(public_path('send'));
        foreach($files as $f){
            $ext = pathinfo($f);
            if(strtolower($ext['extension']) == 'pdf'){
                $res = Http::get('http://fifcoone.saprosa.co/ws/sap/data/showmember?user='.$ext['filename']);
                $json = $res->json();
                if($json['result']){
                    if(!Storage::disk('constancias')->exists($ext['basename'])){
                        $ruta = $ext['dirname'].'/'.$ext['basename'];
                        $path = Storage::disk('constancias')->putFileAs('/', $ruta , $ext['basename']);
                        //Mail::to($json['records']['UID'])->send(new MailConstancia($json['records'],$ruta));
                        $res2 = Http::get('http://fifcoone.saprosa.co/ws/sap/data/showmember?user='.$json['records']['JEFENO']);
                        $json2 = $res2->json();
                        if($json2['result']){
                            Mail::to($json2['records']['UID'])->send(new MailConstancia($json['records'],$ruta));
                        }
                        $collect->push($ext);
                    }
                }
            }
        }
        Log::info('have been sent successfully.');
    }
}
