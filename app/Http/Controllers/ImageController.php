<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Models\Image;

class ImageController extends Controller
{
    public function store(Request $request) {
        $disk = Storage::disk('s3');
        $image = $request->file;
        $path = $disk->putFile('images',$image,'public');
        $url = Storage::disk('s3')->url($path);
        Image::create([
            'filename' => $url
        ]);
        return Inertia::render('Dashboard',['urlo'=>$url]);
    }
}
