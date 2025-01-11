<?php

namespace App\Services;

use Exception;

use Illuminate\Support\Facades\Storage;
use Hidehalo\Nanoid\Client;
use Hidehalo\Nanoid\GeneratorInterface;
use Illuminate\Support\Str;

class FileService
{
    private $storage;

    function __construct() {
        // $this->storage = Storage::cloud();
        $this->storage = Storage::disk('public');

    }
    public function upload($file, $path = '')
    {
        $filename = $this->generateFileName($file);
        $upload = $this->storage->put($path."/".$filename, file_get_contents($file->getRealPath()));
        if ($upload) {
            return $this->storage->url($path."/".$filename);
        }
    }

    private function generateFileName($file)
    {
        $client             = new Client();
        $originalFilename   = $file->getClientOriginalName();
        $extend             = $file->getClientOriginalExtension();
        $objectid= $client->generateId($size = 21, $mode = Client::MODE_DYNAMIC);
        $filename = Str::snake(str_replace(".".$extend."","",$originalFilename))."-".$objectid.'.'.$file->getClientOriginalExtension();
        return $filename;
    }

    public function getFile($path)
    {
        return $this->storage->get($path);
    }

    public function uploadFileDompfd($file, $name){
        $upload = $this->storage->put("/".$name, base64_decode($file));
        if ($upload) {
            return $this->storage->url("/".$name);
        }
    }

}
