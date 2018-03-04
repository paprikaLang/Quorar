<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Http\Requests\StoreQuestionRequest;
use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{
    protected $answerRepository;
    public function __construct(AnswerRepository $repository){
        $this->answerRepository = $repository;
    }

    public function store(StoreAnswerRequest $request,$question) {
       $answer = $this->answerRepository->create([
           'question_id'=>$question,
           'user_id'=>Auth::id(),
           'body'=>$request->get('body')
       ]);
       $answer->question()->increment('answers_count');
       return back();
    }
}
