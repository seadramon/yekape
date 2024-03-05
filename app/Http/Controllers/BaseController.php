<?php

namespace App\Http\Controllers;

use App\Models\Container;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Zip;

class BaseController extends Controller
{

    public function gambar($kode)
    {
        $content_type = [
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'pdf'  => 'application/pdf'
        ];
        $cek = Storage::exists(str_replace('&', '/', $kode));
        if ($cek) {
            $img = Storage::get(str_replace('&', '/', $kode));
            $size = Storage::size(str_replace('&', '/', $kode));
            $splitted = explode('.', $kode);
            $ext = end($splitted);
        } else {
            $img = Storage::get('imagenotfound.jpg');
            $size = Storage::size('imagenotfound.jpg');
            $ext = 'jpg';
        }
//
        return Response::make($img, 200, ['Content-Type' => $content_type[$ext] ?? null, 'Content-Length' => $size]);
    }

}
