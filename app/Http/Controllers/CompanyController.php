<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Company;
use App\Review;
use App\Salary;
use App\Follow;

class CompanyController extends Controller
{

	public function getCompanyFromReview(Request $request){
		$review_id = $request->id;
		return response()->json(Review::find($review_id)->company);
	}

	public function getCompanyFromSalary(Request $request){
		$salary_id = $request->id;
		return response()->json(Salary::find($salary_id)->company);
	}

	public function search(Request $request){
		$text = $request->text;
		if(strlen($text) == 0) $companies = null;
		else $companies = Company::where('name', 'like', "%$text%")->get();
		return response()->json($companies);
	}

	public function feeds(Request $request){
		$user_id = $request->user_id;
		$currPage = $request->page;
		$offset = ($currPage - 1) * 20;

		$companies = Follow::where('user_id', $user_id)->get();
		if($companies->count() == 0){
			$in = '(-1)';
		}else{
			$in = '(';
			foreach ($companies as $c) {
				$append = $c->company_id . ',';
				$in .= $append;
			} 
			$in = substr($in, 0, strlen($in)-1) . ')';
		}

		$query = "SELECT x.id, x.type, x.created_at ".
				"FROM (".
					"SELECT id, created_at, 'review' AS 'type' FROM reviews WHERE company_id in $in ".
					"UNION ".
				    "SELECT id, created_at,'gaji' AS 'type' FROM salaries WHERE company_id in $in ".
				    "UNION ".
				    "SELECT id, created_at, 'lowongan' AS 'type' FROM available_jobs WHERE company_id in $in ".
				") x ".
				"ORDER BY x.created_at DESC ".
				"LIMIT 20 OFFSET $offset";
		
		$queryResult = DB::select($query);
		$finalResult = [];

		foreach ($queryResult as $row) {
			$id = $row->id;
			$type = $row->type;
			$data = $this->getData($id, $type);

			$temp = [
				'id' => $id,
				'type' => $type,
				'data' => $data,
			];

			array_push($finalResult, $temp);
		}

		return response()->json($finalResult);
	}

	public function follow(Request $request){
    	$user_id = $request->user_id;
        $company_id = $request->company_id;

		$followed = Follow::where('user_id', $user_id)
			->where('company_id', $company_id)
			->first();

		if($followed == null){
			$h = new Follow;
            $h->user_id = $user_id;
            $h->company_id = $company_id;
            $h->save();
		}else{
			Follow::destroy($followed->id);
		}

		return response()->json(!$followed);
    }

	private function getData($id, $type){
		if($type == 'review')
		{
			$data = DB::table('reviews')
	            ->join('positions', 'positions.id', '=', 'reviews.position_id')
	            ->join('companies', 'companies.id', '=', 'reviews.company_id')
	            ->where('reviews.id', $id)
	            ->select([
	            	'companies.id as CompanyId',
		            'companies.name as CompanyName',
		            'positions.name as PositionName',
		            'reviews.positive as ReviewPositive',
		            'reviews.star as ReviewRating',
		            'reviews.id as ReviewId'
	            ])
	            ->first();
		}
		else if($type == 'gaji')
		{
			$data = DB::table('salaries')
				->join('companies', 'companies.id', '=', 'salaries.company_id')
				->join('positions', 'positions.id', '=', 'salaries.position_id')
	            ->where('salaries.id', $id)
				->select([
					'salaries.id as SalaryId',
		            'companies.id as CompanyId',
		            'companies.image as CompanyImage',
		            'companies.name as CompanyName',
		            'positions.name as PositionName',
		            DB::raw('COUNT(salaries.id) as SalaryCount'),
		            DB::raw('MAX(salaries.gaji) as MaxSalary'),
		            DB::raw('MIN(salaries.gaji) as MinSalary'), 
		            DB::raw('AVG(salaries.gaji) as AverageSalary')
				])
	            ->groupBy('companies.name', 'positions.name', 'companies.image', 'companies.id', 'salaries.id')
				->first();
		}
		else if($type == 'lowongan')
		{
			$data = DB::table('available_jobs')
	            ->join('companies', 'companies.id', '=', 'available_jobs.company_id')
	            ->join('positions', 'positions.id', '=', 'available_jobs.position_id')
	            ->join('cities', 'cities.id', '=', 'companies.city_id')
	            ->where('available_jobs.id', $id)
	            ->select([
	            	'companies.id as CompanyId',
		            'positions.name as PositionName',
		            'companies.name as CompanyName',
		            'available_jobs.salary as Salary',
		            'available_jobs.description as Description',
		            'cities.name as City',
		        ])
	            ->first();
		}

		return $data;
	}

	public function getProfile(Request $request){
		$company_id = $request->company_id;
		$company = Company::where('id', $company_id)->first();
		return response()->json([
			'CompanyName' => $company->name,
			'CompanyDescription' => $company->description,
			'CompanyLocation' => $company->location,
			'CompanyEmail' => $company->email,
			'CompanyPhone' => $company->phone,
			'CompanyWebsite' => $company->website,
			'CompanyCountry' => $company->city->country->name,
			'CompanyCategory' => $company->category->name,
			'CompanyRating' => $company->reviews->avg('star'),
			'CompanyImage' => $company->image,
		]);
	}

