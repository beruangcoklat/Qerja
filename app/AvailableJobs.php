<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailableJobs extends Model
{
    public function position(){
    	return $this->belongsTo(Position::class);
    }
}
