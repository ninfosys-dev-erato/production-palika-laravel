<?php

namespace Src\DigitalBoard\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\DigitalBoard\Models\Video;

class VideoAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:videos view')->only('index');
        //$this->middleware('permission:videos edit')->only('edit');
        //$this->middleware('permission:videos create')->only('create');
    }

    function index(Request $request)
    {
        return view('DigitalBoard::videos.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('DigitalBoard::videos.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $video = Video::find($request->route('id'));
        $action = Action::UPDATE;
        return view('DigitalBoard::videos.form')->with(compact('action', 'video'));
    }
}
