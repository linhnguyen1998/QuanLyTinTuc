<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "comment";

    public function tintuc()
    {
    	return $this->beLongsTo('App\TinTuc', 'idTinTuc', 'id');
    }

    public function user()
    {
    	return $this->beLongsTo('App\User', 'idUser', 'id');
    }
}
