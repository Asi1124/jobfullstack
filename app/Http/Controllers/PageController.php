<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index(){
        return Inertia::render('Home');
    }

    public function create(){
        return Inertia::render('Create');
    }
}
