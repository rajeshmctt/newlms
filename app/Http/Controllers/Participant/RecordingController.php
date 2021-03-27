<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RecordingController extends Controller
{
    public function index()
    {
        $title = "Recordings";
        $icon_class = "fa fa-file-alt";
        return view(config('app.p_slug').'.dashboard', compact('title', 'icon_class'));
    }
}
