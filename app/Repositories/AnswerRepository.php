<?php
/**
 * Created by PhpStorm.
 * User: paprika
 * Date: 2018/3/4
 * Time: 下午5:01
 */

namespace App\Repositories;


use Facades\App\Answer;

class AnswerRepository
{

    public function create(array $attributes) {
        return Answer::create($attributes);
    }
    public function byId($id) {
        return Answer::find($id);
    }
}