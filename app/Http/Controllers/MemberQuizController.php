<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberQuizController extends Controller
{
    public function index()
    {
        return view('member.quiz');
    }

    public function take()
    {
        return view('member.quiz_take');
    }
}
