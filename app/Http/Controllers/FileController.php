<?php

namespace App\Http\Controllers;

use Dotenv\Util\Str;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload(Request $request): string
    {
        $picture = $request->file('picture');
        $picture->storePubliclyAs('pictures', $picture->getClientOriginalName(), 'local');
        return 'OK ' . $picture->getClientOriginalName();
    }
}
