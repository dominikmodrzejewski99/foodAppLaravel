<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PollController extends Controller
{
    public function getQuestions()
    {
        $questions = DB::table('questions')->get();
        return response()->json($questions);
    }

    public function getAnswers()
    {
        $answers = DB::table('answers')->get();
        return response()->json($answers);
    }
}
