<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Repositories\QuestionRepository;
use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{
    protected $questionRepository;
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
        //有了中间件保护,create路由会重定向到登录页面
        $this->middleware('auth')->except(['index','show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = $this->questionRepository->getQuestionsFeed();
        return view('questions.index',compact('questions'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allTopics = Topic::all()->pluck('name')->all();
        return view('questions.create', compact('allTopics'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));
        $data = [
            'title'=>$request->get('title'),
            'body'=>$request->get('body'),
            'user_id'=>Auth::id()
        ];
        $question = $this->questionRepository->create($data);
        //填入对应表中
        $question->topics()->attach($topics);

        //route名字在web.api里定义
        return redirect()->route('question.show',[$question->id]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //将topics字段加入到question模型中
//        $question_ins = new Question();
//        $question =$question_ins->where('id',$id)->with('topics')->first();
        $question = $this->questionRepository->byIdWithTopicsAndAnswers($id);
//        dd($question->attributesToArray()['body']);
        return view('questions.show',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = $this->questionRepository->byId($id);
        $allTopics = Topic::all()->pluck('name')->all();
        if (Auth::user()->owns($question)){
            return view('questions.edit',['question' => $question,'allTopics' => $allTopics]);
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestionRequest $request, $id)
    {
        $question = $this->questionRepository->byId($id);
        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));
        $question->update([
            'title'=>$request->get('title'),
            'body'=>$request->get('body'),
        ]);
        $question->topics()->sync($topics);
        return redirect()->route('question.show',[$question->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = $this->questionRepository->byId($id);
        if (Auth::user()->owns($question)) {
            $question->delete();
            return redirect('/');
        }
        return abort(403,'Forbidden');//return back();
    }

}
