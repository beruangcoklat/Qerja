<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function salaries(){
    	return $this->hasMany(Salary::class);
    }

    public function city(){
    	return $this->belongsTo(City::class);
    }

    public function category(){
        return $this->belongsTo(CompanyCategory::class, 'company_category_id');
    }

    public function availableJobs(){
        return $this->hasMany(AvailableJobs::class);
    }

}
