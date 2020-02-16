<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Company;
use App\Position;
use App\Salary;

class SalaryController extends Controller
{

    public function getSalariesPaging(){
        $select = [
            'salaries.id as SalaryId',
            'companies.id as CompanyId',
            'companies.image as CompanyImage',
            'companies.name as CompanyName',
            'positions.name as PositionName',
            DB::raw('COUNT(salaries.id) as SalaryCount'),
            DB::raw('MAX(salaries.gaji) as MaxSalary'),
            DB::raw('MIN(salaries.gaji) as MinSalary'), 
            DB::raw('AVG(salaries.gaji) as AverageSalary'),
        ];

        $result = DB::table('salaries')
            ->join('companies', 'companies.id', '=', 'salaries.company_id')
            ->join('positions', 'positions.id', '=', 'salaries.position_id')
            ->select($select)
            ->orderByRaw('salaries.created_at desc')
            ->groupBy('companies.name', 'positions.name', 'companies.image', 'companies.id', 'salaries.id')
            ->paginate(20);


        return $result;
    }

    public function mostReviewed(){
        $select = [
            DB::raw('COUNT(companies.id) as CompanyCount'),
            'salaries.id as SalaryId'
        ];

        $result = DB::table('salaries')
            ->join('companies', 'companies.id', '=', 'salaries.company_id')
            ->select($select)
            ->orderByRaw('COUNT(companies.id) desc')
            ->groupBy('salaries.id')
            ->limit(5)
            ->get();

        $finalResult = [];
        foreach ($result as $r) {
            $salary = Salary::find($r->SalaryId);
            $company = $salary->company;
            $position = $salary->position;
            $max = $company->salaries->max('gaji');
            $min = $company->salaries->min('gaji');
            $avg = $company->salaries->avg('gaji');
            $temp = [
                'JobName' => $position->name,
                'CompanyName' => $company->name,
                'CompanyImage' => $company->image,
                'AverageSalary' => $avg,
                'MaxSalary' => $max,
                'MinSalary' => $min,
            ];
            array_push($finalResult, $temp);
        }

        return $finalResult;
    }

    public function submitReview(Request $request){
        $companyExists = $request->companyExists;

        $rule = [
            'negara' => 'required',
            'perusahaan' => 'required',
            'kota' => 'required',
            'jabatan' => 'required',
            'status' => 'required',
            'gaji' => 'required|digits_between:1,999999',
            'periode' => 'required',
        ];

        $errorMessage = [
            'negara.required' => 'wajib diisi',
            'perusahaan.required' => 'wajib diisi',
            'kota.required' => 'wajib diisi',
            'jabatan.required' => 'wajib diisi',
            'status.required' => 'wajib diisi',
            'gaji.required' => 'wajib diisi',
            'gaji.digits_between' => 'harus angka',
            'periode.required' => 'wajib diisi'
        ];

        if($companyExists == 'false'){
            $rule['web'] = 'required';
            $rule['industri'] = 'required';
            $errorMessage['web.required'] = 'wajib diisi';
            $errorMessage['industri.required'] = 'wajib diisi';
        }

        $validator = Validator::make($request->all(), $rule, $errorMessage);
        if($validator->fails()){
            return response()->json([
                'type' => 'error',
                'errors' => $validator->errors()
            ]);
        }

        // sukses
        // kalo jabatan gak ada, insert
        $jabatan = $request->jabatan;
        if(Position::where('name', $jabatan)->get()->count() == 0){
            $newPosition = new Position;
            $newPosition->name = $jabatan;
            $newPosition->save();
        }
        $jabatan = Position::where('name', $jabatan)->first()->id;

        // insert company kalo gak ada
        if($companyExists == 'false'){
            $newCompany = new Company;
            $newCompany->name = $request->perusahaan;
            $newCompany->description = '';
            $newCompany->image = '';
            $newCompany->company_category_id = $request->industri;
            $newCompany->city_id = $request->kota;
            $newCompany->save();

            $company_id = Company::all()->last()->id;
        }else{
            $company_id = $request->perusahaan;
        }

        $newSalary = new Salary;
        $newSalary->status = $request->status;
        $newSalary->gaji = $request->gaji;
        $newSalary->periode = $request->periode;
        $newSalary->position_id = $jabatan;
        $newSalary->city_id = $request->kota;
        $newSalary->company_id = $company_id;
        $newSalary->save();

        $users = DB::select("select user_id from follows where company_id = $company_id");
        return response()->json([
            'type' => 'success',
            'message' => 'terima kasih',
            'users' => $users,
            'salary_id' => $newSalary->id,
        ]);
    }

    public function salariesFromCompany(Request $request){
        $company_id = $request->company_id;
        $company = Company::find($company_id);
        $salaryCount = $company->salaries->count();
        $positionCount = DB::select("SELECT position_id from salaries where company_id = $company_id GROUP by position_id");
        $positionCount = sizeof($positionCount);
        $item_id = $request->item_id;

        $select = [
            'salaries.id as SalaryId',
            'companies.name as CompanyName',
            'positions.name as PositionName',
            DB::raw('COUNT(positions.id) as PositionCount'),
            DB::raw('MAX(salaries.gaji) as MaxSalary'),
            DB::raw('MIN(salaries.gaji) as MinSalary'),
            DB::raw('AVG(salaries.gaji) as AverageSalary'),
        ];

        $salaries = DB::table('salaries')
            ->join('companies', 'salaries.company_id', '=', 'companies.id')
            ->join('positions', 'salaries.position_id', '=', 'positions.id')
            ->select($select)
            ->groupBy('companies.name', 'positions.name', 'salaries.id')
            ->where('company_id', $company_id)
            ->get();

        $finalResult = [];
        foreach ($salaries as $s) {
            $salaryid = $s->SalaryId;
            $temp = [
                'CompanyName' => $s->CompanyName,
                'PositionName' => $s->PositionName,
                'PositionCount' => $s->PositionCount,
                'MaxSalary' => $s->MaxSalary,
                'MinSalary' => $s->MinSalary,
                'AverageSalary' => $s->AverageSalary,
            ];

            if($salaryid == $item_id) $top = $temp;
            else array_push($finalResult, $temp);
        }

        if($item_id != null){
            array_unshift($finalResult, $top);
        }

        $last_page = (int)ceil(sizeof($finalResult) / 10);
        $curr_page = $request->page;

        return response()->json([
            'LastPage' => $last_page,
            'CurrPage' => $curr_page,
            'SalaryCount' => $salaryCount,
            'PositionCount' => $positionCount,
            'datas' => array_slice($finalResult, ($curr_page-1)*10, 10)
        ]);
    }

}
