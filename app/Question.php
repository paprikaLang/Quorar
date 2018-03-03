<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //MassAssignmentException报错
    protected $fillable = ['title','body','user_id'];
    public function topics() {
        return $this->belongsToMany(Topic::class)->withTimestamps();
    }

}
