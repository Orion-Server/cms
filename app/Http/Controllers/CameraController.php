<?php

namespace App\Http\Controllers;

use App\Models\Camera;
use Illuminate\Http\Request;

class CameraController extends Controller
{
    public function index(Request $request)
    {
        $photos = Camera::latestWith(32, true)->get();

        return view('pages.community.photos.index', compact('photos'));
    }
}
