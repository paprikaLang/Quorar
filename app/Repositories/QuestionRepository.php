<?php
/**
 * Created by PhpStorm.
 * User: paprika
 * Date: 2018/3/3
 * Time: 下午7:09
 */

namespace App\Repositories;
use App\Question;
use App\Topic;
class QuestionRepository
{
    //获取所有问题,利用scope-query限定的范围过滤一部分问题
    public function getQuestionsFeed() {
        return Question::published()->latest('updated_at')->with('user')->get();
    }
    public function byId($id) {
        return Question::find($id);
    }
    public function byIdWithTopicsAndAnswers($id) {
        $question_ins = new Question();
        return $question_ins->where('id',$id)->with(['topics','answers'])->first();
    }
    public function create(array $attributes) {
        return Question::create($attributes);
    }
    public function normalizeTopic(array $topics) {
        return  collect($topics)->map(function ($topic){
            $allTopics = Topic::all()->pluck('name')->all();
            if (in_array($topic, $allTopics)){
                Topic::where('name', $topic)->increment('questions_count');
                return Topic::where('name', $topic)->first()->id;
            }
            $transTopic = Topic::create(['name'=>$topic,'questions_count'=>1]);
            return $transTopic->id;
        })->toArray();
    }
}