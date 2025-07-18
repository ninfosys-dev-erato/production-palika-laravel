<?php

namespace Src\Pages\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Pages\Models\Page;

class PageController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            if($request->route('slug')){
                $row = Page::where('slug',$request->route('slug'))->where('deleted_at',null)->where('deleted_by',null)->first();
                if($row){
                    $data = array(
                        'success'        =>true,
                        'content'        =>$row->content,
                        'title'          =>$row->title,
                    );
                }else{
                    $data = array(
                        'success'        =>false,
                    );
                }

            }else{
                $data = array(
                    'success'        =>false,
                );
            }
            return response()->json($data);
        }
        else{
            $row = Page::where('slug',$request->route('slug'))->where('deleted_at',null)->where('deleted_by',null)->first();
            echo $row->content;
        }
    }
}