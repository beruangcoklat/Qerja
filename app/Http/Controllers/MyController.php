<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cookie;

class MyController extends Controller
{
    public function showHome(){
        $this->forgetSession();
        return view('home');
    }

    public function showCompany(){
        $this->forgetSession();
        return view('company');
    }

    public function showPengaturan(){
        $this->forgetSession();
    	return view('pengaturan');
    }

    public function showSalary(){
        $this->forgetSession();
        return view('salary');
    }

    public function showReviewCompany(){
        $this->forgetSession();
        return view('reviewCompany');
    }

    public function showAddCompany(){
        $this->forgetSession();
        return view('addCompany');
    }

    public function showChat(){
        $this->forgetSession();
        return view('chat');
    }

    public function showFeeds(){
        $this->forgetSession();
        return view('feeds');
    }

    public function showCompanyDetail(){
        // $this->forgetSession();
        if(session('company_id') == null) return redirect()->back();
        return view('companyDetail');
    }

    private function forgetSession(){
        session()->forget('company_list');
        session()->forget('company_id');
    }

    public function getSessionCompanyId(){
        return response()->json(session('company_id'));
    }

    public function setSessionCompanyId(){
        session()->forget('company_id');
        session()->push('company_id', [
            'id' => request()->company_id,
            'type' => request()->type,
            'item_id' => request()->item_id,
        ]);
    }

    public function getSessionCompanyList(){
        return response()->json(session('company_list'));
    }

    public function setSessionCompanyList(){
        session()->forget('company_list');
        session()->push('company_list', [
            'type' => request()->type,
        ]);
    }

}
