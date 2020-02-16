<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Position;
use App\Company;

class Salary extends Model
{
    public function position(){
    	return $this->belongsTo(Position::class);
    }

    public function company(){
    	return $this->belongsTo(Company::class);
    }
}
