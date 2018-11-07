<?php
/**
 * Created by PhpStorm.
 * User: paprika
 * Date: 2018/11/7
 * Time: 8:54 PM
 */

namespace App\Repositories;
use Facades\App\User;
class UserRepository
{
    public function byId($id) {
        return User::find($id);
    }

}