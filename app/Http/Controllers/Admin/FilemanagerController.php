<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class FilemanagerController extends Controller
{

    public function index()
    {
        $nav = 'filemanager';
        $sub_nav = '';
        $page_title = 'File Manager';
        return view('admin.filemanager.index', compact('nav', 'sub_nav', 'page_title'));
    }
}
