<?php
/**
 * Created by PhpStorm.
 * User: paprika
 * Date: 2018/11/9
 * Time: 6:06 AM
 */

namespace App\Repositories;
use Facades\App\Message;

class MessageRepository
{
    public function create(array $attributes) {
        return Message::create($attributes);
    }
}