<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Review extends Model
{
    public function helpfuls(){
        return $this->hasMany(Helpful::class);
    }

    public function position(){
    	return $this->belongsTo(Position::class);
    }
    
    public function company(){
    	return $this->belongsTo(Company::class);
    }

    public function city(){
    	return $this->belongsTo(City::class);
    }

}