    public function mostReviewed(){
    	$select = [
    		DB::raw('COUNT(reviews.id) as ReviewCount'),
    		DB::raw('AVG(reviews.star) as CompanyRating'),
    		'companies.id as CompanyId'
    	];

		$result = DB::table('companies')
			->join('reviews', 'companies.id', '=', 'reviews.company_id')
			->select($select)
			->groupBy('companies.id')
			->orderByRaw('COUNT(reviews.id) asc')
			->limit(10)
			->get();
		
		$finalResult = [];
		for($i=0 ; $i<sizeof($result) ; $i++){
			$res = $result[$i];
			$company = Company::find($res->CompanyId);
			$reviewCount = $company->reviews->count();
			$review = $company->reviews->last();
			$helpfulCount = $review->helpfuls->count();

			$temp = [
				'CompanyName' => $company->name,
				'CompanyId' => $company->id,
				'CompanyRating' => $company->reviews->avg('star'),
				'ReviewCount' => $reviewCount,
				'ReviewPositive' => $review->positive,
				'HelpfulCount' => $helpfulCount,
				'CompanyDescription' => $company->description,
				'Reviewer' => $review->position->name,
				'Reviewer_image' => $review->company->image
			];
			array_push($finalResult, $temp);
		}

		return response()->json($finalResult);
	}
	
	public function getCompaniesPaging(Request $request){
		$select = [
			'companies.image as CompanyImage',
			'companies.name as CompanyName',
			'companies.description as CompanyDescription',
			'companies.id as CompanyId',
    		DB::raw('COUNT(reviews.id) as ReviewCount'),
    		DB::raw('AVG(reviews.star) as CompanyRating'),
		];

		$type = $request->type;
		if($type == 'name_desc') $sort = 'name desc';
		else if($type == 'name_asc') $sort = 'name asc';
		else if($type == 'rating_desc') $sort = 'avg(star) desc';
		else if($type == 'rating_asc') $sort = 'avg(star) asc';
		
		$filter = $request->filter;
		$companies = DB::table('companies')
			->join('reviews', 'companies.id', '=', 'reviews.company_id')
			->select($select)
			->where('companies.name', 'like', "%$filter%")
			->groupBy('companies.name', 'companies.description', 'companies.image', 'companies.id')
			->orderByRaw($sort)
			->paginate(20);

		$s = [];
		$f = [];
		foreach ($companies as $c) {
			$salaryCount = Company::find($c->CompanyId)->salaries->count();
			array_push($s, $salaryCount);

			$user_id = $request->user_id;
			if($user_id == null) continue;
			$company_id = $c->CompanyId;
			$query = "SELECT * FROM follows WHERE user_id = $user_id AND company_id = $company_id";
			$followed = DB::select($query) != null;
			array_push($f, $followed);
		}

		$json = [
			'companies' => $companies,
			'salaries' => $s,
		];

		if($request->user_id != null) $json['follow'] = $f;
		return response()->json($json);
	}

	public function getAll(){
		$companies = Company::all();
		return response()->json([
			'companies' => $companies
		]);
	}

	public function insert(Request $request){
		$rule = [
			'nama' => 'required',
			'negara' => 'required',
			'kota' => 'required',
			'industri' => 'required',
			'foto' => 'required|image',
			'lokasi' => 'required',
			'deskripsi' => 'required',
			'website' => 'required',
			'email' => 'required|email|unique:users',
			'phone' => 'required|numeric',
		];

		$errorMessage = [
			'nama.required' => 'wajib diisi',
			'negara.required' => 'wajib diisi',
			'kota.required' => 'wajib diisi',
			'industri.required' => 'wajib diisi',
			'foto.required' => 'wajib diisi',
			'foto.image' => 'wajib gambar',
			'lokasi.required' => 'wajib diisi',
			'deskripsi.required' => 'wajib diisi',
			'website.required' => 'wajib diisi',
			'email.required' => 'wajib diisi',
			'email.email' => 'wajib format email',
			'email.unique' => 'wajib unik',
			'phone.required' => 'wajib diisi',
			'phone.numeric' => 'wajib angka',
		];

		$validator = Validator::make($request->all(), $rule, $errorMessage);
        if($validator->fails()){
            return response()->json([
                'type' => 'error',
                'errors' => $validator->errors()
            ]);
        }

        $image = $request->foto;
        $filename = time() . $image->getClientOriginalName();
        $image->move(public_path('/image/company'), $filename);

        $newCompany = new Company;
        $newCompany->name = $request->nama;
        $newCompany->city_id = $request->kota;
        $newCompany->company_category_id = $request->industri;
        $newCompany->location = $request->lokasi;
        $newCompany->email = $request->email;
        $newCompany->phone = $request->phone;
        $newCompany->description = $request->deskripsi;
        $newCompany->image = $filename;
        $newCompany->save();
        
		return response()->json([
			'type' => 'success',
			'message' => 'terima kasih'
		]);
	}

}
