<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\news;

class newsController extends Controller
{
    public function index(){
        $newsapp = news::all();
        return $newsapp;
    }
}