<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Company;

class AvailableJobsController extends Controller
{

    public function paging(){
        $select = [
            'companies.id as CompanyId',
            'available_jobs.id as LowonganId',
            'positions.name as PositionName',
            'companies.name as CompanyName',
            'available_jobs.salary as Salary',
            'available_jobs.description as Description',
            'cities.name as City',
        ];

        $result = DB::table('available_jobs')
            ->join('companies', 'companies.id', '=', 'available_jobs.company_id')
            ->join('positions', 'positions.id', '=', 'available_jobs.position_id')
            ->join('cities', 'cities.id', '=', 'companies.city_id')
            ->select($select)
            ->orderByRaw('available_jobs.created_at desc')
            ->paginate(20);

        return response()->json($result);
    }
    
    public function byId(Request $request){
		$company_id = $request->company_id;
		$item_id = $request->item_id;
		$company = Company::find($company_id);
        $availableJobs = $company->availableJobs;

        $finalResult = [];
        foreach ($availableJobs as $avail) {
            $temp = [
            	'PositionName' => $avail->position->name,
            	'CompanyName' => $company->name,
            	'Salary' => $avail->salary,
            	'Description' => $avail->description,
            	'Location' => $company->city->name,
            ];

            if($avail->id == $item_id) $top = $temp;
            else array_push($finalResult, $temp);
        }

        if($item_id != null){
            array_unshift($finalResult, $top);
        }

        $last_page = (int)ceil(sizeof($finalResult) / 10);
        $curr_page = $request->page;

        return response()->json([
            'LastPage' => $last_page,
            'AvailableJobsCount' => $availableJobs->count(),
            'datas' => array_slice($finalResult, ($curr_page-1)*10, 10)
        ]);
    }

}
