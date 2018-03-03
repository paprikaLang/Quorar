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
    public function byIdWithTopics($id) {
        $question_ins = new Question();
        return $question_ins->where('id',$id)->with('topics')->first();
    }
    public function create(array $attributes) {
        return Question::create($attributes);
    }
    public function normalizeTopic(array $topics) {
        return  collect($topics)->map(function ($topic){
            if (is_numeric($topic)){
                Topic::find($topic)->increment('questions_count');
                return (int)$topic;
            }
            $transTopic = Topic::create(['name'=>$topic,'questions_count'=>1]);
            return $transTopic->id;
        })->toArray();
    }
}