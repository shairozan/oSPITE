<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestLog extends Model
{
    protected $table = 'quest_logs';

    public function tags(){
        return $this->hasManyThrough('App\QuestLog',
            'App\Tag',
            'App\QuestLogTag',
            'quest_log_id',
            'id'
        );
    }
}
